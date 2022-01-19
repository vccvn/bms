<?php

namespace App\Models;



use App\Repositories\Dynamic\DynamicRepository;

class Dynamic extends BasePost
{
    public $_folder = 'dynamics'; // folder chứ hình ảnh upload

    public $_route = 'dynamic';


    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }
    public function getDeleteUrl()
    {
        return route('admin.'.$this->_route.'.delete',['id' => $this->id]);
    }
    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['slug' => $this->slug]);
    }

    public function getViewUrl()
    {
        if($this->parent){
            return route('client.'.$this->_route.'.view-child',['parent_slug' => $this->parent->slug,'child_slug' => $this->slug]);
        }
        return route('client.'.$this->_route.'.view',['slug' => $this->slug]);
    }

    
    public function getFullTitle()
    {
        $title = $this->title;
        if($this->parent){
            $title .= ' | '.$this->parent->title;
        }
        return $title;
    }


    public function getChildrenPropInputData()
    {
        $this->applyMeta();
        $data = [];
        if($this->children_props){
            
            $props = ['name', 'type', 'label', 'placeholder'];
            $ep = ['props','default'];
            $f = ["\r\n", "\r", "\n"];
            $p = explode(',', str_replace($f, ',', $this->children_props));
            if($p){
                foreach ($p as $d) {
                    if(!($tt = trim($d))) continue;
                    $tpl = ['name' => '', 'type' => 'text', 'label' => null];
                    $a = explode('=', $tt);
                    if($a){
                        foreach ($a as $k => $v) {
                            if(isset($ep[$k])){
                                $it = $ep[$k];
                                if($it == 'props'){
                                    $prs = explode(':', trim($v));
                                    if($prs){
                                        foreach ($prs as $i => $pr) {
                                            if(isset($props[$i])){
                                                $tpl[$props[$i]] = trim($pr);
                                            }
                                        }
                                    }
                                }elseif ($it == 'default') {
                                    if(strlen($df = trim($v))){
                                        if($df!='null'){
                                            $tpl['default'] = $df;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($tpl['name']){
                        $data[] = $tpl;
                    }
                }
            }
        }
        
        return $data;
    }



}
