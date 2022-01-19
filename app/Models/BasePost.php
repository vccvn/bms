<?php

namespace App\Models;
use DB;


class BasePost extends Model
{
    public $table = 'posts';

    public $fillable = [
        'type','user_id', 'parent_id', 'cate_id', 'cate_map',  'title','slug','description','content',
        'keywords','feature_image','views','likes', 'status'
    ];

    public $_folder = 'posts'; // folder chứ hình ảnh upload

    public $_route = 'post';

    protected $_meta = [];

    protected static $activeID = 0;

    public static function setActiveID($id = null)
    {
        if($id){
            self::$activeID = $id;
        }
    }
    public static function getActiveID()
    {
        return self::$activeID;
    }

    public function parent()
    {
        return $this->belongsTo('App\\Models\\Dynamic','parent_id','id');
    }

    public function children()
    {
        return $this->hasMany('App\\Models\\Dynamic','parent_id','id');
    }


    public function category()
    {
        return $this->belongsTo('App\\Models\\Category','cate_id','id');
    }

    public function author($id)
    {
        $author = DB::table('user')->where('id',$id)->first();
        return $author;
    }

    public function previous()
    {
        return self::find(self::where('id', '<', $this->id)->where('cate_id', $this->cate_id)->max('id'));
    }
    public function next()
    {
        return self::find(self::where('id', '>', $this->id)->where('cate_id', $this->cate_id)->min('id'));
    }

    public function tagLinks()
    {
        return $this->hasMany('App\\Models\\TagLink','object_id','id')->where('object',$this->type);
    }

    public function productLinks()
    {
        return $this->hasMany('App\\Models\\PostProductLink','post_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\\Models\\Comment','object_id','id')->where('object',$this->type);
    }

    
    public function publishComments()
    {
        return $this->hasMany('App\\Models\\Comment','object_id','id')->where('object',$this->type)->where('approved', 1);
    }

    public function gallery()
    {
        return $this->hasMany('App\\Models\\Gallery','ref_id','id')->where('ref',$this->type);
    }

    /**
     * ket noi voi bang post_meta
     * @return queryBuilder 
     */
    public function postMeta()
    {
        return $this->hasMany('App\\Models\\PostMeta','post_id','id');
    }

    public function getAuthor()
    {
        if($user = User::find($this->user_id)){
            return $user;
        }
        $user = new User([
            'username' => 'anonymous',
            'name' => 'Anonymous',
            'id' => 0
        ]);
        return $user;
    }

    public function getCategory()
    {
        if($cate = Category::find($this->cate_id)){
            return $cate;
        }
        return (new Category(['name'=>'Undefined','slug'=>'undefined','id'=>0]));
    }



    public function getParent()
    {
        if($this->parent_id){
            return self::find($this->parent_id);
        }
        return null;
    }

    public function getChildren()
    {
        return self::where('parent_id',$this->id)->where('status', 200)->get();
    }
    public function hasChild()
    {
        return self::where('parent_id',$this->id)->where('status', 200)->count();
    }

