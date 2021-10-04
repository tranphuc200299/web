@extends('tenant::layout')
@section('content')
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('cp.tenants.store') }}" method="post" enctype="multipart/form-data"
                      class="form-horizontal form-label-left form_validation form_submit_check">
                    @csrf
                    <div class="form">
                        <div class="form_title mb-2">
                            <span>{{ trans('core::common.create') }}</span>
                        </div>
                        @include('core::_messages.flash')
                        <div class="form_content">
                            <div id="rootwizard" class="">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                                    <li class="nav-item">
                                        <a class="active" data-toggle="tab" href="#basic" data-target="#basic"
                                           role="tab"><i class="fa fa-building tab-icon"></i>
                                            <span>{{ trans('tenant::text.basic setting') }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="" data-toggle="tab" href="#user" data-target="#user" role="tab"><i
                                                    class="fa fa-user tab-icon"></i>
                                            <span>{{ trans('tenant::text.user setting') }}</span></a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane padding-20 sm-no-padding active slide-left" id="basic">
                                        @include('tenant::tenant._partials.tenant_form')
                                    </div>
                                    <div class="tab-pane slide-left padding-20 sm-no-padding" id="user">
                                        @include('tenant::tenant._partials.user_form')
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <div class="col-md-12">
                                    <a class="btn btn-default" href="{{ route('cp.tenants.index') }}">{{ trans('core::common.cancel') }}</a>
                                    <button type="submit" class="btn btn-success">{{ trans('core::common.submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
