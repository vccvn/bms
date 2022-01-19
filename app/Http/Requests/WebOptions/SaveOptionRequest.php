<?php

namespace App\Http\Requests\WebOptions;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\WebOptions\WebOptionRepository;

use Validator;

class SaveOptionRequest extends FormRequest
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
        Validator::extend('option_group', function($attr, $value){
            return in_array($value, ['siteinfo', 'setting','data','embed','option']);
        });
        $arr = [
            'option_group' => 'required|option_group'
        ];
        $repository = new WebOptionRepository;
        if($list = $repository->getAll()){
            $mimes = 'mimes:jpeg,png,jpg,gif';

            foreach($list as $item){
                $t = $item->type;
                if($t=='file' || $t=='image'){
                    $v = $mimes;
                }elseif($t=='text'){
                    $v = 'max:255';
                }elseif($t=='textarea'){
                    $v = 'max:500000';
                }elseif($t=='number'){
                    $v = 'numeric';
                }elseif($t=='email'){
                    $v = 'email';
                }else{
                    $v = 'required';
                }
                $arr[$item->name] = $v;
            }
        }
        return $arr;
    }

    /** Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $arr = [];
        $repository = new WebOptionRepository;
        if($list = $repository->getAll()){
            $mimes = 'mimes:jpeg,png,jpg,gif';

            foreach($list as $item){
                $t = $item->type;
                if($t=='file' || $t=='image'){
                    $v = 'File không hợp lệ!';
                }elseif($t=='text'){
                    $v = 'Số ký tự vượt quá dộ dài cho phép';
                }elseif($t=='textarea'){
                    $v = 'Số ký tự vượt quá dộ dài cho phép';
                }elseif($t=='number'){
                    $v = 'Đây không phải là kiểu số';
                }elseif($t=='email'){
                    $v = 'email không hợp lệ';
                }else{
                    $v = 'Không được bỏ trống';
                }
                $arr[$item->name] = $v;
            }
        }
        return $arr;
    }
}
