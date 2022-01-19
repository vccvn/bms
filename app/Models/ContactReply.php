<?php

namespace App\Models;



class ContactReply extends Model
{
    //
    public $table = 'contact_replies';
    public $fillable = ['contact_id', 'user_id', 'content'];


    public function author()
    {
        return $this->belongsTo('App\\Models\\User','user_id','id');
    }
}
