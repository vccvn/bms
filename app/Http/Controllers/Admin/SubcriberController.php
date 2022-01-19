<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Subcribers\SubcriberRepository;
use App\Http\Requests\Subcribers\SubcriberRequest;
use Cube\Html\Menu as HtmlMenu;
use Cube\Image as CubeImage;

class SubcriberController extends AdminController
{
	public $module = 'subcriber';
	public $route = 'admin.subcriber';
	public $folder = 'subcriber';

    public function __construct(SubcriberRepository $SubcriberRepository)
    {
        $this->repository = $SubcriberRepository;
        HtmlMenu::addActiveKey('admin_menu',$this->module);
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
    	return $this->view($this->module.'.list',compact('list'));
    }
}