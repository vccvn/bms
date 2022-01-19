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

class PassingPlaceController extends AdminController
{
	public $module = 'route';
	public $route = 'admin.route';
	public $folder = 'routes';

    public function __construct(RouteRepository $RouteRepository, PassingRepository $PassingRepository)
    {
        $this->repository = $PassingRepository;
        $this->routes = $RouteRepository;
        HtmlMenu::addActiveKey('admin_menu','route');
    }

    
    /**
     * hiển thị hành trình theo mã tuyến
     * @param  Request $request 
     * @return Reponse
     */
    public function showJourney(Request $request, $id=null)
    {
        
        if(!$route = $this->routes->detail($id)) return $this->view('errors.404');
        $model = ['route_id'=>$route->id];
        $journeys = $this->repository->getJourneys($route->id);
        if($route->type == 'bus'){
            if($station_id = get_station_id()){
                if($station = (new StationRepository)->find($station_id)){
                    $model['province_id'] = $station->province_id;
                }
            }
        }
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
            $data = $this->repository->addPassingPlace($request->all());
            $status = true;
            $message = "Thêm địa điểm thành công!";

        }
        return response()->json(compact('status', 'errors', 'message', 'data'));
    }

    public function sortPlaces(Request $request)
    {
        $status = false;
        $places = [];
        if(is_array($request->places)){
            $i = 1;
            foreach($request->places as $item){
                if(!$this->repository->find($item['id'])){
                    continue;
                }
                $this->repository->save(['priority'=>$i], $item['id']);
                $data = ['id'=>$item['id'],'priority'=>$i];
                $places[] = $data;
                $i++;
            }
            $status = true;
        }
        return response()->json(compact('status', 'places'));
    }
}
