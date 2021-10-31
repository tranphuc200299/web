<div class="semi-bold header-bread-crumb">
   <span><a href="{{ route('cp') }}"><i class="fs-16 fa fa-home"></i> TOP</a></span>
    @foreach($breadcrumbs as $item)
        @if ($loop->last && !isset($item['link']))
            <i class="fa fa-caret-right mx-1" aria-hidden="true"></i>
            <span><a href="{{ $item['link'] ?? 'javascript:;'}}">{{ $item['name'] }}</a></span>
        @else
            <i class="fa fa-caret-right mx-1" aria-hidden="true"></i>
            <span><a href="{{ $item['link'] ?? 'javascript:;'}}">{{ $item['name'] }}</a></span>
        @endif
    @endforeach
</div>