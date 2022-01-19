<?php

namespace App\Repositories\Permissions;

use App\Repositories\EloquentRepository;


class ModuleRoleRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ModuleRole::class;
    }    
}