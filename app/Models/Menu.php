<?php

namespace App\Models;

class Menu extends Model
{
    public $table = 'menus';

    public $fillable = ['name','type','active','ref_id', 'data', 'priority', 'status'];
    
    public $_route = 'menu';

    public $timestamps = false;

    protected static $menuID = 0;

    public function getSaveItemUrl()
    {
        return route('admin.menu.item.save');
    }
    public function getAddItemUrl()
    {
        return route('admin.menu.item.add',['id'=>$this->id]);
    }
    
    public static function setID($id=0)
    {
        self::$menuID = $id;
    }
    



    public static function getMenuPriorityList()
    {
        $id = self::$menuID;
        $arr = ["Tự động"];
        $num = Menu::where('id','>', 0)->count();
        for($i=1; $i <= $num; $i++){
            $arr[] = $i;
        }
        $arr[] = "Cuối danh sách";
        return $arr;
    }


    public static function getItemPriorityList()
    {
        $id = self::$menuID;
        $arr = ["Tự động"];
        if($id){
            $num = MenuItem::where('menu_id',$id)->count();
            for($i=1; $i <= $num; $i++){
                $arr[] = $i;
            }
            $arr[] = "Cuối danh sách";
        }else{
            $arr[] = 1;
        }
        return $arr;
    }
    

    public function getPriorityMenuList()
    {
        $arr = [];
        $num = self::where('id','>',0)->count();
        if($num>0){
            
            for($i=1; $i <= $num; $i++){
                $arr[] = [
                    'text' => "Chuyển tới vị trí thứ ".$i,
                    'url' => '#',
                    'link_attrs' => ['data-priority'=>$i]
                ];
            }
            $arr[] = [
                'text' => "Cuối danh sách",
                'url' => '#',
                'link_attrs' => ['data-priority'=>$i]
            ];
        }else{
            $arr[] = 1;
        }
        return $arr;
    }
    public function updatePriority($priority=0)
    {
        $c = self::where('id','>',0)->count();
        if($this->priority==0){
            $this->priority = $c;
            $this->save();
        }
        if($priority != 0 && $priority != $this->priority){
            if($priority>self::count()){
                $priority=self::count();
            }
            $query = static::where('id', '!=', $this->id);
            $begin = ($priority<$this->priority)?$priority:$this->priority;
            $end = ($priority>$this->priority)?$priority:$this->priority;
                
            $query->whereBetween('priority',[$begin,$end]);
            if($list = $query->get()){
                if($priority > $this->priority){
                    foreach($list as $item){
                        $item->priority = $item->priority - 1;
                        $item->save();
                    }
                    
                }
                else{
                    foreach($list as $item){
                        $item->priority = $item->priority + 1;
                        $item->save();
                    }
                }
            }
            $this->priority = $priority;
            $this->save();
            return true;
        }elseif($priority == 0){
            $count = self::count();
            if($this->priority==0){
                $this->priority = $count;
                $this->save();
                return true;;
            }
            return $this->updatePriority($count);
        }
        return false;
    }
    
    
    public function items($paginate=null)
    {
        $query = MenuItem::where('menu_id',$this->id)->where('parent_id','<',1)->orderBy('priority','asc');
        if($paginate){
            return $query->paginate($paginate);
        }
        return $query->get();
    }
    
    public static function getMenuList()
    {
        $menu = [];
        if($list = self::all()){
            foreach($list as $cat){
                $menu[$cat->id] = $cat->name;
            }
        }
        return $menu;
    }











    
    public function toMenuList()
    {
        return self::parseMenu($this);
    }
    

    protected static function parseMenu($menu=null)
    {
        $return = [];
        if($menu){
            $t = $menu->type;
            
            if($t=='default'){
                $menulist = $menu->items();
                $return = ['type'=>'list','list'=> self::parseItemList($menulist)];

            }elseif($t=='category'){
                $query = Category::where('parent_id','<',1)->where('is_menu',1)->where('status',200);
                if($list = $query->get()){
                    $cal = [];
                    foreach($list as $item){
                        $cal[] = self::parseCateItem($item);
                    }
                    $return = ['type'=>'list','list'=>$cal];
                    
                }
            }elseif($t=='product_category'){
                $query = Category::where('parent_id','<',1)->where('type','product')->where('is_menu',1)->where('status',200);
                if($list = $query->get()){
                    $cal = [];
                    foreach($list as $item){
                        $cal[] = self::parseCateItem($item);
                    }
                    $return = ['type'=>'list','list'=>$cal];
                }
            }elseif($t=='page'){
                $query = Page::where('parent_id','<',1)->where('status',200);
                if($list = $query->get()){
                    $cal = [];
                    foreach($list as $item){
                        $cal[] = self::parsePageItem($item);
                    }
                    $return = ['type'=>'list','list'=>$cal];
                }
            }elseif($t=='dynamic'){
                $query = Dynamic::where('parent_id','<',1)->where('status',200);
                if($list = $query->get()){
                    $cal = [];
                    foreach($list as $item){
                        $cal[] = self::parseDynamicItem($item);
                    }
                    $return = ['type'=>'list','list'=>$cal];
                }
            }else{
                if(is_callable($menu->data)){
                    $a = $menu->data;
                    if($b = $a()){
                        $return = $b;
                    }
                }
            }
        }
        return $return;
    }



