<?php

namespace App\Models;



use Cube\Laravel\LaravelRoute;

class Module extends Model
{
    public $table = 'modules';
    public $fillable = ['type','parent_id','name','route','description','status'];

    public $_route = 'admin.module';
    public $_folder = 'modules';

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

    public function getParent()
    {
        if($this->parent_id > 0){
            return self::find($this->parent_id);
        }
        if($this->type!='default'){
            $r = null;
            if($this->type=='route_name' && $route = LaravelRoute::getByName($this->route)){
                $r = $route;
            }
            elseif($this->type=='route_uri' && $route = LaravelRoute::getByUri($this->route)){
                $r = $route;
            }
            
            if($r){
                if($r['prefix']){
                    return self::where('type','route_prefix')->where('route',$r['prefix'])->first();
                }
            }
            return null;
        }
        return null;
    }

    public function getParentByID()
    {
        if($this->parent_id > 0){
            return self::find($this->parent_id);
        }
        return null;
    }

    public function getParentByPrefix()
    {
        if($this->type!='default'){
            $r = null;
            if($this->type=='route_name' && $route = LaravelRoute::getByName($this->route)){
                $r = $route;
            }
            elseif($this->type=='route_uri' && $route = LaravelRoute::getByUri($this->route)){
                $r = $route;
            }
            
            if($r){
                if($r['prefix']){
                    return self::where('type','route_prefix')->where('route',$r['prefix'])->first();
                }
            }
        }
        return null;
    }

    public function getChildren()
    {
        if($this->type=='default'){
            return self::where('parent_id',$this->id)->get();
        }
        return null;
    }

    public function toFormData()
    {
        
        $data = [];
        $fields = ['id','name','type','parent_id','route'];
        foreach ($fields as $f) {
            $data[$f] = $this->{$f};
        }
        if($this->type != 'default'){
            $data[$this->type] = $data['route'];
        }
        return $data;
    }



    public function roles()
    {
        return $this->hasMany('App\\Models\\ModuleRole','module_id','id');
    }

    public function getRoleIDList()
    {
        $arr = [];
        if($list = $this->roles()->get()){
            foreach($list as $item){
                $arr[] = $item->role_id;
            }
        }
        return $arr;
    }


    public function getRoles()
    {
        $list = [];
        $role_ids = [];

        if($mroles = $this->roles()->get()){
        
            foreach ($mroles as $mr) {
                $role = $mr->role();
                $list[] = $role;
                $role_ids[] = $role->id;
            }
        }
        // lay role của thằng cha
        if($parent = $this->getParentByID()){
            // parent role
            if($prs = $parent->getRoles()){
                foreach ($prs as $pr) {
                    if(!in_array($pr->id, $role_ids)){
                        $list[] = $pr;
                        $role_ids[] = $pr->id;
                    }
                }
            }
        }
        // lay role của thằng cha
        if($parent = $this->getParentByPrefix()){
            // parent role
            if($prs = $parent->getRoles()){
                foreach ($prs as $pr) {
                    if(!in_array($pr->id, $role_ids)){
                        $list[] = $pr;
                        $role_ids[] = $pr->id;
                    }
                }
            }
        }
        return $list;
    }






    public function getUpdateUrl()
    {
        return route($this->_route.'.update',['id' => $this->id]);
    }

    public function delete()
    {
        //$this->roles()->delete();
        return parent::delete();
    }

}
