<?php

namespace App\Repositories\Categories;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Category;


class BaseCategoryRepository extends EloquentRepository
{

    
    public static $sonLevel = 0;

    public static $maxLevel = 2;
    
    protected static $activeID = 0;

    public $type = null;
    /**
     * get model
     * @return string
     */
    public function setType($type = null)
    {
        if($type && in_array($type, ['post','page','dynamic','product'])){
            $this->addFixableParam('type', $type);
            $this->addDefaultValue('type', $type);
            $this->type = $type;
        }
        
        return $this;
    }

    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Category::class;
    }
    
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

    

    public function find($id)
    {
        return $this->findBy('id', $id);
    }
    
    /**
     * lay danh sach cha
     * @param integer $maxLevel level cao nhat cua 1 danh muc
     * 
     * @return Collection
     */
    public static function getParentSelectOptions($maxLevel = 2)
    {
        self::$maxLevel = $maxLevel;
        $list = ["Không"];
        $repository = new static();
        if(self::$activeID){
            if($cate = $repository->find(self::$activeID)){
                self::$sonLevel = $cate->getSonLevel();
            }
            
        }
        $args = [
            '@where'=>['parent_id', '<', 1],
            'status' => 200
        ];
        if($categories = $repository->get($args)){
            $list = self::toParentSelectOptions($categories, $list);
        }
        return $list;
    }
    protected static function toParentSelectOptions($list, $opts = [], $prefix='')
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $prefix.$c->name;
                $cond = ($c->getLevel() + self::$sonLevel < self::$maxLevel);
                if($c->id != self::$activeID && $cond && !$c->hasPost()){
                    
                    if(count($ch = $c->getChildren())>0){
                        
                        $data = self::toParentSelectOptions($ch,[]);
                        $opts[$c->id] = [
                            'label' => $name,
                            'data' => $data
                        ];
                    }else{
                        $opts[$c->id] = $name;
                    }
                }
            }
        }
        return $opts;
    }


    public static function getCategorySelectOptions()
    {
        $list = ["-- Danh mục --"];
        $repository = new static();
        $args = [
            '@where'=>['parent_id', '<', 1],
            'status' => 200
        ];
        
        if($categories = $repository->get($args)){
            $list = self::toCategorySelectOptions($categories, $list);
        }
        return $list;
    }
    protected static function toCategorySelectOptions($list, $opts = [])
    {
        if(count($list)>0){
            foreach($list as $c){
                $name = $c->name;
                
                if(count($ch = $c->getChildren())){
                    $data = self::toCategorySelectOptions($ch,[]);
                    $opts[$c->id] = [
                        'label' => $name,
                        'data' => $data
                    ];
                    
                    
                    
                }else{
                    $opts[$c->id] = $name;
                }
            }
        }
        return $opts;
    }

    public function getCateWithViews($args = [])
    {
        $args = (array) $args;
        $a = [
            '@selectRaw' => 'categories.*, SUM(posts.views) AS views',
            '@leftJoin' => ['posts', 'posts.cate_id', '=', 'categories.id'],
            '@groupBy' => 'categories.id'
        ];
        return $this->get(array_merge($args, $a));
    }

    public function filter($request, $args = [])
    {
        $args = (array) $args;
        $s = strlen($request->search)?$request->search:$request->s;
        $perpage = $request->perpage?$request->perpage:10;
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }else{
            $orderby['id'] = 'desc';
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $s,
                'by' => ['name', 'keywords'],
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => $perpage,
            'status' => 200
        ];
        $list = $this->get($args);
        $qs = parse_query_string(null,$request->all());
        if($qs){
            $list->withPath('?'.$qs);
        }
        
        return $list;
    }

    public static function getMenuList()
    {
        $array = [];
        $rep = new static();
        if($cates = $rep->get(['status'=>200])){
            foreach ($cates as $c) {
                $array[$c->id] = $c->title;
            }
        }
        return $array;
    }



    public function deleteFeatureImage($id=null)
    {
        if($model = $this->find($id)){
            return $model->deleteFile();
        }
        return false;
    }
}