<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

use Hash;
class AccountRequest extends FormRequest
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
        $id = auth()->user()->id;
        Validator::extend('username', function($attr, $value){
            return preg_match('/^[A-z]+[A-z0-9_\.]*$/si', $value);
        });
        
        
        return [
            'email' => 'required|string|email|unique:users,id,'.$id,
            // 'phone_number' => 'required|string|is_phone_number|unique:users,id,'.$id,
            'username' => 'required|string|username|min:2|unique:users,id,'.$id,
            'password' => 'required|password_match',
            
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Không được bỏ trống trường này',
            //'gender.is_gender' => 'Giới tính không hợp lệ',
            'password_match' => 'Mật khẩu không hợp lệ',
            'username.required' => 'Bạn chưa nhập tên người dùng',
            'email.required' => 'Bạn chưa nhập email',
            // 'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            
            'username.min' => 'Tên người dùng phải có ít nhất 2 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'username.username' => 'Tên đăng nhập không hợp lệ',
            // 'phone_number.unique' => 'Số điện thoại đã tồn tại',
            // 'phone_number.is_phone_number' => 'Số điện thoại không hợp lệ',
        ];
    }
}
