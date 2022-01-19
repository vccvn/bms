<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Validator;

class TagRequest extends FormRequest
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
    public function rules(Request $req)
    {
        Validator::extend('textword', function($attr, $value){
            return preg_match('/^[A-z0-0]+.*/i', str_slug($value));
        });
        Validator::extend('single', function($attr, $value){
            return (count(explode(',', $value))<2);
        });
        return ['tag'=>'required|max:191|textword'.($req->id?"|single":'')];
    }

    public function messages()
    {
        return [
            'tag.required'=>'Thẻ không được bỏ trống',
            'tag.mac'=>'thẻ có dộ dài vượt quá ký tự cho phép',
            'tag.textword' => 'Ký tự bắt đầu thẻ không hợp lệ',
            'tag.single' => 'Thẻ có chứa ký tự ko hợp lệ',
            
        ];
    }
}
