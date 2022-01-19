<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Logs\SaveRequest;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Trips\TripRepository;
use App\Repositories\Buses\BusRepository;

use Carbon\Carbon;
use Cube\Html\Menu as HtmlMenu;

use Validator;

use Cube\Files;

class CheckInController extends AdminController
{
	public $module = 'trip';
	public $route = 'admin.trip';
	public $folder = 'trip';

    public function __construct(TripRepository $TripRepository, ScheduleRepository $ScheduleRepository, BusRepository $BusRepository)
    {
        $this->repository = $TripRepository;
        $this->busRepository = $BusRepository;
        $this->scheduleRepository = $ScheduleRepository;        
        HtmlMenu::addActiveKey('admin_menu','trip');
    }

    public function index(Request $request)
    {
        return $this->view('checkin.index');
    }

    public function search(Request $request)
    {
        $status = false;
        $errors = [];
        $message ='';
        $data = null;
        if(!$bus = $this->busRepository->first(['license_plate_clean' => str_slug($request->license_plate,'')])){
            $message = "Không tìm thấy kết quả phù hợp";
        }

        else{
            $route = $bus->route;
            $trips = null;
            $type = 0;
            $date = date('Y-m-d');
            if (in_array($route->type, ['direct','bus']) && in_array(get_station_id(), [$route->from_id, $route->to_id])){
                if($request->action != 'arrived'){
                    if($list = $this->repository->search($bus->id, 1, 'started', $date, 0)){
                        $type = 1;
                        $trips = $list;
                    }
                }else {
                    if($list = $this->repository->search($bus->id, 2, 'arrived', $date, 0)){
                        $type = 2;
                        $trips = $list;
                    }
                }
            }else{
                if($request->action != 'arrived'){
                    if($list = $this->repository->search($bus->id, 0, 'started', $date, 1)){
                        $type = 3;
                        $trips = $list;
                    }
                }else {
                    if($list = $this->repository->search($bus->id, 0, 'arrived', $date, 0)){
                        $type = 4;
                        $trips = $list;
                    }
                }
            }
            if(count($trips)){
                $status = true;
                $viewData = compact('trips', 'route', 'type');
                $data = $this->view('checkin.trips', $viewData)->render();
            }else{
                $message = "Không có kết quả phù hợp.";
            }
        }
        return response()->json(compact('status','data','message','errors'));
    }

    public function addLog(Request $request)
    {
        $savwRequest = new SaveRequest;
        
        $rules = $savwRequest->rules($request);
        $messages = $savwRequest->messages();

        $status = false;
        $data = null;
        $message = '';
        $errors = [];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $message = 'Thông tin không hợp lệ';
        }
        else{
            $data = $this->repository->addLog($request->id, $request->status, $request->action_type, $request->tickets);
            $status = true;
        }
        return response()->json(compact('status','message','data','errors'));
    }

    public function cancel(Request $request)
    {
        $status = false;
        $data = null;
        $message = '';
        $errors = [];
        if(!$this->find($request->id)){
            $message = 'Thông tin không hợp lệ';
        }
        else{
            $data = $this->repository->addLog($request->id, -1);
            $status = true;
        }
        return response()->json(compact('status','message','data','errors'));
    }
}
