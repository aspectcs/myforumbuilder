<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Aspectcs\MyForumBuilder\Models\Answer;
use Aspectcs\MyForumBuilder\Models\ClientUser;
use Aspectcs\MyForumBuilder\Models\Question;

class AdminDashboard extends Controller
{
    function dashboard()
    {
        return view('MyForumBuilder::admin.dashboard', [
            'totalTopics' => Question::count(),
            'totalPosts' => Answer::count(),
            'totalUsers' => ClientUser::count(),
        ]);
    }
}
