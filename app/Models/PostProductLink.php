<?php

namespace App\Models;



class PostProductLink extends Model
{
    //
    public $fillable = ['post_id','product_id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\\Models\\Product','product_id','id');
    }
    public function post()
    {
        return $this->belongsTo('App\\Models\\BasePost','post_id','id');
    }
}
