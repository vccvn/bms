<?php

namespace App\Http\Requests\Crawl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrameRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => ['required', Rule::unique('crawl_frames')->ignore($this->id)],
            'title' => 'required',
            'content' => 'required',
            // 'slug' => ['required', Rule::unique('crawl_frames')->ignore($this->id)],
            'url' => 'required',
            'index' => 'required|numeric|min:0'
        ];
    }

    public function messages(){
        return [
            'name.unique' => 'Tên website đã tồn tại',
            'name.required' => 'Không được để trống tên website',
            'title.required' => 'Không được để trống tiêu đề',
            'content.required' => 'Không được để trống nội dung',
            'url.required' => 'Không được để trống đường dẫn',
            'slug.unique' => 'slug đã tồn tại',
            'slug.required' => 'Không được để trống slug',
        ];
    }
}
