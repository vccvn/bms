<?php

namespace App\Models;



class Schedule extends Model
{
    protected $table = 'schedules';

    public $fillable = ["bus_id","route_id","direction","active_date"];

    public $_folder = 'schedules'; // folder chứ hình ảnh upload

    public $_route = 'schedule';

    public function trips()
    {
        return $this->hasMany('App\Models\Trip', 'schedule_id', 'id');
    }
    
    public function route()
    {
        return $this->belongsTo('App\Models\Route', 'route_id', 'id');
    }

    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

    public function delete()
    {
        $this->trips()->delete();
        return parent::delete();
    }
 
}
