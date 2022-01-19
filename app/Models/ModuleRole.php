<?php

namespace App\Models;



class ModuleRole extends Model
{
    public $table = 'module_roles';

    public $fillable = ['module_id', 'role_id'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\\Models\\Role','role_id','id')->first();
    }

    public function module()
    {
        return $this->belongsTo('App\\Models\\Module','module_id','id')->first();
    }

}
