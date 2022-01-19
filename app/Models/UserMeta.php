<?php

namespace App\Models;



class UserMeta extends Model
{
    public $table = 'user_meta';
    public $fillable = ['user_id','type','name','value'];
    public $timestamps = false;
}
