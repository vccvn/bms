<?php

namespace App\Http\Requests\Crawl;

use Illuminate\Foundation\Http\FormRequest;

use Validator;
use App\Repositories\Dynamic\DynamicRepository;

class CrawlPostRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){

        Validator::extend('dynamic', function($attr, $value){
            $stt = true;
            if($value){
                $dynamics = new DynamicRepository();

                $args = [
                    'parent_id' => 0,
                    'status' => 200,
                    'id' => $value
                ];
                if($dynamics->count($args)) return true;
                return false;

            }
            
            return $stt;
        });
        $rules = [
            'url' => 'required',
            'dynamic_id' => 'dynamic',
            'user_id' => 'required|exists:users,id',
            'frame_id' => 'required|exists:crawl_frames,id',
        ];
        if(!$this->dynamic_id){
            $rules['cate_id'] =  'required|exists:categories,id';
        }else{
            $dynamics = new DynamicRepository();

            $args = [
                'parent_id' => 0,
                'status' => 200,
                'id' => $this->dynamic_id
            ];
            if($dynamic = $dynamics->first($args)){
                $dynamic->applyMeta();
                if($dynamic->use_category){
                    $rules['cate_id'] =  'required|exists:categories,id';
                }
            }

        }
        return $rules;
    }

    public function messages(){
        return [
            'url.required' => 'Không được để trống url',
            'user_id.required' => 'Không được để trống tác giả',
            'cate_id.required' => 'Không được để trống thể loại',
            'frame_id.required' => 'Không được để trống nguồn',
        ];
    }
}
