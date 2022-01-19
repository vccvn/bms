<?php

namespace App\Http\Requests\Dynamic;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

use App\Repositories\Dynamic\DynamicRepository;

class DynamicRequest extends FormRequest
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
        
        $id=$this->id; 
        $rep = new DynamicRepository();

        Validator::extend('title_unique', function($attr, $value) use($rep, $id){
            $args = [
                'title'=>$value,
                'parent_id'=>0,
            ];
            
            if($p = $rep->first($args)){
                if($id && $id == $p->id){
                    return true;
                }
                return false;
            }
            return true;
        });
        $validate = [
            'title'                => 'required|string|max:191|title_unique',
            'type'                 => 'max:255',
            'description'          => 'max:1000',
            'keywords'             => 'max:191'
        ];

        return $validate;
    }

    public function messages()
    {
        return [
            '__errors__.required'        => 'Lỗi không xác định!',
            '__errors.mimes'             => 'Lỗi không xác định!'
        ];
    }
}
