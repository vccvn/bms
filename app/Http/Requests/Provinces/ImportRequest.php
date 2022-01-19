<?php

namespace App\Http\Requests\Provinces;

use Illuminate\Foundation\Http\FormRequest;


use Validator;


class ImportRequest extends FormRequest
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
        $file = $this->file('file_data');
        Validator::extend('json_file', function($attr, $value) use($file){
            if($file){
                $ext = strtolower($file->getClientOriginalExtension());
                return ($ext == 'json');
            }
            return false;

        });
        return [
            'file_data'                               => 'required|json_file',
            
        ];
        
    }

    public function messages()
    {
        return [
            'file_data.required'                          => 'Tệm dự liệu không được bỏ trống',
            'file_data.json_file'                             => 'Chỉ chấp nhận định dạnh json',
        ];
    }
}
