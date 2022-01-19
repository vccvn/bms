<?php

namespace App\Statistics;

use App\Repositories\Users\UserRepository;
use App\Repositories\Categories\BaseCategoryRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Dynamic\DynamicRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Comments\CommentRepository;
use App\Repositories\Contacts\ContactRepository;
use App\Repositories\Subcribers\SubcriberRepository;
use App\Repositories\Buses\BusRepository;
use App\Repositories\Companies\CompanyRepository;
use App\Repositories\Routes\RouteRepository;
use App\Repositories\Trips\TripRepository;

class Statistic
{
    public $categories;
    public $posts;
    public $pages;
    public $dynamics;
    public $products;
    public $comments;
    public $orders;
    public $contacts;
    public $subcribers;
    public $users;




    public $bus;
    public $companies;
    public $routes;
    public $trips;

    function __construct()
    {
        $this->users             = new UserRepository();
        $this->categories        = new BaseCategoryRepository();
        $this->posts             = new PostRepository();
        $this->dynamics          = new DynamicRepository();
        $this->products          = new ProductRepository();
        $this->orders            = new OrderRepository();
        $this->comments          = new CommentRepository();
        $this->contacts          = new ContactRepository();
        $this->subcribers        = new SubcriberRepository();
        $this->bus               = new BusRepository();
        $this->companies         = new CompanyRepository();
        $this->routes            = new RouteRepository();
        $this->trips             = new TripRepository();


    }
}


?>