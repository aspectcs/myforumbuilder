<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Console\Command;

class FilterTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Filtering tag active those whose count is greater than or equal to 2';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tags = Tag::all();
        foreach ($tags as $tag) {
            if ($tag->questions()->count() >= 2) {
                $tag->status = true;
            } else {
                $tag->status = false;
            }
            $tag->save();
        }
    }
}
