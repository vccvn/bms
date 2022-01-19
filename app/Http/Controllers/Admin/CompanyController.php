<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Companies\CompanyRepository;
use App\Http\Requests\Companies\SaveRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;

use Cube\Html\Input;

class CompanyController extends AdminController
{
	public $module = 'company';
	public $route = 'admin.company';
	public $folder = 'companies';

    public function __construct(CompanyRepository $CompanyRepository)
    {
        $this->repository = $CompanyRepository;
        HtmlMenu::addActiveKey('admin_menu','company');
        
        parent::__construct();
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = 'name,address,email,phone_number';
        $list = $this->repository->filter($request);
        $data = compact('list');

        return $this->showForm($this->module.'.list',$this->module,$inputList,null,$data);
        
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Nhà xe";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,email,phone_number,address,google_map,website,facebook';
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $btnTxt = "Cập nhật";
            }
            else{
                return $this->view('errors.404');
            }
        }
        $form_title=$btnTxt.' '.$title;
        
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('forms.second',$this->module,$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(SaveRequest $request)
    {
        if($this->repository->save($request->all(), $request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }

}
