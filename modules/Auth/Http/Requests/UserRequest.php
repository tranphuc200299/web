<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rule['email'] = 'required|max:50|unique:ms_users,email';
        $rule['password'] = 'nullable|confirmed|min:8|max:20';
        $rule['role_id'] = 'required';

        if ($this->route('user')) {
            unset($rule['email']);
            unset($rule['password']);
            unset($rule['role_id']);
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'name' => trans('auth::user.name'),
            'email' => trans('core::common.email'),
            'password' => trans('core::common.password'),
            'role_id' => trans('core::common.role'),
        ];
    }
}