    public function getMap($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this->id);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getMap($list,$n);
        }
        return $list;
    }
    public function getTree($list = [], $n = 0)
    {
        if(!is_array($list)) $list = [];
        if(!is_integer($n)) $n = 0;
        array_unshift($list,$this);
        $n++;
        if($parent = $this->getParent()){
            return $parent->getTree($list,$n);
        }
        return $list;
    }
    public function getLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $n++;
        if($parent = $this->getParent()){
            return $parent->getLevel($n);
        }
        return $n;
    }


    public function getSonLevel($n = 0)
    {
        if(!is_integer($n)) $n = 0;
        $max = 0;
        if(count($children = $this->getChildren())){
            $n++;
            $max = $n;
            foreach ($children as $child) {
                $k = $child->getSonLevel($n);
                if($k > $max){
                    $max = $k;
                }
            }
            $n = $max;
        }
        return $n;
    }

    // get tags
    public function getTags()
    {
        return Tag::whereRaw("id in (SELECT tag_links.tag_id FROM tag_links WHERE tag_links.object_id = ". to_number($this->id) ." AND tag_links.object = '$this->type' )")->get();
    }





    public function getFullTitle()
    {
        $category = $this->getCategory();
        $cate_parent = $category->parent;
        $title = $this->title . ' | '. $category->name;
        if($cate_parent){
            $title.= ' | '. $cate_parent->name;
        }
        return $title;
        
    }









    // apdung meta

    public function applyMeta()
    {
        $meta = $this->postMeta;
        if(count($meta) && !$this->_meta){
            foreach ($meta as $item) {
                $v = ($item->type == 'number') ? to_number($item->value) : $item->value;
                $this->_meta[$item->name] = $v;
                $this->{$item->name} = $v;
            }
        }
    }


    public function meta($metaname = null, $value = '<!-- DEFAULT VALUE -->')
    {
        if(!$this->_meta){
            $this->applyMeta();
        }
        if(is_null($metaname)) return $this->_meta;
        if(isset($this->_meta[$metaname])) return $this->_meta[$metaname];
        return ($value != '<!-- DEFAULT VALUE -->')?$value:null;
    }

    public function saveMeta($name, $value=null, $type=null)
    {
        $data = compact('name','value');
        if(!is_null($type)){
            $data['type'] = $type;
        }
        if($meta = PostMeta::where('name', $name)->where('post_id', $this->id)->first()){
            // 
        }else{
            $meta = new PostMeta();
            $data['post_id'] = $this->id;
        }
        $meta->fill($data);
        $meta->save();
    }


    public function manyMeta($meta = [])
    {
        if(is_array($meta) && count($meta)){
            foreach($meta as $k => $v){
                if(is_numeric($k)) continue;
                $data = ['name'=>$k,'value'=>$v];
                if($m = PostMeta::where('name', $name)->where('post_id', $this->id)->first()){
                    // 
                }else{
                    $m = new PostMeta();
                    $data['post_id'] = $this->id;
                }
                $m->fill($data);
                $m->save();
            }
        }
        
    }
    public function saveManyMeta($meta = [])
    {
        if(is_array($meta) && count($meta)){
            foreach($meta as $k => $v){
                if(is_numeric($k)) continue;
                $data = ['name'=>$k,'value'=>$v];
                if($m = PostMeta::where('name', $k)->where('post_id', $this->id)->first()){
                    // 
                }else{
                    $m = new PostMeta();
                    $data['post_id'] = $this->id;
                }
                $m->fill($data);
                $m->save();
            }
        }
        
    }
    
    /**
     * kiem tra va set meta cho post
     * @return boolean
     */
    protected function checkMeta()
    {
        if(!$this->_meta){
            if($list = $this->postMeta()->get()){
                $meta = [];
                foreach ($list as $m) {
                    $meta[$m->name] = ($m->type == 'number') ? to_number($m->value) : $m->value;
                }
                $this->_meta = $meta;
                return true;
            }
            return false;
        }
        return true;
    }

    
    public function saveMetaSimple($name,$value=null,$type='text')
    {
        if($meta = $this->postMeta->where('name',$name)->first()){
            $meta->value = $value;
            $meta->save();
        }else{
            $meta = new PostMeta();
            $post_id = $this->id;
            $meta->fill(compact('post_id', 'type', 'name', 'value'));
            $meta->save();
        }
    }

    public function likeUp()
    {
        $this->likes++;
        $this->save();
    }
    public function likeDown()
    {
        if($this->likes){
            $this->likes--;
            $this->save();
        }
    }
    public function viewUp()
    {
        $this->views++;
        $this->save();
    }
    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }
    public function postDate2()
    {
        return 'Thứ '.date('w', strtotime($this->created_at)).', Ngày '.date('d', strtotime($this->created_at)).' Tháng '.date('m', strtotime($this->created_at)).' Năm '.date('Y', strtotime($this->created_at));
    }

    public function updateTimeFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->updated_at));
    }

    public function getProductLinked()
    {
        $products = [];
        if($this->productLinks){
            foreach ($this->productLinks as $link) {
                $products[] = $link->product;
            }
        }
        return $products;
    }
    
    public function getSlug($title=null)
    {
        if(!$title && !isset($this->id)) return null;
        if(!$title){
            $title = isset($this->title)?$this->title:(isset($this->name)?$this->name:null);
        }
        $id = null;
        if(isset($this->id) && $this->id){
            $id = $this->id;
        }
        $aslug = str_slug($title,'-');
        $slug = null;
        $i = 1;
        $c = '';
        $s = true;
        do{
            $sl = $aslug.$c;
            if($news = self::where('slug',$sl)->first()){
                if($id && $news->id == $id){
                    $slug = $sl;
                    $s = false;
                }
                $c='-'.$i;
            }else{
                $slug = $sl;
                $s = false;
            }

            $i++;
        }while($s);
        return $slug;
    }

    public function checkSlug($slug=null)
    {
        if(!strlen($slug) && !isset($this->id)) return -1;
        if(!$slug) $slug = $this->slug;
        $id = null;
        if(isset($this->id) && $this->id){
            $id = $this->id;
        }
        
        if(!$slug) $status = -1;
        elseif(strtolower($slug) != str_slug($slug)) $status = 0;
        elseif($m = self::where('slug',$slug)->first()){
            if($id && $m->id == $id){
                $status = 1;
            }
            else $status = -2;
        }else{
            $status = 1;
        }
        return $status;
    }


    public function getFilePath($size = null)
    {
        if($this->feature_image){
            if(is_string($size) && strlen($size))
                return public_path('/contents/'.$this->type.'s/'.$size.'/'.$this->feature_image);
            return public_path('/contents/'.$this->type.'s/'.$this->feature_image);
        }
        return null;
    }

    public function getImage($size = null)
    {
        $img = $this->feature_image?$this->feature_image:'default.jpg';
        if(is_string($size) && strlen($size) && file_exists(public_path('/contents/'.$this->type.'s/'.$size.'/'.$img))) return asset('/contents/'.$this->type.'s/'.$size.'/'.$img);
        return asset('/contents/'.$this->type.'s/'.$img);
    }

    public function getFeatureImage($size = null)
    {
        return $this->getImage($size);
    }




    public function getUpdateUrl()
    {
        return route('admin.'.$this->type.'.update',['id' => $this->id]);
    }
    
    public function getViewUrl()
    {
        $r = in_array($this->type, ['dynamic', 'page'])?'dynamic':$this->type;
        if($this->parent){
            return route('client.'.$r.'.view-child',['parent_slug' => $this->parent->slug,'child_slug' => $this->slug]);
        }
        return route('client.'.$r.'.view',['slug' => $this->slug]);
    }


    public function deleteFile()
    {
        if($p = $this->getFilePath()){
            if(file_exists($p)) unlink($p);
        }
        if($p = $this->getFilePath('90x90')){
            if(file_exists($p)) unlink($p);
        }
        return true;
    }
    
    public function delete()
    {
        if($children = $this->getChildren()){
            foreach($children as $child){
                $child->status = -2;
                $child->save();
            }
        }
        $this->status = -1;
        $this->save();
    }


    public function erase()
    {
        
        $this->deleteFile();
        $this->tagLinks()->delete();
        $this->comments()->delete();
        $this->postMeta()->delete();
        
        $this->productLinks()->delete();
        if($children = $this->getChildren()){
            foreach($children as $child){
                $child->delete();
            }
        }
        return parent::delete();
    }




    public function toFormData()
    {
        $a = [];
        $this->applyMeta();
        foreach($this->fillable as $field){
            $a[$field] = $this->{$field};
        }
        return array_merge($a, $this->_meta);
    }
    
}
