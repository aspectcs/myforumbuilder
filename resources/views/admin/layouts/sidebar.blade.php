<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="@route('admin.dashboard')" class="app-brand-link">
            <img src="@route('uploads',$forumSettings['logo'])" class="img-fluid" alt="">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="@route('admin.dashboard')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        @if(auth()->user()->is_admin == true)
            <li class="menu-item">
                <a href="@route('admin.user.index')" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div>Admin User's</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="@route('admin.setting.index')" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div>Setting's</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="@route('admin.request-to-join.index')" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin"></i>
                    <div>Request To Join</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="@route('admin.scheduler.index')" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ol"></i>
                    <div>Scheduler's</div>
                </a>
            </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Modules</span>
        </li>
        <li class="menu-item">
            <a href="@route('admin.client-user.index')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>User's</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="@route('admin.category.index')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Categories</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="@route('admin.question.index')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-question-mark"></i>
                <div>Question's</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="@route('admin.tag.index')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-tag"></i>
                <div>Tag's</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Modules</span>
        </li>
        <li class="menu-item">
            <a href="@route('admin.check-update')" class="menu-link">
                <i class="menu-icon tf-icons bx bx-analyse"></i>
                <div>Check Update</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
