<?php
namespace App\History;


use Cookie;


class History{
    public $history = [];
    public function __construct()
    {
        $this->history = $this->getWishlistData();
    }

    public function check()
    {
        if(!$this->history){
            $this->history = $this->getWishlistData();
        }
    }

    public function getWishlistData()
    {
        $wishliststr = Cookie::get('history');
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

    
}
?>