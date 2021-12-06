<ul class="pagination">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
        <li class="paginate_button previous disabled">
            <a href="javascript:void(0)">{{ trans('core::common.previous') }}</a>
        </li>
    @else
        <li class="paginate_button previous">
            <a href="{{ $paginator->previousPageUrl() }}">{{ trans('core::common.previous') }}</a>
        </li>
    @endif

<!-- Pagination Elements -->
    @foreach ($elements as $element)
    <!-- "Three Dots" Separator -->
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif

    <!-- Array Of Links -->
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active">
                        <a href="javascript:void(0)">{{ $page }}</a>
                    </li>
                @else
                    <li class=""><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

<!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <li class="paginate_button next">
            <a href="{{ $paginator->nextPageUrl() }}">{{ trans('core::common.next') }}</a>
        </li>
    @else
        <li class="paginate_button next disabled">
            <a href="javascript:void(0)">{{ trans('core::common.next') }}</a>
        </li>
    @endif
</ul>
