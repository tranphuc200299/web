@extends('tenant::layout')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Tenant Management
                    </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User table</h2>
                            @can('create', Modules\Tenant\Entities\Models\TenantModel::class)
                                <a href="{{ route('cp.tenants.create') }}" class="pull-right">
                                    <button type="button" class="btn btn-success btn-xs">New <i class="fa fa-plus-circle"></i></button>
                                </a>
                            @endcan
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-hover" id="basicTable">
                                    <thead>
                                    <tr>
                                        <th style="width:1%" class="text-center">
                                            <button class="btn btn-link"><i class="pg-trash"></i>
                                            </button>
                                        </th>
                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Phone</th>

                                        <th>Address</th>

                                        <th>{{ trans('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="v-align-middle">
                                                <div class="checkbox text-center">
                                                    <input type="checkbox" value="{{ $item->id }}" name="record[]" id="checkbox_{{$item->id}}">
                                                    <label for="checkbox_{{$item->id}}" class="no-padding no-margin"></label>
                                                </div>
                                            </td>
                                            <td class="v-align-middle">{{$item->name}}</td>

                                            <td class="v-align-middle">{{$item->email}}</td>

                                            <td class="v-align-middle">{{$item->phone}}</td>

                                            <td class="v-align-middle">{{$item->address}}</td>

                                            <td class="v-align-middle">
                                                @can('update', \Modules\Tenant\Entities\Models\TenantModel::class)
                                                    <a class="btn btn-primary btn-xs" href="{{ route('cp.tenants.edit', [$item->id]) }}">Edit</a>
                                                @endcan
                                                @can('read', \Modules\Tenant\Entities\Models\TenantModel::class)
                                                    <a class="btn btn-info btn-xs" href="{{ route('cp.tenants.show', [$item->id]) }}">View</a>
                                                @endcan
                                                @can('delete', \Modules\Tenant\Entities\Models\TenantModel::class)
                                                    <form method="POST" action="{{ route('cp.tenants.destroy', [$item->id]) }}" style="display: initial;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="btn btn-danger btn-xs delete-record" value="Delete">
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
                                    @include('core::_pagination.counting', ['paginator' => $list])
                                </div>
                                <div class="col-xs-12 col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {{ $list->links('core::_pagination.template') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection