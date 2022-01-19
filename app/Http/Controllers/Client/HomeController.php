<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Posts\CategoryRepository;

use App\Repositories\Products\ProductCategoryRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\comments\CommentRepository;
use App\Repositories\Sliders\SliderRepository;

use App\Repositories\Users\UserRepository;
use App\Models\BasePost;
use DB;

use App\Web\Siteinfo;
use App\Web\Setting;

use Cube\Html\Menu as HtmlMenu;

class HomeController extends ClientController
{
    public $module = 'home';
	public $route = 'client.home';
	public $folder = 'home';

    public function __construct(CategoryRepository $CategoryRepository, ProductCategoryRepository $productCategoryRepository, ProductRepository $ProductRepository, PostRepository $PostRepository, PageRepository $PageRepository, DynamicRepository $DynamicRepository, SliderRepository $SliderRepository)
    {
        parent::__construct();
        $this->postCategories = $CategoryRepository;
        $this->productCategories = $productCategoryRepository;
        $this->products = $ProductRepository;
        $this->posts = $PostRepository;
        $this->pages = $PageRepository;
        $this->dynamics = $DynamicRepository;
        $this->sliders = $SliderRepository;
        
        $this->postCategories->addFixableParam('status', 200);
        $this->products->addFixableParam('status', 200);
        $this->posts->addFixableParam('status', 200);
        $this->pages->addFixableParam('status', 200);
        $this->dynamics->addFixableParam('status', 200);
        $this->productCategories->addFixableParam('status', 200);

        HtmlMenu::addActiveKey('main_menu',$this->module);

    }

    public function index()
    {
        $key = 'home_data';

        // neu cho phep dung cache vao co cache
        if($html = $this->getCache('home_view')){
            return $html;
        }
        // lay data

        if(!($data = cache($key))){
            $data = $this->getData();
            if($this->cache_data_time){
                cache([$key=>$data], $this->cache_data_time);
            }
        }
        
        return $this->view('home.index', $data, 'home_view');
    }

    public function getData()
    {
        // slider
        $home_slider = $this->sliders->getSlider('home');

        // cac danh muc hien thi tren trang chu
        // $home_categories = $this->postCategories->get(['parent_id'=>0, 'show_home'=>1]);

        $posts = $this->posts->get([
            '@orderBy' => ['id', 'DESC'],
            '@limit'   => 4
        ]);

        $date = explode('/', date('d/m/Y'));
        $day = $date[0];
        $month = $date[1];
        $year = $date[2];
        $from = get_station_id();
        $to = 0;
        $data = compact(
            'home_slider',
            'posts',
            'day',
            'month',
            'year',
            'from',
            'to'
        );
        return $data;
    }

}
