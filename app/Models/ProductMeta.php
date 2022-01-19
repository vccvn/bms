<?php

namespace App\Models;



class ProductMeta extends Model
{
    public $table = 'product_meta';
    public $fillable = ['product_id','type','name','value'];
    public $timestamps = false;
}
