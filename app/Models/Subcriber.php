<?php

namespace App\Models;

class Subcriber extends Model
{
    protected $table = 'subcribers';
    public $fillable = ['email'];
    
    public $_route = 'subcriber';

}
