<?php

namespace Aspectcs\MyForumBuilder\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;


class AuthenticationController extends Controller
{
    function login()
    {
        return view('MyForumBuilder::admin.auth.login');
    }

    function loginMeIn(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::guard('forum-admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('forum-admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function change_password(Request $request)
    {
        return view('MyForumBuilder::admin.auth.change-password');
    }

    public function change_password_process(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed'],
        ]);
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.dashboard');

    }
}
