<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

class RegisterRequest extends FormRequest
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
        Validator::extend('username', function($attr, $value){
            return preg_match('/^[A-z]+[A-z0-9_\.]*$/si', $value);
        });
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'username' => 'required|string|username|min:2|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'agree' => 'required',
            
        ];
    }


    public function messages()
    {
        return [
            'username.required' => 'Bạn chưa nhập tên người dùng',
            'email.required' => 'Bạn chưa nhập email',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'agree.required' => 'Đăng ký không thành công bạn phải đồng ý các điều khoản của chúng tôi',
            'username.min' => 'Tên người dùng phải có ít nhất 2 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'username.username' => 'Tên đăng nhập không hợp lệ',
            'password.confirmed' => 'Mật khẩu không khớp'
            
        ];
    }
}
