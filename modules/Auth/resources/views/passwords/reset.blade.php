@extends('core::layout.auth.login')
@section('title', trans('passwords.reset password title page'))
@section('body-inside')
    <div class="login-container">
        <div class="w-100 px-3 px-md-5">
            <div class="text-center mb-4 account-box-title">
                パスワードのリセット
            </div>
            <div class="forgot-area box_border_type_1 px-3 py-3 px-md-5 py-5">
                {!!
                   Form::open([
                       'route' => 'password.reset',
                        'class' => 'form_validation form_submit_check',
                        'role' => 'form',
                        'id' => 'resetPasswordForm',
                        'method' => 'POST'
                   ])
               !!}
                <input type="hidden" name="token" value="{{ request('token', '') }}">
                <input type="hidden" name="email" value="{{ request('email', '') }}">

                @foreach ($errors->all() as $error)
                    <label class="invalid-feedback error" role="alert">
                        <strong>{{ $error }}</strong>
                    </label>
                @endforeach

                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fa fa-key"></i>
                              </span>
                        </div>
                        <input type="password" name="password" placeholder="もう一度パスワードを入力してください。" class="form-control" required
                             data-rule-validPassword="true">
                    </div>
                </div>
                <div class="form-group pt-2">
                    <div class="input-group transparent py-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fa fa-key"></i>
                              </span>
                        </div>
                        <input type="password" name="password_confirmation" placeholder="もう一度パスワードを入力してください。（再入力"
                               class="form-control" required data-rule-equalTo="input[name=password]" data-rule-validPassword="true"
                               minlength="8" maxlength="20">
                    </div>
                </div>

                <div class="row">
                    <div class="m-auto align-items-center pt-2">
                        <button class="btn btn-theme-default btn-theme-password btn-block btn-cons m-t-10" type="submit" disabled>
                            <span>登録</span>
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection