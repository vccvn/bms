<?php

namespace App\Models;



class Category extends Model
{
    public $table = 'categories';

    public $fillable = ['type','parent_id', 'name', 'slug', 'description', 'keywords','feature_image', 'is_menu', 'show_home', 'status'];

    public $_route = 'category';

    public $_folder = 'categories';

    public $_props = [];

    protected static $activeID = 0;

    public static function setActiveID($id = null)
    {
        if($id){
            self::$activeID = $id;
        }
    }
    public static function getActiveID()
    {
        return self::$activeID;
    }

    public static function getMenuList()
    {
        $menu = [];
        if($list = self::all()){
            foreach($list as $cat){
                $menu[$cat->id] = $cat->name;
            }
        }
        return $menu;
    }
    public static function getSubMenuList()
    {
        $menu = [];
        if($list = self::where('parent_id','<',1)->get()){
            foreach($list as $cat){
                $menu[$cat->id] = $cat->name;
            }
        }
        return $menu;
    }


    public function getParent()
    {
        if($this->parent_id){
            return self::find($this->parent_id);
        }
        return null;
    }

    public function getChildren()
    {
        return self::where('parent_id',$this->id)->where('status',$this->status)->get();
    }
    public function getMenuChildren()
    {
        return self::where('parent_id',$this->id)->where('status', 200)->get();
    }
    public function hasChild()
    {
        return self::where('parent_id',$this->id)->count();
    }

