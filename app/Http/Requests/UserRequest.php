<?php

namespace App\Http\Requests;

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
        if (request()->isMethod('post')) {
            $rules = [
                'name'     => ['required', 'min:2','max:70'],
                'email'    => ['required', 'email','unique:users,email'],
                'password' => ['required', 'min:6','confirmed'],
                'role_id'  => ['required', 'exists:roles,id'],
            ];
        } elseif (request()->isMethod('put')) {
            $rules = [
                'name'     => ['required', 'min:2','max:70'],
                'email'    => ['required', 'email','unique:users,email,'.$this->segment(3)],
                'password' => ['sometimes', 'min:6','confirmed'],
                'role_id'  => ['required', 'exists:roles,id'],
            ];
        }

        return $rules;
    }
}
