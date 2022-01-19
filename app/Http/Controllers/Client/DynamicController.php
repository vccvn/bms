<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;

use App\Repositories\Dynamic\CategoryRepository;

use Cube\Html\Menu as HtmlMenu;


class DynamicController extends ClientController
{
    public $module = 'dynamic';
	public $route = 'client.dynamic';
	public $folder = 'dynamics';
    public function __construct(PageRepository $PageRepository, DynamicRepository $DynamicRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->repository = $DynamicRepository;
        $this->pageRepository = $PageRepository;
        $this->categoryRepository = $categoryRepository;

        $this->repository->addFixableParam('status', 200);
        $this->categoryRepository->addFixableParam('status', 200);
        $this->pageRepository->addFixableParam('status', 200);
        
        // HtmlMenu::addActiveKey('admin_menu',$this->module);
    }


    public function viewPage(Request $request, $slug)
    {
        $key = "page_$slug--$request->page";
        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if(!$this->cache_data_time || !($data = cache($key))){
            $data = $this->getPageDetailData($request, $slug);
            
            if($this->cache_data_time){
                cache([$key=>$data], $this->cache_data_time);
            }
        }
        $view = $data['view'];
        unset($data['view']);
        return $this->view($view,$data, $key.'_view');
    }

    public function viewChild(Request $request, $parent_slug, $child_slug)
    {
        $key = "page_$parent_slug---$child_slug";

        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if($this->cache_data_time || !($data = cache($key))){
            $data = $this->getChildPageData($request, $parent_slug, $child_slug);
            if($this->cache_data_time){
                $cache = [$key=>$data];
                cache($cache, $this->cache_data_time);
            }
        }

        if(isset($data['parent'])){
            HtmlMenu::addActiveKey('admin_menu',$data['parent']->slug);
        }elseif(isset($data['article'])){
            HtmlMenu::addActiveKey('admin_menu',$data['article']->slug);
        }
        $view = $data['view'];
        unset($data['view']);
        return $this->view($view,$data, $key.'_view');
    }


    public function getPageDetailData(Request $request, $slug)
    {
        $data = [];
        if($article = $this->repository->findBy('slug',$slug)){
            $article->applyMeta();
            $data = compact('article');
            if($article->hasChild()){
                HtmlMenu::addActiveKey('main_menu',$article->slug);
                $list = $this->repository->get([
                    'parent_id' => $article->id,
                    '@paginate' => 12
                ]);
                $data['list'] = $list;
                $data['view'] = 'dynamic.list';
                
            }else{
                $data['view'] = 'dynamic.detail';
                // tang view
                $this->repository->viewUp($article->id);

            }
        }
        elseif($article = $this->pageRepository->findBy('slug',$slug)){
            $article->applyMeta();
            $data = compact('article');
            if($article->hasChild()){
                HtmlMenu::addActiveKey('main_menu',$article->slug);
                $list = $this->pageRepository->get([
                    'parent_id' => $article->id,
                    '@paginate' => 10
                ]);
                $data['list'] = $list;
                $data['view'] = 'page.list';
            }else{
                $data['view'] = 'page.detail';
                // tang view
                $this->pageRepository->viewUp($article->id);
            }
        }else{
            $data['view'] = 'error.404';
        }
        return $data;
    }

    
    public function getChildPageData(Request $request, $parent_slug, $child_slug)
    {
        $data = [];
        if($parent = $this->repository->findBy('slug',$parent_slug)){
            $parent->applyMeta();
            
            if($article = $this->repository->first(['parent_id'=>$parent->id,'slug'=>$child_slug])){
                $article->applyMeta();
                $category = null;
                $args = [
                    'parent_id'=>$parent->id,
                    '@where' => ['id', '!=', $article->id],
                    '@limit' => 8
                ];

                if($parent->use_category){
                    $category = $article->getCategory();
                    $args['vate_id'] = $category->id;
                }

                $related_posts = $this->repository->get($args);
                $data = compact('article','parent','category','related_posts');
                $data['view'] = 'dynamic.detail';
                // tang view
                $this->repository->viewUp($article->id);
                
            }else{
                $data['view'] = 'dynamic.notfound';
                $data['article'] = $parent;
                
            }
        }elseif($parent = $this->pageRepository->findBy('slug',$parent_slug)){
            $parent->applyMeta();
            
            if($article = $this->pageRepository->first(['parent_id'=>$parent->id,'slug'=>$child_slug])){
                $article->applyMeta();
                $data = compact('article','parent');
                $data['view'] = 'page.detail';
                $popular_posts = (!$request->page || $request->page == 1)? $this->pageRepository->getAndLimit($request, ['parent_id'=>$parent->id, '@order_by'=>['views'=>'DESC'], '@limit'=>3]):[];
                $data['popular_posts'] = $popular_posts;
                // tang view
                $this->pageRepository->viewUp($article->id);
            }else{
                $data['view'] = 'page.notfound';
                $data['article'] = $parent;
            }
        }else{
            $data['view'] = 'error.404';
        }
        return $data;
    }







    public function viewCate(Request $request, $dynamic_slug, $slug=null, $child_slug=null)
    {
        $key = "$dynamic_slug-category-$slug--$child_slug---".$request->page;
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data
        if(!$this->cache_data_time || !($data = cache($key))){
            $data = [];
            if($dynamic = $this->repository->findBy('slug',$dynamic_slug)){
                $parent = $dynamic;
                $this->categoryRepository->setType($dynamic_slug);
                if($slug && $cate = $this->categoryRepository->findBy('slug',$slug)){
                    $is_404 = false;
                    $data['view'] = 'dynamic.category';
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
                        
                        //$popular_posts = null;
                        $page_title = $category->name;
                        
                        $list = $this->repository->getFilter($request, $dynamic, $args);
                        
                        $data  = array_merge($data, compact('category', 'view', 'page_title', 'list','parent'));
                    }
                }else{
                    $data['view'] = 'error.404';
                }
            }
            else{
                $data['view'] = 'error.404';
            }
            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }
        $view = $data['view'];
        unset($data['view']);

        return $this->view($view,$data, $key.'_view');
    }
}
