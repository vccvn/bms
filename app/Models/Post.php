<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;



class Post extends BasePost
{
    public $fillable = [
        'type','user_id', 'cate_id', 'cate_map', 'title','slug','description','content',
        'keywords','feature_image','views','likes', 'status'
    ];

    public $_folder = 'posts'; // folder chứ hình ảnh upload

    public $_route = 'post';


}
