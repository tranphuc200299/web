@if(\Illuminate\Support\Facades\Gate::check('read', \Modules\Auth\Entities\Models\User::class) ||
 !empty($defaultMenus))
    <div class="menu_section">
        <h3>Services</h3>
        <ul class="nav side-menu">
            @can('read', \Modules\Auth\Entities\Models\User::class)
                <li><a href="{{ route('cp.users.index') }}"><i class="fa fa-user"></i> Users</a></li>
            @endcan
            @foreach($defaultMenus as $menu)
                @can('read', $menu['class'])
                    <li><a href="{{ route($menu['route']) }}"><i
                                class="fa fa-{{$menu['icon']}}"></i> {{ $menu['name'] }}</a></li>
                @endcan
            @endforeach
        </ul>
    </div>
@endif

@foreach($groupsMenus as $groupName => $menus)
    @if(!empty($menus))
        <div class="menu_section">
            <h3>{{ $groupName }}</h3>
            <ul class="nav side-menu">
                @foreach($menus as $menu)
                    @can('read', $menu['class'])
                        <li><a href="{{ route($menu['route']) }}"><i
                                    class="fa fa-{{$menu['icon']}}"></i> {{ $menu['name'] }}</a></li>
                    @endcan
                @endforeach
            </ul>
        </div>
    @endif
@endforeach
