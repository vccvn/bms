<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Permissions\PermissionRepository;

use App\Http\Requests\Permissions\RoleRequest;
use Cube\Html\Menu as HtmlMenu;


class RoleController extends AdminController
{
	public $module = 'role';
	public $route = 'admin.permission';
	public $folder = 'roles';

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
        HtmlMenu::addActiveKey('admin_menu','user');
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $s = $request->s;
    	$list = $this->repository->list($s,'name',10);
        if($s){
            $list->withPath('?s='.$s);
        }
    	return $this->view($this->module.'.list',compact('list'));
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Quyền";
        $form_title='Thêm quyển mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,handle,description';
        $data = compact('title','form_title','form_action', 'form_id');
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $formtitle = "Cập nhật quyển";
            }
            else{
                return $this->view('errors.404');
            }
        }
        
        return $this->showForm('forms.main',$this->module,$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }

    /**
     * cap nhat thong tin nguoi dung
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(Request $request)
    {
        // sub request
        $req = new RoleRequest;
        
        $rules = $req->rules($request->id);
        
        $messages = $req->messages();
        
        $data = $request->validate($rules,$messages);

        $model = $this->repository->save($data,$request->id);

        return redirect()->route($this->route.'.list');
    }

}
