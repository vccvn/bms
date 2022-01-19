<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Products\ProductCategoryRepository;

use App\Http\Requests\Categories\CategoryRequest;
use Cube\Html\Menu as HtmlMenu;


class ProductCategoryController extends AdminController
{
	public $module = 'product-category';
	public $route = 'admin.product.category';
	public $folder = 'categories';

    public function __construct(ProductCategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
        HtmlMenu::addActiveKey('admin_menu','product');
    }
    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        // filter
        $list = $this->repository->filter($request);
    	return $this->view('product.list-category',compact('list'));
    }

 
    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = $this->repository->model();
        $title = "Danh mục sản phẩm";
        $form_title='Thêm danh mục mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,parent_id,description,feature_image,keywords,is_menu';
        $data = compact('title','form_title','form_action', 'form_id');
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $formtitle = "Cập nhật danh mục";
                $this->repository->setActiveID($id);

            }
            else{
                return $this->view('errors.404');
            }
        }
        
        return $this->showForm('product.cate-form','category-product',$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(CategoryRequest $request)
    {
        $id = $request->id;
        $data = $request->all();
        unset($data['feature_image']);
        // neu tao moi thi rhem id nguoi dung hien tai
        $mo = null;
        if($id && $m = $this->find($id)){
            $mo = $m;
        }
        // neu co anh moi thi xoa anh cu roi moi luu anh moi
        $oldFn = $mo?$mo->feature_image:null;
        if($fn = $this->uploadImage($request,'feature_image', '/contents/'.$this->folder, 'image_data', false, $oldFn)){
            if($fn!=$oldFn) $this->repository->DeleteFeatureImage($id);
            $data['feature_image'] = $fn;
        }
        $data['slug'] = $this->repository->getSlug($request->name,$request->id);
        $data['is_menu'] = $request->is_menu?1:0;
        $model = $this->repository->save($data,$request->id);
        return redirect()->route($this->route.'.list');
    }

}
