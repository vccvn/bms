<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Places\PlaceRepository;
use App\Http\Requests\Places\PlaceRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;
use Cube\Html\Input;

class PlaceController extends AdminController
{
	public $module = 'place';
	public $route = 'admin.place';
	public $folder = 'places';

    public function __construct(PlaceRepository $PlaceRepository)
    {
        $this->repository = $PlaceRepository;
        HtmlMenu::addActiveKey('admin_menu','place');
        $this->repository->addFixableParam('type','place');
        $this->repository->addDefaultValue('type','place');
        
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = 'name,province_id';
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
        $title = "Điểm dừng đỗ / đón trả khách / đi qua / cung đường";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,province_id,address';
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
    public function save(PlaceRequest $request)
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
            $added = $this->repository->addManyByProvince($data);
        }
        unlink($path.'/'.$temp);
        return redirect()->back()->with('added', 'Đã nhập thành công '.$added.' tỉnh thành');
    }

    public function getPlaceOptions(Request $request)
    {
        $status = true;
        $options = (new Input)->toCubeSelectOptions((new PlaceRepository)->getPlaceOptions($request->province_id));
        return response()->json(compact('status','options'));
    }
}
