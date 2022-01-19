<?php

namespace App\Models;



class Order extends Model
{
    public $fillable = ['name','email','phone_number','address','coupon_code','total_money', 'payment_method', 'notes', 'status'];
    
    protected $statusList = ['600' => 'Đã hoàn thành', '300' => 'Đang xử lý', '0' => 'Mới yêu cầu', '-1' => 'Bị hủy'];


    protected $_route = 'order';

    public function orderProduct()
    {
        return $this->hasMany('App\\Models\\OrderProduct','order_id','id');
    }
    public function products()
    {
        return $this->hasMany('App\\Models\\OrderProduct','order_id','id');
    }

    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }

    public function delete()
    {
        $this->orderProduct()->delete();
        return parent::delete();
    }

    public function changeStatus($status = 0)
    {
        if(array_key_exists($status,$this->statusList)){
            $this->status = $status;
            $this->save();
            return true;
        }
        return false;
    }

    public function getStatusText($stt = null)
    {
        if(is_null($stt)) $stt = $this->status;
        if(array_key_exists($stt,$this->statusList)){
            return $this->statusList[$stt];
        }
        return false;

    }

    public function getStatusMenu()
    {
        return $this->statusList;
    }

    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }

    public function getPaymentText()
    {
        $i = $this->payment_method;
        $arr = [
            "Không xác định",
            "Ship COD",
            "Internet Banking",
            "ATM"
        ];
        return isset($arr[$i])?$arr[$i]:$arr[0];
    }

}
