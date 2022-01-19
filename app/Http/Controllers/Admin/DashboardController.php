<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


// use App\Repositories\Posts\PostRepository;

// use App\Repositories\Products\ProductRepository;

// use App\Repositories\Posts\CategoryRepository;

// use App\Shop\ProductOrderData;

use App\Statistics\BmsStatistic;

use Cube\Html\Menu as HtmlMenu;

class DashboardController extends AdminController
{
    //
    // public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository)
    // {
    //     $this->postRepository = $postRepository;
    //     $this->productRepository = $productRepository;
    //     $this->categoryRepository = $categoryRepository;
    //     $this->stats = new ProductOrderData();

        
    //     HtmlMenu::addActiveKey('admin_menu', 'dashboard');
        
    // }
    

    public function __construct(BmsStatistic $bms)
    {

        $this->bms = $bms;
        HtmlMenu::addActiveKey('admin_menu', 'dashboard');
        
    }
    
    
    public function index(Request $request, $action = null)
    {
        $month = date('m');
        $year  = date('Y');
        $trip_chart = $this->bms->trips->getForwardChartsData(7);
        $stats = $this->bms->getMonthStats($year, $month);
        
        $posts = $this->bms->posts->get(['@orderBy'=>['created_at','DESC'], '@limit'=>6]);
        $categories = $this->bms->categories->getCateWithViews(['@orderBy'=>['views','DESC'], '@limit'=>4]);
        

        $data = compact('stats','trip_chart','posts','categories');
        
        
    	return $this->view('dashboard.index',$data);
    }
}
