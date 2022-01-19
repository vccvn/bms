<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $id = $this->id;
        $mimes = 'mimes:jpeg,png,jpg,gif';
    	$validate = [
            'name'                 => 'required|string|max:191|unique:products'.($id?",id,$id":""),
            'code'                 => 'max:32',
            'description'          => 'max:500',
            'detail'               => 'required|max:20000',
            'keywords'             => 'max:191',
            //'list_price'           => 'required|numeric|min:0|max:9999999999.99',
            // 'sale_price'           => 'required|numeric|min:0|max:9999999999.99',
            // 'total'                => 'required|numeric|min:0|max:9999999999',
            
        ];
    	if(!$id){
    		$mimes = 'required|'.$mimes;
        }
        $validate['feature_image'] = $mimes;
        if($this->cate_id){
            $validate['cate_id'] = 'numeric|exists:categories,id';
        }

        return $validate;
    }
}
