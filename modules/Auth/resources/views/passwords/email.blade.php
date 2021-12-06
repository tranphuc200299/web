@extends('core::layout.auth.login')
@section('title', trans('auth::message.Forgot your login password'))
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 account-box-title">
                 {{ trans('auth::message.Forgot your login password') }}
            </div>
            <div class="forgot-area box_border_type_1 px-3 py-3 px-md-5 py-5">
            {!!
                Form::open([
                    'route' => 'password.email.send',
                    'class' => 'form_validation form_submit_check',
                    'role' => 'form',
                     'id' => '',
                     'method' => 'POST'
                 ])
            !!}
                <div class="forgot-password">
                    <p class="notice pb-2">
                        {{ trans('auth::message.Forgot password notice') }}
                    </p>
                </div>
                <div class="input-group transparent pb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fa fa-envelope"></i>
                          </span>
                    </div>
                    <input type="email" name="email" placeholder="{{ trans('auth::text.Email') }}" class="form-control" required>
                </div>
                @if (isset($fail))
                    <label class="invalid-feedback error" role="alert">
                        <strong>{{ trans($fail) }}</strong>
                    </label>
                @endif
                <div class="row">
                    <div class="m-auto align-items-center pt-2">
                        <button class="btn btn-theme-default btn-theme-password btn-block btn-cons m-t-10" type="submit" disabled>
                            <span>{{ trans('auth::text.Send') }}</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mx-auto text-center">
                            <a href="{{ route('auth.login') }}" class="text-info small text-primary">
                                <span>{{ trans('auth::text.Back to login') }}</span>
                            </a>
                        </h5>
                    </div>
                </div>

            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
