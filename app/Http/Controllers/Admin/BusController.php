<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Buses\BusRepository;
use App\Http\Requests\Buses\SaveRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;

use Cube\Html\Input;

class BusController extends AdminController
{
	public $module = 'bus';
	public $route = 'admin.bus';
	public $folder = 'bus';

    public function __construct(BusRepository $BusRepository)
    {
        $this->repository = $BusRepository;
        HtmlMenu::addActiveKey('admin_menu','bus');
        
        parent::__construct();
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
        $data = compact('list');

        return $this->view($this->module.'.list',$data);
        
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "thông tin xe";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = [
            "company_id","phone_number","license_plate","type","description","seets","weight","route_id", 
            "freq_days","freq_trips","date_limited","day_start","day_stop","is_active"
        ];
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
        
        return $this->showForm($this->module.'.form',$this->module,$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(SaveRequest $request)
    {
        $data = $request->all();
        $data['license_plate_clean'] = str_slug(str_replace(' ', '', $request->license_plate),'');
        $data['is_active'] = $request->is_active?1:0;
        $data['date_limited'] = $request->date_limited?1:0;
        if($this->repository->save($data, $request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }

    public function getFreqTripOptions(Request $request)
    {
        $status = true;
        $days = $request->days;
        $options = (new Input)->toCubeSelectOptions($this->repository->getFreqtripOptions($days));
        return response()->json(compact('status','options'));
    }

    public function schedule(Request $request)
    {
        return get_calendar_table(date('m'), 2018, true);
    }
}
