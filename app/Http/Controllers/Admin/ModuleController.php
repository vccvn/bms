<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Modules\ModuleRepository;

use App\Http\Requests\ModuleRequest;
use Cube\Html\Menu as HtmlMenu;


class ModuleController extends AdminController
{
	public $module = 'module';
	public $route = 'admin.module';
	public $folder = 'modules';

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->repository = $moduleRepository;
        HtmlMenu::addActiveKey('admin_menu','user');
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name', 'value'],
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),
        ];
        $list = $this->repository->get($args);
        //$list->withPath('?' . parse_query_string(null, $request->all()));
        
    	return $this->view($this->module.'.list',compact('list'));
    }

    public function detail($id)
    {
        # code...
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return view     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Module";
        $form_title='Thêm Module mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,type,route_name,route_prefix,route_uri,parent_id,description';
        $data = compact('title','form_title','form_action', 'form_id');
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $formtitle = "Cập nhật thông tin Module";
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
        $req = new ModuleRequest;
        
        $rules = $req->rules($request->type, $request->id);
        
        $messages = $req->messages();
        
        if($req->type=='default'){
            $rules['parent_id'] .= '|exists:modules,id';
        }
        
        $data = $request->validate($rules,$messages);

        $t = ($request->type=='default')?'parent_id':'route';
        
        $data[$t] = $data[($request->type=='default')?'parent_id':$request->type];
        
        $model = $this->repository->save($data,$request->id);
        return redirect()->route($this->route.'.list');
    }
}
