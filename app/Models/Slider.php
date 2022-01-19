<?php

namespace App\Models;



class Slider extends Model
{
    //
    public $table = 'sliders';
    public $fillable = ['name','width','height','crop','position','priority', 'status'];

    protected $_route = 'slider';

    
    protected static $activeID = 0;

    public static function setID($id=0)
    {
        self::$activeID = $id;
    }
    
    public static function getPositionData()
    {
        return [
            100=>"Không gán vị trí",
            1 => "Home",
            2 => "Header",
            3 => "Content-header",
            4 => "Content-footer",
            5 => "Sidebar-top",
            6 => "Sidebar-bottom",
            7 => "Footer",
            8 => "post-list",
            9 => "product-list",
            10=> "page-list",

            
        ];
    }

    public function getPosition()
    {
        $pos = self::getPositionData();
        return $pos[$this->position];
    }
    public function getSaveItemUrl()
    {
        return route('admin.slider.item.save');
    }
    public function getAddItemUrl()
    {
        return route('admin.slider.item.add',['id'=>$this->id]);
    }
    
    
    public function updatePriority($priority=0)
    {
        $c = self::where('position',$this->position)->count();
        if($this->priority==0){
            $this->priority = $c;
            $this->save();
        }
        if($priority != 0 && $priority != $this->priority){
            if($priority > $c){
                $priority = $c;
            }
            $query = static::where('position',$this->position)->where('id', '!=', $this->id);

            $begin = ($priority<$this->priority)?$priority:$this->priority;
            $end = ($priority>$this->priority)?$priority:$this->priority;    
            $query->whereBetween('priority',[$begin,$end]);
            if($list = $query->get()){
                if($priority > $this->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }   
            }
            $this->priority = $priority;
            $this->save();
            return true;
        }elseif($priority == 0){
            $count = self::where('position',$this->position)->count();
            if($this->priority==0){
                $this->priority = $count;
                $this->save();
                return true;
            }
            return $this->updatePriority($count);
        }
        return false;
    }
    public static function getSliderPriorityList($pos = 100)
    {
        $id = self::$activeID;
        $arr = ["Tự động"];
        if($pos){
            $num = self::where('position',$pos)->count();
            for($i=1; $i <= $num; $i++){
                $arr[] = $i;
            }
            $arr[] = "Cuối danh sách";
        }else{
            $arr[] = 1;
        }
        return $arr;
    }

    public static function getItemPriorityList()
    {
        $id = self::$activeID;
        $arr = ["Tự động"];
        if($id){
            $num = SliderItem::where('slider_id',$id)->count();
            for($i=1; $i <= $num; $i++){
                $arr[] = $i;
            }
            $arr[] = "Cuối danh sách";
        }else{
            $arr[] = 1;
        }
        return $arr;
    }
    public function getPriorityMenuList()
    {
        $pos = $this->position;
        $arr = [];
        if($pos){
            $num = self::where('position',$pos)->count();
            for($i=1; $i <= $num; $i++){
                $arr[] = [
                    'text' => "Chuyển tới vị trí thứ ".$i,
                    'url' => '#',
                    'link_attrs' => ['data-id'=>$this->id,'data-priority'=>$i]
                ];
            }
            $arr[] = [
                'text' => "Cuối danh sách",
                'url' => '#',
                'link_attrs' => ['data-id'=>$this->id,'data-priority'=>$i]
            ];
        }else{
            $arr[] = 1;
        }
        return $arr;
    }


    #################### URL ################
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }
    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }



    public function items()
    {
        return $this->hasMany('App\\Models\\SliderItem', 'slider_id', 'id');
    }

    public function getItems()
    {
        return $this->items()->orderBy('priority','ASC')->get();
    }
    public function countItem()
    {
        # code...
    }

    public function delete()
    {
    	if(count($this->items)){
            foreach($this->items as $item){
                $item->delete();
            }
        }
        return parent::delete();
    }
}
