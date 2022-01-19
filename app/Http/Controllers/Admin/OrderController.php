<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\Orders\OrderRepository;

use Cube\Html\Menu as HtmlMenu;


class OrderController extends AdminController
{
	public $module = 'order';
	public $route = 'admin.order';
	public $folder = 'orders';

    public function __construct(OrderRepository $orderRepository)
    {
        $this->repository = $orderRepository;
        HtmlMenu::addActiveKey('admin_menu','order');
    }

    /**
     * hien thi danh sach
     * @param  Request $request [description]
     * @return view             [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
        return $this->view('order.list',compact('list'));
    }


    /**
     * hien thi danh sach
     * @param  Request $request [description]
     * @return view             [description]
     */
    public function listStatus(Request $request, $slug=null)
    {
        $ls = ['cancelled' => '-1', "newest" => 0, 'processing' => 300, 'completed' => 600];
        $args = [];
        $s = strtolower($slug);
        if(array_key_exists($s, $ls)){
            $args['status'] = $ls[$s];
        };
        $list = $this->repository->filter($request, $args);
        return $this->view('order.list',compact('list', 'slug'));
    }


    /**
     * hien thi chi tiet
     * @param  int       $id          id cua don hang
     * @return view
     */
    public function detail($id)
    {
        if(!($order = $this->find($id)))
            return $this->view('errors.404');
        return $this->view($this->module . '.detail',compact('order'));
    }


    public function changeStatus(Request $request)
    {
        $status = false;
        $order = null;
        if($request->id && in_array($request->status,[-1,0,300,600])){
            if($s = $this->repository->changeStatus($request->id,$request->status)){
                $status = true;
                $order = $this->repository->find($request->id);
            }
        }
        return response()->json(compact('status','order'));
    }

    public function getOrderData(Request $request)
    {
        $status = false;
        $order = null;
        if($request->id && $o = $this->repository->find($request->id)){
            $status = true;
            $o->products = $this->repository->getProductData($request->id);
            $order = $o;

        }
        return response()->json(compact('status','order'));
    }


}
