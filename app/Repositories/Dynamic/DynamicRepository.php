<?php

namespace App\Repositories\Dynamic;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\Posts\BasePostRepository;

class DynamicRepository extends BasePostRepository
{

    public function __construct()
    {
        parent::__construct();
        $this->setType('dynamic');
    }
    
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Dynamic::class;
    }
    
    public function makeCateMap($cate_id)
    {
        $rep = new CategoryRepository();
        $cate = $rep->find($cate_id);
        $str='';
        if($cate){
            $str = ' '.implode(', ', $cate->getMap()).',';
        }
        
        return $str;
    }

    
    public function getParentList()
    {
        return $this->get(['status' => 200, '@where'=>['parent_id','<',1]]);
    }

    public static function getMenuList()
    {
        $rep = new static();
        $list = [];
        if($d = $rep->get(['status'=>200,'@where'=>['parent_id', '<', 1]])){
            foreach ($d as $f) {
                $list[$f->id] = $f->title;
            }
        }
        return $list;
    }

    public static function getParentSelectOption()
    {
        $repository = new static();
        return $repository->getParentSelection();

    }

    public static function getPostSelectOption()
    {
        $repository = new static();
        return $repository->getPostSelection();
    }
    
    public static function getChildrenSelect($parent_id=null)
    {
        $static = new static();
        if(!($page = $static->find($parent_id))) return [];
        $list = $static->get(['type'=>'dynamic','parent_id'=>$parent_id, 'status'=>200]);
        $a = [$parent_id=>$page->title];
        if($list){
            foreach ($list as $item) {
                $a[$item->id] = $item->title;
            }
        }
        return $a;
    }

    public function getParentSelection()
    {
        $data = ["không"];
        if(self::$activeID && $c = $this->find(self::$activeID)){
            if($c->hasChild()){
                return $data;
            }
        }
        $query = $this->_model->where('status',200)->where('type','dynamic')->where('parent_id','<',1);
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

    public function getPostSelection()
    {
        $data = ["Bài viết"];
        if(self::$activeID && $c = $this->find(self::$activeID)){
            if($c->hasChild()){
                return $data;
            }
        }
        $query = $this->_model->where('status',200)->where('type','dynamic')->where('parent_id','<',1);
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

    public function changeChildrenType($id,$type="dynamic")
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


    public function getActiveDynamics($dynamic = 'services', $args = [])
    {
        $a = (array) $args;
        $a['status'] = 200;
        if($d = $this->first(['slug'=>$dynamic,'status'=>200])){
            $a['parent_id'] = $d->id;
            return $this->get($a);
        }
        return [];
    }



    public function getFilter($request, $post, $args = []){
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }else{
            $orderby['id'] = 'DESC';
        }
        $args = array_merge([
            'parent_id' => $post->id,
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['title', 'keywords'],
            ],
            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),
            'status' => 200
        ], (array) $args);
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));

        return $list;
    }

}