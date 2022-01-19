<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\Menus\MenuRepository;
use App\Repositories\Menus\MenuItemRepository;
use App\Repositories\Menus\MenuItemMetaRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Products\ProductCategoryRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;

use App\Repositories\Dynamic\CategoryRepository as DynamicCategory;
use App\Http\Requests\Menus\MenuRequest;
use App\Http\Requests\Menus\MenuItemRequest;
use App\Http\Requests\Menus\MenuItemMetaRequest;

use Validator;
use Redirect;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files as CubeFile;


class MenuItemController extends AdminController
{
    public $module = 'menu';
    public $route = 'admin.menu.item';
    public $folder = 'menus';

    public function __construct(MenuRepository $menu, MenuItemRepository $menuItem, MenuItemMetaRepository $menuItemMeta, DynamicCategory $DynamicCategory)
    {
        $this->repository = $menuItem;
        $this->menuRepository = $menu;
        $this->itemMetaRepository = $menuItemMeta;
        $this->categoryRepository = new CategoryRepository;
        $this->pageRepository = new PageRepository;
        $this->dynamicRepository = new DynamicRepository;
        $this->productCateRepository = new ProductCategoryRepository;
        $this->dynamicCategoryRepository = $DynamicCategory;
        
        // HtmlMenu::addActiveKey('admin_menu',$this->module);
        HtmlMenu::addActiveKey('admin_menu','option');
    }


    
    public function detail(Request $request, $menu_id = null,$item_id=null)
    {
        if(!$menu_id && $request->menu_id){
            $menu_id = $request->menu_id;
        }
        if(!$menu_id || !($detail = $this->menuRepository->find($menu_id))) return $this->view('errors.404');
        $this->menuRepository->setID($menu_id);
        $inputList = [
            'title', 'type', 
            'link_type', 'url', 'route','action','param', 'cate_id', 'dynamic_cate_id', 'product_cate_id', 'page_id', 'dynamic_id', // meta
            'sub_type',
            'active_key', 'priority',
            'menu_id',
            'classname', 'target',  
            'icon',
            
        ];

        $form_list = $this->getFormList();
        
        $data = compact('detail','form_list');
        return $this->showForm($this->module.'.list-item','menu-items',$inputList,null,$data);

    }

    public function form(Request $request, $menu_id = null,$id=null)
    {
        
        if(!$menu_id && $request->id){
            $menu_id = $request->id;
        }
        if(!$menu_id) return $this->view('errors.404');
        if(!($detail = $this->menuRepository->find($menu_id))) return $this->view('errors.404');
        if($detail->type=='default'){
            $this->menuRepository->setID($menu_id);
            $item = null;
            $btn = 'Thêm';
            if($id && $it = $this->repository->find($id)){
                $item = $it;
                $item->applyMeta();
                $btn = "Cập nhật";
            }else{
                $item = $this->repository->model();
                $item->menu_id = $menu_id;
            }
        
            $inputList = [
                'title', 'type', 
                'url', 'route','action','param', 'cate_id', 'page_id', 'dynamic_id',// meta
                'sub_type', //'sub_menu_id','sub_cate_id', 'sub_product_cate_id','sub_page_id', 'sub_file','sub_action', 'sub_param',  // meta submenu
                'active_key', 'priority',
                'menu_id',
                'classname', 'target',  
                'icon',
            ];
            $form_id = $this->module.'-item-form';
            $form_action = 'admin.'.$this->module.'.item.save';
            $title = 'Menu: '.$detail->name;
            $form_title = $btn.' item';
            $data = compact('title','form_title','form_action', 'form_id');
            return $this->showForm('menu.item-form','menu-items',$inputList,$item,$data, $btn);
        }
        return $this->view('errors.404');
    }



