<?php

namespace App\Repositories\Places;

/**
 * @created doanln  2018-11-08
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

use App\Repositories\Provinces\ProvinceRepository;
use App\Web\Setting;

class PlaceRepository extends EloquentRepository
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


    public function getPlaceOptions($province_id=null)
    {
        $provinceRepository = new ProvinceRepository();
        $types = [
            'station' => 'bến xe',
            'place'   => 'địa điểm'
        ];
        
        if($province_id && $province = $provinceRepository->find($province_id)){
            $args = [
                '@select' => ['stations.*','provinces.name as province'],
                '@join' => ['provinces', 'provinces.id', '=','stations.province_id'],
                'province_id' => $province_id
            ];
                
            $data = ['Chọn địa điểm'];
            if(count($list = $this->get($args))){
                foreach ($list as $place) {
                    $data[$place->id] = $place->name.(isset($types[$place->type])?' ('.$types[$place->type].')':'');
                }
            }
            return $data;
        }


        $data = ['Chọn địa điểm'];
        if(count($list = $provinceRepository->orderBy('name','ASC')->get())){
            foreach ($list as $p) {
                $places = $p->allPlaces;
                if(count($places)){
                    $placeData=[];
                    foreach ($places as $s) {
                        $placeData[$s->id] = $s->name.(isset($types[$s->type])?' ('.$types[$s->type].')':'');
                    }
                    $data[$p->slug] = [
                        'label' => $p->name,
                        'data' => $placeData
                    ];
                }
            }
        }
        
        return $data;
        
    }


    public static function getPlaceSelectOptions($province_id=null)
    {
        return (new static())->getPlaceOptions($province_id);
    }

}