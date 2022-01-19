<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Users\UserRepository;

use App\Http\Requests\Users\SaveUserRequest;

use Cube\Html\Menu as HtmlMenu;


class UserController extends AdminController
{
	public $module = 'user';
	public $route = 'admin.user';
	public $folder = 'users';

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
        HtmlMenu::addActiveKey('admin_menu',$this->module);
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
        if($request->sortby){
            $orderby[$request->sortby] = $request->sorttype;
        }else{
            $orderby['created_at'] = 'DESC';
        }
        $args = [
            // search
            '@search' => $request->s,
            '@search_by' => ['name','email', 'username'],
            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage?$request->perpage:10)
        ];
        $list = $this->repository->get($args);
        $list->withPath('?'.parse_query_string(null,$request->all()));
        
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
        $title = "Người dùng";
        $form_title='Thêm người dùng mới';
        $form_action = $this->route.'.save';
        $form_id = 'user-form';
        $inputList = 'name,email,job,work';
        $data = compact('title','form_title','form_action', 'form_id');
        if($id){
            
            if($m = $this->repository->find($id)){
                $m->checkMeta();
                $model = $m;
                $formtitle = "Cập nhật thông tin người dùng";
            }
            else{
                return $this->view('errors.404');
            }
        }else{
        	$inputList.=',username,password,password_confirmation';
        }
        
        return $this->showForm('forms.main',$this->module,$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }

    /**
     * cap nhat thong tin nguoi dung
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(Request $req)
    {
        $userReq = new SaveUserRequest;
        $validate = $userReq->rules($req->id,$req->password);
        if($req->id){
            unset($validate['username']);
        }
        $messages = $userReq->messages();
        $data = $req->validate($validate,$messages);
        $model = $this->repository->save($data,$req->id);

        $this->repository->saveMetaSimple($model->id, 'job', $req->job);
        $this->repository->saveMetaSimple($model->id, 'work', $req->work);
        
        return redirect()->route($this->route.'.list');
    }


    public function getUser(Request $request)
    {
        $status = false;
        $user = null;
        if($request->id && $t = $this->find($request->id)){
            $status = true;
            $user = $t;
        }
        return response()->json(compact('status','user'));
    }

    public function getData(Request $request)
    {
        $args = [
            '@limit' => 15,
            '@search' => [
                'keywords' => $request->keywords,
                'by' => ['name','email', 'username']
            ],
            'status' => 200
        ];
        $status = true;
        $data = [];
        try{
            if($d = $this->repository->getData($args)){
                $data = $d;
            }    
        }catch(exception $e){
            $status = false;
        }
        return response()->json(compact('status','data'));
    }

}
