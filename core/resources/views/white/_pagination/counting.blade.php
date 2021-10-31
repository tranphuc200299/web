<div class="dataTables_info" id="datatable-fixed-header_info" role="status"
     aria-live="polite">
    @if($paginator->total() == 0)
        {{ trans('core::message.paging.No corresponding record') }}
    @else
        {{ trans('core::message.paging.table detail', [
        'start' => ($paginator->currentpage()-1)*$paginator->perpage()+1,
        'end' => $paginator->currentpage()*$paginator->perpage() < $paginator->total()? $paginator->currentpage()*$paginator->perpage() : $paginator->total(),
        'total' => $paginator->total(),
        ]) }}
    @endif
</div>
