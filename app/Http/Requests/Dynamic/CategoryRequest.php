<?php

namespace App\Http\Requests\Dynamic;

use Illuminate\Foundation\Http\FormRequest;

use Validator;

use App\Repositories\Dynamic\CategoryRepository;

class CategoryRequest extends FormRequest
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
        $parent_id = $this->parent_id;
        $dynamic_slug = $this->dynamic_slug;
        Validator::extend('nopost', function($attr, $value) use($dynamic_slug){
            $stt = true;
            $cp = new CategoryRepository();
            $cp->setType($dynamic_slug);
            if($c = $cp->find($value)){
                $stt = ($c->dynamics()->count())?false:true;
            }
            return $stt;
        });
        return [
            'name' => 'required|string|max:120',
            'parent_id' => 'min:0'.($parent_id?'|nopost|exists:categories,id':''),
            'description' => 'max:5000',
            'keywords' => 'max:128',
            'feature_image' => 'mimes:jpeg,png,jpg,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'Tên danh mục không được bỏ trống',
            'name.max'                => 'Tên danh mục dài vượt quá ký tự cho phép',
            'parent_id.nopost'        => 'Bạn không thể chọn danh mục này',
            'parent_id.exists'        => 'Danh mục này không tồn tại',
            'description.max'         => 'Mô tả quá dài',
            'keywords.max'            => 'Từ khóa quá dài',
            'feature_image.mimes'     => 'Định dạng file không hợp lệ'
        ];
    }
}
