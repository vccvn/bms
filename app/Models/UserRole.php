<?php

namespace App\Models;



class UserRole extends Model
{
    public $table = 'user_roles';

    public $fillable = ['user_id', 'role_id'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\\Models\\Role','role_id','id')->first();
    }

    public function user()
    {
        return $this->belongsTo('App\\Models\\User','user_id','id')->first();
    }

}
