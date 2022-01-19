<?php

namespace App\Http\Requests\Places;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\Places\PlacesRepository;
use App\Repositories\Places\PassingRepository;
use App\Repositories\Routes\RouteRepository;

use Validator;


class PassingRequest extends FormRequest
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
        $route_id = $request->route_id;
        Validator::extend('middle_route', function($attr, $value) use($route_id) {
            if($route_id && $route = (new RouteRepository)->find($route_id)){
                if($value != $route->from_id && $value != $route->from_id){
                    return true;
                }
            }
            return false;
        });
        Validator::extend('not_the_same', function($attr, $value) use($route_id) {
            if((new PassingRepository())->first(['route_id'=>$route_id, 'place_id'=>$value])) return false;
            return true;
        });
        return [
            'place_id'                    => 'required|numeric|min:1|exists:stations,id|middle_route|not_the_same',
            'route_id'                    => 'required|exists:routes,id',
            
        ];
        
    }

    public function messages()
    {
        return [
            'place_id.required'           => 'Bạn chưa chọn địa điểm',
            'place_id.exists'             => 'Địa điểm này không tồn tại',
            'place_id.middle_route'       => 'Địa điểm này phải không được trùng với 2 đầu tuyến',
            'place_id.not_the_same'       => 'Địa điểm này phải không được trùng với bất kỳ điểm nào trong hành trình',
            'place_id.min'                => 'Địa điểm này không hợp lệ!',
            'route_id.required'           => 'Tuyến đường không được bỏ trống!',
            'route_id.exists'             => 'Tuyến đường này không tồn tại',
            
        ];
    }
}
