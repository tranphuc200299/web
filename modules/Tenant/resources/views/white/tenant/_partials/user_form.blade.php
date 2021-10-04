<div class="user-form">
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user.name">{{ trans('tenant::text.user name') }}
                <span class="required">*</span>
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="user.name" class="form-control" value="{{ old('name') }}"
                       data-validate-length-range="6" data-validate-words="2" name="user[name]" maxlength="50" required="required" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user.email">{{trans('tenant::text.user email')}}<span
                        class="required">*</span>
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" id="user.email" name="user[email]" required="required" value="{{ old('email') }}"
                       class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">{{trans('core::common.password')}}
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="password" name="user[password]" data-rule-validPassword="true"
                       class="form-control" autocomplete="new-password">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirmation">{{trans('core::common.password repeat')}}
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="password_confirmation" name="user[password_confirmation]"
                       data-rule-validPassword="true" data-rule-equalTo="input[name='user[password]']" class="form-control" autocomplete="new-password">
            </div>
        </div>
    </div>
</div>