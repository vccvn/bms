<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Pages\PageRequest;

use Illuminate\Http\Request;


use App\Repositories\Pages\PageRepository;
use App\Repositories\Tags\TagLinkRepository;

use Cube\Html\Menu as HtmlMenu;

class PageController extends AdminController
{
    //
    public $module = 'page';
    public $route = 'admin.page';
    public $folder = 'pages';
    public function __construct(PageRepository $PageRepository, TagLinkRepository $tagLink)
    {
        $this->repository = $PageRepository;
        $this->tagLinkRepository = $tagLink;

        HtmlMenu::addActiveKey('admin_menu', $this->module);
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    function list(Request $request) {
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }
        $args = [
            'status' => 200,
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['title', 'keywords']
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10)
        ];
        $list = $this->repository->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $this->view('' . $this->module . '.list', compact('list'));
    }


    public function detail($id)
    {
        # code...
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id = null)
    {
        $model = $this->repository->model();
        $title = "Trang";
        $form_title = 'Thêm trang mới';
        $form_action = $this->route . '.save';
        $form_id = $this->module . '-form';
        $inputList = ['title', 'custom_slug', 'slug', 'type', 'parent_id', 'description', 'content', 'keywords', 'feature_image','show_thumbnail', 'with_sidebar', 'allow_comment', 'layout', 'display_content'];
        if ($id) {
            if ($m = $this->repository->find($id)) {
                $model = $m;
                $model->applyMeta();
                $form_title = "Cập nhật trang";
                $this->repository->setActiveID($id);

            } else {
                return $this->view('errors.404');
            }
        }
        $data = compact('title', 'form_title', 'form_action', 'form_id');

        return $this->showForm('page.form', $this->module, $inputList, $model, $data, ($id ? "Cập nhật" : "Thêm"));
    }

    /**
     * cap nhat thong tin
     * @param  Request $requst
     * @return Reponse
     */
    public function save(Request $request)
    {
        $id = $request->id;
        // sub request
        $req = new PageRequest;

        $rules = $req->rules($id);
        //$messages = $req->messages();

        // validate va get data
        $data = $request->validate($rules);

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
        $this->repository->saveManyMeta($model->id,[
            'custom_slug' => $request->custom_slug,
            'show_thumbnail' => $request->show_thumbnail,
            'with_sidebar' => $request->with_sidebar,
            'allow_comment' => $request->allow_comment,
            'keep_original' => $request->keep_original,
            'layout' => $request->layout,
            'display_content' => $request->display_content,
            
        ]);

        // luu the
        $this->tagLinkRepository->savePageTags($model->id,$request->tags);


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
