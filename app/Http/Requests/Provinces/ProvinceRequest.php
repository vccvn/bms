<?php

namespace App\Http\Requests\Provinces;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\Provinces\ProvinceRepository;

use Validator;


class ProvinceRequest extends FormRequest
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
        Validator::extend('type_list', function($attr, $value){
            return in_array($value,['province','city']);
        });
        $rep = new ProvinceRepository();
        $id = $this->id;
        Validator::extend('unique_name', function($attr, $value) use($rep, $id){
            if($result = $rep->findBy('name', $value)){
                if($id && $result->id == $id) return true;
                return false;
            }
            return true;
        });
        
        return [
            'name'                                    => 'required|unique_name',
            'type'                                    => 'type_list',
            'slug'                                    => $this->slug?'required|unique:provinces'.($id?',id,'.$id:''):'nax:191',
        ];
        
    }

    public function messages()
    {
        return [
            'name.required'                           => 'Tên tỉnh không được bỏ trống',
            'name.unique_name'                             => 'Tỉnh đã tồn tại',
            'type.type_list'                          => 'Phân loại không hợp lệ',
        ];
    }
}
