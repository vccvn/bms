<?php

namespace App\Http\Requests\Buses;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\Buses\BusRepository;
use Validator;

use App\Repositories\Routes\RouteRepository;

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
        $id                = $this->id;
        $route_id          = $this->route_id;
        $freq_days         = $this->freq_days;
        $freq_trips        = $this->freq_trips;
        $date_limited      = $this->date_limited;
        $day_start         = $this->day_start;
        $day_stop          = $this->day_stop;
        $trip_per_month    = $this->getTripPerMonth();

        Validator::extend('license_plate', function($attr, $value) {
            if(preg_match('/^[0-9]{2}\-{0,1}[A-z]{1}\-{0,1}[0-9\.\-]{3,7}$/si', str_replace(' ', '', $value))) return true;
            return false;
        });
        Validator::extend('type_list', function($attr, $value) {
            if(in_array($value, [1, 2])) return true;
            return false;
        });
        Validator::extend('phone_number', function($attr, $value){
            return strlen($value)? preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value):true;
        });
        Validator::extend('freq_trips', function($attr, $value) use($freq_days){
            if($value < 1 || ($freq_days > 1 && $value > 1)) return false;
            return true;
        });
        
        Validator::extend('day_start', function($attr, $value) use($date_limited, $day_stop){
            if($date_limited){
                if(!is_numeric($value) || $value > $day_stop) return false;
            }
            return true;
        });
        Validator::extend('day_stop', function($attr, $value) use($date_limited, $day_start){
            if($date_limited){
                if(!is_numeric($value) || $value < $day_start) return false;
            }
            return true;
        });
        Validator::extend('unique_license', function($attr, $value) use($id){
            $repo = new BusRepository();
            if($bus = $repo->findBy('license_plate_clean', str_slug($value,''))){
                if($id && $id == $bus->id) return true;
                return false;
            }
            return true;
        });
        Validator::extend('route_trips', function($attr, $value) use($route_id, $trip_per_month, $id){
            $repo = new RouteRepository();
            if($route_id && $route = $repo->find($route_id)){
                if($route->coumtTripsRegisterOfBus($id) + $trip_per_month <= $route->month_trips){
                    return true;
                }
            }
            return false;
        });
        
        $rules = [
            "company_id"                  => 'required|exists:companies,id',
            'route_id'                    => 'required|exists:routes,id',
            'type'                        => 'required|type_list',
            "license_plate"               => 'required|license_plate|unique_license',
            "phone_number"                => "phone_number",
            "description"                 => "max:5000",
            "seets"                       => 'required|numeric|min:4',
            "weight"                      => 'numeric|min:1',
            "freq_days"                   => ($freq_days?'numeric|min:1|':'').'max:31',
            "freq_trips"                  => 'freq_trips',
            "day_start"                   => $date_limited?'required|min:1|day_start':'max:31',
            "day_stop"                    => $date_limited?'required|min:1|day_stop':'max:31',
            'route_trips'                 => 'required| route_trips'
        ];
        return $rules;
        
    }

    public function messages()
    {
        return [
            "company_id.exists"           => 'Nh?? xe n??y kh??ng t???n t???i!',
            'route_id.exists'             => 'Tuy???n xe n??y kh??ng t???n t???i',
            'type.type_list'              => 'Lo???i xe kh??ng h???p l???',
            "license_plate.license_plate" => 'Bi???n s??? xe kh??ng h???p l???',
            "license_plate.unique_license"=> 'Xe ???? ???????c th??m tr?????c ????',
            "phone_number.phone_number"   => "S??? DT kh??ng h???p l???",
            "seets.numeric"               => 'S??? ch??? kh??ng h??p l???',
            "seets.min"                   => 'S??? ch??? kh??ng h??p l???',
            "weight.*"                    => 'Tr???ng l?????ng kh??ng h???p l???',
            "freq_days.*"                 => 'T???n su???t ng??y kh??ng h???p l???!',
            "freq_trips.freq_trips"       => 'T???n su???t chuy???n kh??ng h???p l???',
            "day_start.*"                 => 'Ng??y b???t ?????u ch???y xe trong th??ng kh??ng h???p l???!',
            "day_stop.*"                  => 'Ng??y cu???i c??ng ch???y xe trong th??ng kh??ng h???p l???!',
            'route_trips.route_trips'     => 'S??? chuy???n v?????t qu?? quy ho???ch',
            '*.required'                  => 'Tr?????ng n??y kh??ng ???????c b??? tr???ng'
        ];
    }



    public function getTripPerMonth()
    {
        $n = 0;
        if(!$this->freq_trips || !$this->freq_days) return $n;
        $n = $this->freq_trips/$this->freq_days;
        $x = 30;
        if($this->date_limited){
            if($this->day_stop || $this->day_start) return $n*$x;
            $x = $this->day_stop - $this->day_start + 1;
        }
        return $n * $x;
    }
}
