<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Requests\Trips\SaveRequest;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Trips\TripRepository;
use App\Repositories\Buses\BusRepository;

use Carbon\Carbon;
use Cube\Html\Menu as HtmlMenu;

use Validator;

use Cube\Files;

class TripController extends ClientController
{
	public $module = 'trip';
	public $route = 'clirnt.trip';
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
    public function search(Request $request)
    {

        $data = $this->repository->filter($request, ['@paginate'=>50]);
        return $this->view($this->module.'.list',$data);
    }

    

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function ajaxSearch(Request $request)
    {

        
        $viewData = $this->repository->filter($request, ['@paginate'=>50]);
        $data = $this->view($this->module.'.results',$viewData);
        return response()->json(compact('data'));
    }

    

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function detail(Request $request)
    {

        
        $trip = $this->repository->detail($request);
        $data = $trip?$this->view($this->module.'.detail',['trip'=>$trip]):'';
        return response()->json(compact('data'));
    }

    



}