    public function getMap($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this->id);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getMap($list,$n);
        }
        return $list;
    }
    public function getTree($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getTree($list,$n);
        }
        return $list;
    }
    public function getLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $n++;
        if($parent = $this->getParent()){
            return $parent->getLevel($n);
        }
        return $n;
    }


    public function getSonLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $max = 0;
        if(count($children = $this->getChildren())){
            $n++;
            $max = $n;
            foreach ($children as $child) {
                $k = $child->getSonLevel($n);
                if($k > $max){
                    $max = $k;
                }
            }
            $n = $max;
        }
        return $n;
    }

    public function getUpdateUrl()
    {
        if(in_array($this->type, ['post', 'product'])){
            return route('admin.'.$this->type.'.'.$this->_route.'.update',['id' => $this->id]);
        }
        if($d = $this->getRootDynamic()){
            return route('admin.dynamic.category.update',['dynamic_slug' => $d->slug, 'id' => $this->id]);
        }
        return '#';
    }

    public function getViewUrl()
    {
        $p = $this->getParent();
        if(in_array($this->type, ['post', 'product'])){
            if($p){
                return route('client.'.$this->type.'.category.view-child',['slug' => $p->slug, 'child_slug' => $this->slug]);
            }
            return route('client.'.$this->type.'.category.view',['slug' => $this->slug]);
        }
        if($d = $this->getRootDynamic()){
            if($p){
                return route('client.dynamic.category.view-child',['dynamic_slug' => $d->slug, 'slug' => $p->slug, 'child_slug' => $this->slug]);
            }
            return route('client.dynamic.category.view',['dynamic_slug' => $d->slug, 'slug' => $this->slug]);
        }
        return '#';
    }
    

    public function posts()
    {
        return $this->hasMany('App\\Models\\Post','cate_id','id');
    }

    public function dynamics()
    {
        return $this->hasMany('App\\Models\\Dynamic','cate_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\\Models\\Product','cate_id','id');
    }

    public function getRootDynamic()
    {
        return Dynamic::where('slug',$this->type)->first();
    }



    public function hasPost()
    {
        $query = $this->hasMany('App\\Models\\Post','cate_id','id');
        return $query->count()?true:false;
    }


    public function parent()
    {
        return $this->belongsTo('App\\Models\\Category','parent_id','id');
    }


    public function properties()
    {
        return $this->hasMany('App\\Models\CategoryProperty','cate_id','id');
    }





    public function getPropInput()
    {
        $d = [];
        if(count($this->properties)){
            foreach ($this->properties as $prop) {
                $d[$prop->nsme] = $prop->toPropInput();
            }
        }
        return $d;
    }

    public function getAllPropInput()
    {
        $cates = $this->getTree();
        $d = [];
        foreach($cates as $cate){
            if(count($cate->properties)){
                foreach ($cate->properties as $prop) {
                    $d[$prop->nsme] = $prop->toPropInput();
                }
            }
        }
        return $d;
    }

    public function getParentProps()
    {
        $d = [];
        $p = $this->getTree();
        $th = array_pop($p);
        if(count($p)){
            foreach($p as $cate){
                if(count($cate->properties)){
                    foreach ($cate->properties as $prop) {
                        $d[$prop->nsme] = $prop;
                    }
                }
            }
        }
        return $d;
    }


    public function countProduct()
    {
        return Product::where('cate_map', 'like', '% '.$this->id.',%')->where('status', 200)->count();
    }
    public function countPost()
    {
        return Post::where('cate_map', 'like', '% '.$this->id.',%')->where('status', 200)->where('type', 'post')->count();
    }


    public function saveProp($name, $type=null, $default = null, $data=null)
    {
        $d = compact('name');
        if(!is_null($type)){
            $d['type'] = $type;
        }
        if(!is_null($type)){
            $d['default'] = $default;
        }
        if(!is_null($type)){
            $d['data'] = $data;
        }
        if($p = CategoryProperty::where('name', $name)->where('cate_id', $this->id)->first()){
            // 
        }else{
            $p = new CategoryProperty();
            $d['cate_id'] = $this->id;
        }
        $p->fill($d);
        $p->save();
    }


    public function saveProps($props = [])
    {
        $_props = [];
        if(count($props)){
            foreach ($props as $prop) {
                if(is_array($prop)){
                    $d = ['name' => null, 'type' => null, 'data' => null, 'default' => null];
                    foreach($prop as $col => $val){
                        if($col == 'name') $val = strtolower($val);
                        $d[$col] = $val;
                    }
                    if($d['name']){
                        $_props[strtolower($d['name'])] = $d;
                    }
                }
            }
        }
        if(count($this->properties)){
            foreach ($this->properties as $p) {
                if(isset($_props[$p->name])){
                    $p->fill($_props[$p->name]);
                    $p->save();
                    unset($_props[$p->name]);
                }else{
                    $p->delete();
                }
            }
        }
        if(count($_props)){
            foreach($_props as $prop){
                $this->saveProp($prop['name'], $prop['type'], $prop['default'], $prop['data']);
            }
        }
    }



    public function getFilePath()
    {
        if($this->feature_image){
            return public_path('/contents/'.$this->_folder.'/'.$this->feature_image);
        }
        return null;
    }

    public function getImage()
    {
        $img = $this->feature_image?$this->feature_image:'default.png';
        return asset('/contents/'.$this->_folder.'/'.$img);
    }
    public function getFeatureImage()
    {
        return $this->getImage();
    }
    
    
    
    
    
    
    
    
    
    
    public function getFullTitle()
    {
        $cate_parent = $this->parent;
        $title = $this->name;
        if($cate_parent){
            $title.= ' | '. $cate_parent->name;
        }
        if($root = $this->getRootDynamic())
        {
            $title.=" | ".$root->title;
        }
        return $title;
        
    }



    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }
    public function postDate2()
    {
        return 'Thứ '.date('w', strtotime($this->created_at)).', Ngày '.date('d', strtotime($this->created_at)).' Tháng '.date('m', strtotime($this->created_at)).' Năm '.date('Y', strtotime($this->created_at));
    }

    public function updateTimeFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->updated_at));
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function deleteFile()
    {
        if($p = $this->getFilePath()){
            if(file_exists($p)) unlink($p);
        }
        
    }
    




    public function moveToTrash()
    {
        
        if($children = $this->getChildren()){
            foreach($children as $child){
                $child->delete();
            }
        }
        if($list = $this->posts()->where('status', 200)->get()){
            foreach($list as $item){
                $item->status = -2;
                $item->save();
            }
        }
        if($list = $this->products()->where('status', 200)->get()){
            foreach($list as $item){
                $item->status = -2;
                $item->save();
            }
        }
        $this->status = -1;
        $this->save();
        //$this->deleteFile();

        //return parent::delete();
    }

    public function delete()
    {
        return $this->moveToTrash();
    }
    public function restore()
    {
        
        if($children = $this->getChildren()){
            foreach($children as $child){
                $child->restore();
            }
        }
        if($list = $this->posts()->where('status', -2)->get()){
            foreach($list as $item){
                $item->status = 200;
                $item->save();
            }
        }
        if($list = $this->products()->where('status', -2)->get()){
            foreach($list as $item){
                $item->status = 200;
                $item->save();
            }
        }
        $this->status = 200;
        $this->save();
        //$this->deleteFile();

        //return parent::delete();
    }

    public function erase()
    {
        
        $this->deleteFile();
        if($children = $this->getChildren()){
            foreach($children as $child){
                $child->erase();
            }
        }
        if($list = $this->posts()->get()){
            foreach($list as $item){
                $item->erase();
            }
        }
        if($list = $this-products()->get()){
            foreach($list as $item){
                $item->erase();
            }
        }
        $this->deleteFile();

        return parent::delete();
    }
}
