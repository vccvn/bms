<?php

namespace App\Http\Requests\Places;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\Places\PlaceRepository;

use Validator;


class PlaceRequest extends FormRequest
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
        $id = $this->id;
        $province_id = $this->province_id;
        Validator::extend('unique_name', function($attr, $value) use($id, $province_id) {
            $rep = new PlaceRepository();
            $args = ['name'=>$value,'type'=>'place', 'province_id'=> $province_id];
            if($station = $rep->first($args)){
                if($id){
                    return ($id == $station->id);
                }
                return  false;
            }
            return true;
        });
        Validator::extend('phone_number', function($attr, $value){
            return strlen($value)? preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value):true;
        });

        return [
            'province_id'                 => 'required|exists:provinces,id',
            'name'                        => 'required|unique_name',
            'address'                     => 'max:500',
            'google_ map'                 => 'max:500', 
            'map_lat'                     => 'max:191', 
            'map_lng'                     => 'max:191', 
        ];
        
    }

    public function messages()
    {
        return [
            'province_id.required'        => 'Tỉnh thành không dược bỏ trống',
            'province_id.exists'          => 'Tỉnh thành không hợp lệ',
            'name.required'               => 'Tên địa điểm không được bỏ trống!',
            'name.unique_name'            => 'địa điểm này đã tồn tại',
        ];
    }
}
