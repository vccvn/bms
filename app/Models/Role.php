<?php

namespace App\Models;



class Role extends Model
{
    public $table = 'roles';
    public $fillable = ['name','handle','description','status'];
    public $_route = 'admin.permission';
    public $_folder = 'roles';


    public function getUpdateUrl()
    {
        return route($this->_route.'.update',['id' => $this->id]);
    }



    /**
     * get user query
     * @return App\User 
     */
    public function users()
    {
        $users = User::whereRaw('users.id in (select user_id from user_roles where role_id = '.$this->id.')');
        return $users;
    }
    
    /**
     * get user query
     * @return App\User 
     */
    public function usersNotIn()
    {
        $users = User::whereRaw('users.id not in (select user_id from user_roles where role_id = '.$this->id.')');
        return $users;
    }
    /**
     * get module query
     * @return App\Module
     */
    public function modules()
    {
        $modules = Module::whereRaw('modules.id in (select module_id from module_roles where role_id = '.$this->id.' )');
        return $modules;
    }

    /**
     * get module query
     * @return App\Module
     */
    public function modulesNotRequired()
    {
        $modules = Module::whereRaw('modules.id not in (select module_id from module_roles where role_id = '.$this->id.' )');
        return $modules;
    }


    public static function getCheckList()
    {
        $roles = [];
        if($list = self::all()){
            foreach($list as $item){
                $roles[$item->id] = $item->name;
            }
        }
        return $roles;
    }

    public function roleUser()
    {
        return $this->hasMany('App\\Models\\UserRole','role_id','id');
    }
    public function roleModule()
    {
        return $this->hasMany('App\\Models\\ModuleRole','role_id','id');
    }


    
    public function delete()
    {
        $this->roleUser()->delete();
        $this->roleModule()->delete();
        return parent::delete();
    }

}
