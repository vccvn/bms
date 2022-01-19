<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    

    /**
     * view blade file
     * @param string $filename  tên file
     * @param array $data       Dữ liệu truyền tới view
     * @return view
     */
    public function view($bladePath, $data = [])
    {
        $d = (array) $data;
        $p = $bladePath;
        $a = explode('.', $bladePath);
        $b = array_pop($a);
        if(count($a)){
            $__current = implode('.', $a).'.';
        }else{
            $__current = '';
        }
        $d['__current'] = $__current;
        $d['__prefix'] = '';
        $d['__theme'] = '';
        return view($p.$bladePath,$d);
    }


     /**
     * hiển thị form ra màn hình sửa dụng cube extension
     * @param string $filename ten file view
     * @param string $formJSON tên file định nghĩa input Json hoặc mảng
     * @param string $fieldlist danh sach thẻ input
     * @param object $model 
     * @param array  $data dữ liệu bạn muốn truyền thêm vào
     */

    public function showForm($filename, $formJSON='form', $fieldList = '*',$model=null, $data = array(),$btnSaveText = 'Save')
	{
        $flist = is_array($fieldList)?$fieldList:explode(',',str_replace(' ', '',$fieldList));

        $alist = array_merge(['id'],$flist);

        $formdata = [];
        if($model && is_object($model)){
            if(method_exists($model,'toFormData')){
                $formdata = $model->toFormData();
            }
            elseif($fieldList !='*'){
                foreach($alist AS $f){
                    $formdata[$f] = $model->{$f};
                }
            }
            else{
                foreach($model as $k => $v){
                    $formdata[$k] = $v;
                }
            }
        }elseif(is_array($model)){
            if($fieldList !='*'){
                foreach($alist as $f){
                    if(array_key_exists($f,$model)){
                        $formdata[$f] = $model[$f];
                    }
                }
            }
            else{
                foreach($model as $k => $v){
                    $formdata[$k] = $v;
                }
            }
        }

        $viewData = array_merge(compact('formdata','btnSaveText','formJSON','fieldList'),$data);
		return view($filename,$viewData);
	}
}
