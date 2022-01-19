<?php

namespace App\Repositories\Gallery;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

use App\Models\Post;
use App\Models\Project;
use App\Models\Dynamic;
use App\Models\Page;
use App\Models\Product;



class GalleryRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */

     public function getModel()
    {
        return \App\Models\Gallery::class;
    }


    public function checkRef($ref = null, $ref_id = null)
    {
        $o = in_array($ref, ['post','page','product','dynamic', 'project']);
        if(is_null($ref_id) || !$o) return $o;
        if($ref == 'post' && Post::find($ref_id)) return true;
        elseif($ref == 'page' && Page::find($ref_id)) return true;
        elseif($ref == 'dynamic' && Dynamic::find($ref_id)) return true;
        elseif($ref == 'project' && Project::find($ref_id)) return true;
        elseif($ref == 'product' && Product::find($ref_id)) return true;
        return false;
    }
    public function checkRefData($ref, $ref_id, $gallery = [])
    {
        $data = [];
        $gallery = (array) $gallery;

        $o = $this->checkRef($ref,$ref_id);
        if($list = $this->get(['ref'=>$ref,'ref_id'=>$ref_id])){
            if(!$o){
                foreach ($list as $item) {
                    $item->delete();
                }
            }else{
                foreach ($list as $item) {
                    if(in_array($item->id,$gallery)){
                        $data[] = $item->id;
                    }else{
                        $item->delete();
                    }
                }
            }
        }
        return $data;
    }

    public function saveGallery($ref, $ref_id, $filename = null)
    {
        $data = [];
        $o = $this->checkRef($ref,$ref_id);
        if($list = $this->get(['ref'=>$ref,'ref_id'=>$ref_id])){
            if(!$o){
                foreach ($list as $item) {
                    $item->delete();
                }
            }
        }
        if($o){
            $ret = [];
            $data = compact('ref','ref_id');
            if(is_array($filename)){
                foreach($filename as $gi){
                    $d = $data;
                    $li = ['filename','orginal_filename'];
                    if(is_array($gi)){
                        foreach($gi as $i => $f){
                            if(is_numeric($i) && isset($li[$i])){
                                $d[$li[$i]] = $f;
                            }elseif(in_array($i, $li)){
                                $d[$i] = $f;
                            }
                        }
                    }else{
                        $d['filename'] = $f;
                    }
                    if(count($d)==2) continue;
                    $ga = new $this->_model();
                    $ga->fill($d);
                    $ga->save();
                    $ret[] = $ga->id;
                }
                return $ret;
            }
            elseif($filename){
                $data['filename'] = $filename;
                $ga = new $this->_model();
                $ga->fill($data);
                $ga->save();
                return [$ga->id];
            }
        }
        return [];
    }

    public function savePostGallery($post_id, $filename = null)
    {
        return $this->saveGallery('post',$post_id,$filename);
    }

    public function saveProjectGallery($post_id, $filename = null)
    {
        return $this->saveGallery('project',$post_id,$filename);
    }

    public function savePageGallery($page_id, $filename = null)
    {
        return $this->saveGallery('page',$page_id,$filename);
    }
    
    public function saveDynamicGallery($page_id, $filename = null)
    {
        return $this->saveGallery('dynamic',$page_id,$filename);
    }

    public function saveProductGallery($product_id, $filename = null)
    {
        return $this->saveGallery('product',$product_id,$filename);
    }


    public function saveBase64Data($ref, $ref_id, $data=[])
    {
        $ret = [];
        if($this->checkRef($ref, $ref_id)){
            if(is_array($data) && $data){
                foreach ($data as $base64) {
                    $fn = str_slug(microtime()).'-'.rand(10000, 99999);
                    $filename = save_base64_image($base64, $fn, '/contents/galleries');
                    if($filename){
                        $data = compact('ref','ref_id','filename');
                        $ga = new $this->_model();
                        $ga->fill($data);
                        $ga->save();
                        $ret[] = $ga->id;
                    }
                }
            }
        }
        return $ret;
    }
}