<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class ContactReplyRequest extends FormRequest
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

    public function rules()
    {
        return [
            'contact_id'                              => 'required|exists:contacts,id',
            'content'                                 => 'required',
        ];
        
    }

    public function messages()
    {
        return [
            'contact_id.required' => 'ID liên hệ không dược bỏ trống',
            'contact_id.exists' => 'ID liên hệ không hợp lệ',
            'content.required' => 'Bạn chưa nhập nội dung',
            
            
        ];
    }
}
