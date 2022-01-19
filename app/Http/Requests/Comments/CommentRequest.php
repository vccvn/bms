<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class CommentRequest extends FormRequest
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
    public function fullrules($object)
    {
        if($object!='product') $object = 'post';
        return [
            'name'                                    => 'required',
            'email'                                   => 'required|email',
            'content'                                 => 'required',
            'object'                                  => 'required',
            'object_id'                               => 'required|exists:'.$object.'s,id'
        ];
        
    }

    public function rules()
    {
        Validator::extend('object_list', function($attr, $value){
            return in_array($value,['post', 'page','product', 'dynamic']);
        });
        return [
            'name'                                    => 'required',
            'email'                                   => 'required|email',
            'content'                                 => 'required',
            'object'                                  => 'required|object_list',
            'object_id'                               => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'phone_number.required' => 'Bạn chưa nhập số điện thoại',
            'content.required' => 'Bạn chưa nhập nội dung',
            'agree.required' => 'Đăng ký không thành công bạn phải đồng ý các điều khoản của chúng tôi',
            
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'phone_number.is_phone_number' => 'Số điện thoại không hợp lệ',
            'object_id.exists' => 'Comment không hợp lệ'
        ];
    }
}
