<?php

namespace App\Models;



class Bus extends Model
{
    protected $table = 'buses';

    public $fillable = [
        "company_id","route_id","type","license_plate", "license_plate_clean", "description","phone_number","seets","weight",
        "freq_days","freq_trips","date_limited","day_start","day_stop","lastest_run","is_active"
    ];

    public $_folder = 'buses'; // folder chứ hình ảnh upload

    public $_route = 'bus';

    
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

    public function route()
    {
        return $this->belongsTo('App\Models\Route', 'route_id', 'id');
    }
    
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule', 'bus_id', 'id');
    }

    
    public function canDelete()
    {
        if($this->schedules()->count()) return false;
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        if($this->schedules){
            foreach ($this->schedules as $schedule) {
                $schedule->delete();
            }
        }
        return true;
    }

    public function getTripPerMonth()
    {
        $div_trip = $this->freq_trips/$this->freq_days;
        $x = 30;
        if($this->date_limited){
            $x = $this->day_stop - $this->day_start + 1;
        }
        return $div_trip * $x;
    }
}
