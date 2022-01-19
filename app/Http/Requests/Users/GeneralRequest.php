<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;


use Validator;

use Hash;

class GeneralRequest extends FormRequest
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
            'name' => 'required',
            // 'gender' => 'required|is_gender',
            'password' => 'required|password_match',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Không được bỏ trống trường này',
            // 'gender.is_gender' => 'Giới tính không hợp lệ',
            'password_match' => 'Mật khẩu không hợp lệ'
        ];
    }
}
