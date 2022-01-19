<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Crawl\FrameRepository;
use App\Repositories\Crawl\TaskRepository;
use App\Http\Requests\Crawl\FrameRequest;
use App\Http\Requests\Crawl\TaskRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

class CrawlFrameController extends AdminController
{
	public $module = 'crawler';
	public $route = 'admin.crawler.frame';
	public $folder = 'crawler';

    public function __construct(FrameRepository $FrameRepository)
    {
        $this->repository = $FrameRepository;
        HtmlMenu::addActiveKey('admin_menu','crawler');
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
        return $this->view('crawl.frame.list',compact('list'));
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Crawl Frame";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = $this->repository->getFields();
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $btnTxt = "Cập nhật";
            }
            else{
                return $this->view('errors.404');
            }
        }
        $form_title=$btnTxt.' Crawl Frame';
        
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('crawl.frame.form','crawl-frame',$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(FrameRequest $request)
    {
        if($this->repository->saveFrame($request)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }


}
