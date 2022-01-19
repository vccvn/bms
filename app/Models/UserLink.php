<?php

namespace App\Models;

class UserLink extends Model
{
    public $table = 'user_links';
    public $fillable = ['user_id','object','object_id'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\\Models\\User','user_id','id');
    }


}
