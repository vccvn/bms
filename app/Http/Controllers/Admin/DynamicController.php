<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Dynamic\DynamicRequest;
use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Tags\TagLinkRepository;

use Cube\Html\Menu as HtmlMenu;
use Illuminate\Http\Request;

class DynamicController extends AdminController
{
    //
    public $module = 'dynamic';
    public $route = 'admin.dynamic';
    public $folder = 'dynamics';
    public function __construct(DynamicRepository $DynamicRepository, TagLinkRepository $tagLink)
    {
        $this->repository = $DynamicRepository;
        $this->tagLinkRepository = $tagLink;
        HtmlMenu::addActiveKey('admin_menu', 'dynamic');
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    function list(Request $request) {
        // filter
        $list = $this->repository->filter($request,['parent_id' => 0]);
        // dd($list);
        return $this->view($this->module . '.list', compact('list'));
    }


    public function detail(Request $request, $slug) {
        if(!($post=$this->repository->findBy('slug',$slug))){
            return $this->view('error.404');
        }
        $list = $this->repository->filter($request,['parent_id'=>$post->id]);
        return $this->view($this->module . '.item.list', compact('post','list'));
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id = null)
    {
        $model = $this->repository->model();
        $title = "Mục";
        $form_title = 'Thêm mục mới';
        $form_action = $this->route . '.save';
        $form_id = $this->module . '-form';
        $inputList = [
            'title', 'custom_slug', 'slug', 'description', 'content', 
            'keywords', 'feature_image','show_thumbnail', 'use_category', 
            'children_props', 'allow_comment','post_type'
        ];
        $required_fields = [
            'title','slug','description','content','keywords', 'feature_image', 
            'tag','advance','product_link'
        ];
        if ($id) {
            if ($m = $this->repository->find($id)) {
                $model = $m;
                $model->applyMeta();

                $form_title = "Cập nhật mục";
                $this->repository->setActiveID($id);
                $required_fields = [];
            } else {
                return $this->view('errors.404');
            }
        }
        
        
        if($model->required_fields){
            $required_fields = explode(',', $model->required_fields);
        }
        $data = compact('title', 'form_title', 'form_action', 'form_id', 'required_fields');

        return $this->showForm('dynamic.form', $this->module, $inputList, $model, $data, ($id ? "Cập nhật" : "Thêm"));
    }

    /**
     * cap nhat thong tin
     * @param  Request $requst
     * @return Reponse
     */
    public function save(DynamicRequest $request)
    {
        $id = $request->id;
        // sub request
        $data = $request->all();

        // tu tao slug
        if (!$request->slug) {
            $data['slug'] = $this->repository->getSlug($request->title, $id);
        }else{
            $data['slug'] = $this->repository->getSlug($request->post('slug'), $id);
        }
        
        // neu tao moi thi rhem id nguoi dung hien tai
        if($id && $m = $this->find($id)){
            $mo = $m;
        }else{
            $mo = null;
        }
        if(!$mo){
            $data['user_id'] = $request->user()->id;
        }
        // neu co anh moi thi xoa anh cu roi moi luu anh moi
        $oldFn = $mo?$mo->feature_image:null;
        
        // neu co anh moi thi xoa anh cu roi moi luu anh moi
        if($fn = $this->uploadImage($request,'feature_image', '/contents/'.$this->folder, 'image_data', false, $oldFn)){
            if($fn!=$oldFn) $this->repository->deleteFeatureImage($id);
            $data['feature_image'] = $fn;
        }
        
        // luu page
        $model = $this->repository->save($data, $id);
        $meta = [
            'custom_slug'        => $request->custom_slug,
            'post_type'          => $request->post_type,
            'show_thumbnail'     => $request->show_thumbnail,
            'with_sidebar'       => $request->with_sidebar,
            'children_props'     => $request->children_props,
            'use_category'       => $request->use_category,
            'allow_comment'      => $request->allow_comment, 
            'keep_original'      => $request->keep_original,
            'required_fields'    => $request->required_fields?implode(',' ,$request->required_fields):'',
        ];
        $this->repository->saveManyMeta($model->id,$meta);

        // luu the
        $this->tagLinkRepository->saveDynamicTags($model->id,$request->tags);


        return redirect()->route($this->route . '.list');
    }


    public function getSlug(Request $request)
    {
        $id = $request->id;
        $slug = $this->repository->getSlug($request->title, $id);
        $status = true;
        return response()->json(compact('status','slug'));
    }
    
    public function checkSlug(Request $request)
    {
        $id = $request->id;
        
        $status = $this->repository->checkSlug($request->slug, $id);
        return response()->json(compact('status'));
    }
}
