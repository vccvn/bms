<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class ContactRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name'                                    => 'required',
            'email'                                   => 'required|email',
            'phone_number'                            => 'max:15',
            'content'                                 => 'required',
            'subject'                                 => 'max:191'
        ];
        
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            'content.required' => 'Bạn chưa nhập nội dung',
            
            'email.email' => 'Email không hợp lệ',
            'phone_number.is_phone_number' => 'Số điện thoại không hợp lệ',
        ];
    }
}
