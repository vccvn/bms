<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Provinces\ProvinceRepository;
use App\Http\Requests\Provinces\ProvinceRequest;
use App\Http\Requests\Provinces\ImportRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;

class ProvinceController extends AdminController
{
	public $module = 'province';
	public $route = 'admin.province';
	public $folder = 'provinces';

    public function __construct(ProvinceRepository $ProvinceRepository)
    {
        $this->repository = $ProvinceRepository;
        HtmlMenu::addActiveKey('admin_menu','province');
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = 'name,type,data,active,priority';
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
        $title = "Tỉnh thành";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,type';
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
    public function save(ProvinceRequest $request)
    {
        if($this->repository->save($request->all(), $request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }
    /**
     * nhap thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function import(ImportRequest $request)
    {
        $temp = uniqid().'.json';
        $path = public_path('contents/uploads');
        $file = $request->file('file_data');
        $file->move($path,$temp);
        $content = file_get_contents($path.'/'.$temp);
        $json = json_decode($content);
        if($json && $json->data){
            $data = object_to_array($json->data);
            $added = $this->repository->addMany($data);
        }
        unlink($path.'/'.$temp);
        return redirect()->back()->with('added', 'Đã nhập thành công '.$added.' tỉnh thành');
    }



}
