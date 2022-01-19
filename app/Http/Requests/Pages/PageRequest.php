<?php

namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

use App\Repositories\Pages\PageRepository;

class PageRequest extends FormRequest
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
    public function rules($id=null, $parent_id=null)
    {
        $rep = new PageRepository();
        Validator::extend('title_unique', function($attr, $value) use($rep, $id){
            if($p = $rep->first(['title'=>$value])){
                if($id && $id == $p->id){
                    return true;
                }
                return false;
            }
            return true;
        });
        $mimes = 'mimes:jpeg,png,jpg,gif';
    	$validate = [
            'title'                => 'required|string|max:191|title_unique',
            'type'                 => 'max:255',
            'parent_id'            => 'min:0'.($parent_id?'|exists:posts,id':''),
            'description'          => 'max:1000',
            'content'              => 'required',
            'keywords'             => 'max:191'
        ];
        return $validate;
    }
}
