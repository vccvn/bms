<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Web\Siteinfo;
use App\Web\Setting;

class ClientController extends Controller
{
    //
    protected $bladePrefixPath = 'clients.';
    
    protected $theme = 'lightsolution';
    

    public $cache_data_time = 0;
    public $cache_view_time = 0;
    

    public function __construct()
    {
        $this->siteinfo = new Siteinfo();
        $this->setting = new Setting();
        $cdt = $this->setting->cache_data_time;
        $cvt = $this->setting->cache_view_time;
        if(is_numeric($cdt) && $cdt > 0){
            $this->cache_data_time = $cdt;
        }
        if(is_numeric($cvt) && $cvt > 0){
            $this->cache_view_time = $cvt;
        }
        
    }

    public function getCache($cacheKey = null)
    {
        if(!is_null($cacheKey) && $this->cache_view_time && $view = cache($cacheKey)){
            return $view;
        }
        return null;
    }

    
    /**
     * view blade file
     * @param string $filename  tên file
     * @param array $data       Dữ liệu truyền tới view
     * @return view
     */
    public function view($bladePath, $data = [], $cacheKey = null)
    {
        if(!$cacheKey || $this->cache_view_time || !($view = cache($cacheKey))){
            $d = (array) $data;
            $p = get_theme_path().'.';
            $full = get_theme_path($bladePath);
            $a = explode('.', $full);
            $b = array_pop($a);
            if(count($a)){
                $__current = implode('.', $a).'.';
            }else{
                $__current = '';
            }
            $d['__current'] = $__current;
            $d['__prefix'] = $this->bladePrefixPath;
            $d['__theme'] = $p;
            $d['__components'] = $p.'_components.';
            $d['__layouts'] = $p.'_layouts.';
            $d['__templates'] = $p.'_templates.';
            $d['__resources'] = $p.'_resources.';
            $d['__utils'] = 'clients._templates.';
            $view = view($full,$d)->render();
            if($cacheKey && $this->cache_view_time){
                cache([$cacheKey => $view], $this->cache_view_time);
            }
        }
        return $view;
    }

    /**
     * hiển thị form ra màn hình sử dụng cube extension
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
                foreach($alist as $f){
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
		return $this->view($filename,$viewData);
	}
}
