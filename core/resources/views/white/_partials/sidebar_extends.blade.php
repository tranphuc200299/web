@foreach($groupsMenus as $groupName => $menus)
    @if(!is_numeric($groupName))
        <li class="@if(route_active_group(collect($menus)->pluck('route')->toArray())) item-selected open active @endif">
            <span class="icon-thumbnail"><i class="fa fa-cogs"></i></span>
            <a href="javascript:;"><span class="title">{{ $groupName }}</span>
                <span class="arrow @if(route_active_group(collect($menus)->pluck('route')->toArray())) open active @endif"></span></a>
            <ul class="sub-menu" @if(route_active_group(collect($menus)->pluck('route')->toArray())) style="display: block" @else style="display: none" @endif>
                @foreach($menus as $menu)

                    <li class="@if(route_active(route_wildcard($menu['route']))) item-selected @endif">
                        <a href="{{ route($menu['route']) }}" class="menu__sub-item">
                            <span class="title">{{ $menu['name'] }}</span>
                        </a>
                        <span class="icon-thumbnail"><i class="fa fa-{{$menu['icon']}}"></i></span>
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        @can('read', $menus['class'])
            <li class="@if(route_active(route_wildcard($menus['route']))) item-selected @endif">
                <a href="{{ route($menus['route']) }}" class="menu__sub-item">
                    <span class="title">{{ $menus['name'] }}</span>
                </a>
                <span class="icon-thumbnail"><i class="fa fa-{{$menus['icon']}}"></i></span>
            </li>
        @endcan
    @endif
@endforeach
