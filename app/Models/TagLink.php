<?php

namespace App\Models;



class TagLink extends Model
{
    public $table = 'tag_links';
    public $fillable = ['tag_id','object','object_id'];
    public $timestamps = false;
    
    public function tag()
    {
        return $this->belongsTo('App\\Models\\Tag','tag_id','id');
    }

    

}
