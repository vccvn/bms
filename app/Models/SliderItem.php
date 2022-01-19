<?php

namespace App\Models;



class SliderItem extends Model
{
    //
    public $table = 'slider_items';
    public $fillable = ['slider_id', 'type', 'title', 'description', 'link', 'url', 'image', 'priority', 'status'];
    protected $_route = 'slider.item';

    protected $_folder = 'sliders';
    protected static $menuID = 0;

    public function getSaveItemUrl()
    {
        return route('admin.slider.item.save');
    }
    
    public static function setID($id=0)
    {
        self::$menuID = $id;
    }


    public function updatePriority($priority=0)
    {
        $c = self::where('slider_id',$this->slider_id)->count();
        if($priority != 0 && $priority != $this->priority){
            if($priority > $c){
                $priority = $c;
            }
            $query = static::where('slider_id',$this->slider_id)->where('id', '!=', $this->id);

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
            $count = self::where('slider_id',$this->slider_id)->count();
            if($this->priority==0){
                $this->priority = $count;
                $this->save();
                return true;
            }
            return $this->updatePriority($count);
        }
        return false;
    }
    public function getPriorityMenuList()
    {
        $slider_id = $this->slider_id;
        $arr = [];
        if($slider_id){
            $num = self::where('slider_id',$slider_id)->count();
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
        return route('admin.'.$this->_route.'.update',['slider_id' => $this->slider_id, 'id' => $this->id]);
    }
    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }



    public function slider()
    {
        return $this->belongsTo('App\\Models\\Slider', 'slider_id', 'id');
    }

    public function getFilePath()
    {
        if($this->image){
            return public_path('/contents/'.$this->_folder.'/'.$this->image);
        }
        return null;
    }

    public function getImage()
    {
        $img = $this->image?$this->image:'default.png';
        return asset('/contents/'.$this->_folder.'/'.$img);
    }

    
    public function deleteFile()
    {
        if($p = $this->getFilePath()){
            if(file_exists($p)) unlink($p);
        }
        return true;
    }
    

    public function delete()
    {
        $this->deleteFile();
        return parent::delete();
    }
}
