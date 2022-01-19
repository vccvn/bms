<?php

namespace App\Repositories\Users;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

use App\Models\Post;
use App\Models\Project;
use App\Models\Dynamic;
use App\Models\Page;
use App\Models\Product;


class UserLinkRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */

     public function getModel()
    {
        return \App\Models\UserLink::class;
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


    public function saveUsers($object, $object_id, $users = [])
    {
        $data = [];
        $user_list = (array) $users;
        $o = $this->checkObject($object,$object_id);
        if($list = $this->get(['object'=>$object,'object_id'=>$object_id])){
            if(!$o){
                foreach ($list as $item) {
                    $item->delete();
                }
            }else{
                foreach ($list as $item) {
                    if(in_array($item->user_id,$user_list)){
                        $data[] = $item->user_id;
                    }else{
                        $item->delete();
                    }
                }
            }
        }
        if($o){
            foreach($user_list as $user_id){
                if(!in_array($user_id, $data)){
                    $userLink = new $this->_model();
                    $userLink->fill(compact('object','object_id', 'user_id'));
                    $userLink->save();
                }
            }
        }
    }

    public function savePostUsers($post_id, $users = [])
    {
        return $this->saveUsers('post',$post_id,$users);
    }

    public function saveProjectUsers($post_id, $users = [])
    {
        return $this->saveUsers('project',$post_id,$users);
    }

    public function savePageUsers($page_id, $users = [])
    {
        return $this->saveUsers('page',$page_id,$users);
    }
    
    public function saveDynamicUsers($page_id, $users = [])
    {
        return $this->saveUsers('dynamic',$page_id,$users);
    }

    public function saveProductUsers($product_id, $users = [])
    {
        return $this->saveUsers('product',$product_id,$users);
    }
}