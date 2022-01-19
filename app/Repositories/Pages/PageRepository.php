<?php

namespace App\Repositories\Pages;

/**
 * @created doanln  2018-10-27
 */
use App\Models\Page;
use App\Repositories\Posts\BasePostRepository;

class PageRepository extends BasePostRepository
{

    public function __construct()
    {
        parent::__construct();
        $this->setType('page');
    }
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Page::class;
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


    public static function getParentSelectOption()
    {
        $repository = new static();
        return $repository->getParentSelection();

    }



    public function getParentSelection()
    {
        $data = ["không"];
        if(self::$activeID && $c = $this->find(self::$activeID)){
            if($c->hasChild()){
                return $data;
            }
        }
        $query = $this->_model->where('status',200)->where('type','page')->where('parent_id','<',1);
        if(self::$activeID){
            $query->where('id','!=',self::$activeID);
        }
        if($list = $query->get()){
            foreach ($list as $module) {
                $data[$module->id] = $module->title;
            }
        }
        return $data;
    }

    public function changeChildrenType($id,$type="page")
    {
        if($page = $this->find($id)){
            if($type == $page->type) return false;
            if(count($page->children)){
                foreach($page->children as $child){
                    $child->type = $type;
                    $child->save();
                }
            }
        }
    }

    public function checkSlug($name=null,$id=null)
    {
        if($id && $m = $this->find($id)){
            $md = $m;
        }else{
            $md = $this->_model;
        }
        return $md->checkSlug($name);
    }

    /**
     * lay danh sach san pham
     * @param array $data du lieu truyen vao
     * @return App\Page          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-03-08
     * 
     */
    public function getPages($data=null)
    {
        return $this->getList($data);
    }

}