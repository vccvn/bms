<?php
namespace App\Shop;


use Cookie;
use App\Repositories\Products\ProductRepository;

class ShoppingCart{
    
    public static $cart = [];

    protected $products = null;
    public function __construct()
    {
        $this->products = new ProductRepository();
        self::$cart = $this->getCartData();

    }

    /**
     * kiem tra cart
     * @return void
     */
    public function check()
    {
        if(!$this->products){
            $this->products = new ProductRepository();
        }
        if(!self::$cart){
            self::$cart = $this->getCartData();
        }
    }

    /**
     * tạo key từ id và mảng property_ids
     */
    public function keyEncode($id, $property_ids = [])
    {
        $p = is_array($property_ids)?$property_ids:[];
        if(count($p)){
            return $id.="_".implode('-',$p);
        }
        return $id;
    }

    /**
     * tai key thành mảng ID và properties
     */
    public function keyDecode($key)
    {
        $data = ['id'=>null,'properties'=>[]];
        if($key && count($a = explode('_',$key))){
            $data['id'] = $a[0];
            if(count($a)>=2){
                $data['properties'] = explode('-',$a[1]);
            }
        }
        return $data;
    }

    /**
     * ham lay mang key => quantity
     * @return array         mang cart
     */
    public function getCartData()
    {
        $cartstr = Cookie::get('shopping_cart');
        $cart = [];
        if($cartstr){
            if(count($a = explode(',', $cartstr))){
                foreach($a as $b){
                    if(count($c = explode(':',$b))==2){
                        $cart[$c[0]] = $c[1];
                    }
                }
            }
        }
        return $cart;
    }
    /**
     * kiem tra data
     * lay du lieu tu cookie cho vao lop shoppingCart
     */
    public static function checkData()
    {
        if(!self::$cart){
            $cartstr = Cookie::get('shopping_cart');
            $cart = [];
            if($cartstr){
                if(count($a = explode(',', $cartstr))){
                    foreach($a as $b){
                        if(count($c = explode(':',$b))==2){
                            $cart[$c[0]] = $c[1];
                        }
                    }
                }
            }
            self::$cart = $cart;
        }
        return true;
    }

    /**
     * lay so luong san pham thong qua key
     * @param string $key            key duoc tao tu id va property id
     */
    public static function getQty($key)
    {
        self::checkData();
        if(isset(self::$cart[$key])) return self::$cart[$key];
        return 0;
    }

    /**
     * bien mang du lieu thanh chuoi de luu cookie
     * @param array $data             Mang [key=>value] key duoc tao tu id va property id
     */

    public function toCartData($data=[])
    {
        $str = '';
        if(!$data){
            $data = self::$cart;
        }
        if(is_array($data)){
            foreach($data as $i => $q){
                $str.=",$i:$q";
            }
            $str = trim($str,',');
        }
        return $str;
    }

    /**
     * goi ham nhanh tu biem doi tuong thanh chuoi value cookie
     */
    public function __toString()
    {
        return $this->toCartData(self::$cart);
    }

    /**
     * lam moi gio hang
     * @return void
     */
    public function refresh()
    {
        $cart = [];
        $data = self::$cart;
        $ids = [];
        foreach ($data as $key => $qty) {
            if(count($arrIdProp = explode('-',$key))){
                if(in_array($arrIdProp[0],$ids) || $this->products->find($arrIdProp[0])){
                    $cart[$key] = $qty;
                    if(!in_array($arrIdProp[0],$ids)){
                        $ids[] = $arrIdProp[0];
                    }
                }
            }
        }
        self::$cart = $cart;
        Cookie::queue('shopping_cart', $this, 60*24*365);
        return $cart;
    }

