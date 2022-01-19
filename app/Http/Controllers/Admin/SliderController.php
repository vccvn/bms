<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\Sliders\SliderRepository;
use App\Repositories\Sliders\SliderItemRepository;

use App\Http\Requests\Sliders\SliderRequest;
use App\Http\Requests\Sliders\SliderItemRequest;

use Cube\Html\Menu as HtmlMenu;

use Redirect;
use Validator;


class SliderController extends AdminController
{
    public $module = 'slider';
    public $route = 'admin.slider';
    public $folder = 'sliders';

    public function __construct(SliderRepository $slider, SliderItemRepository $sliderItem)
    {
        $this->repository = $slider;
        $this->itemRepository = $sliderItem;
        
        // HtmlMenu::addActiveKey('admin_menu',$this->module);
        HtmlMenu::addActiveKey('admin_menu','option');
    }

    /**
     * tim mot nguoi dung thong qua id
     * @param  integer $id [description]
     * @return model     [description]
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }
    /**
     * hien thi trang chu cua module user
     * @return [type] [description]
     */
    public function index(Request $request)
    {
        return $this->list($request);
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        // filter
        $orderby = ['position' => 'ASC', 'priority'=>'ASC'];
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name'],
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),
        ];
        $list = $this->repository->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        $inputList = 'name,crop,width,height,position';
        $data = compact('list');
        
        return $this->showForm($this->module.'.list',$this->module,$inputList,null,$data);
    }

    
    public function detail(Request $request, $id = null,$item_id=null)
    {
        if(!$id && $request->id){
            $id = $request->id;
        }
        if(!$id || !($slider = $this->find($id))) return $this->view('errors.404');
        
        $list = $this->itemRepository->get(['slider_id'=>$id,'@paginate'=>15,'@orderBy'=>['priority','ASC']]);
        return $this->view($this->module.'.detail',compact('slider','list'));
    }




    /**
     * hien thi form
     * @param  integer $id [description]
     * @return view     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Slider";
        $form_title='Thêm Slider mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,position,crop,width,height';
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $form_title = "Cập nhật thông tin Slider";
                $inputList.=',priority';
                $this->repository->setID($id);
            }
            else{
                return $this->view('errors.404');
            }
        }
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('slider.form',$this->module,$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }


    
    public function save(Request $request)
    {
        $id = $request->id;
        $sliderRequest = new SliderRequest;
        $rules = $sliderRequest->rules($id);
        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'crop' => $request->crop?1:0
        ];
        if($request->crop){
            if($request->width > 200 && $request->height > 100){
                $data['width'] = $request->width;
                $data['height'] = $request->height;
            }
            else{
                $rules['width'].="|required|numeric|min:200";
                $rules['height'].="|required|numeric|min:100";
            }
        }
        $validator = Validator::make($request->all(), $rules, $sliderRequest->messages());
        
        if ($validator->fails()) {
            if($id){
                return Redirect::back()->withErrors($validator)->withInput($request->all());
            }else{
                return redirect()->route('admin.slider.add')->withErrors($validator)->withInput($request->all());
            }
        }
        

        $model = $this->repository->save($data,$id);
        if(is_numeric($request->priority) || !$id){
            $this->repository->updatePriority($model->id,$request->priority);
        }
        return redirect()->route($this->route.'.list');
    }




    public function itemForm(Request $request, $slider_id = null,$id=null)
    {
        
        if(!$slider_id && $request->slider_id){
            $slider_id = $request->slider_id;
        }
        if(!$slider_id) return $this->view('errors.404');
        if(!($slider = $this->find($slider_id))) return $this->view('errors.404');
        $this->repository->setID($slider_id);
        $inputList = ['slider_id', 'image', 'title', 'description', 'link', 'url', 'priority'];
        $model = $this->itemRepository->model();
        $model->slider_id = $slider_id;
        
        $form_title='Thêm Slide item';
        
        if($id){
            if($m = $this->itemRepository->find($id)){
                $model = $m;
                $form_title = "Cập nhật thông tin Slide";
            }
            else{
                return $this->view('errors.404');
            }
        }
        $data = compact('slider','form_title');
        
        return $this->showForm('slider.item-form','slider-item',$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }




    public function saveItem(Request $request)
    {
        $id = $request->id;

        $itemReq = new SliderItemRequest;
        $validate = $itemReq->rules();
        $messages = $itemReq->messages();
        $data = $request->validate($validate, $messages);
        

        $f = 'image';
        $image = null;
        $attachment = str_slug(microtime(), '-');
        // neu co image base64
        if ($request->image_data) {
            $output = save_base64_image($request->image_data, $attachment, '/contents/' . $this->folder);
            $image = $output ? $output : null;
        }
        if (!$image) {
            if(!$id){
                // neu tao moi ma ko co image data thi validate fike
                $request->validate([$f=>'required']);
            }
            // neu co file va filr hop le thi tien hanh upload
            if ($request->hasFile($f)) {
                $file = $request->file($f);
                $ext = strtolower($file->getClientOriginalExtension());
                $filename = $attachment . '.' . $ext;
                //$mime = $file->getClientMimeType();
                $destinationPath = public_path('/contents/' . $this->folder);
                $file->move($destinationPath, $filename);
                $image = $filename;
            }

        }
        if ($image) {
            // neu co anh moi thi xoa anh cu roi moi luu anh moi
            $this->itemRepository->DeleteFeatureImage($id);
            $data['image'] = $image;
        }

        $model = $this->itemRepository->save($data,$request->id);
        
        if(is_numeric($request->priority)){
            $this->itemRepository->updatePriority($model->id,$request->priority);
        }
        

        // item meta
        
        return redirect($model->slider->getDetailUrl());
    }
    public function changePriority(Request $request)
    {
        $status = false;
        $data = [];
        if($item = $this->repository->find($request->id)){
            if(is_numeric($request->priority)){
                if($this->repository->updatePriority($request->id,$request->priority)){
                    $status = true;
                    if(count($list = $this->repository->get(['position'=>$item->position,'@order_by'=>'priority']))){
                        foreach ($list as $it) {
                            $data[] = [
                                'id' => $it->id,
                                'priority' => $it->priority
                            ];
                        }
                    }
                }
            }
        }
        return response()->json(compact('status','data'));
    }




    public function changeItemPriority(Request $request)
    {
        $status = false;
        $data = [];
        if($item = $this->itemRepository->find($request->id)){
            if(is_numeric($request->priority)){
                if($this->itemRepository->updatePriority($request->id,$request->priority)){
                    $status = true;
                    if(count($list = $this->itemRepository->get(['slider_id'=>$item->slider_id,'@order_by'=>'priority']))){
                        foreach ($list as $it) {
                            $data[] = [
                                'id' => $it->id,
                                'priority' => $it->priority
                            ];
                        }
                    }
                }
            }
        }
        return response()->json(compact('status','data'));
    }








    /**
     * xoa nguoi dung
     * @param  Request $req [description]
     * @return json       [description]
     */
    public function deleteItem(Request $req)
    {
        if(is_array($req->ids)){
            $status = false;
            $remove_list = [];
            foreach($req->ids as $id){
                if($this->itemRepository->delete($id)){
                    $status = true;
                    $remove_list[] = $id;
                }
            }
            return response()->json(compact('status','remove_list'));
        }else{
            $status = $this->itemRepository->delete($req->id);
            $remove_id = $req->id;
            return response()->json(compact('status','remove_id'));
        }
    }
}
