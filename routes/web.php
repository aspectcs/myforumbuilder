<?php

use Aspectcs\MyForumBuilder\Http\Controllers\Admin\AdminDashboard;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\AnswerController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\AuthenticationController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\CategoriesController;
use Aspectcs\MyForumBuilder\Http\Controllers\Client\ClientController;
use Aspectcs\MyForumBuilder\Http\Controllers\SetupController;
use Aspectcs\MyForumBuilder\Http\Controllers\Client\SitemapController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\ClientUserController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\QuestionImportController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\RequestToJoinController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\SchedulerController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\QuestionController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\Select2Controller;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\SettingsController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\SubCategoryController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\TagsController;
use Aspectcs\MyForumBuilder\Http\Controllers\Admin\UserController;
use Aspectcs\MyForumBuilder\Http\Middleware\MyForumBuilderSetupChecker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::controller(SetupController::class)->prefix('setup')->name('setup.')->group(function () {
    Route::get("step1", 'step1')->name("step1");
    Route::get("step2", 'step2')->name("step2");
    Route::get("step3", 'step3')->name("step3");
    Route::get("step4", 'step4')->name("step4");
    Route::get("step5", 'step5')->name("step5");
    Route::post("action", 'action')->name("action");
});


Route::get('clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
});

Route::middleware(MyForumBuilderSetupChecker::class)->group(function () {
    Route::macro('resourcesWithJson', function (array $resources, array $options) {
        foreach ($resources as $key => $resource) {
            Route::resource($key, $resource, $options);
            $chunks = explode('.', $key);
            if (count($chunks) > 1) {
                $prefix = $chunks[0] . '/{' . $chunks[0] . '}/' . $chunks[1];
                $modelKey = str_replace('-', '_', $chunks[1]);
            } else {
                $prefix = $name = $key;
                $modelKey = str_replace('-', '_', $key);
            }
            Route::controller($resource)->prefix($prefix)->name($key . '.')->group(function () use ($modelKey) {
                Route::post("json", 'json')->name("json");
                Route::patch("{" . $modelKey . "}/status", 'status')->name("status");
            });
        }
    });

    Route::get('upload/{name}', function ($filename) {
        //$path = storage_path('app/public/upload/' . $filename);
        $path = storage_path('app/upload/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        return response($file)
            ->header('Content-Type', $type)
            ->header('Pragma', 'public')
            ->header('Cache-Control', 'max-age=60, must-revalidate');
    })->where('filename', ':[A-Za-z0-9\./\_-]+')->name('uploads');

    Route::prefix(env('ADMIN_URL_PREFIX', '--admin--'))->name('admin.')->group(function () {
        Route::get('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('login', [AuthenticationController::class, 'loginMeIn']);
        Route::middleware('auth:forum-admin')->group(function () {
            Route::get('/', [AdminDashboard::class, 'dashboard'])->name('dashboard');
            Route::get('change-password', [AuthenticationController::class, 'change_password'])->name('change-password');
            Route::put('change-password', [AuthenticationController::class, 'change_password_process'])->name('change-password');
            Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');


            Route::post('select2/sub-category', [Select2Controller::class, 'sub_category'])->name('select2.sub-category');

            Route::resourcesWithJson([
                'user' => UserController::class,
                'client-user' => ClientUserController::class,
                'category' => CategoriesController::class,
                'category.sub-category' => SubCategoryController::class,
                'question' => QuestionController::class,
                'question.answer' => AnswerController::class,
                'tag' => TagsController::class,
                'setting' => SettingsController::class,
            ], [
                'except' => 'show',
                'parameters' => [
                    'client_user' => 'clientUser',
                    'sub_category' => 'subCategory'
                ]
            ]);

            Route::patch('question/{question}/popular', [QuestionController::class, 'popular'])->name('question.popular');
            Route::patch('category/{category}/popular', [CategoriesController::class, 'popular'])->name('category.popular');
            Route::patch('tag/{tag}/popular', [TagsController::class, 'popular'])->name('tag.popular');

            Route::controller(QuestionImportController::class)->prefix('questions/import')->name('questions.import.')->group(function () {
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('sample', 'sample')->name('sample');
            });

            Route::controller(SchedulerController::class)->prefix('scheduler')->name('scheduler.')->group(function () {
                Route::get("/", 'index')->name("index");
                Route::post("json", 'json')->name("json");
                Route::delete('{scheduler}', 'destroy')->name('destroy');

                Route::get("run/{type}", 'run_artisan')->name("run.artisan");

            });

            Route::controller(RequestToJoinController::class)->prefix('request-to-join')->name('request-to-join.')->group(function () {
                Route::get("/", 'index')->name("index");
                Route::post("json", 'json')->name("json");
            });
        });
    });


    Route::get('/', [ClientController::class, 'index'])->name('home');
    Route::post('search', [ClientController::class, 'search'])->name('search');
    Route::get('sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
//Route::get('sign-up', [ClientController::class, 'sign_up'])->name('sign-up');
    Route::redirect('sign-up', 'request-to-join')->name('sign-up');

    Route::get('sign-in', [ClientController::class, 'sign_in'])->name('sign-in');
    Route::post('sign-in', [ClientController::class, 'sign_in_post']);

    Route::get('forgot-password', [ClientController::class, 'forgot_password'])->name('forgot-password');
    Route::post('forgot-password', [ClientController::class, 'forgot_password_post']);

    Route::get('request-to-join', [ClientController::class, 'request_to_join'])->name('request-to-join');
    Route::post('request-to-join', [ClientController::class, 'request_to_join_post'])->name('request-to-join');
    Route::get('thank-you', [ClientController::class, 'thank_you'])->name('thank-you');
    Route::get('user/{clientUser:username}', [ClientController::class, 'user'])->name('user');
    Route::get('tag/{tag:slug}', [ClientController::class, 'tag'])->name('tag');
    Route::get('category/{category:slug}', [ClientController::class, 'category'])->name('category');
    Route::get('category/{category:slug}/{subCategory:slug}', [ClientController::class, 'sub_category'])->name('sub-category');
    Route::get('{question:slug}', [ClientController::class, 'question'])->name('question');
});
