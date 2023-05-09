<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @isset($forumSettings)
        <link rel="shortcut icon" href="@route('uploads',$forumSettings['favicon'])" type="image/x-icon">
    @endisset
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
    <link rel="stylesheet" href="@assets('plugins/autocomplete/autocomplete.css')">
    <link rel="stylesheet" href="@assets('css/style.css')">
    @stack('style')
    @isset($analytics)
        {!! $analytics !!}
    @endisset
</head>
<body data-scroll-animation="true">
<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        @isset($forumSettings)
            <div class="round_spinner">
                <div class="spinner"></div>
                <div class="text">
                    <img src="@route('uploads',$forumSettings['spinner-logo'])" alt="">
                    {{--                <h4><span>Docy</span></h4>--}}
                </div>
            </div>
            <span class="h2 head">{{$forumSettings['spinner-heading']}}</span>
            <p>{{$forumSettings['spinner-description']}}</p>
        @endisset
    </div>
</div>
<div class="body_wrapper">
    @include('MyForumBuilder::client.layouts.header')
    @yield('content')
    @include('MyForumBuilder::client.layouts.footer')
</div>
<!-- Back to top button -->
<a id="back-to-top" title="Back to Top"></a>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="@assets('js/jquery-3.5.1.min.js')"></script>
<script src="@assets('plugins/autocomplete/jquery.autocomplete.js')"></script>
<script src="@assets('plugins/bootstrap/js/popper.min.js')"></script>
<script src="@assets('plugins/bootstrap/js/bootstrap.min.js')"></script>
<script src="@assets('js/pre-loader.js')"></script>
<script src="@assets('plugins/wow/wow.min.js')"></script>
<script src="@assets('plugins/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js')"></script>
<script src="@assets('js/plugins.js')"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
@stack('script')
<script src="@assets('js/main.js')"></script>
<script>
    $(document).ready(function (e) {
        $('#searchbox').autocomplete({
            type: 'POST',
            paramName: 's',
            ajaxSettings: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            serviceUrl: '@route("search")',
            minChars: 1,
            onSelect: function (suggestion) {
                window.location.assign('@route("question","")/' + suggestion.slug);
            },
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results'
        });
    });
</script>

<script>
    $(document).ready(function () {
        if ($('.page-start').length > 0)
            window.scroll(0, $('.page-start').position().top);
    });
</script>
</body>
</html>
