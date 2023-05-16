<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;
use Aspectcs\MyForumBuilder\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

use Aspectcs\MyForumBuilder\Database\Seeders\SettingsSeeder;
use Aspectcs\MyForumBuilder\Database\Seeders\FakeClientSeeder;

class SetupController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        if (env('MY_FORUM_BUILDER_SETUP', null) === 'Completed') {
            $redirect->to('/')->send();
            die;
        }
    }

    function step1()
    {
        return view('MyForumBuilder::setup.step1');
    }

    function step2()
    {
        return view('MyForumBuilder::setup.step2');
    }

    function step3()
    {
        return view('MyForumBuilder::setup.step3');
    }

    function step4()
    {
        try {
            $response = MyForumBuilder::details();
            if ($response->ok()) {
                $email = $response->json('user.email');
                return view('MyForumBuilder::setup.step4', ['email' => $email]);
            }
        } catch (Exception $e) {
            return redirect()->route('setup.step2')->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    function step5()
    {
        try {
            shell_exec("(crontab -l ; echo '* * * * * cd " . base_path() . " && php artisan schedule:run >/dev/null 2>&1') | sort | uniq | crontab");
        } catch (Exception $e) {

        }
        return view('MyForumBuilder::setup.step5');
    }

    function action(Request $request)
    {
        $request->validate([
            'step' => [
                'required',
                Rule::in([
                    'step1',
                    'step2',
                    'step3',
                    'step4',
                    'step5',
                ])
            ]
        ]);
        $route = '';
        $message = '';
        switch ($request->step) {
            case "step1":
                $insert = $request->validate([
                    'DB_HOST' => 'required',
                    'DB_DATABASE' => 'required',
                    'DB_USERNAME' => 'required',
                    'DB_PASSWORD' => 'required'
                ], [
                    'DB_HOST.required' => 'The database host is required.',
                    'DB_DATABASE.required' => 'The database name is required.',
                    'DB_USERNAME.required' => 'The database username is required.',
                    'DB_PASSWORD.required' => 'The database password is required.',
                ]);
                $connection = env('DB_CONNECTION', 'mysql');
                Config::set('database.connections.' . $connection . '.host', $insert['DB_HOST']);
                Config::set('database.connections.' . $connection . '.database', $insert['DB_DATABASE']);
                Config::set('database.connections.' . $connection . '.username', $insert['DB_USERNAME']);
                Config::set('database.connections.' . $connection . '.password', $insert['DB_PASSWORD']);
                try {
                    DB::connection()->getPDO();
                    foreach ($insert as $key => $value) {
                        put_permanent_env($key, trim($value));
                    }
                    $message = 'Database is connected. Database Name is : ' . DB::connection()->getDatabaseName();
                } catch (Exception $e) {
                    return back()->withErrors([
                        'error' => $e->getMessage()
                    ]);
                }
                $route = 'setup.step2';
                break;
            case "step2":
                $insert = $request->validate([
                    'APP_KEY' => 'required',
                    'APP_SECRET' => 'required',
                ], [
                    'APP_KEY.required' => 'The APP KEY is required.',
                    'APP_SECRET.required' => 'The APP SECRET is required.',
                ]);
                try {
                    $response = MyForumBuilder::validateKeys($insert['APP_KEY'], $insert['APP_SECRET']);
                    if ($response->ok()) {
                        foreach ($insert as $key => $value) {
                            put_permanent_env($key, trim($value));
                        }
                        $message = 'Token validate from server.';
                    }
                } catch (Exception $e) {
                    return back()->withErrors([
                        'error' => $e->getMessage()
                    ]);
                }
                $route = 'setup.step3';
                break;
            case "step3":
                try {
                    Artisan::call('migrate');
                    Artisan::call("db:seed", ['--class' => SettingsSeeder::class]);
                    Artisan::call("db:seed", ['--class' => FakeClientSeeder::class]);
                    put_permanent_env('FORUM_START_DATE', Carbon::now()->subYears(2)->format('Y-m-d'));
                    $message = 'Database Migrated.';
                } catch (Exception $e) {
                    return back()->withErrors([
                        'error' => $e->getMessage()
                    ]);
                }
                $route = 'setup.step4';
                break;
            case "step4":
                $insert = $request->validate([
                    'ADMIN_URL_PREFIX' => 'required',
//                    'ADMIN_EMAIL' => 'required|email',
                    'ADMIN_PASSWORD' => 'required',
                ], [
                    'ADMIN_URL_PREFIX.required' => 'Url prefix is required.',
//                    'ADMIN_EMAIL.required' => 'The Admin Email is required.',
//                    'ADMIN_EMAIL.email' => 'Enter a valid email address.',
                    'ADMIN_PASSWORD.required' => 'The Admin password is required.',
                ]);
                try {
                    $response = MyForumBuilder::details();
                    if ($response->ok()) {
                        $adminPrefix = Str::lower($insert['ADMIN_URL_PREFIX']);
                        put_permanent_env('ADMIN_URL_PREFIX', $adminPrefix);
                        put_permanent_env('APP_URL', $response->json('user.forum_url'));
                        $user = User::updateOrCreate([
                            'email' => $response->json('user.email'),
                        ], [
                            'name' => $response->json('user.name'),
                            'password' => Hash::make($insert['ADMIN_PASSWORD']),
                            'is_admin' => true,
                            'email_verified_at' => Carbon::now()
                        ]);
                        Auth::guard('forum-admin')->login($user);
                        $message = 'Admin Created.';
                    }
                } catch (Exception $e) {
                    return back()->withErrors([
                        'error' => $e->getMessage()
                    ]);
                }
                $route = 'setup.step5';
                break;
            case "step5":
                put_permanent_env('MY_FORUM_BUILDER_SETUP', 'Completed');
                shell_exec('crontab -e > ');
                return redirect()->route('admin.setting.index');
        }
        return redirect()->route($route)->withErrors([
            'message' => $message
        ]);
    }
}
