<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Enums\SchedulerStatusType;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\Scheduler;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ImportQuestionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Questions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $forumStartDate = env('FORUM_START_DATE', null);

        $schedulers = Scheduler::where('status', SchedulerStatusType::PENDING)->take(1)->get();
        if ($schedulers->count() > 0) {
            foreach ($schedulers as $scheduler) {
                $scheduler->fill([
                    'status' => SchedulerStatusType::UNDER_PROCESS
                ])->save();
                $line = 1;
                try {
                    $file = fopen(storage_path('app/' . $scheduler->file_path), 'r');
                    fgetcsv($file);
                    $total = 0;
                    $success = 0;
                    $error = 0;
                    $remarks = [];
                    while (!feof($file)) {
                        $row = fgetcsv($file);
                        if (!$row) {
                            continue;
                        }
                        if (count(array_filter($row)) > 0) {
                            try {

                                $total++;
                                $line++;

                                $i = 0;
                                $insert = [
                                    'category_id' => null,
                                    'sub_category_id' => null,
                                    'question' => null,
                                    'slug' => null,
                                ];
                                $data = [
                                    'category' => $row[$i++],
                                    'sub_category' => $row[$i++],
                                    'question' => $row[$i++],
                                ];

                                if (empty($data['question'])) {
                                    $remarks[] = 'Empty Question on Line no ' . $line;
                                } else {
                                    if (!empty($data['category'])) {
                                        $category = Category::firstOrCreate(
                                            ['name' => $data['category']],
                                            ['priority' => 99, 'slug' => question_slug($data['category'])]
                                        );
                                        $insert['category_id'] = $category->id;

                                        if (!empty($data['sub_category'])) {
                                            $subCategory = SubCategory::firstOrCreate(
                                                ['category_id' => $category->id, 'name' => $data['sub_category']],
                                                ['priority' => 99, 'slug' => question_slug($data['sub_category'])]
                                            );
                                            $insert['sub_category_id'] = $subCategory->id;
                                        }
                                    }

                                    $insert['question'] = str_replace(array('�', '&#039;'), '\'', htmlentities($data['question']));

                                    $insert['api_status'] = 'P';

                                    $user = ClientUser::fake()->inRandomOrder()->first();
                                    $insert['client_id'] = $user->id;

                                    $insert['slug'] = question_slug($insert['question']);

                                    $carbon = Carbon::parse($forumStartDate)->addDays(90);
                                    $carbonToday = Carbon::now()->subDays(7);

                                    $date = $carbon->addDays(rand(0, $carbonToday->diffInDays($carbon)))->addSeconds(rand(0, 86400));

                                    $insert['created_at'] = $date;
                                    $insert['updated_at'] = $date;

                                    if (Question::create($insert)) {
                                        $success++;
                                    } else {
                                        $error++;
                                        $remarks[] = 'Error while Creating Question on line no ' . $line;
                                    }

                                }
                            } catch (\Exception $e) {
                                $error++;
                                $remarks[] = htmlspecialchars($e->getMessage()) . ' on line no ' . $line;
                            }
                        }
                    }
                    $scheduler->fill([
                        'status' => SchedulerStatusType::SUCCESS,
                        'total_count' => $total,
                        'success_count' => $success,
                        'error_count' => $error,
                        'errors' => $remarks
                    ])->save();
                } catch (\Exception $e) {
//                    $remarks[] = $e->getMessage() . 'on line no ' . $line;
//                    var_dump($remarks);
                    $scheduler->fill([
                        'status' => SchedulerStatusType::ERROR,
                        'errors' => $remarks
                    ])->save();
                }
            }
        }
    }

}
