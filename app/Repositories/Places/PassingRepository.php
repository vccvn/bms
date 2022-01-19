<?php

namespace App\Repositories\Places;

/**
 * @created doanln  2018-11-16
 */
use App\Repositories\EloquentRepository;
class PassingRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PassingPlace::class;
    }
  
    public function getJourneys($route_id)
    {
        return $this->get([
            'route_id' => $route_id,
            '@orderBy' => ['priority', 'ASC'],
            '@actions' => [
                ['join', 'stations', 'stations.id', '=', 'passing_places.place_id'],
                ['join', 'provinces', 'provinces.id', '=', 'stations.province_id'],
            ],
            '@select' => ['passing_places.*','stations.name as place_name', 'provinces.name as province_name']
        ]);
    }

    /**
     * them điểm trên hành trình
     * @param array $data
     */
    public function addPassingPlace(array $data = [])
    {
        $data['priority'] = $this->count(['route_id'=>$data['route_id']])+1;
        return $this->save($data);
    }
}