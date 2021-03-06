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
            'type.required'                           => 'Lo???i module kh??ng ???????c b??? tr???ng',
            'type.in_list'                            => 'Lo???i module kh??ng h???p l???',
            'name.required'                           => 'T??n module kh??ng ???????c b??? tr???ng',
            'name.unique'                             => 'Module ???? t???n t???i',
            'description.max'                         => 'M?? t??? qu?? d??i',
            'parent_id.exists'                        => 'Module cha kh??ng t???n t???i',
            'route_name.required'                     => '?????nh danh route kh??ng ???????c b??? tr???ng',
            'route_name.route_name_exists'            => 'Route ch??a ???????c ?????nh danh',
            'route_name.module_route_not_exists'      => 'Route module ???? t???n t???i',
            'route_prefix.required'                   => 'Route Prefix kh??ng ???????c b??? tr???ng',
            'route_prefix.route_prefix_exists'        => 'Route Prefix kh??ng t???n t???i',
            'route_prefix.module_route_not_exists'    => 'Route prefix ???? t???n t???i',
            'route_uri.required'                      => 'Route URI kh??ng ???????c b??? tr???ng',
            'route_uri.route_uri_exists'              => 'Route URI kh??ng t???n t???i',
            'route_uri.module_route_not_exists'       => 'Route URI ???? t???n t???i',
            
        ];
    }

    
}
