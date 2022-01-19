<?php

namespace App\Repositories\Dynamic;

/**
 * @created doanln  2018-01-27
 */

use App\Repositories\Categories\BaseCategoryRepository;

class CategoryRepository extends BaseCategoryRepository
{
    protected static $dynamic = null;
    public function __construct()
    {
        parent::__construct();
        
        //$this->setType('product');
    }

    public function setType($type = null)
    {
        if($type == self::$dynamic || $type=='post'){
            $this->addFixableParam('type', $type);
            $this->addDefaultValue('type', $type);
            $this->type = $type;
            self::$dynamic = $type;
            return $this;
        }
        $dynamics = new DynamicRepository();
        if($type && $dynamics->first(['slug' => $type, 'parent_id' => 0])){
            $this->addFixableParam('type', $type);
            $this->addDefaultValue('type', $type);
            $this->type = $type;
            self::$dynamic = $type;
        }
        return $this;
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
       $repository->setType(self::$dynamic);
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
       $repository->setType(self::$dynamic);
       $args = [
           '@where'=>['parent_id', '<', 1],
           'status' => 200
       ];
       
       if($categories = $repository->get($args)){
           $list = self::toCategorySelectOptions($categories, $list);
       }
       return $list;
   }


   public function getCategoryOptions()
   {
       $list = ["-- Danh mục --"];
       $args = [
           '@where'=>['parent_id', '<', 1],
           'status' => 200
       ];
       if($categories = $this->get($args)){
           $list = self::toCategorySelectOptions($categories, $list);
       }
       return $list;
   }
   public static function getCategoryMenuSelectOptions($type='')
   {
       $list = ["-- Danh mục --"];
       $repository = new static();
       $repository->setType($type);
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

}