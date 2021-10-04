@extends('tenant::layout')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Tenant</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form action="{{ route('cp.tenants.store') }}" method="post" class="form-horizontal form-label-left has_validate" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="name" name="name"   value="">
                                </div>                                <div class="form-group">
                                    <label for="email">Email </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="email" name="email"   value="">
                                </div>                                <div class="form-group">
                                    <label for="phone">Phone </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="phone" name="phone"   value="">
                                </div>                                <div class="form-group">
                                    <label for="address">Address </label>
                                    <span class="help"></span>
                                    <input class="form-control" type="text" id="address" name="address"   value="">
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">{{ trans('core::common.submit') }}</button>
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
