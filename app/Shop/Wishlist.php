<?php
namespace App\Shop;


use Cookie;

use App\Repositories\Products\ProductRepository;

class Wishlist{
    public $wishlist = [];
    protected $products = null;
    public function __construct()
    {
        $this->products = new ProductRepository();
        $this->wishlist = $this->getWishlistData();
    }

    public function check()
    {
        if(!$this->products){
            $this->products = new ProductRepository();
        }
        if(!$this->wishlist){
            $this->wishlist = $this->getWishlistData();
        }
    }

    public function getWishlistData()
    {
        $wishliststr = Cookie::get('wishlist');
        $wishlist = [];
        if($wishliststr){
            if(count($a = explode(',', $wishliststr))>0){
                foreach($a as $b){
                    if(is_numeric($b)){
                        $wishlist[] = $b;
                    }
                }
            }
        }
        return $wishlist;
    }

    public function toWishlistData($data=[])
    {
        $str = '';
        if(!$data){
            $data = $this->wishlist;
        }
        if(is_array($data)){
            $str = implode(',',$data);
        }
        return $str;
    }

    public function __toString()
    {
        return $this->toWishlistData($this->wishlist);
    }

    public function refresh()
    {
        $wishlist = [];
        $data = $this->wishlist;
        if($data){
            $data = array_unique($data);
            if(count($list = $this->products->get(['@whereIn'=>['id',$data]]))){
                foreach($list as $p){
                    $wishlist[] = $p->id;
                }
            }
            
        }
        $this->wishlist = $wishlist;
        Cookie::queue('wishlist', $this, 60*24*365);
        return $wishlist;
    }

    public function getWishlist()
    {
        $t = 0;
        $products = [];
        $data = $this->wishlist;
        if($data){
            $data = array_unique($data);
            if(count($list = $this->products->get(['@whereIn'=>['id',$data]]))){
                foreach($list as $p){
                    $t++;
                    $products[] = [
                        'id' => $p->id,
                        'name' => $p->name,
                        'image' => $p->getFeatureImage(),
                        'link' => $p->getDetailUrl(),
                        'price' => $p->sale_price,
                    ];
                }
            }
        }
        return ['total'=>$t,'products'=>$products];
    }


    public function getProducts($args=[])
    {
        $data = $this->wishlist;
        if($data){
            if(!is_array($args)){
                $args = [];
            }
            $args['@whereIn'] = ['id',$data];

        }else{
            $args['cate_id'] = -10;
        }
        $products = $this->products->get($args);
        return $products;
    }

    public function addItem($id=null)
    {
        $stt = false;
        if($id && $product = $this->products->find($id)){
            $stt = true;
            if(!in_array($id, $this->wishlist)){
                $this->wishlist[] = $id;
                $product->likeUp();
            }
        }
        return $stt;
    }


    public function removeItem($id = null)
    {
        if(is_numeric($id)){
            $newArr = [];
            if(is_array($this->wishlist)){
                $a = array_flip($this->wishlist);
                if(isset($a[$id]) && $product = $this->products->find($id)){
                    unset($a[$id]);
                    $this->wishlist = array_keys($a);
                    $product->likeDown();
                }
            }
            
        }
        return true;
    }
    public function removeAll()
    {
        $this->wishlist = [];
        Cookie::queue('wishlist', null, -1);
    }
    
}
?>