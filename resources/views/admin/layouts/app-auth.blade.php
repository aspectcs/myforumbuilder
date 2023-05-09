<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title','Forum')</title>

    <meta name="description" content="@yield('description','')"/>

    @isset($forumSettings)
        <link rel="shortcut icon" href="@route('uploads',$forumSettings['favicon'])" type="image/x-icon">
    @endisset

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="@asset('fonts/boxicons.css')"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="@asset('css/core.css')" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="@asset('css/theme-default.css" class="template-customizer-theme-css')"/>
    <link rel="stylesheet" href="@asset('css/demo.css')"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="@asset('libs/perfect-scrollbar/perfect-scrollbar.css')"/>

    <!-- Page CSS -->


    @stack('style')
</head>

<body>
<!-- Content -->

<div class="container-xxl">
        @yield('content')
</div>

<!-- / Content -->

<!-- Helpers -->
<script src="@asset('js/helpers.js')"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="@asset('js/config.js')"></script>

<!-- Core JS -->
<!-- build:js assets/admin/js/core.js -->
<script src="@asset('libs/jquery/jquery.js')"></script>
<script src="@asset('libs/popper/popper.js')"></script>
<script src="@asset('js/bootstrap.js')"></script>
<script src="@asset('libs/perfect-scrollbar/perfect-scrollbar.js')"></script>

<script src="@asset('js/menu.js')"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="@asset('js/main.js')"></script>

<!-- Page JS -->

@stack('script')

</body>
</html>
