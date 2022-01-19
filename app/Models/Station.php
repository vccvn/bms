<?php

namespace App\Models;



class Station extends Model
{
    public $table = 'stations';
    public $fillable = [
        'province_id','type','name','slug','image','description','address','email','phone_number',
        'google_ map', 'map_lat', 'map_lng', 'status'
    ];

    protected $_route = 'station';


    public function province()
    {
        return $this->hasMany('App\\Models\\Province', 'province_id','id');
    }

    public function getUpdateUrl()
    {
        return route('admin.'.$this->type.'.update',['id' => $this->id]);
    }

    public function passingPlaces()
    {
        return $this->hasMany('App\Models\PassingPlace', 'place_id', 'id');
    }

    public function startRoutes()
    {
        return $this->hasMany('App\Models\Route', 'from_id', 'id');
    }
    
    public function endRoutes()
    {
        return $this->hasMany('App\Models\Route', 'to_id', 'id');
    }
    
    public function canDelete()
    {
        if($this->passingPlaces()->count() || $this->startRoutes()->count() || $this->endRoutes()->count() || get_station_id()==$this->id) return false;
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        if($this->passingPlaces){
            foreach ($this->passingPlaces as $item) {
                $item->delete();
            }
        }
        if($this->startRoutes){
            foreach ($this->startRoutes as $item) {
                $item->delete();
            }
        }
        if($this->endRoutes){
            foreach ($this->endRoutes as $item) {
                $item->delete();
            }
        }
        return true;
    }


}
