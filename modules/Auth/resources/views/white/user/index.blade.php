@extends('auth::layout')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users
                        <small>Some examples to get you started</small>
                    </h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{route('cp.users.index')}}">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="submit();">Go!</button>
                                </span>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User table</h2>
                            @can('create', Modules\Auth\Entities\Models\User::class)
                            <a href="{{ route('cp.users.create') }}" class="pull-right">
                                <button type="button" class="btn btn-success btn-xs">New <i class="fa fa-plus-circle"></i></button>
                            </a>
                            @endcan
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" name="check_all" id="check-all" class="flat">
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ implode(' ', $user->roles->pluck('name')->toArray()) }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @can('update', \Modules\Auth\Entities\Models\User::class)
                                                <a class="btn btn-primary btn-xs" href="{{ route('cp.users.edit', [$user->id]) }}">Edit</a>
                                                @endcan
                                                @can('read', \Modules\Auth\Entities\Models\User::class)
                                                <a class="btn btn-info btn-xs" href="{{ route('cp.users.show', [$user->id]) }}">View</a>
                                                @endcan
                                                @can('delete', \Modules\Auth\Entities\Models\User::class)
                                                    <form action="{{route('cp.users.destroy', $user->id)}}"
                                                          class="d-inline" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger btn-xs" type="submit">Delete
                                                        </button>
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
                                    @include('core::_pagination.counting', ['paginator' => $users])
                                </div>
                                <div class="col-xs-12 col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {{ $users->links('core::_pagination.template') }}
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