    protected static function parseItemList($list=null)
    {
        if($list){
            //
            $arr = [];
            //text link title id class icon
            foreach($list as $item){
                $item->applyMeta();
                $itemdata = ['url'=>'','text'=>'','title'=>'','active_key'=>'','icon'=>''];
                $title = $item->title?$item->title:'';
                $itemdata['title'] = $title;
                $itemdata['text'] = $item->text?$item->text:$title;
                if($item->icon){
                    $itemdata['icon'] = $item->icon?$item->icon:'';
                }
                if($item->className){
                    $itemdata['className'] = $item->className;
                }
                if($item->target){
                    $itemdata['target'] = $item->target;
                }
                $t = $item->type;
                
                $itm = null;
                if($t=='default'){
                    $itm = self::parseItem($item, $item->sub_type);
                }elseif($t=='route'){
                    $itm = self::parseRouteItem($item, $item->sub_type);
                }elseif($t=='category'){
                    if($item->cate_id && $cate = Category::find($item->cate_id)){
                        $itm = self::parseCateItem($cate, $item->sub_type);
                    }
                }elseif($t=='dynamic_category'){
                    if($item->dynamic_cate_id && $cate = Category::find($item->dynamic_cate_id)){
                        $itm = self::parseCateItem($cate, $item->sub_type);
                    }
                }elseif($t=='product_category'){
                    if($item->product_cate_id && $cate = Category::find($item->product_cate_id)){
                        $itm = self::parseCateItem($cate, $item->sub_type);
                    }
                }
                elseif($t=='page'){
                    if($item->page_id && $page = Page::find($item->page_id)){
                        $itm = self::parsePageItem($page, $item->sub_type);
                    }
                }
                elseif($t=='dynamic'){
                    if($item->dynamic_id && $page = Dynamic::find($item->dynamic_id)){
                        $itm = self::parseDynamicItem($page, $item->sub_type);
                    }
                }
                elseif($t=='define'){
                    if(is_callable($item->action)){
                        $a = $item->action;
                        $b = $a($item->param);
                        if($b){
                            $itm = $b;
                        }
                    }
                }
                $sub = [];
                if($item->children){
                    $sub = self::parseItemList($item->children);
                }
                $sub2 = [];
                if(!in_array($item->sub_type, ['none','default']) && $submenu = self::getItemSubMenu($item)){
                    $sub2 = $submenu;
                }
                if(isset($itm['submenu']) && $sub){
                    $itm['submenu']['list'] = array_merge($sub, $itm['submenu']['list']);
                }
                elseif($sub && $sub2){
                    $itm['submenu'] = [
                        'type'=>'list',
                        'list'=>array_merge($sub,$sub2['list'])
                    ];
                }elseif($sub){
                    $itm['submenu'] = [
                        'type'=>'list',
                        'list'=>$sub
                    ];
                }elseif($sub2){
                    $itm['submenu'] = $sub2;
                }
                if($itm){
                    foreach($itm as $prop => $val){
                        if($prop=='text'){
                            if(!$title){
                                $itemdata[$prop] = $val;
                            }
                        }
                        else{
                            $itemdata[$prop] = $val;
                        }
                    }
                }
                
                $arr[] = $itemdata;
            }
            return $arr; 
        }
        return null;
    }

