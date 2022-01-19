<?php

namespace App\Repositories\Products;

/**
 * @created doanln  2018-01-27
 */

use App\Repositories\Categories\BaseCategoryRepository;

class ProductCategoryRepository extends BaseCategoryRepository
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setType('product');
    }


    /**
     * create and update properties
     * @param int        $id           the id of category
     * @param array      $props        array of properties
     * 
     * @return void
     */
    public function saveProps(int $id, array $props = [])
    {
        if($model = $this->find($id)){
            $model->saveProps($props);
        }
    }
}