<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Dynamic\CategoryRepository;

use App\Http\Requests\Categories\CategoryRequest;
use Cube\Html\Menu as HtmlMenu;

use View;

use Cube\Html\Input;

class DynamicCategoryController extends AdminController
{
	public $module = 'dynamic-category';
	public $route = 'admin.dynamic.category';
    public $folder = 'categories';
    
    protected $type = 'dynamic';

    protected $dynamic = null;
    public function __construct(CategoryRepository $categoryRepository, DynamicRepository $dynamicRepository)
    {
        $this->repository = $categoryRepository;
        $this->dynamics = $dynamicRepository;
        //HtmlMenu::addActiveKey('admin_menu','product');
    }

    public function check($slug = null)
    {
        if($dynamic = $this->dynamics->findBy('slug', $slug)){
            $dynamic->applyMeta();
            $this->dynamic = $dynamic;
            $this->repository->setType($slug);
            HtmlMenu::addActiveKey('admin_menu',$slug);
            view()->share('dynamic', $dynamic);
            return $dynamic;
        }
        return false;
    }



    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function getList(Request $request, $slug=null)
    {
        if(!$this->check($slug)){
            return $this->view('errors.404');
        }
        // filter
        $list = $this->repository->filter($request);
    	return $this->view('dynamic.category.list',compact('list'));
    }

 
    /**
     * hien thi form
     * @param  string  $slug   [description]
     * @param  integer $id     [description]
     * @return [type]           [description]
     */
    public function form($slug, $id=null)
    {
        if(!($dynamic = $this->check($slug))){
            return $this->view('errors.404');
        }
        $model = $this->repository->model();
        $title = "Danh mục ".$dynamic->title;
        $form_title='Thêm danh mục mới';
        $form_action = route($this->route.'.save',['dynamic_slug' => $dynamic->slug]);
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
        
        return $this->showForm('dynamic.category.form','category-dynamic',$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(CategoryRequest $request, $slug)
    {
        if(!($dynamic = $this->check($slug))){
            return $this->view('errors.404');
        }
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
        return redirect()->route($this->route.'.list',['dynamic' => $dynamic->slug]);
    }

    /**
     * lấy danh mục để crawl
     * @param int $id là id của dynamic
     */

    public function getCategories(Request $request, $id = 0)
    {
        if(!$id) $id = $request->get('id');
        $select = $request->get('select');
        if($id && $dynamic = $this->dynamics->first(['id' => $id, 'parent_id' => 0, 'status' => 200])){
            $this->repository->setType($dynamic->slug);
        }else{
            $this->repository->setType('post');
        }
        $status = false;
        $data = null;
        if($cates = $this->repository->getCategoryOptions()){
            $status = true;
            $data  = (new Input)->toCubeSelectOptions($cates,$select);
        }
        return response()->json(compact('status','data'));
    }

}
