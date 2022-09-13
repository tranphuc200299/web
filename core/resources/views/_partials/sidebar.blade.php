<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <a href="{{route('cp')}}">
            <img src="{{ public_url('assets/img/logo.png') }}" alt="logo" class="brand"
                 data-src="{{ public_url('assets/img/logo.png') }}"
                 data-src-retina="{{ public_url('assets/img/logo.png') }}"
                 width="78" height="22">
        </a>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
{{--            <li class="pin-menu-item">--}}
{{--                <span class="pin-menu-custom icon-thumbnail" data-toggle-pin="sidebar" id="btnPinMenu">--}}
{{--                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>--}}
{{--                </span>--}}
{{--                <a href="javascript:;" class="menu__sub-item"></a>--}}
{{--            </li>--}}
            {{ Menu::renders() }}
            <li>
                <a href="{{ route('logout') }}" class="menu__sub-item">
                    <span class="title">{{ trans('auth::text.Logout') }}</span>
                </a>
                <span class="icon-thumbnail"><i class="fa fa-sign-out"></i></span>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>

{{--{{ Menu::renders() }}--}}
