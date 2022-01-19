<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Schedules\SaveRequest;
use App\Http\Requests\Schedules\DeleteRequest;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Trips\TripRepository;
use App\Repositories\Buses\BusRepository;

use Carbon\Carbon;
use Cube\Html\Menu as HtmlMenu;

use Cube\Files;

use Validator;
use Redirect;
class ScheduleController extends AdminController
{
	public $module = 'schedule';
	public $route = 'admin.schedule';
	public $folder = 'schedule';

    public function __construct(ScheduleRepository $ScheduleRepository, BusRepository $BusRepository, TripRepository $TripRepository)
    {
        $this->repository = $ScheduleRepository;
        $this->busRepository = $BusRepository;
        $this->tripRepository = $TripRepository;
        HtmlMenu::addActiveKey('admin_menu','schedule');
    }

    public function schedules(Request $request)
    {
        $year = $request->year?$request->year:date('Y');
        $month = $request->month?$request->month:date('m');
        $day = $request->day?$request->day:date('d');
        
        $args = [];
        $list = $this->repository->filter($request, $year, $month, $day);
    	return $this->view($this->module.'.list',compact('list','year','month','day'));
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */

    public function list(Request $request, $year = null, $month = null, $day = null)
    {
        $dates = explode('-',date('Y-m-d'));
        $y = $dates[0];
        $m = $dates[1];
        $d = $dates[2];
        $ry = $request->year; $rm = $request->month; $rd = $request->day;
        if(!$year) $year = $ry?$ry:$y;
        if(!$month){
            if($y != $year){
                $month = $rm;
            }else{
                $month = $rm?$rm:$m;
            }
        }
        
        if(!$day) {
            $day = $rd;
            
        }
        
        $list = $this->repository->filter($request, $year, $month, $day);

    	return $this->view($this->module.'.list',compact('list','year','month','day'));
    }

    public function schedule(Request $request,$year=null, $month=null, $license_plate=null)
    {
        if(!$year) $year = date('Y');
        if(!$month) $month = date('m');
        if(!is_numeric($year) || !is_numeric($month) || $year < 2000 || $year > 2200 || $month < 1 || $month > 12 || !$bus = $this->busRepository->findBy('license_plate_clean', str_slug($license_plate,'')))
        {
            return $this->view('errors.404');
        }

        // lich trinh đi
        $forwards = [];
        $forward_trips = [];
        $list_forward = $this->repository->getSchedules($bus,1, $year, $month);
        $backs = [];
        $bback_trips = [];
        $list_bback = $this->repository->getSchedules($bus,2, $year, $month);

        if($list_forward){
            $schedule_id = null;
            
            foreach($list_forward as $item){
                $forwards[] = $item->active_date;
                $schedule_id = $item->id;
            }
            if($schedule_id) $forward_trips = $this->tripRepository->getTimes(compact('schedule_id'));
        }
        
        // lich trinh ce
        if($list_bback){
            $schedule_id = null;
            
            foreach($list_bback as $item){
                $backs[] = $item->active_date;
                $schedule_id = $item->id;
            }
            if($schedule_id) $back_trips = $this->tripRepository->getTimes(compact('schedule_id'));
        }
        $calendar = get_calendar_table($month, $year);
        $data = compact('calendar','bus','year', 'month', 'forwards', 'forward_trips', 'backs', 'back_trips');

        return $this->view('schedule.detail', $data);
    }


    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(SaveRequest $request)
    {
        if(!$bus = $this->busRepository->find($request->bus_id))
        {
            return redirect()->back()->withInputs($request->all());
        }
        // luu lich trinh di
        $forward = $this->repository->saveSchedules($bus,1, $request->year, $request->month, $request->forward_date);
        $start = $this->tripRepository->saveTrips($forward, $request->forward_trips, 1);
        if(!$start){
            return Redirect::back()->with('time_start', 'Bị trùng lịch hoặc thời gian giãn cách / xuất bến không hợp lệ')->withInput($request->all());
        }

        // luu lich trinh ve
        $back = $this->repository->saveSchedules($bus,2, $request->year, $request->month, $request->back_date);
        $arrive = $this->tripRepository->saveTrips($back, $request->back_trips, 2);
        if(!$arrive){
            return Redirect::back()->with('time_arrive', 'Bị trùng lịch hoặc thời gian giãn cách / xuất bến không hợp lệ')->withInput($request->all());
        }

        return redirect()->back()->with('message','Đã lưu lịch trình thành công');
    }

    

    /**
     * create or update schedule
     * 
     */
    public function create(Request $request)
    {
        if(!$bus = $this->busRepository->findBy('license_plate_clean', str_slug($request->license_plate,'')))
        {
            return redirect()->route('admin.bus',['searchby'=>'license_plate','s'=>$request->license_plate]);
        }

        return redirect()->route('admin.schedule.detail',[
            'year'=>($request->year && $request->year != 'all')? $request->year : date('Y'),
            'month'=>($request->month && $request->month!='all')?$request->month:1,
            'license_plate'=>$bus->license_plate_clean
        ]);
    }



    /**
     * xoa ban ghi
     * @param  Request $req [description]
     * @return json       [description]
     */
    public function delete(Request $req)
    {
        $status = false;
        $errors = [];
        $message = '';
        $data = null;
        $deleteRequest = new DeleteRequest();
        
        $validator = Validator::make($req->all(), $deleteRequest->rules($req), $deleteRequest->messages());
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            $status = false;
        }
        elseif ($list = $this->repository->get(['bus_id' => $req->bus_id, '@whereYear'=> ['active_date', $req->year], '@whereMonth'=> ['active_date', $req->month]])) {
            foreach ($list as $schedule) {
                if($schedule->canDelete()){
                    $schedule->delete();
                    $status = true;
                }
            }
            if($status){
                $data = ['id'=>$req->bus_id];
            }
        }

        return response()->json(compact('status', 'errors','message', 'data'));
    }
}
