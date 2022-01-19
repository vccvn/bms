<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;


use Validator;

use App\Repositories\Products\ProductCategoryRepository;

class CategoryRequest extends FormRequest
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
    public function rules($id = null,$parent_id=null)
    {
        Validator::extend('noproduct', function($attr, $value){
            $stt = true;
            $cp = new ProductCategoryRepository();
            if($c = $cp->find($value)){
                $stt = $c->products()->count()?false:true;
            }
            return $stt;
        });
        return [
            'name' => 'required|string|max:120|unique:product_categories'.($id?',id,'.$id:''),
            'parent_id' => 'min:0'.($parent_id?'|noproduct|exists:product_categories,id':''),
            'description' => 'max:500',
            'keywords' => 'max:128',
            'feature_image' => 'mimes:jpeg,png,jpg,gif'
        ];
    }
}