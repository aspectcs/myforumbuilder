@extends('MyForumBuilder::client.layouts.app')
@push('style')
    <style>
        .thankyou-wrapper{
            width:100%;
            height:calc(100vh - 100px);
            margin:auto;
            background:#ffffff;
            padding:10px 0px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .thankyou-wrapper h1{
            font:100px Arial, Helvetica, sans-serif;
            text-align:center;
            color:#333333;
            padding:0px 10px 10px;
        }
        .thankyou-wrapper p{
            font:26px Arial, Helvetica, sans-serif;
            text-align:center;
            color:#333333;
            padding:5px 10px 10px;
        }
    </style>
@endpush
@section('content')
    <section class="login-main-wrapper">
        <div class="main-container">
            <div class="login-process">
                <div class="login-main-container">
                    <div class="thankyou-wrapper">
                       <img class="img-fluid" src="@assets('img/thankyou.webp')" alt="thanks" />
                        <p>for contacting us, we will get in touch with you soon... </p>
                        <a class="btn btn-outline-primary w-auto" href="@route('home')">Back to home</a>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </section>
@endsection
