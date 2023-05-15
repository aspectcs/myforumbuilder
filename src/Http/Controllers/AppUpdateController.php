<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers;

use Aspectcs\MyForumBuilder\Facades\MyForumBuilder;

use Composer\InstalledVersions;

use Illuminate\Routing\Controller;

class AppUpdateController extends Controller
{

    public function check_update()
    {
        try {
            $response = MyForumBuilder::checkUpdate();
            return view('MyForumBuilder::update.check-update', $response->json());
        } catch (\Exception $e) {
            abort(401, $e->getMessage());
        }
    }

    public function do_update()
    {
        try {
            MyForumBuilder::update();
            return back()->withErrors([
                'message' => 'Everything updated.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}
