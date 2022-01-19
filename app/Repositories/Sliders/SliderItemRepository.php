<?php

namespace App\Repositories\Sliders;

/**
 * @created doanln  2018-04-08
 */
use App\Repositories\EloquentRepository;

class SliderItemRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\SliderItem::class;
    }

    protected static $activeID = 0;

    public function setActiveID($id = null)
    {
        if ($id) {
            self::$activeID = $id;
        }
    }

    public function getActiveID()
    {
        return self::$activeID;
    }

    public function setID($id = null)
    {
        self::setActiveID($id);
        $this->_model->setID($id);
    }
    public function updatePriority($id, $priority = 0)
    {
        if ($model = $this->find($id)) {
            return $model->updatePriority($priority);
        }
        return false;
    }

    
    public function deleteFeatureImage($id=null)
    {
        if($model = $this->find($id)){
            return $model->deleteFile();
        }
        return false;
    }

}
