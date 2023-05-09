<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Client;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    function sitemap()
    {
        return Response::view('MyForumBuilder::xml.sitemap', [
            'date' => Carbon::now()->tz('UTC')->toAtomString(),
            'statics' => [
                route('home') . '/',
            ],
            'categories' => Category::active()->get(),
//            'subcategories' => SubCategory::active()->get(),
//            'tags' => Tag::active()->get(),
            'questions' => Question::active()->get(),
        ])->header('Content-Type', 'text/xml');
    }
}