    public static function getItemSubMenu($item)
    {
        if($item->sub_type=='menu' && $item->sub_menu_id && $sub = self::find($item->sub_menu_id)){
            return self::parseMenu($sub);
        }
        elseif($item->sub_type=='category' && $item->sub_cate_id && $sub = Category::find($item->sub_cate_id)){
            return self::parseCateMenu($sub);
        }
        elseif($item->sub_type=='product_category' && $item->sub_product_cate_id && $sub = Category::find($item->sub_product_cate_id)){
            return self::parseCateMenu($sub);
        }
        elseif($item->sub_type=='dynamic_category' && $item->sub_dynamic_cate_id && $sub = Category::find($item->sub_dynamic_cate_id)){
            return self::parseCateMenu($sub);
        }
        //page Page ?????? 
        elseif($item->sub_type=='page' && $item->sub_page_id && $sub = Page::find($item->sub_page_id)){
            return self::parsePageMenu($sub);
        }
        elseif($item->sub_type=='dynamic' && $item->sub_dynamic_id && $sub = Dynamic::find($item->sub_dynamic_id)){
            return self::parsePageMenu($sub);
        }
        elseif($item->sub_type=='json' && $item->sub_file){
            return self::parseJSINMenu($item->sub_file);
        }
        elseif($item->sub_type=='define'){
            if(is_callable($item->sub_action)){
                $ac = $item->sub_action;

                $p = null;
                if(strlen($item->sub_param)>0){
                    $arr = explode(',', $item->sub_param);
                    $m = call_user_func_array($ac, $arr);
                }
                else{
                    $m = call_user_func($ac);
                }
                return $m;
            
            }
            
        }
        return null;
    }

    protected static function parseItem($item = null, $sub_type = null)
    {
        $itemdata = ['url'=>'','text'=>'','title'=>'','active_key'=>'','icon'=>''];
        $item->applyMeta();
        $itemdata['url'] = $item->url?$item->url:'#';
        $title = $item->title?$item->title:(!$item->icon?'Menu item':'');
        $itemdata['title'] = $title;
        $itemdata['text'] = $item->text?$item->text:$title;
        if($item->icon){
            $itemdata['icon'] = $item->icon?$item->icon:'';
        }
        if($item->className){
            $itemdata['className'] = $item->className;
        }
        elseif($item->classname){
            $itemdata['className'] = $item->classname;
        }
        if($sm = self::getItemSubMenu($item)){
            $itemdata['submenu'] = $sm;
        }
        
        //
        $itemdata['active_key'] = $item->active_key;
        return $itemdata;
    }

    protected static function parseRouteItem($item = null, $sub_type = null)
    {
        $itemdata = ['url'=>'','text'=>'','title'=>'','active_key'=>'','icon'=>''];
        $item->applyMeta();
        if($item->param){
                parse_str($item->param,$p);
        }else $p = null;
        $itemdata['url'] = $item->route?($p?route($item->route,$p):route($item->route)):'#';
        
        $title = $item->title?$item->title:(!$item->icon?'Menu item':'');
        $itemdata['title'] = $title;
        $itemdata['text'] = $item->text?$item->text:$title;
        if($item->icon){
            $itemdata['icon'] = $item->icon?$item->icon:'';
        }
        if($item->className){
            $itemdata['className'] = $item->className;
        }
        elseif($item->classname){
            $itemdata['className'] = $item->classname;
        }
        if($sm = self::getItemSubMenu($item)){
            $itemdata['submenu'] = $sm;
        }
        
        //
        $itemdata['active_key'] = $item->active_key;
        return $itemdata;
    }

    protected static function parseCateItem($cate = null, $sub_type = null)
    {
        $item = ['url'=>'','text'=>'','title'=>'','active_key'=>''];
        $item['url'] = $cate->getViewUrl();
        $item['text'] = $cate->name;
        $item['title'] = $cate->name;
        if($sub_type == 'default' && $cate->hasChild()){
            $item['submenu'] = self::parseCateMenu($cate);
        }
        $item['active_key'] = $cate->slug;
        return $item;
    }

    protected static function parseCateMenu($cate){
        $menu = [];
        if($list = $cate->getMenuChildren()){
            $menu['type'] = 'list';
            $arr = [];
            foreach($list as $cat){
                $item = self::parseCateItem($cat);
                $arr[] = $item;
            }
            $menu['list'] = $arr;
        }
        return $menu;
    }


    public static function parsePageItem($page = null, $sub_type = null)
    {
        $item = ['url'=>'','text'=>'','title'=>'','active_key'=>''];
        $item['url'] = $page->getViewUrl();
        $item['text'] = $page->title;
        $item['title'] = $page->title;
        if($sub_type == 'default' && $page->hasChild()){
            $item['submenu'] = self::parsePageMenu($page);
        }
        $item['active_key'] = $page->slug;
        return $item;
    }

    public static function parseDynamicItem($page = null, $sub_type = null)
    {
        $item = ['url'=>'','text'=>'','title'=>'','active_key'=>''];
        $item['url'] = $page->getViewUrl();
        $item['text'] = $page->title;
        $item['title'] = $page->title;
        if($sub_type == 'default' && $page->hasChild()){
            $item['submenu'] = self::parseDynamicMenu($page);
        }
        $item['active_key'] = $page->slug;
        return $item;
    }


