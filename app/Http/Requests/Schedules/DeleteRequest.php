<?php

namespace App\Http\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Validator;

use App\Repositories\Schedules\ScheduleRepository;
use App\Repositories\Buses\BusRepository;

class DeleteRequest extends FormRequest
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
 
        $rules = [
            'bus_id'=>'required|exists:buses,id',
            'month'=>'required|numeric',
            'year'=>'required|numeric',
            
        ];
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