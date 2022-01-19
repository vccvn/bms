<?php

namespace App\Http\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class MenuRequest extends FormRequest
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
            'name'                                    => 'required|unique:menus'.($id?',id,'.$id:''),
            'type'                                    => 'required',
            'data'                                    => 'max:191',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required'                           => 'Tên menu không được bỏ trống',
            'name.unique'                             => 'menu đã tồn tại',
            'data.max'                                => 'dữ liệu quá sài',
            
        ];
    }
}
