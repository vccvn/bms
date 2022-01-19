<?php

namespace App\Repositories\Permissions;
/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;


class UserRoleRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\UserRole::class;
    }    
}