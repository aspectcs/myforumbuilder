<?php

namespace Aspectcs\MyForumBuilder\Http\Middleware;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;
use Closure;
use Illuminate\Http\Request;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;

class MyForumBuilderAdminChecker
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $client = MyForumBuilder::details();
            define('MY_FORUM_BUILDER_TOKENS', $client->json('user.wallet'));
        } catch (Exception $e) {
            //Ignore error
            define('MY_FORUM_BUILDER_TOKENS', 'UNAUTHORIZED');
        }
        return $next($request);
    }
}