    public function getForm(Request $request, $menu_id = null,$id=null)
    {
        $status = true;
        $form = null;
        if(!$menu_id && $request->menu_id){
            $menu_id = $request->menu_id;
        }
        if(!$id && $request->id){
            $id = $request->id;
        }
        if(!$menu_id) $status = false;
        if(!($menu = $this->menuRepository->find($menu_id))) $status = false;
        if(!($detail = $this->repository->find($id))) $status = false;
        if($status){
            $inputList = [
                'title', 'type', 
                'url', 'route','action','param', 'cate_id', 'product_cate_id', 'dynamic_cate_id', 'page_id', 'dynamic_id',// meta
                'sub_type', //'sub_menu_id','sub_cate_id', 'sub_product_cate_id','sub_page_id', 'sub_file','sub_action', 'sub_param',  // meta submenu
                'active_key', 'priority',
                'menu_id',
                'classname', 'target',  
                'icon',
            ];
            $this->menuRepository->setID($menu_id);
            $item = $detail;
            $item->applyMeta();
            $btn = "Cập nhật";
            switch ($item->type) {
                case 'category':
                    $group_inputs = [
                        'title', 'type', 
                        'cate_id',
                    ];
                    break;
                // case 'product_category':
                //     $group_inputs = [
                //         'title', 'type', 
                //         'product_cate_id',
                        
                //     ];
                //     break;
                // case 'dynamic_category':
                //     $group_inputs = [
                //         'title', 'type', 
                //         'dynamic_cate_id',
                        
                //     ];
                //     break;
                case 'page':
                    $group_inputs = [
                        'title', 'type', 
                        'page_id',
                        
                    ];
                    break;
                

                case 'dynamic':
                    $group_inputs = [
                        'title', 'type', 
                        'dynamic_id',
                        
                    ];
                    if($page = $this->pageRepository->find($item->dynamic_id)){
                        $inp = [
                            "type" => 'select',
                            'name' => 'dynamic_id',
                            'label' => 'Mục',
                            'action'=> 'App\\Repositories\\Dynamic\\DynamicRepository::getParentSelectOption',
                            'default' => $item->dynamic_id,
                        ];
                        if($page->parent){
                            $inp['label'] = $page->parent->title;
                            $inp['action'] = 'App\\Repositories\\Dynamic\\DynamicRepository::getChildrenSelect';
                            $inp['param'] = $page->parent_id;

                        }
                        $group_inputs[2] = $inp;
                    
                    }
                    break;
                

                case 'dynamic_category':
                    $group_inputs = [
                        'title', 'type', 
                        'dynamic_cate_id',
                        
                    ];
                    if($page = $this->dynamicCategoryRepository->find($item->dynamic_cate_id)){
                        $inp = [
                            "type" => 'select',
                            'name' => 'dynamic_cate_id',
                            'label' => 'Danh mục',
                            'action'=> 'App\\Repositories\\Dynamic\\CategoryRepository::getCategoryMenuSelectOptions',
                            'param' => [$page->type],
                            'default' => $item->dynamic_cate_id,
                        ];
                        $group_inputs[2] = $inp;
                    
                    }
                    break;
                

                case 'define':
                    $group_inputs = [
                        'title', 'type', 
                        'action','param',
                        
                    ];
                    break;

                case 'route':
                    $group_inputs = ['title', 'type', 'route','param'];
                    
                    break;
                default:
                    $group_inputs = ['title', 'type', 'url'];
                    break;
            }
            $group_inputs[] = ['type'=>'hidden','name'=>'priority','value'=>$detail->priority];
            $group_inputs = array_merge($group_inputs,['target', 'sub_type', 'active_key', 'classname',  'icon']);

            $form_id = $this->module.'-item-form';
            $form_action = 'admin.'.$this->module.'.item.save';
            $title = 'Menu: '.$detail->name;
            $form_title = $btn.' item';
            $data = compact('title','form_title','form_action', 'form_id', 'group_inputs');
            $form =  $this->showForm('menu.item-edit-form','menu-items',$inputList,$item,$data, $btn)->render();
        }
        return response()->json(compact('status','form','item'));
    }




    public function save(Request $request)
    {
        $id = $request->id;
        $itemReq = new MenuItemRequest;
        $itemMetaReq = new MenuItemMetaRequest;
        $validate = $itemReq->rules($request->type);
        if($request->icon && $request->icon != 'none'){
            $validate['title'] = 'max:191';
        }
        $messages = $itemReq->messages();
        $metaMessages = $itemMetaReq->messages();
        $metaValidate = $itemMetaReq->rules($request->type);
        
        $validator = Validator::make($request->all(), $validate, $messages);
        $metaValidator = Validator::make($request->all(), $metaValidate, $metaMessages);
        
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }elseif($metaValidator->fails()){
            return Redirect::back()->withErrors($metaValidator)->withInput($request->all());
        }

        $data = $request->all();
        $metadata = $itemMetaReq->getData($request);
            
        unset($data['priority']);
        
        
        $model = $this->repository->save($data,$id);
        
        $this->updateItemMeta($model->id,$model->type,$metadata);
        
        if(is_numeric($request->priority)){
            $this->repository->updatePriority($model->id,$request->priority);
        }
        
