<?php

namespace App\Http\Requests\Menus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use Validator;


class MenuItemMetaRequest extends FormRequest
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
        $rules = [];

        $t = $type;
        if($t=='define'){// tu dinh nghie
            $rules['action'] = 'required';
            $rules['param'] = 'max:191';
        }
        elseif($t=='category'){
            $rules['cate_id'] = 'required|numeric|exists:categories,id';
        }
        elseif($t=='product_category'){
            $rules['product_cate_id'] = 'required|numeric|exists:categories,id';
        }
        elseif($t=='project_category'){
            $rules['project_cate_id'] = 'required|numeric|exists:categories,id';
        }
        elseif($t=='dynamic_category'){
            $rules['dynamic_cate_id'] = 'required|numeric|exists:categories,id';
        }
        elseif($t=='page'){
            $rules['page_id'] = 'required|numeric|exists:posts,id';
        }
        elseif($t=='dynamic'){
            $rules['dynamic_id'] = 'required|numeric|exists:posts,id';
        }
        elseif($t=='route'){
            $rules['route'] = 'required|string|max:191';
            $rules['param'] = 'max:191';
        }
        else{
            $rules['url'] = 'required|string|max:191';
            
        }
        $rules['sub_type']  = 'max:191';
        $rules['icon'] = 'max:64';
        $rules['target'] = 'max:64';
        $rules['classname'] = 'max:128';

        return $rules;
    }

    public function messages()
    {
        return [
            'sub_type.required' => 'Submenu không được bỏ trống',
            'action' => 'phương không hợp lệ',
            'cate_id' => 'Danh mục bài viết không hợp lệ',
            'product_cate_id' => 'Danh mục sản sản phẩm không hợp lệ',
            'page_id' => 'Trang không hợp lệ',
            'dynamic_id' => 'Mục không hợp lệ',
            'route' => 'Route không hợp lệ'
        ];
    }

    public function getData(Request $request)
    {
        $data = [];
        $rules = $this->rules($request->type);
        foreach($rules as $key => $val){
            $data[$key] = $request->{$key};
        }
        return $data;
    }
}
