<?php

namespace App\Http\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Validator;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Buses\BusRepository;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $bus = (new BusRepository)->find($this->bus_id);
        Validator::extend('freq_days', function($attr, $value) use($bus) {
            if(!$bus) return false;
            $time = null;
            $status = true;
            sort($value);
            $i = 0;
            $freq_times = $bus->freq_days*3600*24;
            foreach($value as $v){
                $t = strtotime($v);
                if($i == 0){
                    $time = $t;
                }elseif($t-$freq_times>=$time){
                    $time = $t;
                }else{
                    $status = false;
                }
                $i++;
            }
            return $status;
        });
 
        $rules = [
            'bus_id'=>'required|exists:buses,id',
            'month'=>'required|numeric',
            'year'=>'required|numeric',
            
        ];

        $route = $bus->route;

        if($route->type == 'direct' || ($route->type=='bus' && in_array(get_station_id(), [$route->from_id, $route->to_id]))){
            if($this->forward_date){
                $rules['forward_date'] = 'array|freq_days';
                if($this->forward_trips){
                    $rules['forward_trips'] = 'array';
                    $rules['forward_trips.*.st_hour'] = 'required';
                    $rules['forward_trips.*.st_minute'] = 'required';
                }
            }
            
            
            if($this->back_date){
                $rules['back_date'] = 'array|freq_days';
                if($this->back_trips){
                    $rules['back_trips'] = 'array';
                    $rules['back_trips.*.st_hour'] = 'required';
                    $rules['back_trips.*.st_minute'] = 'required';
                }    
            }
        }else{
            if($this->forward_date){
                $rules['forward_date'] = 'array|freq_days';
                if($this->forward_trips){
                    $rules['forward_trips'] = 'array';
                    $rules['forward_trips.*.st_hour'] = 'required';
                    $rules['forward_trips.*.st_minute'] = 'required';
                    $rules['forward_trips.*.ar_hour'] = 'required';
                    $rules['forward_trips.*.ar_minute'] = 'required';
                }
            }
            
            
            if($this->back_date){
                $rules['back_date'] = 'array|freq_days';
                if($this->back_trips){
                    $rules['back_trips'] = 'array';
                    $rules['back_trips.*.st_hour'] = 'required';
                    $rules['back_trips.*.st_minute'] = 'required';
                    $rules['back_trips.*.ar_hour'] = 'required';
                    $rules['back_trips.*.ar_minute'] = 'required';
                }    
            }
        }

        
        
        return $rules;
    }

    public function messages()
    {
        return [
            '*.required'=>'không được bỏ trống',
            'forward_date.freq_days'=>'Lịch trình không hợp lệ',
            'forward_trips.*.started_at.required' => 'Thời gian xuất phát không dược bỏ trống!',
            'back_date.freq_days'=>'Lịch trình không hợp lệ',
            'back_trips.*.started_at.required' => 'Thời gian xuất phát không dược bỏ trống!'
            
        ];
    }
}