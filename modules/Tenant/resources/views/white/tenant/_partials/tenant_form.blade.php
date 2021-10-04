<div class="tenant-form">
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('tenant::text.tenant name') }}
                <span class="required">*</span>
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" class="form-control" value="{{ old('name', $item->name?? '') }}" name="name" maxlength="50" required="required" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('tenant::text.tenant email') }}
                <span class="required">*</span>
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" class="form-control" value="{{ old('email', $item->email?? '') }}" name="email" maxlength="50" required="required" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">{{ trans('tenant::text.tenant phone') }}
                <span class="required">*</span>
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" class="form-control" value="{{ old('phone', $item->phone?? '') }}" name="phone" maxlength="50" required="required" type="text">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">{{ trans('tenant::text.tenant address') }}
            </label>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="address" class="form-control" value="{{ old('address', $item->address?? '') }}" name="address" maxlength="200" type="text">
            </div>
        </div>
    </div>
</div>