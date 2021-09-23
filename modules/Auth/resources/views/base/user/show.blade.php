@extends('auth::layout')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User detail</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form  class="form-horizontal form-label-left has_validate" autocomplete="off">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" class="form-control col-md-7 col-xs-12"
                                               data-validate-length-range="6" data-validate-words="2" name="name"
                                               placeholder="Your name" required="required" type="text" readonly
                                               value="{{$user->name}}"
                                        >
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" id="email" name="email" required="required"
                                               class="form-control col-md-7 col-xs-12" value="{{$user->email}}" readonly>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role">Role
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select data-toggle="select2-multi" name="role_id[]" id="" class="form-control select2" readonly multiple disabled>
                                            <option value="">No roles</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" @if(in_array($role->id, $user->roles->pluck('id')->toArray())) selected @endif>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        @can('update', \Modules\Auth\Entities\Models\User::class)
                                            <a class="btn btn-primary" href="{{ route('cp.users.edit', [$user->id]) }}">Edit</a>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
