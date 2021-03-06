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
            'from_id.exists'              => 'B???n xe kh??ng t???n t???i', 
            'from_id.direct_start'        => '??i???m b???t ?????u tuy???n kh??ng h???p l???!', 
            'to_id.exists'                => 'B???n xe kh??ng t???n t???i', 
            'to_id.different_from'        => 'B???n xe ?????u cu???i gi???ng nhau th?? t???o tuy???n l??m c??i g?? v???y!?', 
            'type.in_list_type'           => 'Lo???i tuy???n kh??ng h???p l???', 
            'month_trips.integer'         => 'Quy ho???ch chuy???n kh??ng h???p l???', 
            'month_trips.min'             => 'Quy ho???ch chuy???n t???i thi???u l?? 1', 
            'distance.numeric'            => 'Chi???u d??i tuy???n kh??ng h???p l???', 
            'distance.min'                => 'Chi???u d??i tuy???n kh??ng h???p l???', 
            'time_start.date_format'      => 'Th???i gian b???t ?????u kh??ng h???p l???', 
            'time_end.date_format'        => 'th???i gian k???t th??c h???p l???!',
            'time_between.date_format'    => 'th???i gian gi??n c??ch kh??ng h???p l???!',
            '*.required'                  => ':attribute kh??ng ???????c b??? tr???ng'
        ];
    }
}
