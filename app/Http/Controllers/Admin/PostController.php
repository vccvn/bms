<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Posts\PostRepository;
use App\Repositories\Products\ProductRepository;

use App\Repositories\Tags\TagLinkRepository;

use App\Http\Requests\Posts\PostRequest;
use Cube\Html\Menu as HtmlMenu;
use Cube\Image as CubeImage;

class PostController extends AdminController
{
	public $module = 'post';
	public $route = 'admin.post';
	public $folder = 'posts';

    public function __construct(PostRepository $postRepository, ProductRepository $productRepository, TagLinkRepository $tagLink)
    {
        $this->repository = $postRepository;
        $this->productRepository = $productRepository;
        $this->tagLinkRepository = $tagLink;
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


    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $post = $this->repository->model();
        $title = "Bài viết";
        $form_title='Thêm bài viết mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = ['title','slug','custom_slug','cate_id', 'description','content','meta_title','meta_description','keywords','feature_image','show_thumbnail','with_sidebar', 'product_cate_id', 'allow_comment'];
        if($id){
            if($m = $this->repository->find($id)){
                $post = $m;
                $form_title = "Cập nhật bài viết";
                $m->applyMeta();
                $this->repository->setActiveID($id);

            }
            else{
                return $this->view('errors.404');
            }
        }
        $data = compact('title','form_title','form_action', 'form_id','post');
        
        return $this->showForm('post.form',$this->module,$inputList,$post,$data,($id?"Cập nhật":"Thêm"));
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
        $req = new PostRequest;
        
        $rules = $req->rules($id);
        //$messages = $req->messages();
        
        // validate va get data
        $data = $request->validate($rules);
        
        // tu tao slug
        $data['slug'] = $this->repository->getSlug((($request->custom_slug && $request->slug)?$request->slug:$request->title),$id);

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

        if($fn = $this->uploadImage($request,'feature_image', '/contents/'.$this->folder, 'image_data', true, $oldFn)){
            if($fn!=$oldFn) $this->repository->DeleteFeatureImage($id);
            $data['feature_image'] = $fn;
        }

        $data['cate_map'] = $this->repository->makeCateMap($request->cate_id);
        // luu bai viet
        $model = $this->repository->save($data,$id);
        
        // luu nwta
        $this->repository->saveManyMeta($model->id,[
            'custom_slug'                  => $request->custom_slug?$request->custom_slug:0,
            'show_thumbnail'               => $request->show_thumbnail?$request->show_thumbnail:0,
            'with_sidebar'                 => $request->with_sidebar?$request->with_sidebar:0,
            'allow_comment'                => $request->allow_comment,
            'keep_original'                => $request->keep_original,
            'meta_title'                   => $request->meta_title,
            'meta_description'             => $request->meta_description,
        ]);
        
        //cap nhat lien ket

        $this->repository->updateProductLinks($model->id,$request->products);

        $this->tagLinkRepository->savePostTags($model->id,$request->tags);

        return redirect()->route($this->route.'.list');
    }

    public function getProductData(Request $request)
    {
        $status = true;
        $products = [];

        $args = [
            'status' => 200,
            '@search' =>[
                'keyword' => $request->keyword,
                'by' => ['name','keywords']
            ],
            '@paginate' => 30
        ];

        if($request->cate_id){
            $args['@all_of_category'] = $request->cate_id;
        }

        if(count($list = $this->productRepository->get($args))){
            foreach ($list as $item) {
                $products[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->getFeatureImage()
                ];
            }
        }

        $data = compact('status', 'products');
        return response()->json($data);
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
