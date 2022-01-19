<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Posts\PostRepository;
use Validator;
class PostRequest extends FormRequest
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
    public function rules($id=null)
    {
        $rep = new PostRepository();
        Validator::extend('post_title_unique', function($attr, $value) use($rep, $id){
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
            'title'                => 'required|string|max:191|post_title_unique',
            'cate_id'              => 'required|numeric|exists:categories,id',
            'description'          => 'max:1000',
            'content'              => 'required',
            'keywords'             => 'max:191'
        ];
    	// if(!$id){
    	// 	$mimes = 'required|'.$mimes;
        // }
        $validate['feature_image'] = $mimes;

        return $validate;
    }
}
