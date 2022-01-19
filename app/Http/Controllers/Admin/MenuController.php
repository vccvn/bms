<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\Menus\MenuRepository;
use App\Repositories\Menus\MenuItemRepository;
use App\Repositories\Menus\MenuItemMetaRepository;

use App\Repositories\Products\ProductCategoryRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Pages\PageRepository;

use App\Http\Requests\Menus\MenuRequest;
use App\Http\Requests\Menus\MenuItemRequest;

use Validator;
use Redirect;

use Cube\Html\Menu as HtmlMenu;


class MenuController extends AdminController
{
    public $module = 'menu';
    public $route = 'admin.menu';
    public $folder = 'menus';

    public function __construct(MenuRepository $menu, MenuItemRepository $menuItem, MenuItemMetaRepository $menuItemMeta)
    {
        $this->repository = $menu;
        $this->itemRepository = $menuItem;
        $this->itemMetaRepository = $menuItemMeta;
        $this->categoryRepository = new CategoryRepository;
        $this->productCateRepository = new ProductCategoryRepository;
        $this->pageRepository = new PageRepository;
        
        // HtmlMenu::addActiveKey('admin_menu',$this->module);
        HtmlMenu::addActiveKey('admin_menu','option');
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $inputList = 'name,type,data,active,priority';
        $list = $this->repository->filter($request);
        $data = compact('list');

        return $this->showForm($this->module.'.list',$this->module,$inputList,null,$data);
        
    }

    

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return view     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Menu";
        $form_title='Thêm menu mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,type,data,active,priority';
        $data = compact('title','form_title','form_action', 'form_id');
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $formtitle = "Cập nhật thông tin menu";
            }
            else{
                return $this->view('errors.404');
            }
        }
        
        return $this->showForm('forms.main',$this->module,$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }


    
    public function save(Request $request)
    {
        
        $menuRequest = new MenuRequest;

        
        
        $validator = Validator::make($request->all(), $menuRequest->rules($request->id), []);
        
        if ($validator->fails()) {
            if($request->id){
                return Redirect::back()->withErrors($validator)->withInput($request->all());
            }else{
                return redirect()->route('admin.menu.add')->withErrors($validator)->withInput($request->all());
            }
        }
        $data = $request->all();
        if($request->active){
            $data['active'] = 1;
        }
        else{
            $data['active'] = 0;
        }
        unset($data['priority']);
        $model = $this->repository->save($data,$request->id);
        if(is_numeric($request->priority)){
            $this->repository->updatePriority($model->id,$request->priority);
        }
        return redirect()->route($this->route.'.list');
    }
}
