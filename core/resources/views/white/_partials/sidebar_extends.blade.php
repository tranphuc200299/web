@foreach($groupsMenus as $groupName => $menus)
    @if(!empty($menus))
        <li>
            <a href="javascript:;"><span class="title">{{ $groupName }}</span>
                <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="pg-calender"></i></span>
            <ul class="sub-menu">
                @foreach($menus as $menu)
                    <li class="">
                        <a href="{{ route($menu['route']) }}">{{ $menu['name'] }}</a>
                        <span class="icon-thumbnail">c</span>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endforeach
