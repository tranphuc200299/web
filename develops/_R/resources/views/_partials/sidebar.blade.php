<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('r.index') }}" class="site_title"><i class="fa fa-clone"></i> <span>R System</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="/assets/base/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Hacker</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Services</h3>
                <ul class="nav side-menu">
                    <li><a href="{{ route('r.index') }}"><i class="fa fa-cubes"></i>Entities</a></li>
                    <li><a href="{{ route('r.roles.index') }}"><i class="fa fa-group"></i>Roles</a></li>
                    <li><a href="{{ route('r.permissions.index') }}"><i class="fa fa-gears"></i>Permissions</a></li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
