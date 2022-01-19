<?php

namespace App\Models;



class PassingPlace extends Model
{
    public $table = 'passing_places';

    public $fillable = [
        'place_id', 'route_id', 'priority'
    ];

    public $_folder = 'places'; // folder chứ hình ảnh upload

    public $_route = 'place';

    public $timestamps = false;
}
