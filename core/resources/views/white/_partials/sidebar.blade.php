<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="{{ public_url('assets/img/logo_white.png') }}" alt="logo" class="brand"
             data-src="{{ public_url('assets/img/logo_white.png') }}"
             data-src-retina="{{ public_url('assets/img/logo_white.png') }}"
             width="78" height="22">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
            </button>
            <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
            <li class="">
                <span class="pin-menu-custom icon-thumbnail" data-toggle-pin="sidebar" id="btnPinMenu">
                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                </span>
                <a href="javascript:;" class="menu__sub-item"></a>
            </li>
            @can('read', Modules\Auth\Entities\Models\User::class)
                <li class="@if(route_active('cp.users*')) item-selected @endif">
                    <a href="{{ route('cp.users.index') }}" class="menu__sub-item">
                        <span class="title">{{ trans('core::common.menu.users') }}</span>
                    </a>
                    <span class="icon-thumbnail"><i class="fa fa-user"></i></span>
                </li>
            @endcan
            {{ Menu::renders() }}
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
