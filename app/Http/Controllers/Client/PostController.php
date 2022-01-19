<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;


use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\CategoryRepository;


use App\Repositories\Users\UserRepository;


use View as ViewShare;
use Cube\Html\Menu as HtmlMenu;

use Cookie;

class PostController extends ClientController
{
    public $module = 'post';
	public $route = 'client.post';
	public $folder = 'posts';

    public function __construct(CategoryRepository $CategoryRepository, PostRepository $PostRepository)
    {
        parent::__construct();
        $this->categoryRepository = $CategoryRepository;
        $this->postRepository = $PostRepository;

        $this->postRepository->addFixableParam('status', 200);
        $this->categoryRepository->addFixableParam('status', 200);

        HtmlMenu::addActiveKey('main_menu',$this->module);

    }

    public function index(Request $request)
    {
        $key = 'post-lastest-'.$request->page;

        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data
        

        if(!$this->cache_data_time || !($data = cache($key))){

            $list = $this->postRepository->filter($request);
            
            $popular_posts = (!$request->page || $request->page == 1)? $this->postRepository->get(['@order_by'=>['views'=>'DESC'], '@limit'=>3]):[];
            $page_title = 'Tin Tức';
            $data = compact('list','page_title', 'popular_posts');


            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = 'post.list';
        return $this->view($view,$data, $key.'_view');
    }

    public function popular(Request $request)
    {
        $key = 'post-popular---'.$request->page;
        
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data
        if(!$this->cache_data_time || !($data = cache($key))){

            $list = $this->postRepository->filter($request,['@ordrBy'=>['views','DESC']]);
            $page_title = 'Tin tức';
            $data = compact('list','page_title');

            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        
        $view = 'post.list';
        return $this->view($view,$data, $key.'_view');
    }

    public function viewCate(Request $request, $slug=null, $child_slug=null)
    {
        $key = "post-category-$slug--$child_slug---".$request->page;
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data
        if(!$this->cache_data_time || !($data = cache($key))){
            $data = [];
            if($slug && $cate = $this->categoryRepository->findBy('slug',$slug)){
                $is_404 = false;
                $data['view'] = 'post.list';
                $category = $cate;
                if($child_slug){
                    if($child = $this->categoryRepository->first(['parent_id'=>$cate->id,'slug'=>$child_slug])){
                        $category = $child;
                    }
                    else{
                        $is_404 = true;
                        $data['view'] = 'error.404';
                    }
                    
                }
                if(!$is_404){
                    //$key = $category->slug;
                    // HtmlMenu::addActiveKey('category_menu',$key);
                    $args = [
                        '@all_of_category' => $category->id
                    ];
                    
                    $popular_posts = null;
                    $page_title = $category->name;
                    
                    $list = $this->postRepository->filter($request, $args);
                    
                    $data  = array_merge($data, compact('list','category', 'view', 'page_title', 'popular_posts'));
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
        $key = "post-detail-$slug";


        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data
        if(!$this->cache_data_time || !($data = cache($key))){
            
            if($slug && $article = $this->postRepository->findBy('slug',$slug)){
                $category = $article->category;
                //HtmlMenu::addActiveKey('main_menu',$category->slug);
                $this->postRepository->viewUp($article->id);
                $args = [
                    
                    'cate_id'=>$article->cate_id, 
                    '@where' => ['id', '!=', $article->id],
                    '@order_by'=>['id'=>'DESC'],
                    '@limit'=>8
                ];
                $related_posts = $this->postRepository->get($args);
                $data = compact('article','category','related_posts');
                $data['view'] = 'post.detail';
            }else{
                $data = ['view'=>'error.404'];
            }
            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = $data['view'];
        unset($data['view']);
        return $this->view($view,$data, $key.'_view');
    }

}
