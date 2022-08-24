<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $rule['full_name'] = 'required|max:50';
        $rule['user_name'] = ['required', 'max:50',  Rule::unique('ms_users', 'user_name')->withoutTrashed()];
        $rule['password'] = 'nullable|confirmed|min:8|max:20';
        $rule['role_id'] = 'required';

        if ($this->route('user')) {
            unset($rule['user_name']);
            unset($rule['password']);
            unset($rule['role_id']);
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'full_name' => trans('auth::user.full_name'),
            'user_name' => trans('core::common.user_name'),
            'password' => trans('core::common.password'),
            'role_id' => trans('core::common.role'),
        ];
    }
}
