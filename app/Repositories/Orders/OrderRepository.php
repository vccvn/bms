<?php

namespace App\Repositories\Orders;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Product;
use App\Models\OrderProduct;

use App\Models\PostProductLink;
class OrderRepository extends EloquentRepository
{
    

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Order::class;
    }
    
    
    // lay ra danh sach order

    public function filter($request, $args = [])
    {
        
        
        
        
        $a = (array) $args;
        $p = [
            '@search' => [
                'keywords' => $request->s,
                'by' => ['name','email','phone_number']
            ],
            '@paginate' => $request->perpage?$request->perpage:10,
        ];
        if($request->sortby){
            $p['@order_by'] = [$request->sortby=>$request->sorttype];
        }else{
            $p['@order_by'] = ['created_at'=>'DESC'];
        }
        $actions = [];
        if($request->from_date && isDate($request->from_date)){
            $actions[] = ['whereRaw', "DATE(created_at) >= '$request->from_date'"];
        }
        if($request->to_date && isDate($request->to_date)){
            $actions[] = ['whereRaw', "DATE(created_at) <= '$request->to_date'"];
        }
        if($actions){
            $p['@actions'] = $actions;
        }
         return $this->get(array_merge($p,$a));
             
        
    }



    public function addOrder($request, $cart_data = [])
    {
        $data = $request->all();
        $data['total_money'] = isset($cart_data['total_money'])?$cart_data['total_money']:0;
        if($m = $this->save($data)){
            foreach($cart_data['products'] as $p){
                $op = new OrderProduct();
                $op->fill([
                    'order_id' => $m->id,
                    'product_id' => $p['id'],
                    'product_qty' => $p['qty'],
                    'date_price' => $p['price']?$p['price']:0
                ]);
                $op->save();
            }
            return $m;
        }
        return false;
    }

    
    public function changeStatus($id, $status = null)
    {
        if($id && in_array($status,[-1,0,300,600])){
            if($m = $this->find($id)){
                $m->status = $status;
                $m->save();
                return true;
            }
        }
        return false;
    }

    public function getProductData($id)
    {
        $products = [];
        if($o = $this->find($id)){
            if(count($o->orderProduct)){
                foreach ($o->orderProduct as $p) {
                    if($p->detail){
                        $pd = $p->detail;
                        $pr = (int) $p->date_price;
                        $products[] = [
                            'name' => $pd->name,
                            'link' => $pd->getViewUrl(),
                            'image' => $pd->getFeatureImage(),
                            'qty' => $p->product_qty,
                            'price' => number_format($pr,0, ',', '.'),
                            'total_price' => number_format($p->product_qty*$pr,0, ',', '.')
                        ];
                    }
                }
            }
        }
        return $products;
    }



}