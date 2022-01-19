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

class MenuRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Menu::class;
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
    

    public function getMenu($name=null)
    {
        $main_menu = [];
        if($menu = $this->first(['name'=>$name,'@order_by'=>'priority'])){
            if($m = $menu->toMenuList()){
                $main_menu = $m;
            }
        }
        return $main_menu;

    }
    public function getMainMenu()
    {
        $main_menu = [];
        if($menu = $this->first(['active'=>1,'@order_by'=>'priority'])){
            if($m = $menu->toMenuList()){
                $main_menu = $m;
            }
        }
        return $main_menu;

    }

    public function getMenuBy($field=null,$val=null)
    {
        $args = [];
        if(is_array($field)){
            foreach ($field as $key => $value) {
                if(is_numeric($key)){
                    $args[$value] = $val;
                }else{
                    $args[$key] = $value;
                }
            }
        }
        elseif(is_string($field)){
            $args[$field] = $val;
        }
        $args['@orderBy'] = ['priority','ASC'];
        $main_menu = [];
        if($menu = $this->first($args)){
            if($m = $menu->toMenuList()){
                $main_menu = $m;
            }
        }
        return $main_menu;
    }

    public function filter($request){
        // filter
        $orderby = ['priority'=>'ASC'];
        $args = [
            // search
            '@search' => [
                'keyword' => $request->s,
                'by' => ['name', 'data'],
            ],

            // endsearch
            '@order_by' => $orderby,
            '@paginate' => ($request->perpage ? $request->perpage : 10),
            'status' => 200
        ];
        $list = $this->get($args);
        $list->withPath('?' . parse_query_string(null, $request->all()));
        return $list;
    }

}