    public static function parseAdminPageItem($page = null)
    {
        $item = ['url'=>'','text'=>'','title'=>'','active_key'=>'','icon'=>'file'];
        $page->applyMeta();
        $item['url'] = $page->getDetailUrl();
        $item['text'] = $page->title;
        $item['title'] = $page->title;
        $data = [
            [
                'title' => "Danh sách",
                'text'  => "Danh sách",
                'active_key' => 'list',
                'icon' => 'th-list',
                'url' => route('admin.dynamic.item.list',['slug'=>$page->slug])
            ]
        ];

        if($page->use_category){
            $data[] = [
                'title' => "Danh mục",
                'text'  => "Danh mục",
                'active_key' => 'category',
                'icon' => 'folder',
                'url' => route('admin.dynamic.category.list',['dynamic_slug'=>$page->slug])
            ];
        }


        $data[] = [
            'title' => "Thêm mới",
            'text'  => "Thêm mới",
            'active_key' => 'add',
            'icon' => 'plus',
            'url' => route('admin.dynamic.item.add',['slug'=>$page->slug])
        ];
        $item['submenu'] = [
            'type' => 'list',
            'data' => $data
        ];
        
        $item['active_key'] = $page->slug;
        return $item;
    }

    public static function parsePageMenu($page){
        $menu = [];
        if($list = $page->getChildren()){
            $menu['type'] = 'list';
            $arr = [];
            foreach($list as $p){
                $item = self::parsePageItem($p);
                $arr[] = $item;
            }
            $menu['list'] = $arr;
        }
        return $menu;
    }
    public static function parseDynamicMenu($page){
        $menu = [];
        if($list = $page->getChildren()){
            $menu['type'] = 'list';
            $arr = [];
            foreach($list as $p){
                $item = self::parsePageItem($p);
                $arr[] = $item;
            }
            $menu['list'] = $arr;
        }
        return $menu;
    }



    protected static function parseJSINMenu($file=null){
        $menu = ['type'=>'list', 'list'=>null];
        $files = new Files();
        $files->cd('json/menus');
        if($list = $files->getJSON($file)){
            $menu['list'] = self::parseJSONItemList($list);
        }
        return $menu;
    }

    protected static function parseJSONItemList($list = null){
        $arr = [];
        if($list){
            $list = Helper::to_array($list);
            foreach ($list as $item)
            {
                $itm = [];
                $i = new Arr($item);
                if($l = $i->get('url')){
                    $itm['url'] = $l;
                }elseif($r = $i->get('route')){
                    $a = [];
                    if($p = $i->get('param')){
                        parse_str($p,$b);
                        if($a){
                            $a = $b;
                        }
                    }
                    $itm['url'] = route($r,$a);
                }
                elseif($pt = $i->get('path')){
                    $itm['url'] = url($pt);
                }else{
                    $itm['url'] = '#';
                }
                $itm['text'] = $i->get('text')?$i->get('text'):($i->get('name')?$i->get('name'):($i->get('title')?$i->get('title'):'menu Item'));
                $item['title'] = $i->get('title')?$i->get('title'):$item['text'];

                if($cn = $i->get('class')){
                    $itm['class'] = $cl;
                }
                if($ic = $i->get('icon')){
                    $itm['icon'] = $ic;
                }
                if($sm = $i->get('submenu')){
                    if($el = $i->get('submit.0')){
                        $itm['submenu'] = self::parseJSONItemList($sm);
                    }
                }
                $arr[] = $itm;
            }
        }
        return $arr;
    }


    public static function getMenuOptions($orderBy = 'ASC')
    {
        $list = self::orderBy('id',$orderBy)->get();
        $submenu = [];
        foreach($list as $item){
            $submenu[$item->slug] = [
                'id' => $item->id,
                'title' => $item->name,
                'slug' => $item->slug,
                'text' => str_limit($item->name, 28, '...'),
                'route' => $item->routeName,
                'url' => $item->getDetailUrl()
            ];
        }
        return $submenu;
    }

    public static function repairPriority()
    {
        $max = self::count();
        if(count($list = self::where('active',1)->orderBy('priority','DESC')->get())>0){
            foreach($list as $menu){
                if($menu->priority>$max){
                    $menu->priority = $max;
                    $menu->save;
                }
                $max--;
            }
        }
    }
    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }
    public function getDeleteUrl()
    {
        return route('admin.'.$this->_route.'.delete',['id' => $this->id]);
    }
    public function getDetailUrl()
    {
        return route('admin.'.$this->_route.'.detail',['id' => $this->id]);
    }

    public function delete()
    {
    	if($list = $this->items()){
            foreach($list as $item){
                $item->delete();
            }
        }
        $s = parent::delete();
        self::repairPriority();
        return $s;
    }    
}
