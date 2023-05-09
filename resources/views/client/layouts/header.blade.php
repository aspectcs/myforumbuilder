<nav class="navbar navbar-expand-lg menu_one dark_menu sticky-nav">
    <div
        class="container
        @isset($forumSettings)">
        <a class="navbar-brand header_logo" href="/">
            <img class="first_logo sticky_logo main_logo" src="@route('uploads',$forumSettings['logo'])" alt="logo">
            {{--            <img class="white_logo" src="@route('uploads',$forumSettings['logo-w'])" alt="White logo">--}}
        </a>
        @endisset
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="menu_toggle">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="hamburger-cross">
                        <span></span>
                        <span></span>
                    </span>
                </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @isset($forumNavbar)
                <ul class="navbar-nav menu ml-auto">
                    @foreach($forumNavbar as $nav)
                        <li class="nav-item dropdown submenu d-md-flex justify-content-md-center align-items-md-center">
                            <a href="{{$nav['href']}}" class="nav-link dropdown-toggle">{{$nav['label']}}</a>
                            @isset($nav['child'])
                                @if($nav['child'])
                                    <i class="arrow_carrot-down_alt2 mobile_dropdown_icon ml-2 d-md-inline-block" aria-hidden="false"
                                       data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        @foreach($nav['child'] as $child)
                                            <li class="nav-item">
                                                <a href="{{$child['href']}}" class="nav-link">{{$child['label']}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endisset
                        </li>
                    @endforeach
                    {{--<li class="nav-item dropdown submenu">
                        <a href="#" class="nav-link dropdown-toggle">Categories</a>
                        <i class="arrow_carrot-down_alt2 mobile_dropdown_icon" aria-hidden="false" data-toggle="dropdown"></i>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a href="" class="nav-link">Creative Helpdesk</a></li>
                        </ul>
                    </li>--}}
                </ul>
            @endisset
            <div class="right-nav">
                {{--<a class="px-2 ml-3" href="#" title="Subscribe to the newsletter">
                    <ion-icon name="mail"></ion-icon>
                </a>
                <a class="px-2" href="#" title="RSS feed">
                    <ion-icon name="logo-rss"></ion-icon>
                </a>
                <div class="px-2 js-darkmode-btn" title="Toggle dark mode">
                    <label for="something" class="tab-btn tab-btns">
                        <ion-icon class="light-mode" name="contrast"></ion-icon>
                    </label>
                    <input type="checkbox" name="something" id="something" class="dark_mode_switcher">
                    <label for="something" class="tab-btn">
                        <ion-icon class="dark-mode" name="contrast-outline"></ion-icon>
                    </label>
                </div>--}}
            </div>

        </div>
    </div>
</nav>
