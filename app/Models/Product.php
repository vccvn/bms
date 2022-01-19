<?php

namespace App\Models;



class Product extends Model
{
    public $table = 'products';

    public $fillable = [
        'user_id', 'cate_id', 'cate_map', 'name','slug','code','description','detail',
        'keywords','feature_image','list_price','sale_price',
        'total','views','likes', 'status'
    ];

    public $_folder = 'products'; // folder chứ hình ảnh upload

    public $_route = 'product';

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


    public function category()
    {
        return $this->belongsTo('App\\Models\\Category','cate_id','id');
    }

    public function postLinks()
    {
        return $this->hasMany('App\\Models\\PostProductLink','product_id','id');
    }

        /**
     * ket noi voi bang product_meta
     * @return queryBuilder 
     */
    public function productMeta()
    {
        return $this->hasMany('App\\Models\\ProductMeta','product_id','id');
    }

    public function tagLinks()
    {
        return $this->hasMany('App\\Models\\TagLink','object_id','id')->where('object','product');
    }
    public function gallery()
    {
        return $this->hasMany('App\\Models\\Gallery','ref_id','id')->where('ref','product');
    }
    

    /**
     * get tags
     * @param void
     * @return queryBuilder
     */
    public function getTags()
    {
        return Tag::whereRaw("id in (SELECT tag_links.tag_id FROM tag_links WHERE tag_links.object_id = ". to_number($this->id) ." AND tag_links.object = 'product' )")->get();
    }
    public function getCategory()
    {
        if($cate = Category::find($this->cate_id)){
            return $cate;
        }
        return (new Category(['name'=>'Undefined','slug'=>'undefined']));
    }
    public function getPostLinked()
    {
        $products = [];
        if($this->postLinks){
            foreach ($this->postLinks as $link) {
                $products[] = $link->post;
            }
        }
        return $products;
    }

    /**
     * kiem tra va set meta cho product
     * @return boolean
     */
    protected function checkMeta()
    {
        if(!$this->_meta){
            if($list = $this->productMeta()->get()){
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
        if($meta = $this->productMeta->where('name',$name)->first()){
            $meta->value = $value;
            $meta->save();
        }else{
            $meta = new ProductMeta();
            $product_id = $this->id;
            $meta->fill(compact('product_id', 'type', 'name', 'value'));
            $meta->save();
        }
    }


    // apdung meta

    public function applyMeta()
    {
        $meta = $this->productMeta;
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
        if($meta = productMeta::where('name', $name)->where('product_id', $this->id)->first()){
            // 
        }else{
            $meta = new productMeta();
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
                if($m = productMeta::where('name', $name)->where('product_id', $this->id)->first()){
                    // 
                }else{
                    $m = new productMeta();
                    $data['product_id'] = $this->id;
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
                if($m = productMeta::where('name', $k)->where('product_id', $this->id)->first()){
                    // 
                }else{
                    $m = new productMeta();
                    $data['product_id'] = $this->id;
                }
                $m->fill($data);
                $m->save();
            }
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

    public function dateFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->created_at));
    }
    public function updateTimeFormat($format=null)
    {
        if(!$format) $format = 'd/m/Y - H:m';
        return date($format, strtotime($this->updated_at));
    }

    public function getPriceFormat()
    {
        return number_format($this->sale_price, 0, ',', '.');
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
                    break;
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


    public function getFullTitle()
    {
        $category = $this->getCategory();
        
        $title = $this->name;
        if($category->id){
            $title.= ' | '.$category->name;
            $cate_parent = $category->parent;
            if($cate_parent){
                $title.= ' | '. $cate_parent->name;
            }
        }
        
        return $title;
        
    }



    public function getFilePath()
    {
        if($this->feature_image){
            return public_path('/contents/'.$this->_folder.'/'.$this->feature_image);
        }
        return null;
    }

    public function getImage($size = null)
    {
        $img = $this->feature_image?$this->feature_image:'default.jpg';
        if(is_string($size) && strlen($size) && file_exists(public_path('/contents/'.$this->_folder.'/'.$size.'/'.$img))) return asset('/contents/'.$this->_folder.'/'.$size.'/'.$img);
        return asset('/contents/'.$this->_folder.'/'.$img);
    }

    public function getFeatureImage($size = null)
    {
        return $this->getImage($size);
    }



    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }
    public function getDeleteUrl()
    {
        return route('admin.'.$this->_route.'.delete',['id' => $this->id]);
    }
    
    public function getViewUrl()
    {
        return route('client.'.$this->_route.'.view',['slug' => $this->slug]);
    }

    public function deleteFile()
    {
        if($p = $this->getFilePath()){
            if(file_exists($p)) unlink($p);
        }
        return true;
    }
    
    public function trash()
    {
        $this->status = -1;
        $this->save();
        // $this->deleteFile();
        // if($this->postLinks){
        //     foreach ($this->postLinks as $link) {
        //         $link->delete();
        //     }
        // }
        //return parent::delete();
    }
    public function delete()
    {
        $this->trash();
    }

    public function erase()
    {
        
        $this->deleteFile();
        if($this->postLinks){
            foreach ($this->postLinks as $link) {
                $link->delete();
            }
        }
        return parent::delete();
    }
}
