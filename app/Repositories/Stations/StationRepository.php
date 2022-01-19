<?php

namespace App\Repositories\Stations;

/**
 * @created doanln  2018-11-08
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

use App\Repositories\Provinces\ProvinceRepository;
use App\Web\Setting;


use App\Repositories\Places\PlaceRepository;

class StationRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Station::class;
    }
    
    protected static $activeID = 0;

    public function setActiveID($id = null)
    {
        if($id){
            self::$activeID = $id;
        }
    }

    public function getActiveID()
    {
        return self::$activeID;
    }


    public function setID($id=null)
    {
        self::setActiveID($id);
        $this->_model->setID($id);
    }

    
    public function save(array $attributes = [], $id = null)
    {
        $attributes['slug'] = $this->getSlug((isset($attributes['slug']) && $attributes['slug'])? $attributes['slug'] :$attributes['name'], $id);
        return parent::save($attributes,$id);

    }


    
    public function filter($request){
        // filter
        $orderby = [];
        $sb = strtolower($request->sortby);
        if(($sb && in_array($sb, $this->getFields())) || $sb == 'province_name'){
            if($sb == 'province_name') $sb = 'provinces.name';
            $orderby[$sb] = $request->sorttype;
            
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name', 'id']
            ],
            '@join' => ['provinces','provinces.id','=','stations.province_id'],
            '@selectRaw' => ['stations.*, provinces.name as province_name'],
            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ];
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    /**
     * them theo tỉnh thanh
     * 
     */
    public function addManyByProvince($data = [])
    {
        $add = 0;
        if(is_array($data)){
            $rep = new ProvinceRepository();
            foreach ($data as $p) {
                $prv = new Any($p);
                $name = $prv->name;
                if(!$name) continue;
                if(!$province = $rep->findBy('name',$name)){
                    $slug = str_slug($prv->slug?$prv->slug:$prv->name);
                    $d = [
                        'name' => $name,
                        'slug' => $slug
                    ];
                    $province = $rep->save($d);
                }
                if(is_array($prv->list)){
                    foreach($prv->list as $stname){
                        $data = [
                            'name' => $stname,
                            'province_id' => $province->id
                        ];
                        $d = array_merge($data,['slug'=>$this->getSlug($stname)]);
                        if(!$this->first($data) && $this->save($d)){
                            $add++;
                        } 
                    }
                }
            }
        }
        return $add;
    }

    public static function getStationOptions()
    {
        $provinceRepository = new ProvinceRepository();
        $data = ['Chọn bến xe'];
        if(count($list = $provinceRepository->orderBy('name','ASC')->get())){
            foreach ($list as $p) {
                $stations = $p->stations;
                if(count($stations)){
                    $stationData=[];
                    foreach ($stations as $s) {
                        $stationData[$s->id] = $s->name;
                    }
                    $data[$p->slug] = [
                        'label' => $p->name,
                        'data' => $stationData
                    ];
                }
            }
        }
        return $data;
    }

    public function getStartStationOptions($route_type = 'direct')
    {
        $type = strtolower($route_type);
        if($type == 'direct'){
            $station_id = (new Setting())->station_id;
            if($station = $this->find($station_id)){
                return [$station_id=>$station->name];
            }
            return ["Bến xe chưa được thiết lập"];
        }
        if($type == 'bus'){
            $station_id = get_station_id();
            if($station = $this->find($station_id)){
                if($places = (new PlaceRepository)->where('province_id', $station->province_id)->get()){
                    $data = ['Chọn địa điểm'];
                    $types = [
                        'station' => 'bến xe',
                        'place'   => 'dịa điểm'
                    ];
                    foreach ($places as $item) {
                        $data[$item->id] = "$item->name (".$types[$item->type].")";
                    }
                    return $data;
                }
                return ["Bến xe chưa được thiết lập"];
            }
            return ["Bến xe chưa được thiết lập"];
        }
        
        return self::getStationOptions();
    }

    public static function getStartOptions($route_type = 'direct')
    {
        return (new static())->getStartStationOptions($route_type);
    }

    public function getEndStationOptions($route_type = 'direct')
    {
        $type = strtolower($route_type);
        if($type == 'bus'){
            $station_id = get_station_id();
            if($station = $this->find($station_id)){
                if($places = (new PlaceRepository)->where('province_id', $station->province_id)->get()){
                    $data = ['Chọn địa điểm'];
                    $types = [
                        'station' => 'bến xe',
                        'place'   => 'dịa điểm'
                    ];
                    foreach ($places as $item) {
                        $data[$item->id] = "$item->name (".$types[$item->type].")";
                    }
                    return $data;
                }
                return ["Bến xe chưa được thiết lập"];
            }
            return ["Bến xe chưa được thiết lập"];
        }
        return self::getStationOptions();
    }

    public static function getEndOptions($route_type = 'direct')
    {
        return (new static())->getEndStationOptions($route_type);
    }

}