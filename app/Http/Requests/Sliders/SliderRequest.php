<?php

namespace App\Http\Requests\Sliders;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class SliderRequest extends FormRequest
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
        Validator::extend('position_list', function($attr, $value){
            return in_array($value,[1,2,3,4,5,6,7,8,9,10, 100]);
        });
        return [
            'name'                                    => 'required|unique:sliders'.($id?',id,'.$id:''),
            'position'                                => 'required|numeric|position_list',
            'width'                                   => 'max:4096',
            'height'                                  => 'max:2160',
            'crop'                                    => 'max:10',
            'priority'                                => 'max:1000'
        ];
        
    }

    public function messages()
    {
        return [
            'name.required'                           => 'Tên Slider không được bỏ trống',
            'name.unique'                             => 'Slider đã tồn tại',
            'width.max'                               => 'Chiều rộng ảnh vượt quá giới hạn cho phép',
            'height.max'                              => 'Chiều cao ảnh vượt quá giới hạn cho phép',
            'position'                                => 'Vị trí slide không hợp lệ'
        ];
    }
}
