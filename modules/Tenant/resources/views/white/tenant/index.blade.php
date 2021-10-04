@extends('tenant::layout')
@section('content')
    <div class="container-fluid bg-white">
        {{--@include('tenant::tenant._filter')--}}
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
                            <th style="width:1%" class="text-center">
                                <button class="btn btn-link"><i class="pg-trash"></i>
                                </button>
                            </th>
                            <th>{{ trans('tenant::text.tenant name') }}</th>
                            <th>{{ trans('tenant::text.tenant email') }}</th>
                            <th>{{ trans('tenant::text.tenant phone') }}</th>
                            <th>{{ trans('tenant::text.tenant address') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $tenant)
                            <tr>
                                <td class="v-align-middle">
                                    <div class="checkbox text-center">
                                        <input type="checkbox" value="{{ $tenant->id }}" name="record[]"
                                               id="checkbox_{{$tenant->id}}">
                                        <label for="checkbox_{{$tenant->id}}" class="no-padding no-margin"></label>
                                    </div>
                                </td>
                                <td class="v-align-middle">{{$tenant->name}}</td>
                                <td class="v-align-middle">{{$tenant->email}}</td>
                                <td class="v-align-middle">{{$tenant->phone}}</td>
                                <td class="v-align-middle">{{$tenant->address}}</td>
                                <td class="v-align-middle">
                                    @can('update', \Modules\Tenant\Entities\Models\TenantModel::class)
                                        <a class="btn btn-primary btn-xs"
                                           href="{{ route('cp.tenants.edit', [$tenant->id]) }}">Edit</a>
                                    @endcan
                                    @can('read', \Modules\Tenant\Entities\Models\TenantModel::class)
                                        <a class="btn btn-info btn-xs"
                                           href="{{ route('cp.tenants.show', [$tenant->id]) }}">View</a>
                                    @endcan
                                    @can('delete', \Modules\Tenant\Entities\Models\TenantModel::class)
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
