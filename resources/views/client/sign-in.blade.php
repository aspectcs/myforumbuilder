@extends('MyForumBuilder::client.layouts.app')
@section('content')
    <section class="signup_area">
        <div class="row ml-0 mr-0">
            {{--<div class="sign_left signin_left">
                <h2>We are design changers do what matters.</h2>
                <img class="position-absolute top" src="@assets('img/signup/top_ornamate.png')" alt="top">
                <img class="position-absolute bottom" src="@assets('img/signup/bottom_ornamate.png')" alt="bottom">
                <img class="position-absolute middle" src="@assets('img/signup/door.png')" alt="bottom">
                <div class="round"></div>
            </div>--}}
            <div class="sign_right signup_right">
                <div class="sign_inner signup_inner">
                    <div class="text-center">
                        {{--<h3>Sign in to Docy platform</h3>--}}
                        <p>Don’t have an account yet? <a href="@route('sign-up')">Sign up here</a></p>
{{--                        <a href="#" class="btn-google"><img src="@assets('img/signup/gmail.png')" alt=""><span class="btn-text">Sign in with Gmail</span></a>--}}
                    </div>
                    <div class="divider">
                        <span class="or-text">or</span>
                    </div>
                    <form action="@route('sign-in')" class="row login_form" method="post">
                        @csrf
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Your email</div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="john@example.com">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="small_text">Password</div>
                            <div class="confirm_password">
                                <input id="confirm-password" name="password" type="password" class="form-control" placeholder="*********" autocomplete="off">
                                <a href="@route('forgot-password')" class="forget_btn">Forgotten password?</a>
                            </div>
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn action_btn thm_btn">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
