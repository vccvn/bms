<?php

namespace App\Repositories\Products;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Product;

class ProductRepository extends EloquentRepository
{
    
    protected $last_args = [];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
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

     
    
    public function saveMetaSimple($id, $name,$value=null,$type='text')
    {
        if($model = $this->find($id)){
            $model->saveMetaSimple($name,$value,$type);
            return true;
        }
        return false;
    }

        
    public function saveMeta($id, $name, $value=null, $type=null, $comment = null)
    {
        if($model = $this->find($id)){
            $model->saveMeta($name,$value,$type,$comment);
            return true;
        }
        return false;
    }
    public function saveManyMeta($id, $meta=[])
    {
        if($model = $this->find($id)){
            $model->saveManyMeta($meta);
            return true;
        }
        return false;
    }

    public function save(array $attributes = [], $id = null)
    {
        if(isset($attributes['detail'])){
            $home = rtrim(route('home'),'/').'/';
            $attributes['detail'] = str_replace($home, '/', $attributes['detail']);
            
        }
        return parent::save($attributes,$id);

    }



    public function deleteFeatureImage($id=null)
    {
        if($model = $this->find($id)){
            return $model->deleteFile();
        }
        return false;
    }


    public function viewUp($id)
    {
        if($model = $this->find($id)){
            $model->views++;
            $model->save();
        }
    }



    
    public function parseParams($data = [], $main_table = 'products')
    {
        $price = null;
        $allOfCategory = null;
        $limit = null;
        $sortby = null;
        $args = [];
        $actions = [];
        if (is_array($data)) {
            $abc = $data;
            foreach ($abc as $field => $vl) {
                $k = strtolower($field);
                if (substr($k, 0, 1) == '@') {
                    $f = substr($k, 1);
                    if ($f == 'price') {
                        $price = $vl;
                    } elseif ($f == 'all_of_category') {
                        $allOfCategory = $vl;
                    } elseif ($f == 'sort') {
                        $sortby = $vl;
                    } else {
                        $args[$field] = $vl;
                    }
                } else {
                    $args[$field] = $vl;
                }
            }
        }
        if ($allOfCategory!==null) {
            $actions[] = ['where', 'cate_map', 'like', "% $allOfCategory,%"];
        }
        if ($price) {
            if (is_string($price)) {
                if (count($pr = explode('-', $price)) == 2) {
                    $a = to_number($pr[0]);
                    $b = to_number($pr[1]);
                    if ($a > $b) {
                        $between = [$b, $a];
                    } else {
                        $between = [$a, $b];
                    }
                    $args['@whereBetween'] = ['sale_price', $between];
                } else {
                    $args['sale_price'] = $price;
                }
            } elseif (is_array($price)) {
                if (array_key_exists('0', $price) && array_key_exists('1', $price)) {
                    $args['@whereBetween'] = ['sale_price', $price];
                } elseif (array_key_exists('from', $price) && array_key_exists('to', $price)) {
                    $a = to_number($price['from']);
                    $b = to_number($price['to']);
                    if ($a > $b) {
                        $between = [$b, $a];
                    } else {
                        $between = [$a, $b];
                    }
                    $args['@whereBetween'] = ['sale_price', $between];
                } elseif (array_key_exists('min', $price) && array_key_exists('max', $price)) {
                    $a = to_number($price['min']);
                    $b = to_number($price['max']);
                    if ($a > $b) {
                        $between = [$b, $a];
                    } else {
                        $between = [$a, $b];
                    }
                    $args['@whereBetween'] = ['sale_price', $between];
                } elseif (array_key_exists('from', $price)) {
                    $args['@where'] = ['sale_price', '>=', $price['from']];
                } elseif (array_key_exists('to', $price)) {
                    $args['@where'] = ['sale_price', '<=', $price['to']];
                } elseif (array_key_exists('min', $price)) {
                    $args['@where'] = ['sale_price', '>=', $price['min']];
                } elseif (array_key_exists('max', $price)) {
                    $args['@where'] = ['sale_price', '<=', $price['max']];
                }
            }
        }
        if ($sortby) {
            $orderby = isset($args['@order_by']) ? (is_array($args['@order_by']) ? $args['@order_by'] : [$args['@order_by']]) : [];
            $orderByRaw = isset($args['@orderByRaw']) ? (is_array($args['@orderByRaw']) ? $args['@orderByRaw'] : [$args['@orderByRaw']]) : [];
            // sort by
            $sb = 'created_at';
            // sort type
            $st = 'ASC';
            // is sort by sale_total
            $issale = false;
            // ngau nhien
            $isrand = false;
            if (is_array($sortby)) {
                $sb = isset($sortby['by']) ? $sortby['by'] : 'created_at';
                $st = isset($sortby['type']) ? (strtolower($sortby['type']) == 'desc' ? 'DESC' : 'ASC') : 'ASC';
                if ($sb == 'sale_total') {
                    $issale = true;
                }
                // something here

            } elseif (in_array($sortby, ['sale_total', 'best_seller', 'slump'])) {
                $issale = true;
                $sb = 'sale_total';
                if ($sortby == 'slump') {
                    $st = 'ASC';
                } else {
                    $st = 'DESC';
                }
            } elseif (in_array($sortby, ['random', 'rand()', '@rand'])) {
                $orderByRaw[] = 'RAND()';
                $isrand = true;
            } elseif ($sortby != '') {
                $sb = $sortby;
            }

            if ($issale) {
                $sl = ', (SELECT SUM(order_products.product_qty)
                FROM order_products JOIN orders ON orders.id = order_products.order_id
                WHERE order_products.product_id = products.id AND orders.status = 2) AS sale_total';
                if (!isset($args['@selectRaw'])) {
                    $args['@selectRaw'] = 'products.*' . $sl;
                } else {
                    $args['@selectRaw'] .= $sl;
                }

            }
            if (!$isrand) {
                if ($issale) {
                    $orderByRaw[] = "$sb $st";
                } else {
                    $orderby[$sb] = $st;
                    $args['@oeder_by'] = $orderby;
                }

            }
            $args['@orderByRaw'] = $orderByRaw;

        }
        if(isset($args['@actions'])){
            $args['@actions'] = array_merge($args['@actions'], $actions);
        }
        else{
            $args['@actions'] = $actions;
        }

    
        return $args;
    }

    public function makeQuery($args = [])
    {
        return $this->query($this->parseParams($args),'products');
    }

    /**
     * lay danh sach san pham
     * @param array $data du lieu truyen vao
     * @return App\Product          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-01-26
     *
     */
    
    public function getProducts($data = null)
    {
        $rs = $this->get($this->parseParams($data),'products');
        return $rs;
    }

    public function first($data = null, $main_table = 'products')
    {
        $query = $this->makeQuery($data);

        return $query->first();
    }

    public function countProducts($data = null)
    {
        return $this->count($this->parseParams($data));
    }

    public function filter($request, $args = [])
    {
        $a = (array) $args;
        $s = $request->search?$request->search:($request->s?$request->s:null);
        $perpage = $request->perpage?$request->perpage:12;
        $orderby = [];
        
        if($request->sortby){
            $sb = strtolower($request->sortby);
            if($sb == 'price-up'){
                $orderby['sale_price'] = 'ASC';
            }elseif($sb == 'price-down'){
                $orderby['sale_price'] = 'DESC';
            }elseif($sb == 'likes'){
                $orderby['likes'] = 'DESC';
            }
        }
        $orderby['created_at'] = 'DESC';
        $args = [
            '@search' => $s,
            '@search_by' => ['name','keywords'],
            '@order_by' => $orderby,
            '@paginate' => $perpage
        ];
        if(!is_null($request->min_price) || !is_null($request->max_price)){
            $price = [];
            if(!is_null($request->min_price)){
                $price['min'] = $request->min_price;
            }
            if(!is_null($request->max_price)){
                $price['max'] = $request->max_price;
            }
            $args['@price'] = $price;
            
        }
        $args = array_merge($a,$args);
        $list = $this->getProducts($args);
        
        $qs = parse_query_string(null,$request->all());
        if($qs){
            $list->withPath('?'.$qs);
        }
        
        return $list;
    }

    /**
     * tim kiem
     * @param Request $request 
     * @param array $args
     * @return array
     */
    public function search($request, $args = [])
    {   $t = 'products.';
        $search = $request->search?$request->search:($request->s?$request->s:($request->keyword?$request->keyword:null));
        $data = (array) $args;
        unset($data['@search']);
        if(strlen($search)){
            $data['@actions'] = [
                ['selectRaw',$t.'*'],
                ['where', function($query) use($search, $t){
                    $query->where($t.'name','like',"%$search%");
                    $query->orWhere($t.'keywords','like',"%$search%");
                    $query->orWhereRaw($t."id in (
                        SELECT tag_links.object_id FROM tag_links INNER JOIN tags ON tags.id = tag_links.tag_id
                        WHERE tag_links.object='product' and (tags.lower like '%".str_replace("'", "\'", strtolower($search))."%' OR tags.tagname like '%".str_slug($search)."%')
                    )");
                    
                }],
                ['orderBy',$t.'created_at','DESC']
            ];
        }
        $list = $this->getProducts($data);
        if(isset($data['@paginate'])){
            $list->withPath('?'.parse_query_string(null,$request->all()));
        }
        return $list;
    }

    public function makeCateMap($cate_id)
    {
        $rep = new ProductCategoryRepository;
        if(!$cate_id || !($cate = $rep->find($cate_id))) return '';
        $str = ' '.implode(', ', $cate->getMap()).',';
        return $str;
    }
}