<?php

namespace App\Models;



class Comment extends Model
{
    //

    public $table = 'comments';
    public $fillable = ['parent_id', 'user_id', 'object', 'object_id', 'author_name', 'author_phone', 'author_email', 'content', 'approved'];



    public function post()
    {
        if($this->object == 'post'){
            return $this->belongsTo('App\\Models\\Post', 'object_id','id')->first();
        }
        return null;
    }
    public function product()
    {
        if($this->object == 'product'){
            return $this->belongsTo('App\\Models\\Product', 'object_id','id')->first();
        }
        return null;
    }
    public function page()
    {
        if($this->object == 'page'){
            return $this->belongsTo('App\\Models\\Page', 'object_id','id')->first();
        }
        return null;
    }


    public function dynamic()
    {
        if($this->object == 'dynamic'){
            return $this->belongsTo('App\\Models\\Dynamic', 'object_id','id')->first();
        }
        return null;
    }

    public function replies()
    {
        return $this->hasMany('App\\Models\\Comment','parent_id','id')->where('approved', 1);
    }


    public function title()
    {
        $title = $this->author_name . " đã gửi phản hồi ";
        if($p = $this->post()) $title.=" cho bài viết \"".$p->title."\"";
        elseif($p = $this->page()) $title.=" trên trang \"".$p->title."\"";
        elseif($p = $this->dynamic()) $title.=" về mục \"".$p->title."\"";
        elseif($p = $this->product()) $title.=" về sản phẩm \"".$p->name."\"";
        else $title = $this->author_name . " đã gửi thông tin nhờ tư vấn ";
        return $title;
    }

    public function getShortDesc($length=null, $after = '...')
    {
        $desc = null;
        $trim = true;;
        if(isset($this->content) && $this->content){
            $desc = $this->content;
        }
        if($trim){
            if(!$length) $length = 500;
            if($length < strlen(strip_tags($desc))){
                $a = explode(' ', str_limit(strip_tags($desc),$length));
                $b = array_pop($a);
                return implode(' ', $a).$after;
            }else{
                return strip_tags($desc);
            }
        }
        return $desc;
    }

    
    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }

    public function getDetailUrl()
    {
        return route('admin.comment.detail',['id' => $this->id]);
    }

    public function user()
    {
        if($this->user_id && $u = User::find($this->user_id)){
            $user = $u;
        }else{
            $user = new User();
            $user->name = $this->auther_name;
            $user->email = $this->auther_email;
            $user->id = 0;
        }
        return $user;
    }

}
