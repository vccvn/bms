<?php

namespace App\Models;



class Tag extends Model
{
    //
    public $table = 'tags';
    public $fillable = ['keywords','lower','tagname', 'status'];
    public $timestamps = false;
    
    public $_route = 'content.tag';


    public function posts()
    {
        return Post::join('has_tags','posts.id','=','has_tags.object_id')
                    ->join('tags','tags.id','=','has_tags.tag_id')
                    ->where('has_tags.object','post')
                    ->where('has_tags.tag_id', $this->id);
    }

    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

}
