<?php

namespace App\Http\Requests\Sliders;

use Illuminate\Foundation\Http\FormRequest;

class SliderItemRequest extends FormRequest
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
    public function rules($id=null)
    {
        return [
            'title'                                   => 'required',
            'link'                                    => 'max:191',
            'url'                                     => 'max:191',
            'description'                             => 'max:1000',
            'priority'                                => 'max:1000',
            'image'                                   => 'mimes:jpeg,png,jpg,gif',
            'slider_id'                               => 'required|exists:sliders,id'
        ];
        
    }

    public function messages()
    {
        return [
            'title.required'                          => 'Tiêu đề không được bỏ trống',
            'description.max'                         => 'Mô tả dài quá giới hạn cho phép',
            'image.mimes'                             => 'file không hợp lệ',
        ];
    }
}
