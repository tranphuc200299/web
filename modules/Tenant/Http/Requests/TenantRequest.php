<?php

namespace Modules\Tenant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule['name'] = 'required|max:50';
        $rule['email'] = 'required|max:50';
        $rule['phone'] = 'required|max:50';
        $rule['address'] = 'max:200';

        $rule['user.name'] = 'required|max:50';
        $rule['user.email'] = 'required|max:50|unique:ms_users,email';
        $rule['user.password'] = 'nullable|confirmed|min:8|max:20';
        $rule['user.password_confirmation'] = 'nullable|confirmed|min:8|max:20|same:user.password';

        return $rule;
    }

    public function attributes()
    {
        return [
            'name' => trans('tenant::text.tenant name'),
            'email' => trans('tenant::text.tenant email'),
            'phone' => trans('tenant::text.tenant phone'),
            'address' => trans('tenant::text.tenant address'),

            'user.name' => trans('tenant::text.user name'),
            'user.email' => trans('tenant::text.user email'),
            'user.password' => trans('core::common.password'),
            'user.password_confirmation' => trans('core::common.password repeat'),
        ];
    }
}
