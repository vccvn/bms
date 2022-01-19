<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Trips\SaveRequest;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Trips\TripRepository;
use App\Repositories\Buses\BusRepository;

use Carbon\Carbon;
use Cube\Html\Menu as HtmlMenu;

use Validator;

use Cube\Files;

class TripController extends AdminController
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

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $data = $this->repository->filter($request, [], 1);
        // $data = compact('list','year','month', 'day');
        return $this->view($this->module.'.list',$data);
    }

    
    public function changeStatus(Request $request)
    {
        $status = false;
        $trip = null;
        $id = $request->id;
        $stt = $request->status;
        if($id && $this->repository->find($id) && in_array($stt,[100, 1,0,-1])){
            if($s = $this->repository->save(['status' => $stt], $id)){
                $status = true;
                $s->status = $stt;
                $trip = $s;
            }
        }
        return response()->json(compact('status','trip'));
    }


    public function getUpdateForm(Request $request)
    {
        
        $id = $request->id;
        $model = null;
        if(!$id || !$model = $this->repository->getFormData($id)){
            $form = null;
            $status = false;
        }else{
            $form = $this->view('trip.form',compact('model'))->render();
            $status = true;
        }
               
        return response()->json(compact('status','form'));
    }
    
    public function save(Request $request)
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
            $data = $this->repository->saveTrip($request->all());
            $status = true;
        }
        return response()->json(compact('status','message','data','errors'));
    }
}
