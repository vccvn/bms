<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ProductCategoryRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Pages\PageRepository;
use App\Repositories\Users\UserRepository;

use Illuminate\Http\Response;

use View;
class SitemapController extends Controller
{
    public function __construct(CategoryRepository $CategoryRepository, ProductRepository $ProductRepository, PostRepository $PostRepository, PageRepository $PageRepository, ProductCategoryRepository $ProductCategoryRepository)
    {
        $this->categoryRepository = $CategoryRepository;
        $this->productRepository = $ProductRepository;
        $this->postRepository = $PostRepository;
        $this->pageRepository = $PageRepository;
        $this->productCategoryRepository = $ProductCategoryRepository;
    }

    public function index(Request $request)
    {
        $pages = $this->pageRepository->get(['status'=>200]);
        $posts = $this->postRepository->get(['status'=>200]);
        $products = $this->productRepository->get(['status'=>200]);
        $product_categories = $this->productCategoryRepository->get(['status'=>200]);
        $categories = $this->categoryRepository->get(['status'=>200]);
        
        $data = compact('pages','posts','products','categories', 'product_categories');
        // return view('sitemap.sitemap', $data)->header('content');
        $content = View::make('sitemap.sitemap')->with($data);
        $response = response($content, '200');
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

}
