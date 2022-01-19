<?php

namespace Cube\Html;

class MenuItem extends HtmlObject{
    protected $_data = [
        'text' => "menu item",
        'title' => 'Menu item',
        'active_name' => '',
        'active_key' => '',
        
        'sub_tag' => 'ul',
        'sub_item_tag' => 'li',
        'sub_active_name' => '',
        'sub_active_key' => '',
        'sub_id' => "",
        'sub_class' => "",
        'sub_attrs' => [],
       
        // item
        'tag' => 'li',
        'id' => '',
        'active_class' => '',
        'has_sub_class' => '',
        'has_sub_active_class' => '',
        'use_active_key' => false,
        'attrs' => [],
        
        'sub_item_class' => '',
        'sub_item_active_class' => '',
        'sub_link_class' => '',
        'sub_link_active_class' => '',
        'sub_link_attrs' => [],
        
        // link attr
        'url' => "",
        'link_id' => null,
        'link_class' => '',
        'link_active_class' => '',
        'link_attrs' => [],
        'route' => '',
        'param' => [],
        
    
        // icon
        'icon' => null,
        'use_icon' => false,
        'icon_tag' => 'i',
        'icon_prefix_class' => 'fa fa-',
        'icon_class' => '',
        'icon_attrs' => [],
    
        'submenu' => [],
    
        'beforeLink' => '',
        'afterLink' => '',

        'total' => 0,
        'index' => 0,
    ];

    
    protected $orginalData = [];

    protected $actions = [];
    public $link = null;

    public $parent = null;
    
    public $sub = null;
     /**
     * khoi tao form group
     */

    public function __construct($data=[], $options=[])
    {
        $tag = isset($options['tag'])?$options['tag']:(isset($options['item_tag'])?$options['item_tag']:null);
        parent::__construct($tag);
        if(is_array($options)){
            $this->orginalData = $options;
            $this->setOption($options);
        }
        if(is_array($data)){
            $this->setOption($data);
        }
        
    }


    public function render($action=null)
    {
        $this->addAction($action);
        
        $d = $this->_data;

        $link_attrs = $d['link_attrs'];

        $active = $this->isActive();

        if($this->route){
            $url = route($d['route'],$d['param']);
            $link_attrs['href'] = $url;
            $this->url = $url;
        }
        elseif($this->url){
            $link_attrs['href'] = $this->url;
        }
        
        if(!isset($link_attrs['title'])){
            $link_attrs['title'] = $this->title;
        }
        $link = new HtmlObject('a',' '.($d['text']?$d['text']:$d['title']).' ',$link_attrs);
        if($this->target && $this->target != 'none'){
            $link->attr('target', $this->target);
        }else{
            $this->target=null;
        }
        if($d['link_class']){
            $link->addClass($d['link_class']);
        }
        if($active && $d['link_active_class']){
            $link->addClass($d['link_active_class']);
        }
        
        if($d['link_id']){
            $link->id=$d['link_id'];
        }

        
        $className = ((count($this->submenu) > 0)?' '.$this->has_sub_class:'')
                    .($active?(
                        ($this->active_class?' '.$this->active_class:'')
                       .($this->hasSubMenu()?($this->has_sub_active_class?' '.$this->has_sub_active_class:''):'')
                    ):'');
        $this->addClass($className);

        $this->link = $link;
        
        
        $this->append($link);
        
        if(($this->use_icon || $this->icon) && $this->icon != 'none'){
            $icon_attrs = $this->icon_attrs;

            if($this->icon_prefix_class || !isset($icon_attrs['prefix_class'])){
                $icon_attrs['prefix_class'] = $this->icon_prefix_class;
            }
            if($this->icon_class || !isset($icon_attrs['class'])){
                $icon_attrs['class'] = $this->icon_class;
            }
            $a = $icon_attrs;
            $icoClass = (
                $this->icon_class?$this->icon_class.' ':''
            ).(
                $a['prefix_class'].(isset($this->icon)?$this->icon:'cube')
            );
            unset($a['prefix_class'],$a['class']);
            $icon = new HtmlObject(($this->icon_tag?$this->icon_tag:'i'),null,$a);
            $icon->addClass($icoClass);
            $link->prepend($icon);
        }
        // a:link
        $sub = null;
        if($this->hasSubMenu()){
            $sm = $this->submenu;
            if(is_array($sm)){
                #sub = null;
                if(isset($sm[0])){
                    $sub = ['type'=>'list','list'=>$sm];
                }elseif(isset($sm['type'])){
                    $sub = $sm;
                }
                if($sm){
                    $submenu = new Menu(
                        $sm,
                        [
                            'tag' => $this->sub_tag,
                            'id' => $this->sub_id,
                            'class' => $this->sub_class,
                            'attrs' => $this->sub_attrs,
                            'item_class' => $this->sub_item_class,
                            'link_class' => $this->sub_link_class,
                            'link_attrs' => $this->sub_link_attrs,
                            'item_active_class' => $this->sub_item_active_class,
                            'icon_tag' => $this->icon_tag,
                            'icon_prefix_class' => $this->icon_prefix_class,
                            'icon_class' => $this->icon_class,
                            'icon_attrs' => $this->icon_attrs,
                        ],
                        
                        $this->active_name.'_'.$this->active_key
                    );
                    if($submenu->checkMenuData()){
                        $this->sub = $submenu;
                        $this->append($submenu);
                    }else{
                        $this->submenu = [];
                    }
                    
                }
            }
        }
        if(count($this->actions)>0){
            foreach($this->actions as $act){
                $act($this,$link,$sub);
            }
        }
        
        // end submenu
        return parent::render();
    }

    public function isActive()
    {
        if(Menu::checkActiveKey($this->active_name,$this->active_key)) return true;
        return Menu::checkActiveURL($this->url);
    }


    public function index()
    {
        return $this->_data['index'];
    }
    public function isFirst()
    {
        return ($this->_data['index'] == 0);
    }
    public function isLast()
    {
        return ($this->_data['total'] - $this->_data['index'] == 1);
    }
    public function inList()
    {
        return !($this->isFirst() || $this->isLast());
    }
    
    public function hasSubMenu()
    {
        return count($this->submenu);
    }

    
    protected function setOpt($name,$value=null)
    {
        $n = strtolower($name);
        if (array_key_exists($n, $this->_data)) {
            $this->_data[$n] = $value;
            
            if($n=='item_class' || $n=='class' || $n=='classname'){
                return $this->attr('class',$value);
            }
            if($name=='item_attrs' || $name=='attrs'){
                return $this->attr($value);
            }
        }elseif($n=='item_class' || $n=='class' || $n=='classname'){
            return $this->attr('class',$value);
        }else{
            return $this->attr($name,$value);
        }
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
    public function __toString(){
        return $this->render();
    }
}