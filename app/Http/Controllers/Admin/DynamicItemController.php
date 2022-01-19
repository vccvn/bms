<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Dynamic\DynamicItemRequest;
use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Dynamic\CategoryRepository;

use App\Repositories\Tags\TagLinkRepository;

use App\Repositories\Gallery\GalleryRepository;

use Cube\Html\Menu as HtmlMenu;
use Cube\Image;
use Illuminate\Http\Request;

class DynamicItemController extends AdminController
{
    //
    public $module = 'dynamic';
    public $route = 'admin.dynamic.item';
    public $folder = 'dynamics';
    protected $dynamic = null;
    public function __construct(DynamicRepository $DynamicRepository, TagLinkRepository $tagLink, GalleryRepository $gallery, CategoryRepository $categoryRepository)
    {
        $this->repository = $DynamicRepository;
        $this->tagLinkRepository = $tagLink;
        $this->galleryRepository = $gallery;
        $this->categories = $categoryRepository;
        HtmlMenu::addActiveKey('admin_menu', 'dynamic');
    }

    
    public function check($slug = null)
    {
        if($dynamic = $this->repository->findBy('slug', $slug)){
            $dynamic->applyMeta();
            $this->dynamic = $dynamic;
            $this->categories->setType($slug);
            HtmlMenu::addActiveKey('admin_menu',$slug);
            view()->share('dynamic', $dynamic);
            return $dynamic;
        }
        return false;
    }


    function list(Request $request, $slug) {
        if(!($post=$this->check($slug))){
            return $this->view('errors.404');
        }
        $list = $this->repository->getFilter($request, $post);
        return $this->view($this->module . '.item.list', compact('post','list'));
    }



    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($slug, $id = null)
    {
        if(!($post=$this->check($slug))){
            return $this->view('errors.404');
        }
        $model = $this->repository->model();
        $title = $post->title;
        $form_title = 'Thêm mới';
        $form_url = route($this->route . '.save',['slug'=>$post->slug]);
        $form_id = $this->module . '-dynamic-form';
        $inputList = [
            'title', 'custom_slug', 'slug' ,'video_url', 'description', 'content', 
            'keywords', 'feature_image','show_thumbnail','with_sidebar', 
            'allow_comment', 'gallery_images', 'product_cate_id'
        ];
        
        $required_fields = explode(',',$post->required_fields);
        
        if($post->use_category){
            $inputList[] = 'cate_id';
            $required_fields[] = 'cate_id';
        }
        if ($id) {
            if ($m = $this->repository->find($id)) {
                $model = $m;
                $model->applyMeta();
                $form_title = "Cập nhật";
                $this->repository->setActiveID($id);

            } else {
                return $this->view('errors.404');
            }
        }
        
        $data = compact('title', 'form_title', 'form_url', 'form_id', 'post', 'required_fields');

        return $this->showForm('dynamic.item.form', $this->module, $inputList, $model, $data, $form_title);
    }

    /**
     * cap nhat thong tin
     * @param  Request $requst
     * @return Reponse
     */
    public function save(DynamicItemRequest $request, $slug) {
        if(!($post=$this->check($slug))){
            return $this->view('errors.404');
        }
        $post->applyMeta();

        $id = $request->id;
        
        // validate va get data
        $data = $request->all();

        // tu tao slug
        $data['slug'] = $this->repository->getSlug((($request->custom_slug && $request->post('slug'))?$request->post('slug'):$request->title), $id);
        // neu tao moi thi rhem id nguoi dung hien tai
        if (!$id) {
            $data['user_id'] = $request->user()->id;
        }
        $data['parent_id'] = $post->id;
        $video = get_video_data($request->video_url);
        // neu co anh moi thi xoa anh cu roi moi luu anh moi
        if($post->post_type == 'video' && !$request->file('feature_image') && $video){
            $isUpload = true;
            if($id && $d = $this->find($id)){
                if($d->meta('video_url') == $request->video_url){
                    $isUpload = false;
                }
            }
            if($isUpload && $video->thumbnail){
                $image = new Image($video->thumbnail);
                $fname = uniqid().'-'.$data['slug'].'.'.$image->getExt();
                $dir = '/contents/'.$this->folder.'/';
                $image->save(public_path($dir.$fname));
                $image->RaC(90,90);
                $image->save(public_path($dir.'90x90/'.$fname));
                if($id) $this->repository->deleteFeatureImage($id);
                $data['feature_image'] = $fname;
            }
        }
        elseif($fn = $this->uploadImage($request,'feature_image', '/contents/'.$this->folder, 'image_data')){
            $this->repository->deleteFeatureImage($id);
            $data['feature_image'] = $fn;
        }
        $data['cate_map'] = $this->repository->makeCateMap($request->cate_id);

        // luu page
        $model = $this->repository->save($data, $id);
        $meta = [
            'custom_slug'     => $request->custom_slug,
            'show_thumbnail'  => $request->show_thumbnail,
            'with_sidebar'    => $request->with_sidebar,
            'allow_comment'   => $request->allow_comment,
            'keep_original'   => $request->keep_original,
        ];
        if($request->props){
            $meta = array_merge($meta, $request->props);
        }
        if($post->post_type=='video'){
            $meta['video_url'] = $request->video_url;
            $meta['embed_url'] = $video->embed_url;
            $meta['post_type'] = 'video';
        }
        $this->repository->saveManyMeta($model->id,$meta);

        // luu the
        $this->tagLinkRepository->saveDynamicTags($model->id,$request->tags);

        $this->repository->updateProductLinks($model->id,$request->products);
        
        $this->galleryRepository->checkRefData('dynamic', $model->id, $request->gallery_list);
        $this->galleryRepository->saveBase64Data('dynamic', $model->id, $request->gallery_images);

        return redirect()->route($this->route . '.list',['slug'=>$post->slug]);
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
