<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\Products\ProductRepository;

use App\Repositories\Menus\MenuRepository;

use App\Repositories\Orders\OrderRepository;

use App\Repositories\Users\UserRepository;

use App\Http\Requests\Orders\OrderRequest;

use App\Shop\ShoppingCart;

use Cube\Html\Menu as HtmlMenu;

use Cube\Email;

use Cookie;

use Auth;

use App\Jobs\SendOrderNoitificationEmailToAdmin;
use App\Jobs\SendOrderNoitificationEmailToClient;

class CartController extends ClientController
{
    public $module = 'cart';
    public $route = 'client.cart';
    public $folder = 'cart';

    public function __construct(ProductRepository $ProductRepository, OrderRepository $OrderRepository)
    {
        parent::__construct();
        $this->productRepository = $ProductRepository;
        $this->shoppingCart = new ShoppingCart();
        $this->shoppingCart->check();
        $this->orderRepository = $OrderRepository;

        HtmlMenu::addActiveKey('main_menu',$this->module);
    }

    public function index()
    {
        $this->shoppingCart->check();
        //
    }
    public function viewCart(Request $request)
    {
        $this->shoppingCart->check();
        $cart_data = $this->shoppingCart->getCart();
        $home_slider = get_slider('home');
        return $this->view('cart.index', compact('cart_data','home_slider'));
    }

    public function checkout(Request $request)
    {
        $this->shoppingCart->check();
        $cart_data = $this->shoppingCart->getCart();
        
        $home_slider = get_slider('home');
        return $this->view('cart.checkout', compact('cart_data','home_slider'));
    }

    public function placeOrder(OrderRequest $request)
    {
        $this->shoppingCart->check();
        $cart = $this->shoppingCart->getCart();
        if($order = $this->orderRepository->addOrder($request, $cart)){
            // xóa giỏ hàng
            if($request->create_account){
                $ur = new UserRepository();
                if(!$ur->findBy('email', $request->email)){
                    $data = $request->all();
                    $data['password'] = substr(md5(microtime()), 8, 8);
                    if($user = $ur->save($data)){
                        // 
                    }
                }
            }
            $data = $request->all();
            $status = true;
            
            // gui mail thong bao
            //$cllentContent = view('mail.noitifications.order-client',  compact('order'))->render();

            //SendOrderNoitificationEmailToClient::dispatch($order->email, $cllentContent)->delay(now()->addMinutes(1));
            //SendOrderNoitificationEmailToAdmin::dispatch($order)->delay(now()->addMinutes(2));
            $email = $this->setting->email_get_data?$this->setting->email_get_data:'doanln16@gmail.com';
            $admin = $email;
            Email::from($this->siteinfo->email, $this->siteinfo->site_name)
                    ->to($email, 'Quản trị viên') // doviethieulc@gmail.com
                    ->subject('Thông báo: Có người Đặt hàng')
                    ->body('mail.noitifications.order')
                    ->data(compact('admin', 'order'))
                    ->send();
            Email::from($this->siteinfo->email, $this->siteinfo->site_name)
                    ->to($order->email, $order->name) // doviethieulc@gmail.com
                    ->subject('Bạn vừa đặt hàng thành công trên website '.$this->siteinfo->site_name)
                    ->body('mail.noitifications.order-client')
                    ->data(compact('order'))
                    ->send();
            
            $msg = $this->setting->order_alert_message?str_replace(["\r", "\n"], "", nl2br($this->setting->order_alert_message)):"Chúc mừng bạn đã đặt hàng thành công!<br>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất";
            $this->shoppingCart->removeAll();
            $url = route('client.alert');
            if(in_array($request->payment_method, [1, 2])){
                $url = $request->payment_method == 2 ?'/phuong-thuc-thanh-toan/thanh-toan-truc-tuyen.html':"/phuong-thuc-thanh-toan/cod.html";
                return redirect($url)->withCookie(cookie('shopping_cart',null,-1))->with(['type'=>'success','alert_message' => $msg]);
            }


            return redirect($url)->withCookie(cookie('shopping_cart',null,-1))->with(['type'=>'success','message' => $msg]);
        }
        return redirect()->route('client.alert.error')
                        ->with([
                            'message' => 'Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại trong giây lát'
                        ]);

    }

    public function addItem(Request $request)
    {
        $this->shoppingCart->check();
        $status = false;
        if($this->shoppingCart->addItem($request->id, $request->properties, $request->qty)){
            $status = true;
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;  
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }


    public function updateItem(Request $request)
    {
        $this->shoppingCart->check();
        $status = false;
        if($this->shoppingCart->updateItem($request->id, $request->properties, $request->qty)){
            $status = true;
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }

    public function updateItemByKey(Request $request)
    {
        $this->shoppingCart->check();
        $status = false;
        if($this->shoppingCart->updateByKey($request->key, $request->qty)){
            $status = true;
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }


    public function updateItems(Request $request)
    {
        $this->shoppingCart->check();
        $status = true;
        if($request->products && is_array($request->products)){
            $status = false;
            if($this->shoppingCart->updateItems($request->products)){
                $status = true;
            }
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }


    public function updateCart(Request $request)
    {
        $this->shoppingCart->check();
        $status = true;
        if($request->products && is_array($request->products)){
            $status = false;
            foreach($request->products as $key => $qty){
                if($this->shoppingCart->updateByKey($key, $qty)){
                    $status = true;
                }
            }
            
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }


    public function removeItem(Request $request)
    {
        $this->shoppingCart->check();
        $status = false;
        if($this->shoppingCart->removeItem($request->key)){
            $status = true;
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $cart['remove_key'] = $request->key;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }

    public function removeItemById(Request $request)
    {
        $this->shoppingCart->check();
        $status = false;
        if($this->shoppingCart->removeItemById($request->id)){
            $status = true;
        }
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        $cart['remove_key'] = $request->key;
        $response = new Response($cart);
        $response->withCookie(cookie('shopping_cart',$this->shoppingCart->toCartData(),60*24*365));
        return $response;
    }

    public function removeAll()
    {
        $this->shoppingCart->check();
        $response = new Response(['status' => true]);
        $response->withCookie(cookie('shopping_cart',null,-60*24*365));
        return $response;
    }

    public function refresh()
    {
        $this->shoppingCart->check();
        $status = true;
        $cart = $this->shoppingCart->getCart();
        $cart['status'] = $status;
        
        return response($cart);
    }

    
}
