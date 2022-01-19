<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules($id=nul, $password=null)
    {
        Validator::extend('username', function($attr, $value){
            return preg_match('/^[A-z]+[A-z0-9_\.]*$/si', $value);
        });
        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users'.($id?',id,'.$id:''),
            'username' => 'required|string|username|min:2|unique:users'.($id?',id,'.$id:''),
        ];
        if(!$id || (is_string($password) && strlen($password)>0)){

            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập họ và tên người dùng',
            'username.required' => 'Bạn chưa nhập tên người dùng',
            'email.required' => 'Bạn chưa nhập email',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'username.min' => 'Tên người dùng phải có ít nhất 2 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'username.username' => 'Tên đăng nhập không hợp lệ',
            
        ];
    }
}
