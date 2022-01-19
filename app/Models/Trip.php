<?php

namespace App\Models;

class Trip extends Model
{
    protected $table = 'trips';

    public $fillable = ["schedule_id","tickets","estimated_time","started_at","arrived_at","completed_at",'checkin_at', 'checkout_at', 'status'];

    public $_folder = 'trips'; // folder chứ hình ảnh upload

    public $_route = 'trip';

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule', 'schedule_id', 'id');
    }


    public function getEstimateTimeArray()
    {
        return get_time_array($this->estimated_time);
    }



    public function canDelete()
    {
        $created_time = strtotime($this->completed_at);
        $time = time();
        if($this->status == 100 && $created_time >= $time - 3600*24*365) return false;
        elseif($this->status == 1 && $created_time >= $time - 3600*24*2) return false;
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        
        return true;
    }
}
