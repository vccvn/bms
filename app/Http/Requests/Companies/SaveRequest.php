<?php

namespace App\Http\Requests\Companies;

use App\Repositories\Companies\CompanyRepository;
use Illuminate\Foundation\Http\FormRequest;

use Validator;


class SaveRequest extends FormRequest
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

        Validator::extend('phone_number', function($attr, $value){
            return strlen($value)? preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value):true;
        });
        $rep = new CompanyRepository();
        $id = $this->id;
        Validator::extend('unique_name', function($attr, $value) use($rep, $id){
            if($result = $rep->findBy('name', $value)){
                if($id && $result->id == $id) return true;
                return false;
            }
            return true;
        });
        

        return [
            'name'                        => 'required|unique_name',
            'address'                     => 'max:500',
            'email'                       => $this->email?'email':'max:191',
            'phone_number'                => 'phone_number',
            'google_ map'                 => 'max:500', 
            'website'                     => 'max:191', 
            'facebook'                    => 'max:191', 
        ];
        
    }

    public function messages()
    {
        return [
            'name.required'               => 'Tên nhà xe không được bỏ trống!',
            'name.unique_name'                 => 'Nhà xe này đã tồn tại',
            'email.email'                 => 'email không hợp lệ',
            'phone_number.phone_number'   => 'Số điện thoại không hợp lệ'
        ];
    }
}
