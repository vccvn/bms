<?php

namespace App\Repositories\Provinces;

/**
 * @created doanln  2018-11-08
 */
use App\Repositories\EloquentRepository;
use App\Light\Any;

class ProvinceRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Province::class;
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


    public static function getProvinceOptions()
    {
        $data = ['Chọn tỉnh'];
        $rep = new static();
        if(count($list = $rep->get())){
            foreach ($list as $province) {
                $data[$province->id] = $province->name;
            }
        }
        return $data;
    }

    
    public function filter($request){
        // filter
        $orderby = [];
        
        if($request->sortby && in_array($request->sortby, $this->getFields())){

            $orderby[$request->sortby] = $request->sorttype;
            
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name', 'slug']
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ];
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

    public function addMany($data = [])
    {
        $add = 0;
        if(is_array($data)){
            foreach ($data as $p) {
                $prv = new Any($p);
                $name = $prv->name;
                $slug = str_slug($prv->slug?$prv->slug:$prv->name);
                if(!$name || $this->findBy('name',$name)) continue;
                
                $data = [
                    'name' => $name,
                    'slug' => $slug
                ];
                $this->save($data);
                $add++;
            }
        }
        return $add;
    }
}