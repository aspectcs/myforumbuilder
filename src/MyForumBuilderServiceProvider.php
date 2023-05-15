<?php

namespace Aspectcs\MyForumBuilder;

use Aspectcs\MyForumBuilder\Models\Setting;
use Aspectcs\MyForumBuilder\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Aspectcs\MyForumBuilder\Console\Commands\CalculatePopularTagCommand;
use Aspectcs\MyForumBuilder\Console\Commands\FilterTags;
use Aspectcs\MyForumBuilder\Console\Commands\GenerateQuestionsCommand;
use Aspectcs\MyForumBuilder\Console\Commands\GenerateRandomLikeCommand;
use Aspectcs\MyForumBuilder\Console\Commands\GenerateRandomVisitorCommand;
use Aspectcs\MyForumBuilder\Console\Commands\GenerateRandomWeeklyLikeCommand;
use Aspectcs\MyForumBuilder\Console\Commands\ImportQuestionsCommand;

class MyForumBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('MyForumBuilder', function ($app) {
            return new MyForumBuilder();
        });

        $this->commands([
            ImportQuestionsCommand::class,
            GenerateQuestionsCommand::class,
            CalculatePopularTagCommand::class,
            GenerateRandomWeeklyLikeCommand::class,
            GenerateRandomLikeCommand::class,
            GenerateRandomVisitorCommand::class,
            FilterTags::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        Config::set('auth.guards.forum-admin', [
            'driver' => 'session',
            'provider' => 'forum-admin',
        ]);

        Config::set('auth.providers.forum-admin', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


        if ($this->app->runningInConsole()) {
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command(ImportQuestionsCommand::class)->everyFifteenMinutes()->withoutOverlapping();
                $schedule->command(GenerateQuestionsCommand::class)->withoutOverlapping();
                $schedule->command(CalculatePopularTagCommand::class)->monthly();
                $schedule->command(GenerateRandomWeeklyLikeCommand::class)->weekly();
                $schedule->command(GenerateRandomLikeCommand::class)->daily();
                $schedule->command(GenerateRandomVisitorCommand::class)->daily();
                $schedule->command(FilterTags::class)->daily();
            });
        }

        if (!$this->app->runningInConsole()) {
            Blade::directive('asset', function ($expression) {
                return "<?= asset('vendor/my-forum-builder/admin/'.{$expression}) ?>";
            });
            Blade::directive('assets', function ($expression) {
                return "<?= asset('vendor/my-forum-builder/assets/'.{$expression}) ?>";
            });
            Blade::directive('route', function ($expression) {
                return "<?= route({$expression}) ?>";
            });
            Blade::directive('json', function ($expression) {
                return "<?= json_encode({$expression}) ?>";
            });

            if (env('MY_FORUM_BUILDER_SETUP', null) !== null) {

                $setting11 = Setting::getData(11);
                View::share('forumName', @$setting11['name']);

                View::share('forumNavbar', Setting::getData(6));

                View::share('forumFooter', Setting::getData(14));

                View::share('forumSettings', Setting::getData(7));

                $analytics = Setting::getData(8);
                View::share('analytics', @$analytics['analytics']);

                $ads = Setting::getData(9);
                View::share('ads', @$ads['ads']);
            }
        }

        $this->app->booted(function () {
            Route::middleware('api')->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });

            Route::middleware('web')->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'MyForumBuilder');

        });

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/my-forum-builder'),
//            __DIR__.'/../database' => base_path('database'),
        ], 'my-forum-builder');
    }
}
