<?php

namespace App\Models;

class CrawlFrame extends Model
{
    protected $table = 'crawl_frames';
    public $fillable = [
        "name",
        "slug",

        'url',
        
        "image",
        "attr_image",
        
        "title",
        'attr_title',
        
        "description",
        "attr_description",
        
        "tag",
        "attr_tag",
        
        "content",
        "avatar",
        'style',
        
        'except',
        
        'meta_title',
        'meta_description',
        'meta_keyword',
        
        'index',
        "created_by"
    ];
    
    public $_route = 'crawler.frame';

    public $_folder = 'frames';

    public function getAvatar()
    {
        return asset('contents/frames/'.$this->avatar);
    }

    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
        
    }

}
