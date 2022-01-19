<?php

namespace App\Http\Requests\WebOptions;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\WebOptions\WebOptionRepository;

use Validator;

class AddOptionRequest extends FormRequest
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
    public function rules()
    {
        
        $repository = new WebOptionRepository;
        $opg = $this->option_group;
        Validator::extend('option_unique', function($attr, $value) use($opg, $repository) {
            return $repository->first(['name'=>$value, 'option_group'=>$opg])?false:true;
        });
        
        Validator::extend('in_list', function($attr, $value){
            return in_array($value, ['text', 'textarea','number','email','file']);
        });
        Validator::extend('option_group', function($attr, $value){
            return in_array($value, ['siteinfo', 'setting','data','embed','option']);
        });
        return [
            'name' => 'required|option_unique|max:255',
            'type' => 'required|in_list',
            'option_group' => 'required|option_group',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Tên thuộc tính không dược bỏ trống",
            'name.option_unique' => 'thuộc tính đã tồn tại',
            'name.max' => 'Tên thuộc tính chứ số ký tự vượt quá độ dài cho phép',
            'type.required' => 'Kiểu dữ liệu không được bỏ trống',
            'type.in_list' => 'Kiểu dữ liệu không hợp lệ',
            'option_group.required' => 'Group không được bỏ trống',
            'option_group.option_group' => 'Group không hợp lệ'
        ];
    }
}
