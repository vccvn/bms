<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;


use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\BasePostRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;

use App\Repositories\Products\ProductRepository;

use App\Repositories\Users\UserRepository;


use Cube\Html\Menu as HtmlMenu;

use Cookie;

class SearchController extends ClientController
{
    public $module = 'search';
	public $route = 'client.search';
	public $folder = 'posts';

    public function __construct(PostRepository $PostRepository, BasePostRepository $basePostRepository, DynamicRepository $DynamicRepository, PageRepository $pageRepository)
    {
        parent::__construct();
        $this->dynamicRepository = $DynamicRepository;
        
        $this->postRepository = $PostRepository;
        $this->basePostRepository = $basePostRepository;
        $this->pageRepository = $pageRepository;
        
        $this->basePostRepository->addFixableParam('status', 200);
        $this->postRepository->addFixableParam('status', 200);
        $this->pageRepository->addFixableParam('status', 200);
        $this->dynamicRepository->addFixableParam('status', 200);
        HtmlMenu::addActiveKey('main_menu',$this->module);

    }

    public function search(Request $request)
    {
        $key = 'search_'.md5(json_encode($request->all()));
        // neu cho phep dung cache vao co cache
        if($html = $this->getCache($key.'_view')){
            return $html;
        }
        // lay data

        if(!$this->cache_data_time || !($data = cache($key))){

            $cate = null;
            $cate = $request->cate;
            $lc = strtolower($cate);
            
            if(in_array($lc,['post','page','dynamic'])){
                switch ($lc) {
                    case 'post':
                        $list = $this->postRepository->search($request,['@paginate'=>12]);
                        break;
                    
                    case 'page':
                        $list = $this->pageRepository->search($request,['@paginate'=>12]);
                        break;

                    case 'dynamic':
                    $list = $this->dynamicRepository->search($request,['parent_id'=>0,'@paginate'=>12]);
                        break;
                }
            }
            elseif($dynamic = $this->dynamicRepository->first(['status'=>200,'slug'=>$lc])){
                $list = $this->dynamicRepository->search($request,['parent_id'=>$dynamic->id,'@paginate'=>12]);
            }
            else{
                $list = $this->basePostRepository->searchAll($request,['@paginate'=>12]);
                $lc = 'all';
        
            }
        
            $cate_list = [
                'all' => 'Tất cả',
                'post' => 'Bài viết'
            ];
            if($listCate = $this->dynamicRepository->get(['status'=>200,'parent_id'=>0])){
                foreach($listCate as $p){
                    $cate_list[$p->slug] = $p->title;
                }
            }
            $cate_list['page'] = "Trang";
            $current_cate = $lc;
            $keywords = $request->s;

            $page_title = "Tìm kiếm";
            $data = compact('keywords', 'list','cate_list','current_cate', 'page_title');

            if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);


            // $keywords = $request->search?$request->search:($request->s?$request->s:($request->keyword?$request->keyword:null));
            
            // $page_title = "Kết quả tìm kiếm cho $keywords";
            // $list = $this->productRepository->search($request,['@paginate'=>12]);
            // $data = compact('list', 'keywords', 'page_title');
            // if($this->cache_data_time) cache([$key=>$data], $this->cache_data_time);
        }

        $view = 'search.result';
        return $this->view($view, $data, $key.'_view');
    }

    
}
