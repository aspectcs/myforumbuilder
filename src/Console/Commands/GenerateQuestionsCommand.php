<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\Tag;
use Aspectcs\MyForumBuilder\Models\TagsMapping;
use Aspectcs\MyForumBuilder\Traits\MyForumBuilderTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GenerateQuestionsCommand extends Command
{
    use MyForumBuilderTrait;

    protected $hidden = true;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate New Questions description if not exist generate tags and generate answers as well.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $questions = Question::where('api_status', 'P')->take(1)->get();
        foreach ($questions as $question) {
            try {
                $response = MyForumBuilder::question($question);
                $this->turboPrompt = [];
                $question->api_status = 'IP';
                $question->save();

                if ($question->description == null) {
                    $this->generateDescription($question);
                    sleep(3);
                }

                if ($question->tags == null) {
                    $this->generateTags($question);
                    sleep(3);
                }

                $this->generateAnswers($question);
//            sleep(3);
                $question->api_status = 'S';
                $question->save();
            } catch (Exception $e) {
                MyForumBuilder::error($question, $e->getMessage());
                $question->api_status = 'E';
                $question->api_remarks = 'Error has been reported to admin we will get back to you soon.';
                $question->save();
            }
        }
    }

    private function generateDescription(Question &$question)
    {
        $turboPrompt = [];
        $prompt = $question->question . "\n\nUnderstand the above question and I need you to act like a user who is asking this question in a relevant forum. Provide good enough personal context to this question, so that users can answer your query";
        $turboPrompt[] = ['role' => 'user', 'content' => $prompt];
        $result = $this->AITurbo($turboPrompt);

        $question->description = trim($result['choices'][0]['message']['content'], '"');
        $question->total_tokens += $result['usage']['total_tokens'];
        $question->save();
    }

    private function generateTags(Question &$question)
    {
        $turboPrompt = [];
        $tagsIds = [];
        $prompt = "Give me the most relevant tags from below content with comma (,) separated.\n\n" . $question->description;
        $turboPrompt[] = ['role' => 'user', 'content' => $prompt];
        $result = $this->AITurbo($turboPrompt);
        $question->total_tokens += $result['usage']['total_tokens'];

        $tags = explode(',', $result['choices'][0]['message']['content']);

        if (count($tags) == 1)
            $tags = explode('#', $result['choices'][0]['message']['content']);

        foreach ($tags as $tag) {
            $tag = trim($tag);
            $tag = str_replace('.', '', $tag);
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($tag)], ['name' => ucwords($tag)]
            );
            $insert[] = [
                'question_id' => $question->id,
                'tag_id' => $tag->id
            ];

        }
        TagsMapping::insert($insert);
//        $question->tags = $tagsIds;
        $question->save();

    }

    private function generateAnswers(Question &$question)
    {
        $turboPrompt = [];

        $prompt = $question->question . "\n\nUnderstand the above question and I need you to act like a user who is asking this question in a relevant forum. Provide good enough personal context to this question, so that users can answer your query";
        $turboPrompt[] = ['role' => 'user', 'content' => $prompt];

        $turboPrompt[] = ['role' => 'assistant', 'content' => $question->description];

        $random = rand(4, 8);
        for ($i = 1; $i <= $random; $i++) {
            if ($i == 1)
                $prompt = sprintf('Now contribute to this thread as user %d based on individual personal experience.', $i);
            else
                $prompt = sprintf('Now contribute to this thread as user %d based on individual personal experience. Please make sure the word length significantly differs from the last response in this thread and also the response style', $i);

            $turboPrompt[] = ['role' => 'user', 'content' => $prompt];
            $result = $this->AITurbo($turboPrompt);

            $question->total_tokens += $result['usage']['total_tokens'];
            $question->save();

            $turboPrompt[] = ['role' => 'assistant', 'content' => $result['choices'][0]['message']['content']];
            $user = ClientUser::fake()->inRandomOrder()->first();

            $carbon = Carbon::parse($question->created_at);
            $carbonToday = Carbon::now();

            $date = $carbon->addDays(rand(1, $carbonToday->diffInDays($carbon)))->addSeconds(rand(0, 86400));

            $question->answers()->create([
                'client_id' => $user->id,
                'answer' => trim($result['choices'][0]['message']['content'], '"'),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            sleep(3);
        }
//        $question->total_tokens = $question->total_tokens+$total_tokens;
//        $question->api_status = 'S';
//        $question->save();
    }
}
