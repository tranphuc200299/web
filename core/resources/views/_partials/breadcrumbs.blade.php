<div class="semi-bold header-bread-crumb">
    @foreach($breadcrumbs as $item)
        @if ($loop->last && !isset($item['link']))
            <i class="fa fa-caret-right mx-1" aria-hidden="true"></i>
            <span><a href="{{ $item['link'] ?? 'javascript:;'}}">{{ $item['name'] }}</a></span>
        @else
            <span><a href="{{ $item['link'] ?? 'javascript:;'}}">{{ $item['name'] }}</a></span>
        @endif
    @endforeach
</div>
