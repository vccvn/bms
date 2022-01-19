<?php

namespace App\Models;



class Contact extends Model
{
    public $table = 'contacts';
    public $fillable = ['name','email','phone_number','subject','content', 'status'];

    protected $_route = 'contact';


    public function replies()
    {
        return $this->hasMany('App\\Models\\ContactReply', 'contact_id','id');
    }

    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }

    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }


}
