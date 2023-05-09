<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Models\Answer;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateRandomLikeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:likes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate random Like For posts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $carbonToday = Carbon::now();
        $questions = Question::active()->doesntHave('likes')->get();
        foreach ($questions as $question) {
            $rand = rand(10, ClientUser::fake()->active()->count() * 0.50);
            $clients = ClientUser::fake()->inRandomOrder()->take($rand)->get();

            if ($question->visitor_count < $rand) {
                $question->visitor_count = $rand + rand(10, 250);
                $question->save();
            }

            foreach ($clients as $client) {
                /*$carbon = Carbon::create(($client->created_at > $question->created_at ? $client->created_at : $question->created_at));
                $diff = rand(1, $carbonToday->diffInDays($carbon));
                $date = $carbon->addDays($diff)->addSeconds(rand(0, 86400));*/
                $question->likes()->firstOrCreate([
                    'question_id' => $question->id,
                    'client_id' => $client->id,
                ]/*, [
                    'created_at' => $date,
                    'updated_at' => $date
                ]*/);
            }
        }

        $answers = Answer::active()->doesntHave('likes')->get();
        foreach ($answers as $answer) {
            $rand = rand(1, 5);
            $clients = ClientUser::inRandomOrder()->take($rand)->get();
            foreach ($clients as $client) {
                /*$carbon = Carbon::create(($client->created_at > $question->created_at ? $client->created_at : $question->created_at));
                $diff = rand(1, $carbonToday->diffInDays($carbon));
                $date = $carbon->addDays($diff)->addSeconds(rand(0, 86400));*/
                $answer->likes()->firstOrCreate([
                    'answer_id' => $answer->id,
                    'client_id' => $client->id,
                ]/*, [
                    'created_at' => $date,
                    'updated_at' => $date
                ]*/);
            }
        }
    }
}
