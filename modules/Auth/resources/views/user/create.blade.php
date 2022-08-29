@extends('auth::layout')
@section('content')
    <!-- page content -->
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="{{route('cp.users.store')}}" method="post" class="form-horizontal form-label-left form_validation form_submit_check" autocomplete="off">
                    <div class="form">
                        <div class="form_title">
                            <span>{{ trans('core::common.register') }}</span>
                        </div>
                        <div class="form_content">
                            @include('core::_messages.flash')
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('auth::user.full_name') }}
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="name" class="form-control" value="{{ old('full_name') }}"
                                               data-validate-length-range="6" data-validate-words="2" name="full_name" maxlength="100" required="required" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('auth::user.user_name') }} ({{ trans('auth::user.login ID') }})
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="user_name" class="form-control" value="{{ old('user_name') }}"
                                               data-validate-length-range="6" data-validate-words="2" name="user_name" maxlength="100" required="required" type="text">
                                    </div>
                                </div>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<div class="row">--}}
                                    {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('auth::user.login ID') }}（{{trans('core::common.email')}}）<span--}}
                                                {{--class="required">*</span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                        {{--<input type="email" id="email" name="email" required="required" value="{{ old('email') }}"--}}
                                               {{--class="form-control">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{trans('core::common.password')}}
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" id="password" name="password" data-rule-validPassword="true"
                                               class="form-control" autocomplete="new-password" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirmation">{{trans('core::common.password repeat')}}
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               data-rule-validPassword="true" data-rule-equalTo="input[name=password]" class="form-control" autocomplete="new-password" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="display: none">
                                <div class="row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id">{{trans('core::common.role')}}
                                        <span class="required">*</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="role_id" id="role_id" class="form-control" required data-toggle="select2-multi">
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" @if(old('role_id') == $role->id) selected @endif>
                                                    {{ trans($role->display_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success pull-right" type="submit">
                                            {{trans('core::common.create')}}
                                        </button>
{{--                                        <a href="{{ back_link() }}" class="btn btn-default pull-right mr-2">--}}
{{--                                            {{trans('core::common.back')}}--}}
{{--                                        </a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
@push('custom-scripts')
@endpush
