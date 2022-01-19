<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Stations\StationRepository;
use App\Http\Requests\Stations\SaveRequest;
use App\Http\Requests\Stations\ImportRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;


use Cube\Html\Input;

class StationController extends AdminController
{
	public $module = 'station';
	public $route = 'admin.station';
	public $folder = 'station';

    public function __construct(StationRepository $StationRepository)
    {
        $this->repository = $StationRepository;
        HtmlMenu::addActiveKey('admin_menu','station');
        $this->repository->addFixableParam('type','station');
        $this->repository->addDefaultValue('type','station');
        
        parent::__construct();
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = 'name,province_id,address';
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
        $title = "Bến đầu cuối";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,province_id,address,google_map';
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


    public function getStationOptions(Request $request)
    {
        $status = true;
        $type = $request->type;
        $default_value = 0;
        $default_text = "Chọn bến bắt đầu";
        $options = (new Input)->toCubeSelectOptions($this->repository->getStartStationOptions($type));
        if(strtolower($type) == 'direct'){
            $station_id = $this->setting->station_id;
            if($station_id && $station = $this->repository->find($station_id)){
                $default_text = $station->name;
                $default_value = $station->id;
            }else{
                $status = false;
            }
        }
        return response()->json(compact('status','type','options','default_value','default_text'));
    }

    public function getEndOptions(Request $request)
    {
        $status = true;
        $type = $request->type;
        $default_value = 0;
        $default_text = "Chọn điểm kết thúc";
        $options = (new Input)->toCubeSelectOptions($this->repository->getEndStationOptions($type));
        return response()->json(compact('status','type','options','default_value','default_text'));
    }

}
