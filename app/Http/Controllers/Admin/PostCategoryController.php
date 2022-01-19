<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Posts\CategoryRepository;

use App\Http\Requests\Categories\CategoryRequest;
use Cube\Html\Menu as HtmlMenu;


class PostCategoryController extends AdminController
{
	public $module = 'post-category';
	public $route = 'admin.post.category';
	public $folder = 'categories';

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
        HtmlMenu::addActiveKey('admin_menu','post');
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
        return $this->view('post.list-category',compact('list'));
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Danh mục bài viết";
        $form_title='Thêm danh mục mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'name,parent_id,description,feature_image,keywords,is_menu,show_home';
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $form_title = "Cập nhật danh mục";
                $this->repository->setActiveID($id);

            }
            else{
                return $this->view('errors.404');
            }
        }
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('forms.main','category',$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
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
        $data['show_home'] = $request->show_home?1:0;


        $model = $this->repository->save($data,$request->id);

        return redirect()->route($this->route.'.list');
    }


}
