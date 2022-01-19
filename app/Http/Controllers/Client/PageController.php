<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;

use Cube\Html\Menu as HtmlMenu;


class PageController extends ClientController
{
    public $module = 'page';
	public $route = 'client.page';
	public $folder = 'pages';
    public function __construct(PageRepository $PageRepository, DynamicRepository $DynamicRepository)
    {
        parent::__construct();
        $this->repository = $PageRepository;
        $this->dynamicRepository = $DynamicRepository;
        $this->repository->addFixableParam('status', 200);
        $this->dynamicRepository->addFixableParam('status', 200);
                
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

    public function viewChild($parent_slug, $child_slug)
    {
        $key = "page_$parent_slug---$child_slug";
        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if($this->cache_data_time || !($data = cache($key))){
            $data = $this->getChildPageData($parent_slug, $child_slug);
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
            $page_title = $article->title;
            $data = compact('article', 'page_title');
            if($page->hasChild()){
                HtmlMenu::addActiveKey('main_menu',$page->slug);
                $list = $this->repository->get([
                    'parent_id' => $page->id,
                    '@paginate' => 10
                ]);
                $data['list'] = $list;
                $data['view'] = 'page.list';
            }else{
                $this->repository->viewUp($page->id);
                $data['view'] = 'page.detail';
            }
        }else{
            $data['view'] = 'error.404';
        }
        return $data;
    }

    
    public function getChildPageData($parent_slug, $child_slug)
    {
        $data = [];
        if($parent = $this->repository->findBy('slug',$parent_slug)){
            $parent->applyMeta();
            if($article = $this->repository->first(['parent_id'=>$parent->id,'slug'=>$child_slug])){
                $article->applyMeta();
                $page_title = $article->title;
                $data = compact('article','parent', 'page_title');
                $data['view'] = 'page.detail';
                $this->repository->viewUp($page->id);
            }else{
                $data['view'] = 'page.notfound';
                $data['article'] = $parent;
                $data['page_title'] = $parent->title;
                
                
            }
        }else{
            $data['view'] = 'error.404';
            
        }
        return $data;
    }
}
