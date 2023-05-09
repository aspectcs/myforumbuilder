<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="@route('uploads',$forumSettings['favicon'])" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($canonical)
        <link rel="canonical" href="{{$canonical}}"/>
    @endisset
    @stack('meta')

    <link rel="stylesheet" href="@assets('plugins/bootstrap/css/bootstrap.min.css')"/>
    <!-- icon css-->
    <link rel="stylesheet" href="@assets('plugins/elagent-icon/style.css')">
    <link rel="stylesheet" href="@assets('plugins/animation/animate.css')">
    <link rel="stylesheet" href="@assets('css/style-main.css')">
    <link rel="stylesheet" href="@assets('css/responsive.css')">

    @stack('style')
    {!! $analytics !!}
</head>
<body data-scroll-animation="true" class="body_dark">
<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="round_spinner">
            <div class="spinner"></div>
            <div class="text">
                <img src="@route('uploads',$forumSettings['spinner-logo'])" alt="">
                {{--                <h4><span>Docy</span></h4>--}}
            </div>
        </div>
        <h2 class="head">{{$forumSettings['spinner-heading']}}</h2>
        <p>{{$forumSettings['spinner-description']}}</p>
    </div>
</div>
<div class="body_wrapper">
    @yield('content')
</div>
<!-- Back to top button -->
<a id="back-to-top" title="Back to Top"></a>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="@assets('js/jquery-3.5.1.min.js')"></script>
<script src="@assets('js/pre-loader.js')"></script>
<script src="@assets('plugins/bootstrap/js/popper.min.js')"></script>
<script src="@assets('plugins/bootstrap/js/bootstrap.min.js')"></script>

<script src="@assets('js/parallaxie.js')"></script>
<script src="@assets('js/TweenMax.min.js')"></script>
<script src="@assets('plugins/wow/wow.min.js')"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="@assets('js/main.js')"></script>

@stack('script')
</body>
</html>