        return redirect($model->menu()->getDetailUrl());
    }


    public function ajaxSave(Request $request)
    {
        $status = false;
        $errors = [];
        $id = $request->id;
        $itemReq = new MenuItemRequest;
        $itemMetaReq = new MenuItemMetaRequest;
        $validate = $itemReq->rules($request->type);
        if($request->icon && $request->icon != 'none'){
            $validate['title'] = 'max:191';
        }
        $messages = $itemReq->messages();
        $metaMessages = $itemMetaReq->messages();
        $metaValidate = $itemMetaReq->rules($request->type, $id);
        
        $validator = Validator::make($request->all(), $validate, $messages);
        $metaValidator = Validator::make($request->all(), $metaValidate, $metaMessages);

        $item = null;
        if ($validator->fails() || $metaValidator->fails() ) {
            if($validator->fails()){
                $errors = array_merge($errors, $validator->errors()->all());
            }
            if($metaValidator->fails()){
                $errors = array_merge($errors, $metaValidator->errors()->all());
            }
        }else{
            $status = true;
            $data = $request->all();
            $metadata = $itemMetaReq->getData($request);
            $model = $this->repository->save($data,$id);
            $this->updateItemMeta($model->id,$model->type,$metadata);
            if(is_numeric($request->priority)){
                $this->repository->updatePriority($model->id,$request->priority);
            }
            $item = $this->repository->find($model->id);
        }
        return response()->json(compact('status','item','errors'));
    }

    protected function updateItemMeta($id,$type='default',$data=[])
    {
        $t = $type;
        $model = $this->repository->find($id);
        $this->repository->updateMeta($id, $data);
        if($t=='category'){
            if(!$model->title)$this->repository->update($id, ['title' => $this->categoryRepository->find($data['cate_id'])->name]);
        }
        elseif($t=='product_category'){
            if(!$model->title)$this->repository->update($id, ['title' => $this->productCateRepository->find($data['product_cate_id'])->name]);
        }
        elseif($t=='dynamic_category'){
            if(!$model->title)$this->repository->update($id, ['title' => $this->dynamicCategoryRepository->find($data['dynamic_cate_id'])->name]);
        }
        elseif($t=='page'){
            if(!$model->title)$this->repository->update($id, ['title' => $this->pageRepository->find($data['page_id'])->title]);
        }
        elseif($t=='dynamic'){
            if(!$model->title)$this->repository->update($id, ['title' => $this->dynamicRepository->find($data['dynamic_id'])->title]);
        }
        
        //$model->save();
        
    }

    
    public function getFormList()
    {
        $filemng = new CubeFile();
        $filemng->cd('json/data');
        $data = object_to_array($filemng->getJSON('menu-item-group'));
        
        if($dynamic = $this->dynamicRepository->getParentList()){
            $last = array_pop($data);
            
            foreach($dynamic as $p){
                $data[] = [
                    'label' => 'Danh mục '.$p->title,
                    'id' => 'item-dynamic-category-'.$p->id,
                    'class' => 'item-dynamic=category',
                    'type' => 'dynamic_category',
                    "inputs"=>[
                        [
                            'type'=>'select',
                            'name'=>'dynamic_cate_id',
                            'label' => 'Chọn danh mục '.$p->title,
                            'action'=> 'App\\Repositories\\Dynamic\\CategoryRepository::getCategoryMenuSelectOptions',
                            'param' => [$p->slug]


                        ],'target', "active_key","priority","classname","icon"],
                    'hidden'=>[['name'=>'title',"value"=>'']]
                ];

                $data[] = [
                    'label' => $p->title,
                    'id' => 'item-dynamic-'.$p->id,
                    'class' => 'item-dynamic',
                    'type' => 'dynamic',
                    "inputs"=>[
                        [
                            'type'=>'select',
                            'name'=>'dynamic_id',
                            'label' => 'Chọn '.$p->title,
                            'action'=> 'App\\Repositories\\Dynamic\\DynamicRepository::getChildrenSelect',
                            'param' => $p->id,
                        ],'target',"active_key","priority","classname","icon"],
                    'hidden'=>[['name'=>'title',"value"=>'']]
                ];

                
            }
            $data[] = $last;
        }
        return $data;
    }

    public function changePriority(Request $request)
    {
        $status = false;
        $data = [];
        if($item = $this->repository->find($request->id)){
            if(is_numeric($request->priority)){
                if($this->repository->updatePriority($request->id,$request->priority)){
                    $status = true;
                    if(count($list = $this->repository->get(['menu_id'=>$item->menu_id,'@order_by'=>'priority']))){
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


    public function sortItems(Request $request)
    {
        $status = false;
        $items = [];
        if($request->items){
            $i = 1;
            foreach($request->items as $item){
                if(!$this->repository->find($item['id'])){
                    continue;
                }
                $this->repository->save(['parent_id'=>0], $item['id']);
                $this->repository->updatePriority($item['id'], $i);
                $data = ['id'=>$item['id'],'priority'=>$i];
                if(isset($item['children'])){
                    $j = 1;
                    $data['children'] = [];
                    foreach($item['children'] as $child){
                        if(!$this->repository->find($child['id']) || $item['id'] == $child['id']){
                            continue;
                        }
                        $this->repository->save(['parent_id'=>$item['id']], $child['id']);
                        $this->repository->updatePriority($child['id'], $j);
                        $data['children'][] = ['id'=>$child['id'],'priority'=>$j];
                        $j++;
                    }
                }
                $items[] = $data;
                $i++;
            }
            $status = true;
        }
        return response()->json(compact('status', 'items'));
    }

}
