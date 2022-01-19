<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Validator;


use Cube\Laravel\LaravelRoute;


class ModuleRequest extends FormRequest
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
    public function rules($type='default',$id=null)
    {
        Validator::extend('in_list', function($attr, $value){
            return in_array($value, ['default', 'route_name','route_prefix','route_uri']);
        });
                // tao validate function
        Validator::extend('route_uri_exists', function($attr, $value){
            return LaravelRoute::checkUri($value);
        });
        Validator::extend('route_name_exists', function($attr, $value){
            return LaravelRoute::checkName($value);
        });
        Validator::extend('route_prefix_exists', function($attr, $value){
            return LaravelRoute::checkPrefix($value);
        });
        Validator::extend('module_route_not_exists', function($attr, $value, $parameters){
            $query = \DB::table($parameters[0]);
            for($i=1; $i<count($parameters); $i+=2){
                $col = $parameters[$i];
                $val = $parameters[$i+1];
                if($col!='id'){
                    $query->where($col,$val);
                }else{
                    $query->where($col,'<>',$val);
                }
                
            }
            $query->where('route',$value);
            return ($query->count()<1);
        });

        $unid = $id?',id,'.$id:'';
        $route = [
            'parent_id'          => 'min:0',
            'route_uri'          => 'required|string|route_uri_exists|module_route_not_exists:modules,type,'.$type.$unid,
            'route_name'         => 'required|string|route_name_exists|module_route_not_exists:modules,type,'.$type.$unid,
            'route_prefix'       => 'required|string|route_prefix_exists|module_route_not_exists:modules,type,'.$type.$unid,
        ];
        $rules = [
            'type'         => 'required|in_list',
            'name'         => 'required|string|unique:modules'.$unid,
            'description'  => 'max:500',
        ];
        $t = (!$type || $type=='default')?'parent_id':$type;
        if(array_key_exists($t, $route)){
            $rules[$t] = $route[$t];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'type.required'                           => 'Loại module không được bỏ trống',
            'type.in_list'                            => 'Loại module không hợp lệ',
            'name.required'                           => 'Tên module không được bỏ trống',
            'name.unique'                             => 'Module đã tồn tại',
            'description.max'                         => 'Mô tả quá dài',
            'parent_id.exists'                        => 'Module cha không tồn tại',
            'route_name.required'                     => 'Định danh route không được bỏ trống',
            'route_name.route_name_exists'            => 'Route chưa được định danh',
            'route_name.module_route_not_exists'      => 'Route module đã tồn tại',
            'route_prefix.required'                   => 'Route Prefix không được bỏ trống',
            'route_prefix.route_prefix_exists'        => 'Route Prefix không tồn tại',
            'route_prefix.module_route_not_exists'    => 'Route prefix đã tồn tại',
            'route_uri.required'                      => 'Route URI không được bỏ trống',
            'route_uri.route_uri_exists'              => 'Route URI không tồn tại',
            'route_uri.module_route_not_exists'       => 'Route URI đã tồn tại',
            
        ];
    }

    
}
