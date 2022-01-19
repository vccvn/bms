<?php

namespace App\Models;



use App\Repositories\Pages\PageRepository;

class Page extends BasePost
{

    public $_route = 'page';

    public $_folder = 'pages';
    
    
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
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }

    public function getViewUrl()
    {
        if($this->parent){
            return route('client.dynamic.view-child',['parent_slug' => $this->parent->slug,'child_slug' => $this->slug]);
        }
        return route('client.dynamic.view',['slug' => $this->slug]);
    }

    public function getFullTitle()
    {
        $title = $this->title;
        if($this->parent){
            $title .= ' | '.$this->parent->title;
        }
        return $title;
    }
}
