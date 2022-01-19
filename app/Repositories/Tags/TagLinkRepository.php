<?php

namespace App\Repositories\Tags;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

use App\Models\Post;
use App\Models\Project;
use App\Models\Dynamic;
use App\Models\Page;
use App\Models\Product;



class TagLinkRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */

     public function getModel()
    {
        return \App\Models\TagLink::class;
    }


    public function checkObject($object = null, $object_id = null)
    {
        $o = in_array($object, ['post','page','product','dynamic', 'project']);
        if(is_null($object_id) || !$o) return $o;
        if($object == 'post' && Post::find($object_id)) return true;
        elseif($object == 'page' && Page::find($object_id)) return true;
        elseif($object == 'dynamic' && Dynamic::find($object_id)) return true;
        elseif($object == 'project' && Project::find($object_id)) return true;
        elseif($object == 'product' && Product::find($object_id)) return true;
        return false;
    }


    public function saveTags($object, $object_id, $tags = [])
    {
        $data = [];
        $tag_list = (array) $tags;
        $o = $this->checkObject($object,$object_id);
        if($list = $this->get(['object'=>$object,'object_id'=>$object_id])){
            if(!$o){
                foreach ($list as $item) {
                    $item->delete();
                }
            }else{
                foreach ($list as $item) {
                    if(in_array($item->tag_id,$tag_list)){
                        $data[] = $item->tag_id;
                    }else{
                        $item->delete();
                    }
                }
            }
        }
        if($o){
            foreach($tag_list as $tag_id){
                if(!in_array($tag_id, $data)){
                    $tagLink = new $this->_model();
                    $tagLink->fill(compact('object','object_id', 'tag_id'));
                    $tagLink->save();
                }
            }
        }
    }

    public function savePostTags($post_id, $tags = [])
    {
        return $this->saveTags('post',$post_id,$tags);
    }

    public function saveProjectTags($post_id, $tags = [])
    {
        return $this->saveTags('project',$post_id,$tags);
    }

    public function savePageTags($page_id, $tags = [])
    {
        return $this->saveTags('page',$page_id,$tags);
    }
    
    public function saveDynamicTags($page_id, $tags = [])
    {
        return $this->saveTags('dynamic',$page_id,$tags);
    }

    public function saveProductTags($product_id, $tags = [])
    {
        return $this->saveTags('product',$product_id,$tags);
    }
}