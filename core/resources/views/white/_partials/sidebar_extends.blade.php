@foreach($groupsMenus as $groupName => $menus)
    @if(!empty($menus))
        <li class="@if(route_active('cp.settings*') ||
                        route_active('cp.venues*') ||
                        route_active('cp.users*') ||
                        route_active('cp.settings*') ||
                         route_active('cp.faq*')
                         ) item-selected open active @endif">
            <span class="icon-thumbnail"><i class="fa fa-cogs"></i></span>
            <a href="javascript:;"><span class="title">{{ $groupName }}</span>
                <span class="arrow @if(route_active('cp.settings*') ||
                        route_active('cp.venues*') ||
                        route_active('cp.users*') ||
                        route_active('cp.settings*') ||
                         route_active('cp.faq*')
                         ) open active @endif"></span></a>
            <ul class="sub-menu" @if(route_active('cp.settings*') ||
                        route_active('cp.venues*') ||
                        route_active('cp.users*') ||
                        route_active('cp.settings*') ||
                         route_active('cp.faq*')
                         ) style="display: block" @else style="display: none" @endif>
                @foreach($menus as $menu)
                    <li class="@if(route_active('cp.logs.*')) item-selected @endif">
                        <a href="{{ route($menu['route']) }}" class="menu__sub-item">
                            <span class="title">{{ $menu['name'] }}</span>
                        </a>
                        <span class="icon-thumbnail"><i class="fa fa-{{$menu['icon']}}"></i></span>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endforeach
