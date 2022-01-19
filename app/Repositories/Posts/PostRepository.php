<?php

namespace App\Repositories\Posts;

/**
 * @created doanln  2018-10-27
 */
class PostRepository extends BasePostRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->settype('post');
    }
}