<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Products\ProductRepository;

use App\Repositories\Tags\TagLinkRepository;

use App\Repositories\Gallery\GalleryRepository;

use App\Http\Requests\Products\ProductRequest;
use Cube\Html\Menu as HtmlMenu;


class ProductController extends AdminController
{
	public $module = 'product';
	public $route = 'admin.product';
	public $folder = 'products';

    public function __construct(ProductRepository $ProductRepository, TagLinkRepository $tagLink, GalleryRepository $gallery)
    {
        $this->tagLinkRepository = $tagLink;
        $this->repository = $ProductRepository;
        
        $this->galleryRepository = $gallery;

        HtmlMenu::addActiveKey('admin_menu',$this->module);
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        // filter
        $orderby = [];
        if ($request->sortby) {
            $orderby[$request->sortby] = $request->sorttype;
        }
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name', 'keywords'],
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),
            'status' => 200
        ];
        $list = $this->repository->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        
        
    	return $this->view($this->module.'.list',compact('list'));
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description] 'list_price','sale_price',
     */
    public function form($id=null)
    {
        $model = $this->repository->model();
        $title = "Sản phẩm";
        $form_title='Thêm Sản phẩm mới';
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = [
            'name','cate_id', 'code','description','sale_price','total', 'detail',
            'keywords','feature_image','allow_comment', 'gallery_images'
        ];
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $form_title = "Cập nhật Sản phẩm";
                $this->repository->setActiveID($id);
            }
            else{
                return $this->view('errors.404');
            }
        }
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('product.form',$this->module,$inputList,$model,$data,($id?"Cập nhật":"Thêm"));
    }

    /**
     * cap nhat thong tin 
     * @param  Request $requst
     * @return Reponse         
     */
    public function save(ProductRequest $request)
    {
        $id = $request->id;
        
        $data = $request->all();
        
        // tu tao slug
        $data['slug'] = $this->repository->getSlug($request->name,$id);

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
        if($fn = $this->uploadImage($request,'feature_image', '/contents/'.$this->folder, 'image_data', true, $oldFn)){
            if($fn!=$oldFn) $this->repository->deleteFeatureImage($id);
            $data['feature_image'] = $fn;
        }
        
        $data['cate_map'] = $this->repository->makeCateMap($request->cate_id);
        // luu san pham
        $model = $this->repository->save($data,$id);

        
        // upload loat anh bìa
        if($mo){
            $mo->applyMeta();
            if($mo->cover_image){
                $oldFile = $mo->cover_image;
            }else{
                $oldFile = null;
            }
        }else{
            $oldFile = null;
        }
        if($fn = $this->uploadImage($request,'cover_image', '/contents/'.$this->folder, 'cover_image_data', true, $oldFile)){
            // upload file neu co
            if($oldFile && $fn!=$oldFile ) unlink(public_ath('/contents/'.$this->folder.'/'.$oldFile)); // xóa file nếu tên file khá< file cũ
            $cover_image = $fn;
        }else{
            $cover_image = $oldFile;
        }
        
        // luu nwta
        $this->repository->saveManyMeta($model->id,[
            'allow_comment' => $request->allow_comment,
            'keep_original' => $request->keep_original,
            'cover_image'   => $cover_image

        ]);
        
        $this->galleryRepository->checkRefData('product', $model->id, $request->gallery_list);
        $this->galleryRepository->saveBase64Data('product', $model->id, $request->gallery_images);

        $this->tagLinkRepository->saveProductTags($model->id,$request->tags);
        return redirect()->route($this->route.'.list');
    }

}
