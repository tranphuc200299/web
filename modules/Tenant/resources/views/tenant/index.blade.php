@extends('tenant::layout')
@section('content')
    <div class="container-fluid bg-white">
        @include('tenant::tenant._partials.filter')
        <div class="card card-transparent pt-2">
            @include('core::_messages.flash')
            <div class="">
                <div class="row bold">
                    <div class="col-12">
                        @can('create', Modules\Tenant\Entities\Models\TenantModel::class)
                            <a href="{{ route('cp.tenants.create') }}" class="pull-right">
                                <button type="button"
                                        class="btn btn-success btn-xs">{{ trans('core::common.new item') }} <i
                                            class="fa fa-plus-circle"></i></button>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="basicTable">
                        <thead>
                            <tr>
                                {!!  Html::renderHeader(
                                 [
                                 'id' => ['name' => trans('core::common.No'), 'style' => 'width: 80px'],
                                 'name' => ['name' => trans('tenant::text.tenant name') , 'sortable' => true],
                                 'email' => ['name' => trans('tenant::text.tenant email') , 'sortable' => true],
                                 'phone' => ['name' => trans('tenant::text.tenant phone') , 'sortable' => true],
                                 'address' => ['name' => trans('tenant::text.tenant address')  , 'sortable' => true],
                                 'created_at' => ['name' => trans('core::common.created at'), 'sortable' => true],
                                 'action' => ['name' => '', 'sortable' => false, 'style' => "width: 270px"],
                                 ],'id', route(Route::currentRouteName()), false)  !!}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $tenant)
                            <tr>
                                <td class="v-align-middle text-center">
                                    <div class="checkbox text-center">
                                        {{($users->currentpage()-1)*$users->perpage()+ $key + 1}}
                                    </div>
                                </td>
                                <td class="v-align-middle text-center">{{$tenant->name}}</td>
                                <td class="v-align-middle">{{$tenant->email}}</td>
                                <td class="v-align-middle text-center">{{$tenant->phone}}</td>
                                <td class="v-align-middle">{{$tenant->address}}</td>
                                <td class="v-align-middle text-center">{{$tenant->created_at}}</td>
                                <td class="v-align-middle text-center">
                                    @can('update', $tenant)
                                        <a class="btn btn-primary btn-xs"
                                           href="{{ route('cp.tenants.edit', [$tenant->id]) }}">Edit</a>
                                    @endcan
                                    @can('read', $tenant)
                                        <a class="btn btn-info btn-xs"
                                           href="{{ route('cp.tenants.show', [$tenant->id]) }}">View</a>
                                    @endcan
                                    @can('delete', $tenant)
                                        <form method="POST" action="{{ route('cp.tenants.destroy', [$tenant->id]) }}"
                                              style="display: initial;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger btn-xs delete-record"
                                                   value="Delete">
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-5">
                        <nav class="mt-3">
                            @include('core::_pagination.counting', ['paginator' => $list])
                        </nav>
                    </div>
                    <div class="col-xs-12 col-sm-7">
                        <nav class="mt-3">
                            @if(!empty($list))
                                {{ $list->appends(request()->input())->links() }}
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- END card -->
    </div>
@endsection
@push('custom-scripts')
@endpush
