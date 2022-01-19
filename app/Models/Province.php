<?php

namespace App\Models;



class Province extends Model
{
    public $table = 'provinces';

    public $fillable = [
        'type', 'name', 'slug'
    ];

    public $_folder = 'provinces'; // folder chứ hình ảnh upload

    public $_route = 'province';

    
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }


    public function stations()
    {
        return $this->hasMany('App\Models\Station', 'province_id', 'id')->where('type','station');
    }

    public function places()
    {
        return $this->hasMany('App\Models\Station', 'province_id', 'id')->where('type','place');
    }

    public function allPlaces()
    {
        return $this->hasMany('App\Models\Station', 'province_id', 'id');
    }

    
    public function canDelete()
    {
        if($this->stations()->count() || $this->places()->count()) return false;
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        if($this->allPlaces){
            foreach ($this->allPlaces as $item) {
                $item->delete();
            }
        }
        return true;
    }
}
