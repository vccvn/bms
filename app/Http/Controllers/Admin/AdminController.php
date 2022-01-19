<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Web\Siteinfo;
use App\Web\Setting;

use Cube\Image as CubeImage;

class AdminController extends Controller
{
    //

    public function __construct()
    {
        $this->siteinfo = new Siteinfo();
        $this->setting = new Setting();
        
    }

    protected $bladePrefixPath = 'admin.';
    public function view($bladePath, $data = [])
    {
        $d = (array) $data;
        $p = $this->bladePrefixPath;
        $full = $this->bladePrefixPath.$bladePath;
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

        return view($full,$d);
    }


     /**
     * hiển thị form ra màn hình sửa dụng cube extension
     * @param string $filename ten file view
     * @param string $formJSON tên file định nghĩa input Json hoặc mảng
     * @param string $fieldlist danh sach thẻ input
     * @param object $model 
     * @param array  $data dữ liệu bạn muốn truyền thêm vào
     */

    public function showForm($filename, $formJSON='form', $fieldList = '*',$model=null, $data = [],$btnSaveText = 'Save')
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
                $formdata = $model;
            }
        }
        
        $viewData = array_merge(compact('formdata','btnSaveText','formJSON','fieldList','model'),$data);
		return $this->view($filename,$viewData);
    }
    
    public function replace(Request $request)
    {
        if($request->columns && $request->find){
            $stt = $this->repository->replace($request->columns, $request->find, $request->replace);
            if($stt !== false){
                if($stt)
                    return "Đã tìm kiếm và thay thế $stt bản ghi";
                return "Không có kết quã phù hợp";
            }
        }
        return "Tham số không hợp lệ";
    }

    /**
     * upload anh cho bai viet, san pham, trang
     * @param Request $request
     * @param string $field
     * @param string $path
     * @param string $imageField
     */

    public function uploadImage(Request $request, $field = 'feature_image', $path = null, $imageField = 'image_data', $required = false, $oldFilename = null)
    {
        $fn = null;
        if(!$path) $path = '/contents/'.$this->folder;
        $feature_image = null;
        if($oldFilename){
            $of = explode('.',$oldFilename);
            $ext = array_pop($of);
            $attachment = implode('.',$of);
        }else{
            $attachment = str_slug(microtime(),'-');
        }
        
        // neu co image base64
        if($request->{$imageField} && !$request->keep_original){
            $output = save_base64_image($request->{$imageField}, $attachment, $path);
            $feature_image = $output?$output:null;
        }
        if(!$feature_image){
            if(!$request->id && $required){
                // neu tao moi ma ko co image data thi validate fike
                $request->validate([$field=>'required']);
            }
            // neu co file va filr hop le thi tien hanh upload
            if($request->hasFile($field)){
                $file = $request->file($field);
                $ext = strtolower($file->getClientOriginalExtension());
                $filename = $attachment.'.'.$ext;
                //$mime = $file->getClientMimeType();
                $destinationPath = public_path($path);
                $file->move($destinationPath, $filename);
                $feature_image = $filename;
            }
            
        }
        if($feature_image){
            
            $fn = $feature_image;
            $image = new CubeImage(public_path($path.'/'.$feature_image));
            $image->RaC(90,90);
            $image->save(public_path($path.'/90x90/'.$feature_image));
        }
        return $fn;
    }
    
    /**
     * tim mot ban ghi thong qua id
     * @param  integer   $id 
     * @return model
     */
    
    public function find($id)
    {
        return $this->repository->find($id);
    }


    
    public function index(Request $request)
    {
        return $this->list($request);
    }

    
    /**
     * xoa ban ghi
     * @param  Request $req [description]
     * @return json       [description]
     */
    public function delete(Request $req)
    {
        if (is_array($req->ids)) {
            $status = false;
            $remove_list = [];
            foreach ($req->ids as $id) {
                if ($this->repository->delete($id)) {
                    $status = true;
                    $remove_list[] = $id;
                }
            }
            $message = count($req->ids) < count($remove_list)? 'Do ràng buộc dữ liệu, một số mục không thể xóa ngay lúc này! Xin vui lòng kiểm tra lại':'';
            return response()->json(compact('status', 'remove_list', 'message'));
        } else {
            $status = $this->repository->delete($req->id);
            $remove_id = $req->id;
            $message = $status?: 'Do ràng buộc dữ liệu, một số mục không thể xóa ngay lúc này! Xin vui lòng kiểm tra lại';
            return response()->json(compact('status', 'remove_id', 'message'));
        }
    }
}
