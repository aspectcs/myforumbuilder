<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Models\Question;
use Illuminate\Console\Command;

class GenerateRandomVisitorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:visitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Random Visitor Count';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $questions = Question::active()->get();
        foreach ($questions as $question) {
            if ($question->visitor_count <= 10) {
                if ($question->likes()->count() > 0) {
                    $question->visitor_count = $question->likes()->count() + rand(10, 250);
                } else {
                    $question->visitor_count = rand(10, 250);
                }
            } else {
                $question->visitor_count = $question->visitor_count + rand(2, 20);
            }
            $question->save();
        }
    }
}
