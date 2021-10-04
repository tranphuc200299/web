@extends('tenant::layout')
@section('content')
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form">
                        <div class="form_title">
                            <span>{{ trans('core::common.edit') }}</span>
                        </div>
                        <div class="form_content">
                                                            <div class="form-group">
                                    <label for="name">Name </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="name" name="name"  disabled  value="{{ $model->name }}">
                                </div>                                <div class="form-group">
                                    <label for="email">Email </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="email" name="email"  disabled  value="{{ $model->email }}">
                                </div>                                <div class="form-group">
                                    <label for="phone">Phone </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="phone" name="phone"  disabled  value="{{ $model->phone }}">
                                </div>                                <div class="form-group">
                                    <label for="address">Address </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="address" name="address"  disabled  value="{{ $model->address }}">
                                </div>
                            <div class="form-group text-right">
                                <div class="col-md-12">
                                    <a class="btn btn-default" href="{{ route('cp.tenants.index') }}">{{ trans('core::common.cancel') }}</a>
                                    <a class="btn btn-success pull-right" href="{{ route('cp.tenants.edit', $id) }}">{{ trans('core::common.edit') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
