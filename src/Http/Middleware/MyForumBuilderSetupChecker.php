<?php

namespace Aspectcs\MyForumBuilder\Http\Middleware;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;
use Aspectcs\MyForumBuilder\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class MyForumBuilderSetupChecker
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('MY_FORUM_BUILDER_SETUP', null) == null) {
            if (env('DB_HOST', null) == null || env('DB_DATABASE', null) == null || env('DB_USERNAME', null) == null || env('DB_PASSWORD', null) == null) {
                return redirect()->route('setup.step1');
            } else if (env('APP_KEY', null) == null || env('APP_SECRET', null) == null) {
                return redirect()->route('setup.step2');
            } else {
                $migration = DB::table('migrations')->doesntExist();
                if ($migration) {
                    return redirect()->route('setup.step3');
                } else {
                    $users = User::count();
                    if ($users <= 0) {
                        return redirect()->route('setup.step4');
                    }
                }
            }
        }
        return $next($request);
    }
}
