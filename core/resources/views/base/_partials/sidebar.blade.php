<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('cp') }}" class="site_title"><i class="fa fa-clone"></i> <span>L7 System</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                @if(auth()->user() && auth()->user()->picture)
                    <img src="{{ Storage::url(auth()->user()->picture) }}" alt="..." class="img-circle profile_img">
                @else
                    <img src="/assets/base/images/img.jpg" alt="..." class="img-circle profile_img">
                @endif
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ auth()->user()->name?? 'NoName' }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <!-- sidebar_extends.blade.php -->
            {{ Menu::renders() }}
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
