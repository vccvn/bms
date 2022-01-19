<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
        return [
            'current_password' => 'required|password_match',
            'new_password' => 'required|string|min:6|confirmed'
            
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Không được bỏ trống trường này',
            'password_match' => 'Mật khẩu không hợp lệ',
            'new_password.confirmed' => 'Mật khẩu mới không khớp'
        ];
    }
}
