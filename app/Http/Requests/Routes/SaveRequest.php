<?php

namespace App\Http\Requests\Routes;

use Illuminate\Foundation\Http\FormRequest;
use App\Web\Setting;

use Validator;


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
        $from_id = $this->from_id;
        $to_id = $this->to_id;
        
        $type = $this->type;
        
        Validator::extend('different_from', function($attr, $value) use($from_id) {
            return ($value != $from_id);
        });
        Validator::extend('in_list_type', function($attr, $value){
            return in_array(strtolower($value),['direct','indirect', 'bus']);
        });

        Validator::extend('direct_start', function($attr, $value) use($type){
            $setting = new Setting();
            if(strtolower($type)=='direct' && $value!=$setting->station_id) return false;
            return true;
        });

        $a = strtolower($type) == 'bus';
        return [
            'from_id'                     => 'required|exists:stations,id|direct_start', 
            'to_id'                       => 'required|exists:stations,id|different_from', 
            'type'                        => 'required|in_list_type', 
            'name'                        => 'required|max:191',  
            'month_trips'                 => 'required|integer|min:1', 
            'distance'                    => $a?'max:50000':'required|numeric|min:0', 
            'time_start'                  => 'required|date_format:"H:i:s"|before:time_end', 
            'time_between'                => 'required|date_format:"H:i:s"', 
            'time_end'                    => 'required|date_format:"H:i:s"|after:time_start'
        ];
        
    }

    public function messages()
    {
        return [
            'from_id.exists'              => 'Bến xe không tồn tại', 
            'from_id.direct_start'        => 'Điểm bắt đầu tuyến không hợp lệ!', 
            'to_id.exists'                => 'Bến xe không tồn tại', 
            'to_id.different_from'        => 'Bến xe đầu cuối giống nhau thì tạo tuyến làm cái gì vậy!?', 
            'type.in_list_type'           => 'Loại tuyến không hợp lệ', 
            'month_trips.integer'         => 'Quy hoạch chuyến không hợp lệ', 
            'month_trips.min'             => 'Quy hoạch chuyến tối thiểu là 1', 
            'distance.numeric'            => 'Chiều dài tuyến không hợp lệ', 
            'distance.min'                => 'Chiều dài tuyến không hợp lệ', 
            'time_start.date_format'      => 'Thời gian bắt đầu không hợp lệ', 
            'time_end.date_format'        => 'thời gian kết thúc hợp lệ!',
            'time_between.date_format'    => 'thời gian giãn cách không hợp lệ!',
            '*.required'                  => ':attribute không được bỏ trống'
        ];
    }
}
