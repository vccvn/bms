<?php

namespace App\Models;



class ProductProperties extends Model
{
    public $table = 'product_properties';
    public $fillable = ['product_id','name','value'];
    public $timestamps = false;

}
