<?php

namespace App\Models;



class WebOption extends Model
{
    public $fillable = ['type','option_group','name','value','comment'];
    protected $_route = 'admin.option';
    public $timestamps = false;
    public function getUpdateUrl()
    {
        return route($this->_route.'.update',['id' => $this->id]);
    }
}
