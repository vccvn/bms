<?php

namespace App\Models;

class CategoryProperty extends Model
{
    public $table = 'category_properties';
    public $fillable = ['cate_id','type','name','label', 'defval', 'data'];
    public $_folder = 'category-properties';
    
    /**
     * trả về mảng các tham số để tạo input
     * 
     * @return array ['type' => string , 'name' => string, 'label' => string, 'default' => mixed, 'data' => string | json]
     */
    public function toPropInput()
    {
        $ar = [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'defval' => $this->defval,
            'data' => $this->data
        ];
        return $ar;

    }

}
