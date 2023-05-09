@extends('MyForumBuilder::client.layouts.app-blank')
@section('content')
    <section class="signup_area signup_area_height">
        <div class="row ml-0 mr-0">
            <div class="sign_left signup_left">
                <h2>We are design changers do what matters.</h2>
                <img class="position-absolute top" src="@assets('img/signup/top_ornamate.png')" alt="top">
                <img class="position-absolute bottom" src="@assets('img/signup/bottom_ornamate.png')" alt="bottom">
                <img class="position-absolute middle wow fadeInRight" src="@assets('img/signup/man_image.png')" alt="bottom">
                <div class="round wow zoomIn" data-wow-delay="0.2s"></div>
            </div>
            <div class="sign_right signup_right">
                <div class="sign_inner signup_inner">
                    <div class="text-center">
{{--                        <h3>Create your Docy Account</h3>--}}
                        <p>Already have an account? <a href="@route('sign-in')">Sign in</a></p>
                        <a href="#" class="btn-google"><img src="@assets('img/signup/gmail.png')" alt=""><span class="btn-text">Sign up with Google</span></a>
                    </div>
                    <div class="divider">
                        <span class="or-text">or</span>
                    </div>
                    <form action="#" class="row login_form" method="post">
                        <div class="col-sm-6 form-group">
                            <div class="small_text">First name</div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="John">
                        </div>
                        <div class="col-sm-6 form-group">
                            <div class="small_text">Last name</div>
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Doe">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Your email</div>
                            <input type="email" class="form-control" id="email" placeholder="john@example.com">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Password</div>
                            <input id="signup-password" name="signup-password" type="password" class="form-control" placeholder="5+ characters required" autocomplete="off">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="small_text">Confirm password</div>
                            <input id="confirm-password" name="confirm-password" type="password" class="form-control" placeholder="5+ characters required" autocomplete="off">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="check_box">
                                <input type="checkbox" value="None" id="squared2" name="check">
                                <label class="l_text" for="squared2">I accept the <span>politic of confidentiality</span></label>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn action_btn thm_btn">Create an account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
