<?php

namespace App\Models;



class PostMeta extends Model
{
    public $table = 'post_meta';
    public $fillable = ['post_id','type','name','value'];
    public $timestamps = false;
}
