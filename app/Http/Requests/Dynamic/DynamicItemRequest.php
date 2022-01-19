<?php

namespace App\Http\Requests\Dynamic;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

use App\Repositories\Dynamic\DynamicRepository;

class DynamicItemRequest extends FormRequest
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

        $parent_id = null;
        if(!$dynamic = $rep->first(['status'=>200,'slug'=>$this->route('slug')])){
            return ['__errors__'=>'required|mimes:png'];
        }
        $dynamic->applyMeta();
        $parent_id = $dynamic->id;
        $fileds = explode(',', $dynamic->required_fields);
        // dd($dynamic->meta());
        Validator::extend('title_unique', function($attr, $value) use($rep, $id, $parent_id){
            $args = ['title'=>$value, 'status' => 200];
            if($parent_id){
                $args['parent_id'] = $parent_id;
            }
            if($p = $rep->first($args)){
                if($id && $id == $p->id){
                    return true;
                }
                return false;
            }
            return true;
        });
        Validator::extend('video_check', function($attr, $value){
            $video = get_video_data($value);
            return $video?true:false;

        });
        $validate = [
            'title'                => 'required|string|max:191|title_unique',
            'type'                 => 'max:255',
            'description'          => 'max:1000',
            'keywords'             => 'max:191'
        ];

        // kiểm tra cate_id
        if($dynamic->use_category){
            $validate['cate_id'] = 'required|exists:categories,id';
        }
        if($dynamic->post_type == 'video'){
            $validate['video_url'] = 'required|string|video_check';
        }
        if(in_array('content', $fileds)){
            $validate['content'] = 'required';
        }
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
