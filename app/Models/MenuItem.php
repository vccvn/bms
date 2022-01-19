<?php

namespace App\Models;



class MenuItem extends Model
{
    public $table = 'menu_items';

    public $fillable = ['menu_id','parent_id','type', 'title','active_key','priority', 'status'];

    public $timestamps = false;

    public $__route = 'menu.item'; // folder chứ hình ảnh upload

    public $__meta = [];
    public function updatePriority($priority=0)
    {
        $c = self::where('menu_id',$this->menu_id)->where('parent_id',$this->parent_id)->count();
        if($this->priority==0){
            $this->priority = $c;
            $this->save();
        }
        if($priority != 0 && $priority != $this->priority){
            if($priority > $c){
                $priority = $c;
            }
            $query = static::where('menu_id',$this->menu_id)->where('parent_id',$this->parent_id)->where('id', '!=', $this->id);

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
            $count = self::where('menu_id',$this->menu_id)->where('parent_id',$this->parent_id)->count();
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
        $id = $this->menu_id;
        $arr = [];
        if($id){
            $num = MenuItem::where('menu_id',$id)->count();
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
    public function menu()
    {
        return Menu::find($this->menu_id);
    }
    public function getMeta()
    {
        $metas = MenuItemMeta::where('item_id',$this->id)->get();
        return $metas;
    }

    public function checkMeta()
    {
        if(!$this->__meta){
            $metas = $this->getMeta();
            if($metas->count()>0){
                foreach($metas as $m){
                    $this->__meta[$m->name] = $m->value;
                }
            }
        }
        return $this;
    }

    public function meta($name=null,$value=null)
    {
        $this->checkMeta();
        if(is_null($name)) return $this->__meta;
        $metas = [];
        if(is_array($name)){
            $metas = $name;
        }elseif(is_null($value)){
            if(count($ars = explode(',',str_replace(' ','',$name)))>1){
                $metas = $ars;
            }else{
                return isset($this->__meta[$name])?$this->__meta[$name]:null;
            }
        }
        elseif(is_string($name)){
            if(count($ars = explode(',',str_replace(' ','',$name)))>1){
                foreach($ars as $name){
                    $metas[$name] = $value;
                }
            }else{
                $this->__meta[$namw] = $value;
                return $this->applyMeta();
            }
        }
        if(count($metas)>0){
            foreach($metas as $key => $val){
                $this->__meta[$key] = $val;
            }
            return $this->applyMeta();
        }
        return $this;
    }


    public function applyMeta()
    {
        $this->checkMeta();
        if(count($this->__meta)>0){
            foreach($this->__meta as $name => $value){
                $this->{str_slug($name,'_')} = $value;
            }
        }
        return $this;
    }

    public function category()
    {
        $this->applyMeta();
        $cate = Category::find($this->cate_id);
        foreach($cate as $key => $val){
            $this->__meta[$key] = $val;
        }
        $this->checkMeta();
        return $cate;
    }



    public function getUpdateUrl()
    {
        return route('admin.'.$this->__route.'.update',['menu_id' => $this->menu_id,'id' => $this->id]);
    }
    public function getDeleteUrl()
    {
        return route('admin.'.$this->__route.'.delete',['id' => $this->id]);
    }
    public function getDetailUrl()
    {
        return route('admin.'.$this->__route.'.detail',['id' => $this->id]);
    }


    public function delete()
    {
    	if($list = $this->getMeta()){
            foreach($list as $item){
                $item->delete();
            }
        }
        if($this->children){
            foreach($this->children as $child){
                $child->delete();
            }
        }
        return parent::delete();
    }

    public function updateMeta($name,$value=null)
    {
        if(is_string($name)){
            if($item_meta = MenuItemMeta::where([['item_id',$this->id],['name',$name]])->first()){
                // update
            }
            else{
                $item_meta = new MenuItemMeta();
                $item_meta->item_id = $this->id;
                $item_meta->name = $name;
            }
            $item_meta->value = $value;
            $item_meta->save();
        }
        elseif(is_array($name)){
            foreach($name as $n => $v){
                if($item_meta = MenuItemMeta::where([['item_id',$this->id],['name',$n]])->first()){
                    // update
                }
                else{
                    $item_meta = new MenuItemMeta();
                    $item_meta->item_id = $this->id;
                    $item_meta->name = $n;
                }
                $item_meta->value = $v;
                $item_meta->save();
                $item_meta = null;
            }
        }
    }




    public function children()
    {
        return $this->hasMany('App\\Models\\MenuItem','parent_id','id')->orderBy('priority','ASC');
    }
}
