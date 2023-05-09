<?php

namespace Aspectcs\MyForumBuilder\Console\Commands;

use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Console\Command;

class CalculatePopularTagCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:popular-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculating popular tag';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Tag::query()->update([
            'popular' => 0
        ]);

        $tags = Tag::active()->get();
        $tagsArray = [];
        foreach ($tags as $tag) {
            $tagsArray[] = [
                'count' => $tag->questions()->count(),
                'id' => $tag->id
            ];
        }
        $popular = collect($tagsArray)->sortBy('count')->pop(15)->pluck('id')->toArray();

        Tag::whereIn('id', $popular)->update(['popular'=> true]);
    }
}
