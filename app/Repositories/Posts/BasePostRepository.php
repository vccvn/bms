<?php

namespace App\Repositories\Posts;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Post;
use App\Models\PostProductLink;

use App\Repositories\Categories\BaseCategoryRepository as CateRep;
class BasePostRepository extends EloquentRepository
{
    public $type = null;
    /**
     * get model
     * @return string
     */
    public function setType($type = null)
    {
        if($type && in_array($type, ['post','page','dynamic','project'])){
            $this->addFixableParam('type', $type);
            $this->addDefaultValue('type', $type);
            $this->type = $type;
        }
    }
    public function getModel()
    {
        return \App\Models\Post::class;
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

    /**
     * tim kiem
     * @param Request $request 
     * @param array $args
     * @return array
     */
    public function searchAll($request, $args = [])
    {   $t = 'posts.';
        $search = $request->search?$request->search:($request->s?$request->s:($request->keyword?$request->keyword:null));
        $data = (array) $args;
        unset($data['@search']);
        if(strlen($search)){
            $data['@actions'] = [
                ['selectRaw',$t.'*'],
                ['where', function($query) use($search, $t){
                    $query->where($t.'title','like',"%$search%");
                    $query->orWhere($t.'keywords','like',"%$search%");
                    $query->orWhereRaw("posts.id in (
                        SELECT tag_links.object_id FROM tag_links INNER JOIN tags ON tags.id = tag_links.tag_id
                        WHERE "
                        .($this->type?"tag_links.object = '$this->type' AND ":'')
                        ."(tags.lower like '%".str_replace("'", "\'", strtolower($search))."%' OR tags.tagname like '%".str_slug($search)."%')
                    )");
                    
                }],
                ['orderBy',$t.'created_at','DESC'],
            ];
        }
        $data['status'] = 200;
        $q = $this->makeQuery($data);
        
        $q->where(function($query) use($search){
            $query->where(function($s){
                $s->where('posts.type','!=','dynamic');
            })->orWhere(function($s){
                $s->where('posts.type','dynamic')->where('posts.parent_id','>', 0);
            });
        });
        
        if(isset($data['@paginate'])){
            $list = $q->paginate($data['@paginate']);
            $qs = parse_query_string(null,$request->all());
            if($qs){
                $list->withPath('?'.$qs);
            }
            
        }else{
            $list = $q->get($data);
        }
        return $list;
    }


    
    public function checkSlug($name=null,$id=null)
    {
        if($id && $m = $this->find($id)){
            $md = $m;
        }else{
            $md = new $this->_model;
        }
        return $md->checkSlug($name);
    }

    
    public function saveMetaSimple($id, $name,$value=null,$type='text')
    {
        if($model = $this->find($id)){
            $model->saveMetaSimple($name,$value,$type);
            return true;
        }
        return false;
    }

        
    public function saveMeta($id, $name, $value=null, $type=null, $comment = null)
    {
        if($model = $this->find($id)){
            $model->saveMeta($name,$value,$type,$comment);
            return true;
        }
        return false;
    }
    public function saveManyMeta($id, $meta=[])
    {
        if($model = $this->find($id)){
            $model->saveManyMeta($meta);
            return true;
        }
        return false;
    }


    public function save(array $attributes = [], $id = null)
    {
        if(isset($attributes['content'])){
            $home = rtrim(route('home'),'/').'/';
            $attributes['content'] = str_replace($home, '/', $attributes['content']);
            
        }
        return parent::save($attributes,$id);

    }

    public function updateProductLinks($id, $products = [])
    {
        if($model = $this->find($id)){
            if(!$products || !is_array($products)){
                PostProductLink::where('post_id',$id)->delete();
            }else{
                $passed = [];
                if(count($list = PostProductLink::where('post_id',$id)->get())){
                    foreach ($list as $item) {
                        if(in_array($item->product_id,$products)){
                            $passed[] = $item->product_id;
                        }else{
                            $item->delete();
                        }
                    }
                }
                foreach($products as $product_id){
                    if(!in_array($product_id,$passed)){
                        $pp = new PostProductLink();
                        $pp->fill([
                            'post_id' => $id,
                            'product_id' => $product_id
                        ]);
                        $pp->save();
                    }
                }
            }
            
            return true;
        }
        return false;
    }



    public function makeQuery($data = [])
    {
        
        $price = null;
        $allOfCategory = null;
        $limit = null;
        $sortby = null;
        $args = [];
        if (is_array($data)) {
            $abc = $data;
            foreach ($abc as $field => $vl) {
                $k = strtolower($field);
                if (substr($k, 0, 1) == '@') {
                    $f = substr($k, 1);
                    if ($f == 'all_of_category') {
                        $allOfCategory = $vl;
                    } elseif ($f == 'cate_map') {
                        $allOfCategory = $vl;
                    } elseif ($f == 'sort') {
                        $sortby = $vl;
                    } else {
                        $args[$field] = $vl;
                    }
                } else {
                    $args[$field] = $vl;
                }
            }
        }
        if ($allOfCategory && is_numeric($allOfCategory)) {
            $args['@whereRaw'] = "posts.cate_map like '% $allOfCategory,%'";
        }
        if ($sortby) {
            $orderby = isset($args['@order_by']) ? (is_array($args['@order_by']) ? $args['@order_by'] : [$args['@order_by']]) : [];
            $orderByRaw = isset($args['@orderByRaw']) ? (is_array($args['@orderByRaw']) ? $args['@orderByRaw'] : [$args['@orderByRaw']]) : [];
            // sort by
            $sb = 'created_at';
            // sort type
            $st = 'ASC';
            // is sort by sale_total
            $issale = false;
            // ngau nhien
            $isrand = false;
            if (is_array($sortby)) {
                $sb = isset($sortby['by']) ? $sortby['by'] : 'created_at';
                $st = isset($sortby['type']) ? (strtolower($sortby['type']) == 'desc' ? 'DESC' : 'ASC') : 'ASC';
            }
            if (in_array($sortby, ['random', 'rand()', '@rand'])) {
                $orderByRaw[] = 'RAND()';
                $isrand = true;
            } elseif ($sortby != '') {
                $sb = $sortby;
            }

            if (!$isrand) {
                $orderby[$sb] = $st;
                $args['@oeder_by'] = $orderby;
            }

            $args['@orderByRaw'] = $orderByRaw;

        }
        return $this->query($args, 'posts');
    }



    /**
     * lay danh sach san pham
     * @param array $data du lieu truyen vao
     * @return App\Post          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-03-08
     * 
     */
    public function getList($data=null)
    {
        $paginate = null;
        $data = (array) $data;
        $cmt = "(SELECT COUNT(1) FROM comments WHERE comments.object_id = posts.id"
        .($this->type?" AND comments.object = '$this->type'":'')
        ." AND comments.approved = 1 AND comments.parent_id = 0) AS comment_count";
        if(array_key_exists('@selectRaw', $data)){
            if(is_array($data['@selectRaw'])){
                if(isset($data['@selectRaw'][0])){
                    $data['@selectRaw'][0] .= ', '.$cmt;
                }else{
                    $data['@selectRaw'][] = $cmt;
                }
            }else{
                $data['@selectRaw'] .= ', '.$cmt;
            }
        }else{
            $data['@selectRaw'] = 'posts.*, '.$cmt;
        }
        if(array_key_exists('@paginate',$data)){
            $paginate = $data['@paginate'];
        }
    
        $query = $this->makeQuery($data);
        if(is_numeric($paginate) && $paginate > 0){
            $rs = $query->paginate($paginate);
        }else{
            $rs = $query->get();
        }
        return $rs;
    }


    public function filter($request, $args = [])
    {
        $args = (array) $args;
        $s = strlen($request->search)?$request->search:$request->s;
        $perpage = $request->perpage?$request->perpage:10;
        $orderby = [];
        
        if($request->sortby){
            $sb = strtolower($request->sortby);
            if($sb == 'views'){
                $orderby['views'] = 'DESC';
            }
            elseif ($sb=='category') {
                $orderby['categories.name'] = $request->sorttype;
                $args['@join'] = ['categories','categories.id','=','posts.cate_id'];
                $args['@selectRaw'] = 'posts.*, categories.name as cate_name';
            }
            else{
                $orderby[$sb] = $request->sorttype;
            }
        }
        $orderby['created_at'] = 'DESC';
        $args2 = [
            '@search' => [
                'keywords' => $s,
                'by' => ['title','keywords']
            ],
            
            '@order_by' => $orderby,
            '@paginate' => $perpage,
            'status' => 200
        ];

        $args = array_merge($args, $args2);
        $list = $this->getList($args);
        $qs = parse_query_string(null,$request->all());
        if($qs){
            $list->withPath('?'.$qs);
        }
        
        return $list;
    }


    public function getActiveList($args = [])
    {
        $a = (array) $args;
        $a['status'] = 200;
        return $this->getList($a);
    }

    /**
     * tim kiem
     * @param Request $request 
     * @param array $args
     * @return array
     */
    public function search($request, $args = [])
    {   $t = 'posts.';
        $search = $request->search?$request->search:($request->s?$request->s:($request->keyword?$request->keyword:null));
        $data = (array) $args;
        unset($data['@search']);
        if(strlen($search)){
            $data['@actions'] = [
                ['selectRaw',$t.'*'],
                ['where', function($query) use($search, $t){
                    $query->where($t.'title','like',"%$search%");
                    $query->orWhere($t.'keywords','like',"%$search%");
                    $query->orWhereRaw("posts.id in (
                        SELECT tag_links.object_id FROM tag_links INNER JOIN tags ON tags.id = tag_links.tag_id
                        WHERE "
                        .($this->type?"tag_links.object = '$this->type' AND ":'')
                        ."(tags.lower like '%".str_replace("'", "\'", strtolower($search))."%' OR tags.tagname like '%".str_slug($search)."%')
                    )");
                    
                }],
                ['orderBy',$t.'created_at','DESC'],
            ];
        }
        $data['status'] = 200;
        $q = $this->makeQuery($data);
        if(isset($data['@paginate'])){
            $list = $q->paginate($data['@paginate']);
            $qs = parse_query_string(null,$request->all());
            if($qs){
                $list->withPath('?'.$qs);
            }
            
        }else{
            $list = $q->get($data);
        }
        return $list;
    }


    public function deleteFeatureImage($id=null)
    {
        if($model = $this->find($id)){
            return $model->deleteFile();
        }
        return false;
    }

    public function viewUp($id)
    {
        if($model = $this->find($id)){
            $model->views++;
            $model->save();
        }
    }

    public function makeCateMap($cate_id)
    {
        $rep = new CateRep();
        if($this->type){
            $rep->setType($this->type);
        }
        $cate = $rep->find($cate_id);
        $str='';
        if($cate){
            $str = ' '.implode(', ', $cate->getMap()).',';
        }
        
        return $str;
    }
}