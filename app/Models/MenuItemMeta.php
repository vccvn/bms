<?php

namespace App\Models;



class MenuItemMeta extends Model
{
    public $table = 'menu_item_meta';

    public $fillable = ['item_id','name', 'value'];

    public $timestamps = false;
}
