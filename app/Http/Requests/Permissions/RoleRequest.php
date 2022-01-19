<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class RoleRequest extends FormRequest
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
        Validator::extend('isCallable', function($attr, $value){
            
            return $value?is_callable($value):true;
        });
        return [
            'name'                                    => 'required|unique:roles'.($id?',id,'.$id:''),
            'handle'                                  => 'isCallable',
            'description'                             => 'max:500',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required'                           => 'Tên quyền không được bỏ trống',
            'name.unique'                             => 'Quyền đã tồn tại',
            'description.max'                         => 'Mô tả quá dài',
            'handle.isCallable'                       => 'Module cha không tồn tại',
            
        ];
    }
}
