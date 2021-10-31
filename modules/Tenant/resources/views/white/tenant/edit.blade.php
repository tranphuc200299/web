@extends('tenant::layout')
@section('content')
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('cp.tenants.update', $id) }}" method="post" enctype="multipart/form-data"
                      class="form-horizontal form-label-left form_validation form_submit_check">
                    @csrf
                    <div class="form">
                        <div class="form_title mb-2">
                            <span>{{ trans('core::common.edit') }}</span>
                        </div>
                        @include('core::_messages.flash')
                        <div class="form_content">
                            @include('tenant::tenant._partials.tenant_form', ['item' => $model])
                            <div class="form-group text-right">
                                <div class="col-md-12">
                                    <a class="btn btn-default"
                                       href="{{ route('cp.tenants.index') }}">{{ trans('core::common.cancel') }}</a>
                                    <button type="submit" class="btn btn-success">{{ trans('core::common.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
