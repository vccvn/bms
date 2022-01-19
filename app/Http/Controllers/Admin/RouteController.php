<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Routes\RouteRepository;
use App\Repositories\Places\PassingRepository;
use App\Http\Requests\Routes\SaveRequest;
use App\Http\Requests\Places\PassingRequest;
use App\Repositories\Stations\StationRepository;

use Validator;
use Cube\Html\Menu as HtmlMenu;

use Cube\Files;


use Cube\Html\Input;
class RouteController extends AdminController
{
	public $module = 'route';
	public $route = 'admin.route';
	public $folder = 'routes';

    public function __construct(RouteRepository $RouteRepository, PassingRepository $PassingRepository)
    {
        $this->repository = $RouteRepository;
        $this->places = $PassingRepository;
        HtmlMenu::addActiveKey('admin_menu','route');
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = [
            'name', 'type', 'from_id', 'to_id','distance', 'month_trips', 
            'freq_days', 'freq_trips', 'time_start', 'time_end', 'time_between'
        ];
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
        $title = "Tuyến đường";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = [
            'name', 'type', 'from_id', 'to_id', 'distance', 'month_trips', 
            'freq_days', 'freq_trips', 'time_start', 'time_end', 'time_between'
        ];
        $model = null;
        
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
        
        return $this->showForm('route.form',$this->module,$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $request
     * @return Reponse
     */
    public function save(SaveRequest $request)
    {
        $data = $request->all();
        if(strtolower($request->type) == 'bus'){
            $data['distance'] = 0;
        }
        if($this->repository->save($data, $request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }

    /**
     * hiển thị hành trình theo mã tuyến
     * @param  Request $request 
     * @return Reponse
     */
    public function showJourney(Request $request, $id=null)
    {
        
        if(!$route = $this->repository->detail($id)) return $this->view('errors.404');
        $model = ['route_id'=>$route->id];
        $journeys = $this->places->getJourneys($route->id);
        $data = compact('route','journeys');
        return $this->showForm($this->module.'.journey','passing-place','*',$model,$data);

    }

    /**
     * thêm hành trình
     */
    public function addPassingPlace(Request $request)
    {
        $status = false;
        $errors = [];
        $data = null;
        $message = '';
        $req = new PassingRequest();
        $validator = Validator::make($request->all(),$req->rules($request), $req->messages());
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = "Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin!";
        }else{
            $data = $this->places->addPassingPlace($request->all());
            $status = true;
            $message = "Thêm địa điểm thành công!";

        }
        return response()->json(compact('status', 'errors', 'message', 'data'));
    }

    public function getRouteOptions(Request $request)
    {
        $status = true;
        $type = $request->type;
        $options = (new Input)->toCubeSelectOptions($this->repository->getRouteSelectOptions($type));
        return response()->json(compact('status','type','options'));
    }
}
