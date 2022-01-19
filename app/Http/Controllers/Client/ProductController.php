<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ProductCategoryRepository;

use Cube\Html\Menu as HtmlMenu;


class ProductController extends ClientController
{
    public $module = 'product';
	public $route = 'client.product';
	public $folder = 'products';

    public function __construct(ProductCategoryRepository $CategoryRepository, ProductRepository $ProductRepository)
    {
        $this->categoryRepository = $CategoryRepository;
        $this->productRepository = $ProductRepository;
        
        $this->categoryRepository->addFixableParam('status', 200);
        $this->productRepository->addFixableParam('status', 200);
        
        HtmlMenu::addActiveKey('main_menu',$this->module);

    }

    public function index(Request $request)
    {
        $key = "product-list-".$request->page;

        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if(!$this->cache_data_time || !($data = cache($key))){

            $list = $this->productRepository->filter($request);
            $total = $this->productRepository->total_count;
            $current_page = $request->page?$request->page:1;
            $page_title = 'Sản phẩm';
            $data = compact('list','total','current_page','page_title');

            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = 'product.list';
        return $this->view($view,$data, $key.'_view');
    }

    public function viewCate(Request $request, $slug=null, $child_slug=null)
    {
        $key = "product-category-$slug--$child_slug---".$request->page;
        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if(!$this->cache_data_time || !($data = cache($key))){
            $data = [];
            if($slug && $cate = $this->categoryRepository->findBy('slug',$slug)){
                $category = $cate;
                $data['view'] = 'product.list';
                $is_404 = false;
                $page_title = $cate->name;
                if($child_slug){
                    if($child = $this->categoryRepository->first(['parent_id'=>$cate->id,'slug'=>$child_slug])){
                        $category = $child;
                        $page_title = $child->name;
                    }
                    else{
                        $data['view'] = 'error.404';
                        $is_404 = true;
                    }
                    
                }
                $data['page_title'] = $page_title;
                if(!$is_404){
                    //$key = $category->slug;
                    //HtmlMenu::addActiveKey('category_menu',$key);
                    $args = [
                        '@all_of_category' => $category->id
                    ];
                    
                    
                    $list = $this->productRepository->filter($request, $args);
                    $total = $this->productRepository->total_count;
                    $current_page = $request->page?$request->page:1;

                    $data = array_merge($data, compact('list','category','total', 'current_page'));
                }
            }else{
                $data['view'] = 'error.404';
            }

            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = $data['view'];
        unset($data['view']);

        return $this->view($view,$data, $key.'_view');
    }

    public function detail(Request $request, $slug=null)
    {
        
        $key = "product-detail-$slug";
        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if(!$this->cache_data_time || !($data = cache($key))){
            
            if($slug && $product = $this->productRepository->findBy('slug',$slug)){
                $product->applyMeta();
                $category = $product->getCategory();
                HtmlMenu::addActiveKey('main_menu',$category->slug);
                $this->productRepository->viewUp($product->id);
                $related = $this->productRepository->get([
                    'cate_id' => $product->cate_id,
                    '@limit' => 6,
                    '@order_by' => ['created_at'=>'DESC']
                ]);
                $view = 'product.detail';
                $data = compact('product','category','related','view');

            }else{
                $data = ['view' => 'error.404'];
            }

            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = $data['view'];
        unset($data['view']);
        return $this->view($view,$data, $key.'_view');
    }
    public function quickView(Request $request, $id=null)
    {
        if($id){
            if($product = $this->productRepository->find($id)){
                $category = $product->category();
                $key = $category->slug;
                return $this->view('product.quick-view', compact('product','category'));

            }
        }

        return $this->view('error.404');
    }



}
