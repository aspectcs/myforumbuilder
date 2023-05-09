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
                        <h3 class="text-uppercase">Forgotten password?</h3>
                    </div>
                    <div class="divider">
                        <span class="or-text"></span>
                    </div>
                    <form action="@route('forgot-password')" class="row login_form" method="post">
                        @csrf
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Enter Your Email</div>
                            <input type="email" class="form-control" id="email" name="email"  placeholder="john@example.com">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn action_btn thm_btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
