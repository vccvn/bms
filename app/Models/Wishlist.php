<?php

namespace App\Models;



class Wishlist extends Model
{
    public $fillable = ['product_id','likes'];
    public $timestamps = false;
}
