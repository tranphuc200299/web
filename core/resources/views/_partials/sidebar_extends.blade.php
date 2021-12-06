@foreach($menus as $pos => $item)
    @if(isset($item['child']))
        <li class="@if(route_active_group(collect($item['child'])->pluck('route')->toArray())) item-selected open active @endif">
            <span class="icon-thumbnail"><i class="fa fa-cogs"></i></span>
            <a href="javascript:;"><span class="title">{{ trans($item['name']) }}</span>
                <span class="arrow @if(route_active_group(collect($item['child'])->pluck('route')->toArray())) open active @endif"></span></a>
            <ul class="sub-menu" @if(route_active_group(collect($item['child'])->pluck('route')->toArray())) style="display: block" @else style="display: none" @endif>
                @foreach($item['child'] as $menu)
                    @can($menu['action']?? 'read', $menu['class'])
                        <li class="@if(route_active(route_wildcard($menu['route']))) item-selected @endif">
                            <a href="{{ route($menu['route']) }}" class="menu__sub-item">
                                <span class="title">{{ trans($menu['name']) }}</span>
                            </a>
                            <span class="icon-thumbnail"><i class="fa fa-{{$menu['icon']}}"></i></span>
                        </li>
                    @endcan
                @endforeach
            </ul>
        </li>
    @endif
    @if(isset($item['single']))
        @can($item['single']['action']?? 'read', $item['single']['class'])
            <li class="@if(route_active(route_wildcard($item['single']['route']))) item-selected @endif">
                <a href="{{ route($item['single']['route']) }}" class="menu__sub-item">
                    <span class="title">{{ trans($item['single']['name']) }}</span>
                </a>
                <span class="icon-thumbnail"><i class="fa fa-{{$item['single']['icon']}}"></i></span>
            </li>
        @endcan
    @endif
@endforeach
