@extends('core::layout.auth.login')
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 account-box-title">
                {{ trans('auth::text.Welcome') }}
            </div>
            <div class="login-area box_border_type_1 px-3 py-3 px-md-5 py-5">
                {!!
                    Form::open([
                        'url' => route('login'),
                        'class' => 'form_validation form_submit_check',
                        'role' => 'form',
                        'id' => 'loginForm'
                    ])
                !!}
                @if ($errors->has('message'))
                    <label class="invalid-feedback error" role="alert">
                        <strong>{{ $errors->first('message') }}</strong>
                    </label>
                @endif
                @include('core::_messages.flash')
                <div class="form-group">
                    <div class="input-group transparent pb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text transparent"><i class="fa fa-envelope"></i>
                              </span>
                        </div>
                        <input type="email" name="email" placeholder="{{ trans('auth::text.Email') }}"
                               class="form-control" required>
                    </div>
                    @if ($errors->has('email'))
                        <label class="invalid-feedback error" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </label>
                    @endif
                </div>

                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text transparent"><i class="fa fa-key"></i>
                              </span>
                        </div>
                        <input type="password" name="password" placeholder="{{ trans('auth::text.Password') }}"
                               class="form-control" required>
                    </div>
                    @if ($errors->has('password'))
                        <label class="invalid-feedback error" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </label>
                    @endif
                </div>

                <div class="row">
                    <div class="m-auto align-items-center pt-4">
                        <button class="btn btn-theme-default btn-theme-login btn-block btn-cons m-t-10" type="submit"
                                disabled>
                            <span>{{ trans('auth::text.Login') }}</span>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
