<?php

namespace App\Repositories\Posts;

/**
 * @created doanln  2018-05-27
 */
use App\Repositories\Categories\BaseCategoryRepository;

class CategoryRepository extends BaseCategoryRepository
{

    public function __construct()
    {
        parent::__construct();
        
        $this->addDefaultParam('type','post');
        $this->addDefaultValue('type','post');
    }
}