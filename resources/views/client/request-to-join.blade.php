@extends('MyForumBuilder::client.layouts.app')
@section('content')
    <section class="signup_area signup_area_height">
        <div class="row ml-0 mr-0">
            {{--<div class="sign_left signup_left">
                <h2>We are design changers do what matters.</h2>
                <img class="position-absolute top" src="@assets('img/signup/top_ornamate.png')" alt="top">
                <img class="position-absolute bottom" src="@assets('img/signup/bottom_ornamate.png')" alt="bottom">
                <img class="position-absolute middle wow fadeInRight" src="@assets('img/signup/man_image.png')"
                     alt="bottom">
                <div class="round wow zoomIn" data-wow-delay="0.2s"></div>
            </div>--}}
            <div class="sign_right signup_right">
                <div class="sign_inner signup_inner">
                    <div class="text-center">
                        <h3 class="text-uppercase">Request to join</h3>
                    </div>
                    <div class="divider">
                        <span class="or-text"></span>
                    </div>
                    <form action="@route('request-to-join')" class="row login_form" method="post">
                        @csrf
                        <div class="col-sm-6 form-group">
                            <div class="small_text">First name</div>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   placeholder="John">
                            @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col-sm-6 form-group">
                            <div class="small_text">Last name</div>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Doe">
                            @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Your email</div>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="john@example.com">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{--<div class="col-lg-12 form-group">
                            <div class="check_box">
                                <input type="checkbox" value="None" id="squared2" name="check">
                                <label class="l_text" for="squared2">I accept the
                                    <span>politic of confidentiality</span></label>
                            </div>
                        </div>--}}
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn action_btn thm_btn">Create an account</button>
                        </div>
                    </form>
                </div>
       </div>
        </div>
    </section>
@endsection
