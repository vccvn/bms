<?php

namespace App\Repositories\Products;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

class OrderRepository extends EloquentRepository
{
    

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }
    
    public function addOrder($data = [], $cart = [])
    {
        //
        $order = $this->p;
    }
}