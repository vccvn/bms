<?php
namespace App\Shop;

use App\Repositories\Users\UserRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Comments\CommentRepository;

use Carbon\Carbon;


class ProductOrderData{

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->productRepository = new ProductRepository();
        $this->postRepository = new PostRepository();
        $this->commentRepository = new CommentRepository();
    }

    /**
     * get thong ke trong thang
     */
    public function getMonthStats($month=null)
    {
        if(is_null($month)) $month = date('m');
        
        // san pham
        $product_total = $this->productRepository->count();
        $product_month_total = $this->productRepository->count(['@whereMonth' =>['created_at','=',$month]]);
        // san pham
        $post_total = $this->postRepository->count();
        $post_month_total = $this->postRepository->count(['@whereMonth' =>['created_at','=',$month]]);
        // don hang
        $comment_total = $this->commentRepository->count();
        $comment_month_total = $this->commentRepository->count(['@whereMonth' => ['created_at','=',$month]]);
        
        $category_total = $this->categoryRepository->count();
        $category_month_total = $this->categoryRepository->count(['@whereMonth' => ['created_at','=',$month]]);
        
        $user_total = $this->userRepository->count();
        $user_month_total = $this->userRepository->count(['@whereMonth' => ['created_at','=',$month]]);
        
        $view_total = $this->postRepository->first(['@selectRaw'=>'SUM(views) as total']);
        $view_total = $view_total?$view_total->total:0;
        
        $view_month_total = $this->postRepository->first(['@selectRaw'=>'SUM(views) as total','@whereMonth' =>['created_at','=',$month]]);
        $view_month_total = $view_month_total?$view_month_total->total:0;



        $data = compact('product_total', 'product_month_total', 'post_total', 'post_month_total', 
                        'comment_total', 'comment_month_total', 'view_total', 'view_month_total', 
                        'category_total', 'category_month_total', 'user_total', 'user_month_total'
                );

        return $data;
    }

    public function getChartsData($days = 7)
    {
        $data = [];
        if($tm = $this->commentRepository->get([
            // call function
            '@selectRaw' => "count(id) AS total_comment, 
                DAY(created_at) as comment_day, MONTH(created_at) as comment_month, YEAR(created_at) as comment_year, 
                DATE(created_at) AS comment_date",
            // nho hob hoac bang 7 ngay tro lai
            '@where' => ['created_at','>=',Carbon::now()->subDays($days)],
            '@groupByRaW' => 'comment_date',
            '@orderByRaw' => ['comment_date ASC']
        ])){
            $data = $tm;
        }
        return $data;
    }

}