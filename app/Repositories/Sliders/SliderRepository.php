<?php

namespace App\Repositories\Sliders;

/**
 * @created doanln  2018-04-08
 */
use App\Repositories\EloquentRepository;

class SliderRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Slider::class;
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

    public function getSlider($pos = 100, $args =[])
    {
        $posArr = $this->_model::getPositionData();
        $p = 0;
        $arrPos = array_flip($posArr);
        $k = ucfirst(strtolower($pos));
        if(in_array($pos,$arrPos)){
            $p = $pos;
        }elseif(array_key_exists($k, $arrPos)){
            $p = $arrPos[$k];
        }
        if($p){
            $args = (array) $args;
            return $this->first(array_merge(['status'=>200, 'position'=>$p,'@orderBy'=>['priority','ASC']], $args));
        }
        return null;
    }
}
