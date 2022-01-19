<?php

namespace App\Repositories\Permissions;
/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;


use App\Models\User;
use App\Models\UserRole;
use App\Models\Module;
use App\Models\ModuleRole;

class PermissionRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Role::class;
    }
    
    
    /**
     * lay danh sach Role
     * @param  string $keyywords Từ khóa tìm kiếm
     * @param  string $search_by tìm theo tên cột
     * @param  integer $paginate  số kết quả mỗi trang
     * @return App\Role          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-01-26
     * 
     */
    public function list($keyywords = null, $search_by=null, $paginate=null)
    {
        $query = $this->_model->where('status','>',0);
        if(is_string($keyywords) && strlen($keyywords) > 0){
            if($search_by){
                if(is_string($search_by)){
                    $query->where($search_by,'like',"%$keyywords%");
                }elseif(is_array($search_by)){
                    $data = [$keyywords,$search_by];
                    $query->where(function($q) use($data){
                        $b = $data[1];
                        $q->where(array_shift($b),'like', "%$data[0]%");
                        foreach($b as $col){
                            $q->orWhere($col,'like', "%$data[0]%");
                        }
                    });
                }
            }else{
                $query->where('name','like',"%$keyywords%");
            }
        }
        if(is_numeric($paginate) && $paginate > 0){
            $rs = $query->paginate($paginate);
        }else{
            $rs = $query->get();
        }
        return $rs;
    }

    



    public function getUseersInRole($id=null, $search = null, $paginate = 15)
    {
        if(!$paginate || !is_numeric($paginate)) $paginate = 15;
        $stt = true;
        $list = [];
        $total = 0;
        if(!$id){
            $stt = false;
        }
        elseif(!($detail = $this->find($id))){
            $stt = false;
        }
        if($stt){
            $s = $search;
            $queryBuilder = $detail->users();
            if($s){
                $queryBuilder->where(function($query) use ($s){
                     $query->where('name','like',"%$s%");
                     $query->orwhere('email','like',"%$s%");
                     //$query->orwhere('phone_number','like',"%$s%");
                });
            }
            $total = $queryBuilder->count();
            if($listRole = $queryBuilder->paginate($paginate)){
                foreach ($listRole as $user) {
                    $list[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role_id' => $id
                    ];
                }
            }
        }
        return ['status'=>$stt,'id'=>$id,'tab'=> 'inrole','users'=> $list, 'total' => $total];
    }

    public function getUseersNotInRole($id=null, $search = null, $paginate = 15)
    {
        if(!$paginate || !is_numeric($paginate)) $paginate = 15;
        $stt = true;
        $list = [];
        $total = 0;
        if(!$id){
            $stt = false;
        }
        elseif(!($detail = $this->find($id))){
            $stt = false;
        }
        if($stt){
            $s = $search;
            $queryBuilder = $detail->usersNotIn();
            if($s){
                $queryBuilder->where(function($query) use ($s){
                     $query->where('name','like',"%$s%");
                     $query->orwhere('email','like',"%$s%");
                     //$query->orwhere('phone_number','like',"%$s%");
                });
            }
            $total = $queryBuilder->count();
            if($listRole = $queryBuilder->paginate($paginate)){
                foreach ($listRole as $user) {
                    $list[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role_id' => $id
                    ];
                }
            }
        }
        return ['status'=>$stt,'id'=>$id,'tab'=> 'notinrole','users'=> $list, 'total' => $total];
    }

    public function removeUsersRole($role_id=null,$users = null)
    {
        $remove_list = [];
        $stt = false;
        $total = 0;
        if($role_id && $users){
            if($role = $this->find($role_id) && is_array($users)){
                $stt = true;
                foreach($users as $id){
                    if(UserRole::where('user_id',$id)->where('role_id',$role_id)->delete()){
                        $remove_list[] = $id;
                    }
                }
                $total = UserRole::where('role_id',$role_id)->count();
            }
        }
        return['status'=>$stt,'id'=>$role_id,'tab'=> 'inrole','remove_list'=>$remove_list,'total' => $total];
    }


    public function addUsersRole($role_id=null,$users = null)
    {
        $remove_list = [];
        $stt = false;
        $total = 0;
        if($role_id && $users){
            if($role = $this->find($role_id) && is_array($users)){
                $stt = true;
                foreach($users as $id){
                    if($user = User::find($id)){
                        if(!UserRole::where('user_id',$user->id)->where('role_id',$role_id)->first()){
                            $ur = new UserRole();
                            $ur->fill([
                                'user_id' => $user->id,
                                'role_id' => $role_id
                            ]);
                            $ur->save();
                            $remove_list[] = $user->id;
                        }
                    }    
                }
                
                $total = UserRole::where('role_id',$role_id)->count();
            }
        }
        return ['status'=>$stt,'id'=>$role_id,'tab'=> 'notinrole','remove_list'=>$remove_list,'total' => $total];
    }

    public function getModulesRequiredRole($id=null,$search=null, $paginate = 15)
    {
        if(!$paginate || !is_numeric($paginate)) $paginate = 15;
        $stt = true;
        $list = [];
        $total = 0;
        if(!$id){
            $stt = false;
        }
        elseif(!($detail = $this->_model->find($id))){
            $stt = false;
        }
        if($stt){
            $s = $search;
            $queryBuilder = $detail->modules();
            if($s){
                $queryBuilder->where('name','like',"%$s%");
            }
            $total = $queryBuilder->count();
            if($modules = $queryBuilder->paginate($paginate)){
                foreach ($modules as $module) {
                    $list[] = [
                        'id' => $module->id,
                        'name' => $module->name,
                        'parent' => $module->getParent(),
                        'children' => $module->getChildren(),
                        'role_id' => $id
                    ];
                }
            }
        }
        return ['status'=>$stt,'id'=>$id,'tab'=> 'required','modules'=> $list, 'total' => $total];
    }


    public function getModulesNotRequiredRole($id=null,$search=null, $paginate = 15)
    {
        $stt = true;
        $list = [];
        $total = 0;
        if(!$id){
            $stt = false;
        }
        elseif(!($detail = $this->_model->find($id))){
            $stt = false;
        }
        if($stt){
            $s = $search;
            $queryBuilder = $detail->modulesNotRequired();
            if($s){
                $queryBuilder->where('name','like',"%$s%");
            }
            $total = $queryBuilder->count();
            if($modules = $queryBuilder->paginate($paginate)){
                foreach ($modules as $module) {
                    $list[] = [
                        'id' => $module->id,
                        'name' => $module->name,
                        'parent' => $module->getParent(),
                        'children' => $module->getChildren(),
                        'role_id' => $id
                    ];
                }
            }
        }
        return ['status'=>$stt,'id'=>$id,'tab'=> 'notrequired','modules'=> $list, 'total' => $total];
    }


    public function removeModulesRole($role_id=null, $modules=null)
    {
        $remove_list = [];
        $stt = false;
        $total = 0;
        if($role_id && $modules){
            if($role = $this->find($role_id) && is_array($modules)){
                $stt = true;
                foreach($modules as $id){
                    if(ModuleRole::where('module_id',$id)->where('role_id',$role_id)->delete()){
                        $remove_list[] = $id;
                    }
                }
                $total = ModuleRole::where('role_id',$role_id)->count();
            }
        }
        return ['status'=>$stt,'id'=>$role_id,'tab'=> 'required','remove_list'=>$remove_list,'total' => $total];
    }

    public function addModulesRole($role_id=null, $modules=null)
    {
        $remove_list = [];
        $stt = false;
        $total = 0;
        if($role_id && $modules){
            if($role = $this->find($role_id) && is_array($modules)){
                $stt = true;
                foreach($modules as $id){
                    if($module = Module::find($id)){
                        if(!ModuleRole::where('module_id',$module->id)->where('role_id',$role_id)->first()){
                            $mr = new ModuleRole();
                            $mr->fill([
                                'module_id' => $module->id,
                                'role_id' => $role_id
                            ]);
                            $mr->save();
                            $remove_list[] = $module->id;
                        }
                    }    
                }
                
                $total = ModuleRole::where('role_id',$role_id)->count();
            }
        }
        return ['status'=>$stt,'id'=>$role_id,'tab'=> 'notrequired','remove_list'=>$remove_list,'total' => $total];
    }




}