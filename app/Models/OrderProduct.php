<?php

namespace App\Models;



class OrderProduct extends Model
{
    //
    public $fillable = ['order_id','product_id','product_qty','date_price'];
    public $timestamps = false;
    public function total()
    {
        return $this->date_price * $this->product_qty;
    }

    public function detail()
    {
        return $this->belongsTo('App\\Models\\Product','product_id','id');
    }
    
    public function getOrder()
    {
        return $this->belongsTo('App\\Models\\Order','order_id','id');
    }

    public function delete()
    {
        return self::where('order_id',$this->order_id)->where('product_id', $this->product_id)->delete();
    }
}
