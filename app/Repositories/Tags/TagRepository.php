<?php

namespace App\Repositories\Tags;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use DB;
class TagRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */

     public function getModel()
    {
        return \App\Models\Tag::class;
    }


    public function makeQuery($data = [])
    {
        $limit = null;
        $sortby = null;
        $args = [];
        $find = null;
        if (is_array($data)) {
            $abc = $data;
            foreach ($abc as $field => $vl) {
                $k = strtolower($field);
                if (substr($k, 0, 1) == '@') {
                    $f = substr($k, 1);
                    if ($f == 'sort') {
                        $sortby = $vl;
                    } elseif ($f == 'find') {
                        $find = $vl;
                    } elseif ($f == 'search') {
                        $find = $vl;
                    } else {
                        $args[$field] = $vl;
                    }
                } else {
                    $args[$field] = $vl;
                }
            }
        }

        if(is_string($find) && strlen($find)){
            $args['@where'] = function($query) use ($find){
                $find = vn_to_lower($find);
                $query->where('lower', 'like', "%$find%")
                    ->orWhere('tagname', 'like', "%".str_slug($find)."%");
            };
        }
        if ($sortby) {
            $orderby = isset($args['@order_by']) ? (is_array($args['@order_by']) ? $args['@order_by'] : [$args['@order_by']]) : [];
            $orderByRaw = isset($args['@orderByRaw']) ? (is_array($args['@orderByRaw']) ? $args['@orderByRaw'] : [$args['@orderByRaw']]) : [];
            // sort by
            $sb = 'id';
            // sort type
            $st = 'ASC';
            // is sort by sale_total
            $issale = false;
            // ngau nhien
            $isrand = false;
            if (is_array($sortby)) {
                $sb = isset($sortby['by']) ? $sortby['by'] : 'id';
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
        return $this->query($args, 'tags');
    }


        /**
     * lay danh sach ban ghi
     * @param array $data du lieu truyen vao
     * @return App\Post          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-03-08
     * 
     */
    public function getTags($data=null)
    {
        $paginate = null;
        if(is_array($data)){
            if(array_key_exists('@paginate',$data)){
                $paginate = $data['@paginate'];
                unset($data['@paginate']);
            }
        }
        $query = $this->makeQuery($data);
        if(is_numeric($paginate) && $paginate > 0){
            $rs = $query->paginate($paginate);
        }else{
            $rs = $query->get();
        }
        
        return $rs;
    }

    public function getData($data=[])
    {
        $tags = [];
        $s = vn_to_lower(isset($data['@search'])?$data['@search']:(isset($data['@find'])?$data['@find']:''));
        if($list = $this->getTags($data)){
            if($s){
                foreach($list as $t){
                    if($s == $t->lower){
                        $t->active = 1;
                    }else{
                        $t->active = 0;
                    }
                    $tags[] = $t;
                }
            }
            else{
                foreach($list as $t){
                    $t->active = 0;
                    $tags[] = $t;
                }
            }
        }
        return $tags;
    }

    // lay ra danh sach ban ghi dc filter
    public function filter($request, $args = [])
    {
        $a = (array) $args;
        $s = strlen($request->search)?$request->search:$request->s;
        $p = [];
        if(strlen($s)){
            $p['@find'] = $s;
        }
        $p['@paginate'] = $request->perpage > 0?$request->perpage:15;
        
        if($request->sortby){
            $p['@order_by'] = [$request->sortby=>$request->sorttype];
        }
        return $this->getTags(array_merge($p,$a));
    }

    public function addTag($tag)
    {
        $a = null;
        $keywords = trim($tag);
        if(!$keywords) return null;
        $lower = vn_to_lower($keywords);
        $tagname = str_slug($keywords);
        if($ta = $this->findBy('lower',$lower)){
            //$a = $ta;
        }elseif($m = $this->save(compact('keywords','lower','tagname'))){
            $a = $m;
        }
        return $a;
    }

    public function updateTag($id, $tag)
    {
        if(!$this->find($id)) return false;
        $a = null;
        $keywords = trim($tag);
        $lower = vn_to_lower($keywords);
        $tagname = str_slug($keywords);
        if($m = $this->save(compact('keywords','lower','tagname'),$id)){
            $a = $m;
        }
        return $a;
    }

    public function addTags($tags)
    {
        
        $a = [];
        if($tags){
            if(count($tag_list = explode(',', $tags))){
                foreach ($tag_list as $t) {
                    if($ta = $this->findBy('lower',trim(vn_to_lower($t)))){
                        $a[] = $ta;
                    }elseif($tag = $this->addTag($t)){
                        $a[] = $tag;
                    }
                }
            }
        }

        return $a;
    }

    public function addIfNotExists($tags)
    {
        
        $a = [];
        if($tags){
            if(count($tag_list = explode(',', $tags))){
                foreach ($tag_list as $t) {
                    if($tag = $this->addTag($t)){
                        $a[] = $tag;
                    }
                }
            }
        }

        return $a;
    }

    /**
     * lay ra cac the duoc gan nhieu nhat
     */
    public function getPopularTags($args = [])
    {
        $args = (array) $args;
        // dung mang de goi ham thay cho dung query buider
        $args['@selectRaw'] =  'tags.*, (SELECT COUNT(1) FROM tag_links WHERE tag_links.tag_id = tags.id) AS link_count';
        $args['@orderByRaw']='link_count DESC';
        
        return $this->getTags($args);
    }
}