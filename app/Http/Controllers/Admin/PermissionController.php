<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Permissions\PermissionRepository;

use App\Http\Requests\Permissions\RoleRequest;


class PermissionController extends AdminController
{
	public $module = 'role';
	public $route = 'admin.permission';
	public $folder = 'roles';

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }

    /**
     * lay danh sach user co role id dc truyen vao
     * @param  Request $request [description]
     * @param  integer  $id      [description]
     * @return JSON           [description]
     */
    public function getUseersInRole(Request $request, $id=null)
    {
        if(!$id && $request->id){
            $id = $request->id;
        }
        $resault = $this->repository->getUseersInRole($id,$request->search,$request->perpage);
        return response()->json($resault);
    }


    public function getUseersNotInRole(Request $request, $id=null)
    {
        if(!$id && $request->id){
            $id = $request->id;
        }
        $resault = $this->repository->getUseersNotInRole($id,$request->search,$request->perpage);
        return response()->json($resault);
    }




    public function removeUsersRole(Request $request)
    {
        $resault = $this->repository->removeUsersRole($request->role_id,$request->users);
        return response()->json($resault);
    }



    /**
     * set quey cho user
     * @param Request $request
     * @author Doanln
     * @created     2018/01/16
     */
    public function addUsersRole(Request $request)
    {
        $resault = $this->repository->addUsersRole($request->role_id,$request->users);
        return response()->json($resault);
    }








    /**
     * lay danh sach MODULE co role id dc truyen vao
     * @param  Request $request [description]
     * @param  integer  $id      [description]
     * @return JSON           [description]
     */
    public function getModulesRequiredRole(Request $request, $id=null)
    {
        if(!$id && $request->id){
            $id = $request->id;
        }
        $resault = $this->repository->getModulesRequiredRole($id,$request->search,$request->perpage);
        return response()->json($resault);
    }


    /**
     * lay danh sach MODULE co role id dc truyen vao
     * @param  Request $request [description]
     * @param  integer  $id      [description]
     * @return JSON           [description]
     */
    public function getModulesNotRequiredRole(Request $request, $id=null)
    {
        if(!$id && $request->id){
            $id = $request->id;
        }
        $resault = $this->repository->getModulesNotRequiredRole($id,$request->search,$request->perpage);
        return response()->json($resault);
    }


    



    public function removeModulesRole(Request $request)
    {
        $resault = $this->repository->removeModulesRole($request->role_id,$request->modules);
        return response()->json($resault);
    }



    /**
     * set quey cho user
     * @param Request $request
     * @author Doanln
     * @created     2018/01/16
     */
    public function addModulesRole(Request $request)
    {
        $resault = $this->repository->addModulesRole($request->role_id,$request->modules);
        return response()->json($resault);
    }

}