    /**
     * lay du lieu gio hang
     * @return array          $mang
     * @comment array(
     * total_qty       =>     tổng số sản phẩm trong giỏ hàng
     * qty             =>     số sàn phẩm
     * total_money     =>     Tổng số tiền
     * products        =>     Danh sách sản phẩm
     * )
     */
    public function getCart()
    {
        $t = 0;
        $tm = 0;
        $total_qty = 0;
        $products = [];
        $data = self::$cart;
        if($data){
            $ids = [];
            $product_list = [];
            $cart_data = [];
            $keys = [];

            foreach ($data as $key => $qty) {
                $pdata = $this->keyDecode($key);
                $id = $pdata['id'];
                $properties = $pdata['properties'];
                $keys[] = $key;
                $cart_data[$key] = [
                    'id' => $id,
                    'properties' => $properties,
                    'qty' =>$qty
                ];
                if(!in_array($id, $ids)){
                    $ids[] = $id;
                }

            }
            
            if($list = $this->products->get(['@whereIn'=>['id', $ids]])){
                foreach($list as $p){
                    $product_list[$p->id] = $p;
                }
            }
            
            foreach ($cart_data as $key => $item) {
                
                if(isset($product_list[$item['id']])){
                    $p = $product_list[$item['id']];
                    $qty = $item['qty'];
                    $q = $qty;
                    if($q>0){
                        $total_qty += $qty;
                        $t++;
                        $pr = $p->sale_price;
                        $tp = $pr*$q;
                        $tm+=$tp;
                        $props = [];
                        if(count($properties)){
                            if(count($pp = $p->getProperties($properties))){
                                foreach($pp as $v){
                                    $props[] = [
                                        'id' => $v->id,
                                        'name' => $v->name,
                                        'value' => $v->value
                                    ];
                                }
                            }

                        }
                        $products[] = [
                            'key' => $key,
                            'id' => $p->id,
                            'name' => $p->name,
                            'image' => $p->getFeatureImage('90x90'),
                            'link' => $p->getViewUrl(),
                            'props' => $props,
                            'price' => $pr,
                            'qty' => $q,
                            'total_price' => $tp,
                            'properties' => $properties
                        ];
                    }
                }else{
                    unset(self::$cart[$key]);
                }
            }
        }
        return ['total_qty' =>$total_qty, 'qty' => $t, 'total_money' => $tm, 'products'=>$products];
    }
    /**
     * lay du lieu gio hang
     * @return array          $mang
     * @comment array(
     * total_qty       =>     tổng số sản phẩm trong giỏ hàng
     * qty             =>     số sàn phẩm
     * total_money     =>     Tổng số tiền
     * products        =>     Danh sách sản phẩm
     * )
     */
    public function getSimpleCart()
    {
        $t = 0;
        $tm = 0;
        $total_qty = 0;
        $products = [];
        $data = self::$cart;
        if($data){
            $ids = [];
            $product_list = [];
            $cart_data = [];
            $keys = [];

            foreach ($data as $key => $qty) {
                $pdata = $this->keyDecode($key);
                $id = $pdata['id'];
                $properties = $pdata['properties'];
                $keys[] = $key;
                $cart_data[$key] = [
                    'id' => $id,
                    'properties' => $properties,
                    'qty' =>$qty
                ];
                if(!in_array($id, $ids)){
                    $ids[] = $id;
                }

            }
            
            if($list = $this->products->get(['@whereIn'=>['id', $ids]])){
                foreach($list as $p){
                    $product_list[$p->id] = $p;
                }
            }
            
            foreach ($cart_data as $key => $item) {
                
                if(isset($product_list[$item['id']])){
                    $p = $product_list[$item['id']];
                    $qty = $item['qty'];
                    $q = $qty;
                    if($q>0){
                        $total_qty += $qty;
                        $t++;
                        $pr = $p->price;
                        $tp = $pr*$q;
                        $tm+=$tp;
                        
                    }
                }else{
                    unset(self::$cart[$key]);
                }
            }
        }
        return ['total_qty' =>$total_qty, 'qty' => $t, 'total_money' => $tm, 'products'=>$products];
    }
    
    
    public function addItem($id=null, $properties=[], $qty=null)
    {
        $stt = false;
        if($id && $product = $this->products->find($id)){
            $stt = true;
            $qty = $qty?$qty:1;
            $key = $this->keyEncode($id, $properties);
            if(isset(self::$cart[$key])){
                self::$cart[$key]+= $qty;
            }else{
                self::$cart[$key] = $qty;
            }
        }
        
        return $stt;
    }
    
    public function updateByKey($key=null, $qty = null)
    {
        if(!$key) return false;
        if($qty<1){
            unset(self::$cart[$key]);
            return false;
        }
        self::$cart[$key] = $qty;
        return true;
    }

    public function updateItem($id=null, $properties=[], $qty=null)
    {
        $stt = false;
        if($id && $p = $this->products->find($id)){
            $stt = true;
            $qty = (!is_null($qty) && is_numeric($qty))?((int)$qty):0;
            $key = $this->keyEncode($id, $properties);
            if($qty<1){
                unset(self::$cart[$key]);
                return $stt;
            }
            self::$cart[$key] = $qty;
        }
        return $stt;
    }

    public function updateItems($data = [])
    {
        $stt = false;
        if(is_array($data)){
            foreach($data as $prod)
            {
                if($this->updateItem(isset($prod['id'])?$prod['id']:0,isset($prod['properties'])?$prod['properties']:[], isset($prod['qty'])?$prod['qty']:0)) $stt = true;
            }
        }
        return $stt;
    }

    public function removeItem($key = null)
    {
        unset(self::$cart[$key]);
        return true;
    }

    public function removeById($id=null)
    {
        if(!is_null($id)){
            $data = self::$cart;
            if($data){
                foreach ($data as $key => $qty) {
                    $pdata = $this->keyDecode($key);
                    $pid = $pdata['id'];
                    if($pid == $id){
                        unset(self::$cart[$key]);
                    }
                }
            }
        }
        Cookie::queue('shopping_cart', $this, 60*24*365);
    }
    public function removeAll()
    {
        self::$cart = [];
        Cookie::queue('shopping_cart', null, -1);
    }
    
}
?>