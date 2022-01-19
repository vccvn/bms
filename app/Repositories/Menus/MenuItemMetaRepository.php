<?php

namespace App\Repositories\Menus;

/**
 * @created doanln  2018-01-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuItemMeta;
use App\Models\Category;


class MenuItemMetaRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\MenuItemMeta::class;
    }
    
    protected static $activeID = 0;

    public function setActiveID($id = null)
    {
        if($id){
            self::$activeID = $id;
        }
    }

    public function getActiveID()
    {
        return self::$activeID;
    }


   public function setID($id=null)
    {
        self::setActiveID($id);
        $this->_model->setID($id);
    } 
    public function updatePriority($id, $priority=0)
    {
        if($model = $this->find($id)){
            $model->updatePriority($priority);
        }
    }
    

}