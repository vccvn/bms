<?php

namespace App\Models;

class CrawlTask extends Model
{
    protected $table = 'crawl_tasks';
    public $fillable = [
        'frame_id',
        'dynamic_id',
        'user_id',
        'cate_id',
        'url',
        'url_post',
        'quantity',
        'run_time',
        'repeat_time',
        'crawl_time',
        'datetime_crawl',
        'crawl_last_time',
        'status'
    ];

    public $_route = 'admin.crawler.task';

    protected $status_list = [
        1 => 'Bật',
        0 => 'Tắt'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'cate_id', 'id');
    }

    public function frame()
    {
        return $this->belongsTo('App\Models\CrawlFrame', 'frame_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getTimeAgo()
    {
        return $this->calculator_time($this->datetime_crawl);
    }

    public function dynamic()
    {
        return $this->belongsTo('App\Models\Dynamic', 'dynamic_id', 'id');
    }

    public function getChannelName()
    {
        return $this->dynamic?$this->dynamic->title:"Bài viết";
    }
    
    public function getStatusMenu()
    {
        return $this->status_list;
    }

    public function getStatusText()
    {
        if(!isset($this->status_list[$this->status])) return "Tắt";
        return $this->status_list[$this->status];
    }


    
    public function getUpdateUrl()
    {
        return route($this->_route.'.update',['id' => $this->id]);
    }

}
