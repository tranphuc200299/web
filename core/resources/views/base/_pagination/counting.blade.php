<div class="dataTables_info" id="datatable-fixed-header_info" role="status"
     aria-live="polite">Showing {{($paginator->currentpage()-1)*$paginator->perpage()+1}}
    to {{$paginator->currentpage()*$paginator->perpage() < $paginator->total()? $paginator->currentpage()*$paginator->perpage() : $paginator->total()}} of {{$paginator->total()}} entries
</div>
