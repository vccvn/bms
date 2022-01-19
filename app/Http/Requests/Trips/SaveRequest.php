<?php

namespace App\Http\Requests\Trips;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Trips\TripRepository;
use App\Repositories\Buses\BusRepository;

use Validator;

use App\Light\Any;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($request)
    {
        $id = $request->id;
        Validator::extend('fail_haha', function($attr, $value){
            return false;
        });
        Validator::extend('date_check', function($attr, $value){
            $date = new Any($value);
            return is_date($date->day, $date->month, $date->year);
        });
        Validator::extend('time_check', function($attr, $value){
            $time = new Any($value);
            return (strlen($time->hour) > 0 && strlen($time->minute) > 0);
        });
        Validator::extend('status_list', function($attr, $value){
            return in_array($value, [-1, 0, 1, 100]);
        });

        if(!$id || !$trip = (new TripRepository)->find($id)){
            return ['id'=>'required|numeric|fail_haha'];
        }
        $route = $trip->schedule->route;
        $rules = [
            'started' => 'required|array|date_check|time_check',
            'status' => 'required|status_list'
        ];
        if (in_array($route->type, ['direct','bus']) && in_array(get_station_id(), [$route->from_id, $route->to_id])){
            if($request->estimated)$rules['estimated'] = 'required|array|time_check';
        }else{
            $rules['arrived'] = 'required|array|time_check|date_check';
        }
        return $rules;

        
    }

    public function messages()
    {
        return [
            'started.required'          => 'Thời gian xuất bến không được bỏ trống!',
            'arrived.required'          => 'Thời gian vào bến không được bỏ trống!',
            'estimated.required'        => 'Thời gian dự kiến không được bỏ trống!',
            
            'started.date_check'        => 'Ngày tháng xuất bến không hợp lệ',
            'arrived.date_check'        => 'Ngày tháng Vào bến không hợp lệ',
            'started.time_check'        => 'Thời gian xuất bến không hợp lệ',
            'arrived.time_check'        => 'Thời gian vào bến không hợp lệ',
            
            'status.required'           => 'Trạng thái không được bỏ trống',
            'status.status_list'        => 'Trạng thái không hợp lệ',
            
            
            
        ];
    }
}
