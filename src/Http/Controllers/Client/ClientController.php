<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Client;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Category;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;
use Aspectcs\MyForumBuilder\Models\RequestToJoin;
use Aspectcs\MyForumBuilder\Models\Setting;
use Aspectcs\MyForumBuilder\Models\SubCategory;
use Aspectcs\MyForumBuilder\Models\Tag;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class ClientController extends Controller
{
    function index()
    {
        View::share('canonical', route('home') . '/');
        View::share('breadcrumbs', [
            [
                'label' => 'Home',
                'href' => '/'
            ],
            [
                'label' => 'Community',
                'href' => '#'
            ]
        ]);
        return view('MyForumBuilder::client.index', [
            'categories' => Category::active()->has('questions')->get(),
            'latest' => Question::active()->take(15)->orderBy('created_at', 'DESC')->get(),
            'popular' => Question::active()->popular()->take(15)->orderBy('created_at', 'DESC')->get(),
            'tags' => Tag::active()->popular()->get(),
            'setting' => Setting::getData(1)
        ]);
    }

    function user(ClientUser $clientUser)
    {
        View::share('canonical', route('user', $clientUser->username));
        $setting = Setting::getData(5);
        return view('MyForumBuilder::client.user', [
            'client' => $clientUser,
            'topicStarted' => $clientUser->questions()->active()->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'topics'),
            'repliesCreated' => $clientUser->answers()->active()->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'replies'),
            'setting' => ['title' => str_replace(['[NAME]', '[USERNAME]'], [$clientUser->name, $clientUser->username], $setting['title']), 'description' => str_replace(['[NAME]', '[USERNAME]'], [$clientUser->name, $clientUser->username], $setting['description'])]
        ]);
    }

    function tag(Tag $tag)
    {
        View::share('heading', $tag->name . ' Tag - Related Discussion Topics');
        View::share('canonical', route('tag', $tag->slug));
        View::share('breadcrumbs', [
            [
                'label' => 'Home',
                'href' => '/'
            ],
            [
                'label' => 'Community',
                'href' => route('home')
            ],
            [
                'label' => $tag->name,
                'href' => '#'
            ]
        ]);
        $setting = Setting::getData(4);
        return view('MyForumBuilder::client.tag', [
            'totalContributors' => $tag->totalContributors(),
            'totalTopics' => $tag->questions()->count(),
            'totalPosts' => $tag->totalPosts(),

            'recent' => $tag->questions()->active()->orderBy('created_at', 'DESC')->take(5)->get(),
            'pagination' => $tag->questions()->active()->orderBy('created_at', 'DESC')->paginate(50),
            'subCategories' => null,
            'popularCategories' => Category::popular()->get(),
            'tags' => Tag::popular()->get(),
            'popularTopics' => Question::popular()->orderBy('created_at', 'DESC')->take(6)->get(),
            /*'recent7days' => $tag->questions()->where('created_at', '>', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),
            'recent30days' => $tag->questions()->where('created_at', '>', Carbon::now()->subDays(30))->where('created_at', '<', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),*/
            'setting' => ['title' => str_replace('[TAG]', $tag->name, $setting['title']), 'description' => str_replace('[TAG]', $tag->name, $setting['description'])]
        ]);
    }

    function category(Category $category)
    {
        View::share('heading', $category->name . ' Category - Related Discussion Topics');
        View::share('canonical', route('category', $category->slug));
        View::share('breadcrumbs', [
            [
                'label' => 'Home',
                'href' => '/'
            ],
            [
                'label' => 'Community',
                'href' => route('home')
            ],
            [
                'label' => $category->name,
                'href' => '#'
            ]
        ]);
        $setting = Setting::getData(2);
        return view('MyForumBuilder::client.category', [
            'totalContributors' => $category->totalContributors(),
            'totalTopics' => $category->questions()->count(),
            'totalPosts' => $category->totalPosts(),

            'category' => $category,
            'recent' => $category->questions()->active()->orderBy('created_at', 'DESC')->take(5)->get(),
            'pagination' => $category->questions()->active()->orderBy('created_at', 'DESC')->paginate(50),
            'subCategories' => $category->subCategories()->active()->get(),
            'popularCategories' => Category::where('id', '!=', $category->id)->popular()->get(),
            'tags' => Tag::active()->popular()->get(),
            'popularTopics' => Question::popular()->orderBy('created_at', 'DESC')->take(6)->get(),
            /* 'recent7days' => $category->questions()->where('created_at', '>', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),
             'recent30days' => $category->questions()->where('created_at', '>', Carbon::now()->subDays(30))->where('created_at', '<', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),*/
            'setting' => ['title' => str_replace('[CATEGORY]', $category->name, $setting['title']), 'description' => str_replace('[CATEGORY]', $category->name, $setting['description'])]
        ]);
    }

    function sub_category(Category $category, SubCategory $subCategory)
    {
        View::share('heading', $subCategory->name . ' Category - Related Discussion Topics');
        View::share('canonical', route('sub-category', ['category' => $category->slug, 'subCategory' => $subCategory->slug]));
        View::share('breadcrumbs', [
            [
                'label' => 'Home',
                'href' => '/'
            ],
            [
                'label' => 'Community',
                'href' => route('home')
            ],
            [
                'label' => $category->name,
                'href' => route('category', $category->slug)
            ],
            [
                'label' => $subCategory->name,
                'href' => '#'
            ]
        ]);
        $setting = Setting::getData(3);

        return view('MyForumBuilder::client.category', [
            'totalContributors' => $subCategory->totalContributors(),
            'totalTopics' => $subCategory->questions()->count(),
            'totalPosts' => $subCategory->totalPosts(),

            'category' => $category,
            'subCategory' => $subCategory,
            'recent' => $subCategory->questions()->active()->orderBy('created_at', 'DESC')->take(5)->get(),
            'pagination' => $subCategory->questions()->active()->orderBy('created_at', 'DESC')->paginate(50),
            'popularCategories' => Category::where('id', '!=', $category->id)->popular()->get(),
            'tags' => Tag::active()->popular()->get(),
            'popularTopics' => Question::active()->popular()->orderBy('created_at', 'DESC')->take(6)->get(),
            /*'recent7days' => $subCategory->questions()->where('created_at', '>', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),
            'recent30days' => $subCategory->questions()->where('created_at', '>', Carbon::now()->subDays(30))->where('created_at', '<', Carbon::now()->subDays(7))->orderBy('created_at', 'DESC')->take(6)->get(),*/
            'setting' => ['title' => str_replace(['[CATEGORY]', '[SUB-CATEGORY]'], [$category->name, $subCategory->name], $setting['title']), 'description' => str_replace(['[CATEGORY]', '[SUB-CATEGORY]'], [$category->name, $subCategory->name], $setting['description'])]
        ]);
    }

    function question(Question $question)
    {
        View::share('canonical', route('question', $question->slug));
        $question->increaseVisitor();
        $breadcrumbs = [];
        $breadcrumbs[] = [
            'label' => 'Home',
            'href' => '/'
        ];
        $breadcrumbs[] = [
            'label' => 'Community',
            'href' => route('home')
        ];
        $breadcrumbs[] = [
            'label' => $question->category->name,
            'href' => route('category', $question->category->slug)
        ];
        if ($question->sub_category) {
            $breadcrumbs[] = [
                'label' => $question->sub_category->name,
                'href' => route('sub-category', ['category' => $question->category->slug, 'subCategory' => $question->sub_category->slug])
            ];
        }
        $breadcrumbs[] = [
            'label' => $question->question,
            'href' => '#'
        ];

        View::share('breadcrumbs', $breadcrumbs);

        return view('MyForumBuilder::client.question', [
            'client' => $question->client,
            'question' => $question,
            'previous' => $question->previous(),
            'next' => $question->next(),
            'answers' => $question->answers()->active()->orderBy('created_at', 'DESC'),
            'tags' => Tag::active()->popular()->get(),
            'recent' => Question::active()->orderBy('created_at', 'DESC')->take(5)->get(),
            'popularTopics' => Question::active()->popular()->orderBy('created_at', 'DESC')->take(6)->get(),
            'related' => $question->category->questions()->active()->where('id', '!=', $question->id)->whereHas('tags', function (Builder $query) use ($question) {
                if ($question->tags()->active()->count() > 0) {
                    foreach ($question->tags()->active()->get() as $index => $tag) {
                        if ($index == 0) {
                            $query->where('tag_id', $tag->id);
                        } else {
                            $query->orWhere('tag_id', $tag->id);
                        }
                    }
                }
            })->inRandomOrder()->take(10)->get()
        ]);
    }

    function sign_up()
    {
        View::share('canonical', route('sign-up'));
        return view('MyForumBuilder::client.sign-up');
    }

    function sign_in()
    {
        View::share('canonical', route('sign-in'));
        return view('MyForumBuilder::client.sign-in');
    }

    function sign_in_post(Request $request)
    {
        $insert = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        return redirect()->back()->withErrors(['email' => 'There is no account associated with this email']);
    }

    function forgot_password()
    {
        View::share('canonical', route('forgot-password'));
        return view('MyForumBuilder::client.forgot-password');
    }

    function forgot_password_post(Request $request)
    {
        $insert = $request->validate([
            'email' => ['required', 'email'],
        ]);
        return redirect()->back()->withErrors(['email' => 'There is no account associated with this email']);
    }

    function request_to_join()
    {
        View::share('canonical', route('request-to-join'));
        return view('MyForumBuilder::client.request-to-join');
    }

    function request_to_join_post(Request $request)
    {
        $insert = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);
        RequestToJoin::create($insert);
        return redirect()->route('thank-you');
    }

    function thank_you()
    {
        View::share('canonical', route('thank-you'));
        return view('MyForumBuilder::client.thank-you');
    }

    function search(Request $request)
    {
        $request->validate([
            's' => ['required', 'string']
        ]);
        return [
            'query' => $request->s,
            'suggestions' => Question::select('id', 'question as value', 'slug')->where('question', 'LIKE', '%' . $request->s . '%')->get()
        ];
    }
}
