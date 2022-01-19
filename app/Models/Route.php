<?php

namespace App\Models;



class Route extends Model
{
    public $table = 'routes';

    public $fillable = [
        'from_id', 'to_id', 'type', 'name', 'distance', 'month_trips', 
        'freq_days', 'freq_trips', 'time_start', 'time_between', 'time_end', 'status'
    ];

    public $_folder = 'routes'; // folder chứ hình ảnh upload

    public $_route = 'route';

    
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

    public function getJourneyUrl()
    {
        return route('admin.place.journey',['id' => $this->id]);
    }

    public function places()
    {
        return $this->hasMany('App\Models\PassingPlace', 'route_id', 'id')
                    ->join('stations','stations.id', '=', 'passing_places.place_id')
                    ->join('provinces','provinces.id', '=', 'stations.province_id')
                    ->select('passing_places.*', 'stations.name as place_name', 'stations.type as place_type', 'provinces.name as province')
                    ->orderBy('priority', 'ASC');
    }

    public function reversePlaces()
    {
        return $this->hasMany('App\Models\PassingPlace', 'route_id', 'id')
                    ->join('stations','stations.id', '=', 'passing_places.place_id')
                    ->join('provinces','provinces.id', '=', 'stations.province_id')
                    ->select('passing_places.*', 'stations.name as place_name', 'stations.type as place_type', 'provinces.name as province')
                    ->orderBy('priority', 'DESC');
    }

    public function passingPlaces()
    {
        return $this->hasMany('App\Models\PassingPlace', 'route_id', 'id');
    }

        
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule', 'route_id', 'id');
    }

    public function buses()
    {
        return $this->hasMany('App\Models\Bus', 'route_id', 'id');
    }


    public function getJourney()
    {
        $data = [];
        if($this->places){
            foreach ($this->places as $place) {
                $data[] = $place;
            }
        }
        return $data;
    }


    public function coumtTripsRegisterOfBus($notId = null)
    {
        $n = 0;
        if(count($this->buses)){
            if(!$notId){
                foreach ($this->buses as $bus) {
                    $n += $bus->getTripPerMonth();
                }
            }else{
                foreach ($this->buses as $bus) {
                    if($bus->id != $notId){
                        $n += $bus->getTripPerMonth();
                    }
                    
                }
            }
        }
        return $n;
    }


    public function fromStation()
    {
        return $this->belongsTo('App\Models\Station', 'from_id', 'id');
    }

    public function toStation()
    {
        return $this->belongsTo('App\Models\Station', 'to_id', 'id');
    }


    
    public function canDelete()
    {
        if($this->passingPlaces()->count() || $this->schedules()->count() || $this->buses()->count()) return false;
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
        if($this->schedules){
            foreach ($this->schedules as $item) {
                $item->delete();
            }
        }
        return true;
    }


}
