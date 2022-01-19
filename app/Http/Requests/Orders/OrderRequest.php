<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;


use Validator;

class OrderRequest extends FormRequest
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
        Validator::extend('phone_number', function($attr, $value){
            return preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value);
        });

        $rules = [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email',
            'phone_number' => 'phone_number',
            'address' => 'max:500',
            'payment_method' => 'numeric|min:0|max:10',
            'notes' => 'max:500',
            
        ];

        if($this->email){
            $rules['email'] = 'email';
        }
        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            'address.required' => 'Bạn chưa nhập mật khẩu',
            
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'phone_number.phone_number' => 'Số điện thoại không hợp lệ',
            'payment_method' => 'Phương thức thanh toán không hợp lệ',
        ];
    }
}
