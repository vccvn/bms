<?php

namespace Cube\Html;

use Cube\Files;

use URL;

class Menu extends HtmlObject
{
    protected $_data = [
        'menu_tag' => 'ul',
        'sub_tag' => 'ul',
        'sub_item_tag' => 'li',
        'sub_id' => "",
        'sub_class' => "",
        'sub_attrs' => [],
        
        // item
        'item_tag' => 'li',
        'item_active_class' => 'active',
        'item_class' => '',
        'use_active_key' => false,
        'item_attrs' => [],
        'has_sub_class' => '',
        'has_sub_active_class' => '',
        
        'sub_item_class' => '',
        'sub_item_active_class' => 'active',
        'sub_link_class' => '',
        'sub_link_active_class' => 'active',
        'sub_link_attrs' => [],
        
        // link attr
        'link_attrs' => [],
        'link_class' => '',
        'link_active_class' => '',
    
        // icon
        'use_icon' => false,
        'icon_tag' => 'i',
        'icon_class' => '',
        
        'icon_prefix_class' => 'fa fa-',
        'icon_attrs' => [],
    ];

    
    protected $orginalData = [];

    protected static $active_keys = [];
    protected $menu = [];
    public $active_name = null;

    protected static $active_url = null;

    protected $actions = [];

    protected $_children = [];

     /**
     * khoi tao form group
     */
    protected $menuData = [];
    public function __construct($menu = null, $options=[], $active_name='menu')
    {
        $this->menu = $menu;
        $this->active_name = $active_name;
        if(!self::$active_url) self::$active_url = URL::full();
        
        if(is_array($options)){
            parent::__construct(isset($options['menu_tag'])?$options['menu_tag']:(isset($options['tag'])?$options['tag']:'ul'));
            $this->orginalData = $options;
            $this->setOption($options);
        }
        $this->checkMenuData();
        $this->prepare();
    }
    public function checkMenuData()
    {
        if(!$this->menuData){
            if($this->menu && $menuList = $this->getMenuList()){
                $this->menuData = $menuList;
                return true;
            }
            return false;
        }
        return true;
    }
    public function getMenuList()
    {
        $menuList = [];
        $menu = Helper::toArray($this->menu);
        $t = isset($menu['type'])?strtolower($menu['type']):null;
        if($t=='json'){
            if(!isset($menu['file'])) return null;
            $files = new Files();
            $files->cd('json/menus');
            if($data = $files->getJSON($menu['file'])){
                $menuList = Helper::toArray($data);
            }
            
        }elseif($t == 'define'){
            $c = null;
            if(isset($menu['call'])){
                $c = $menu['call'];
            }elseif(isset($menu['func'])){
                $c = $menu['func'];
            }elseif(isset($menu['method'])){
                $c = $menu['method'];
            }

            if($c && is_callable($c)){
                $a = isset($menu['param'])?$menu['param']:(isset($menu['args'])?$menu['args']:[]);
                if($d = $c($a)){
                    $menuList = Helper::oArray($d);
                }
                
            }
        }
        elseif($t == 'list'){
            $menuList = isset($menu['list'])?$menu['list']:(
                isset($menu['data'])?$menu['data']:(
                    isset($menu['items'])?$menu['items']:(
                        []
                    )
                )
            );

        }elseif(isset($menu[0])){
            $menuList = $menu;
        }
        return $menuList;
    }

    public function prepare($action=null)
    {
        if($this->checkMenuData()){
            $this->addAction($action);
            $menuList = $this->menuData;
            $d = $this->_data;
            $i = 0;
            $total = count($menuList);
            foreach($menuList as $k => $v){
                $item = new MenuItem($v,[
                    'tag' => $d['item_tag'],
                    'active_name' => $this->active_name,
                    'attrs' => $d['item_attrs'],
                    'class' => $d['item_class'],
                    'active_class' => $d['item_active_class'],
                    'has_sub_class' => $d['has_sub_class'],
                    'has_sub_active_class' => $d['has_sub_active_class'],
                    
                    'link_class' => $d['link_class'],
                    'link_attrs' => $d['link_attrs'],
                    'link_active_class' => $d['link_active_class'],
                    
                    'use_icon' => $d['use_icon'],
                    'icon_tag' => $d['icon_tag'],
                    'icon_prefix_class' => $d['icon_prefix_class'],
                    'icon_class' => $d['icon_class'],
                    'icon_attrs' => $d['icon_attrs'],
                    
                    'sub_tag' => $d['sub_tag'],
                    'sub_id' => $d['sub_id'],
                    'sub_class' => $d['sub_class'],
                    'sub_attrs' => $d['sub_attrs'],
                    
                    'sub_item_tag' => $d['sub_item_tag'],
                    'sub_item_class' => $d['sub_item_class'],
                    'sub_item_active_class' => $d['sub_item_active_class'],

                    'sub_link_class' => $d['sub_link_class'],
                    'sub_link_active_class' => $d['sub_link_active_class'],
                    'sub_link_attrs' => $d['sub_link_attrs'],
                    
                    
                    'total' => $total,
                    'index' => $i,
                ]);
                //$item->addAction($this->actions);
                $this->_children[] = $item;
                
                $this->append($item);
                $i++;
            }
        
        }
    }
    public function render($action = null)
    {
        $this->addAction($action);

        if($this->_children){
            foreach($this->_children as $child){
                if(is_a($child,MenuItem::class)){
                    $child->addAction($this->actions);
                }
            }
        }
        
        return parent::render();
    }

    public function addAction($action=null)
    {
        if(is_callable($action)){
            $this->actions[] = $action;
        }elseif(is_array($action)){
            foreach($action as $act){
                if(is_callable($act)){
                    $this->actions[] = $act;
                }
            }
        }
        return $this;
    }


    /**
     * set key active menu
     * @param string $name tên key
     * @param string $active_key  gia tri key
     */

    public static function addActiveKey($name='default', $active_key = null){
        self::$active_keys[$name] = $active_key;
    }
    public static function checkActiveKey($name, $active_key=null)
    {
        if(is_string($name) && isset(self::$active_keys[$name])){
            $key = self::$active_keys[$name];
            if($active_key && $active_key == $key){
                return true;
            }
        }
        return false;
    }

    
    public static function checkActiveURL($url = null)
    {
        if(!$url || !is_string($url)) return false;
        if(self::$active_url){
            $url = strtolower($url);
            $active_url = strtolower(self::$active_url);
            $ua = explode('?',$active_url);
            $uc = explode('?',$url);

            if($active_url == $url){
                return true;
            }
            
            $ucc = trim($url,'?');
            if(count($ua)==2 && $ua[0] == $ucc){
                return true;
            }


            if(count($ua)==2 && count($uc)==2 ){
                parse_str($ua, $ap);
                parse_str($uc, $up);
                if($up && $ap){
                    foreach($up as $k => $v){
                        if(!isset($ap[$k]) || strtolower($ap[$k]) != strtolower($v)){
                            return false;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    protected function setOpt($name,$value=null)
    {
        $n = strtolower($name);
        if (array_key_exists($n, $this->_data)) {
            $this->_data[$n] = $value;
            
            if($n=='menu_class' || $n=='class' || $n=='classname'){
                return $this->addClass($value);
            }
            if($name=='menu_attrs' || $name=='attrs'){
                return $this->attr($value);
            }
        }elseif($n=='menu_class' || $n=='class' || $n=='classname'){
            return $this->addClass($value);
        }elseif($n=='tag' || $n=='menu_tag' || $n=='item_tag' || $n=='icon_tag'){
            $this->_data[$n] = $value;
        }
        else{
            return $this->attr($name,$value);
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
