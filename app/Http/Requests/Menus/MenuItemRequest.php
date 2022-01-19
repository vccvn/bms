<?php

namespace App\Http\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class MenuItemRequest extends FormRequest
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
    public function rules($type = null, $id=null)
    {
        Validator::extend('in_menu_list', function($attr, $value){
            return in_array($value, ['default',"route", 'category', 'product_category', 'project_category', 'dynamic_category', 'post', 'page', 'dynamic','define']);
        });

        $rules = [
            'title'          => 'max:191',
            'type'           => 'required|in_menu_list',
            'active_key'     => 'max:191',
        ];
        if($type=='default'){
            $rules['title'] = 'required|'.$rules['title'];
        }
        if(!$id){
            $rules['menu_id'] = 'required|exists:menus,id';
        }
        

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => 'Loại item không được bỏ trống',
            'type.in_menu_list' => 'Loại item không hợp lệ',
            'title.required' => 'Tiêu đề item không được bỏ trống',
            'title.max' => 'Tiêu đề quá dài',
            'active_key.max' => 'Khóa kích hoạt quá dài',
            'priority.required' => 'Độ ưu tiên không được bỏ trống',
            'title.numeric' => 'Độ ưu tiên không phải dạng số',
            'menu_id.exists' => 'Menu không tồn tại'


        ];
    }
}
