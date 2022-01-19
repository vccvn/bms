<?php

namespace App\Http\Requests\Logs;

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
        Validator::extend('status_list', function($attr, $value){
            return in_array($value, [-1, 0, 1, 100]);
        });

        $rules = [
            'id' => 'required|exists:trips',
            'status' => 'required|status_list'
        ];
        if($request->tickets){
            $rules['ticketd'] = 'numeric';
        }

        return $rules;

        
    }

    public function messages()
    {
        return [
            'id.required'               => 'Mã chuyến không được bỏ trống',
            'id.exists'                 => 'Mã chuyến không tồn tại',
            
            'status.required'           => 'Trạng thái không được bỏ trống',
            'status.status_list'        => 'Trạng thái không hợp lệ',
            
            
            
        ];
    }
}
