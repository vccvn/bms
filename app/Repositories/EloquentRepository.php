<?php
namespace App\Repositories;

use App\Light\Parameter;

/**
 * Created by PhpStorm.
 * User: Gin
 * Date: 12/22/17
 * Time: 4:53 PM
 * @updated DoanLN
 */
abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    ### DOANLN ===
    /**
     * @var integer
     */

    public $total_count = 0;

     /**
      * du lieu lan gan day
      * @var array
      */
    protected $last_params = [];


    /**
     * @var queryBuilder
     */

    protected $last_query_builder = null;



    /**
     * sql functions
     * @var array $sqlclause
     */
    protected $sqlclause = [
        // select
        'select','selectRaw',
        // from
        'from','fromRaw',
        // join
        'join','leftJoin','crossJoin',
        // where
        'where','whereRaw','whereIn','whereNotIn','whereBetween','whereNotBetween', 'whereDay', 'whereMonth', 'whereYear', 
        'whereDate','whereTime',
        'whereColumn',
        // orWhere
        'orWhere','orWhereRaw','orWhereIn','orWhereNotIn','orWhereBetween','orWhereNotBetween', 'orWhereDay', 'orWhereMonth', 
        'orWhereYear', 'orWhereDate', 'orWhereTime',
        'orWhereColumn',
        // group by
        'groupBy',
        // having
        'having','havingRaw',
        // order by
        'orderBy','orderByRaw',
        // limit
        'skip','take',
    ];
    public $default_params = [];

    public $fill_values = [];

    public $fixable_params = [];



    /**
     * @var $params tham so truy van
     */
    protected $_params = [];

    ### END DOANLN ===
    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();


    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }


    /**
     * đưa tất cả về 0 =))))
     * 
     */
    public function reset($all = false)
    {
        $this->params = new Parameter();
        $this->total_count = 0;
        $this->query = null;
        $this->last_query_builder = null;
        $this->last_params = [];

        if($all){
            $this->removeFixableParam();
        }
    }
    
    

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        if($this->fill_values){
            $attributes = array_merge($this->fill_values, $attributes);
        }
        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Delete
     *
     * @param int|int[] $id
     * @return bool
     */
    public function delete($id)
    {
        // nếu xóa nhiều
        if(is_array($id)){
            $ids = [];
            $list = $this->get(['id' => $id]);
            if(count($list)){
                foreach ($list as $item) {
                    if(!$item->canDelete()) continue;
                    $ids[] = $item->id;
                    $item->delete();
                }
            }
            return $ids;
        }
        $result = $this->find($id);
        if($result) {
            if($result->canDelete()){
                $result->delete();
                return true;
            }
            
        }

        return false;
    }

    
    ### DOANLN ===
    public function findBy($prop='name',$value=null)
    {
        if($prop && $value!==null){
            return $this->first([$prop=>$value]);
        }
        return null;
    }

    public function getBy($prop='name',$value=null)
    {
        if($prop && $value!==null){
            return $this->get([$prop=>$value]);
        }
        return null;
    }



    /**
     * trash
     *
     * @param $id
     * @return bool
     */
    public function moveToTrash($id)
    {
        $result = $this->find($id);
        if($result) {
            return $result->moveToTrash();
        }

        return false;
    }

    /**
     * khôi phục bản ghi
     * @param int $id
     */
    public function restore($id)
    {
        $result = $this->find($id);
        if($result) {
            return $result->restore();
        }

        return false;
    }

    /**
     * xóa vĩnh viễn bản ghi
     * @param int $id
     */
    public function erase($id)
    {
        $result = $this->find($id);
        if($result) {
            return $result->erase();
        }

        return false;
    }

    /**
     * luu du lieu
     * @param  array  $attributes mang du lieu
     * @param  integer $id        id cua ban ghi
     * @return Eloquan            
     */
    public function save(array $attributes, $id=null)
    {
        if($id && $m = $this->_model->find($id)){
            $model = $m;
        }else{
            $model = new $this->_model;
            if($this->fill_values){
                $attributes = array_merge($this->fill_values, $attributes);
            }
        }
        $model->fill($attributes);
        $model->save();
        return $model;
    }


    public function model()
    {
        return new $this->_model;
    }

    public function _model()
    {
        return new $this->_model;
    }


    /**
     * lấy về các bản ghi phù hợp với tham số đã cung cấp
     * @param array $data 
     */
    public function get($data = null, $main_table = null)
    {

        $paginate = null;
        $limit = null;
        if(is_array($data)){
            if(isset($data['@paginate'])){
                $paginate = $data['@paginate'];
                unset($data['@paginate']);
            }
        }
        if(is_array($data)){
            if(isset($data['@limit'])){
                $limit = $data['@limit'];
                unset($data['@limit']);
            }
        }
        
        $query = $this->query($data, $main_table);
        $this->last_query_builder = $query;
        $this->total_count = $query->count();
        if($limit) $this->buildLimitQuery($query, $limit);
        if($paginate){
            $collection = $query->paginate($paginate);
        }else{
            $collection = $query->get();
        }
        
        return $collection;
    }

    public function getOnly($data = null, $main_table = null)
    {

        $paginate = null;
        $limit = null;
        if(is_array($data)){
            if(isset($data['@paginate'])){
                $paginate = $data['@paginate'];
                unset($data['@paginate']);
            }
        }
        if(is_array($data)){
            if(isset($data['@limit'])){
                $limit = $data['@limit'];
                unset($data['@limit']);
            }
        }
        
        $query = $this->query($data, $main_table);
        if($limit) $this->buildLimitQuery($query, $limit);
        if($paginate){
            $collection = $query->paginate($paginate);
        }else{
            $collection = $query->get();
        }
        
        return $collection;
    }

    public function first($data = [], $main_table = null)
    {
        $query = $this->query($data, $main_table);
        $this->last_query_builder = $query;
        if(is_array($data)){
            //
        }
        return $query->first();
    }
    public function count($data = [], $main_table = null)
    {
        if(is_array($data)){
            if(isset($data['@paginate'])){
                unset($data['@paginate']);
            }
        }
        if(is_array($data)){
            if(isset($data['@limit'])){
                unset($data['@limit']);
            }
        }
        $query = $this->query($data, $main_table);
        $this->last_query_builder = $query;

        return $query->count();
    }
    public function countLast()
    {
        $data = $this->last_params;
        $query = $this->query($data);
        return $query->count();
    }


    /**
     * thay the noi dung mot
     * @param string $columns
     * @param string $find
     * @param string $replace
     * @return void
     */
    
     public function replace($columns, $find = null, $replace='')
     {
         if($find && $list = $this->get()){
             if(is_array($columns)){
                 $cols = $columns;
             }elseif(count($c = explode(',',str_replace(' ','', $columns)))){
                 $cols = $c;
             }else{
                 return false;
             }
             $i = 0;
             foreach ($list as $item) {
                 foreach($cols as $col){
                     $col = trim($col);
                     if($col!='id' && isset($item->{$col})){
                         $item->{$col} = str_replace($find, $replace, $item->{$col});
                         
                     }
                 }
                 $i++;
                 $item->save();
             }
             return $i;
         }
         return false;
     }


    public function getSlug($str=null, $id=null, $col = null, $value=null)
    {
        if(!$str && !$id=null) return null;
        if(!$str) return null;
        $aslug = str_slug($str,'-');
        $slug = null;
        $i = 1;
        $c = '';
        $s = true;
        $args = [];
        if($col){
            $args[$col] = $value;
        }
        do{
            $sl = $aslug.$c;
            $args['slug'] = $sl;

            if($pf = $this->first($args)){
                if($id && $pf->id == $id){
                    $slug = $sl;
                    $s = false;
                    break;
                }
                $c='-'.$i;
            }else{
                $slug = $sl;
                $s = false;
                break;
            }

            $i++;
        }while($s);
        return $slug;
    }



    /**
     * thêm tham số
     */
    public function addDefaultParam()
    {
        $params = func_get_args();
        if(count($params)>1){
            $this->default_params[] = $params;
        }
        return $this;
    }

    public function resetDefaultParams()
    {
        $this->default_params=[];
        return $this;
    }

    /**
     * thêm giá trị mặc định khi tạo mới
     */
    public function addDefaultValue($key, $value = null)
    {
        if(is_string($key)){
            $this->fill_values[$key] = $value;
        }elseif(is_array($key)){
            foreach ($key as $k => $v) {
                $this->fill_values[$k] = $v;
            }
        }
        return $this;
    }

    /**
     * thêm tham số có thể override
     * @param string|array $name có thể là tên cột hoac458 một mảng
     * @param mixed        $value giá trị 
     * 
     * @return object EloquanRepository
     */
    public function addFixableParam($name, $value=null)
    {
        if(is_array($name)){
            foreach($name as $key => $val){
                if(is_numeric($key)){
                    if(is_string($val)){
                        $this->fixable_params[$val] = $value;
                    }
                }else{
                    $this->fixable_params[$key] = $val;
                }
            }
        }elseif (is_string($name)) {
            $this->fixable_params[$name] = $value;
        }
        return $this;
    }

    /**
     * xóa giá trị tham số mặt định
     * @param array|string $name
     * 
     * @return object EloquanRepository
     */
    public function removeFixableParam($name=null)
    {
        if(is_array($name)){
            foreach($name as $val){
                unset($this->fixable_params[$val]);
            }
        }elseif (is_string($name)) {
            unset($this->fixable_params[$name]);
        }
        else{
            $this->fixable_params = [];
        }
        return $this;
    }


    /**
     * kiểm tra field
     * @param string $field tên cột
     * @return boolean
     */
    public function checkField($field)
    {
        return in_array($field, $this->_model->fillable);
    }

    

    public function getFields()
    {
        return array_merge(['id'], $this->_model->fillable);
    }


    
    /**
     * tạo qury builder 
     * @param array $args            Mảng các tham số hoặc têm hàm và tham số hàm
     * @param string $main_table     Tên bảng chính nếu trong trường hợp nối nhiều bảng
     * @return quryBuilder
     * @author DoanLN
     */
    public function query($args=[], $main_table = null)
    {
        $keywords = null; 
        $search_by= null; 
        $orderby=null;
        $limit = null;
        $actions = [];
        $parameters = $this->_params;
        $param_actions = isset($parameters['@actions'])?$parameters['@actions']:[];
        unset($parameters['@actions']);
        if(count($parameters)){
            $args = array_merge($parameters, (array)$args);
        }
        
        
        if($this->fixable_params){
            $args = array_merge($this->fixable_params, $args);
        }
        // pewfix 
        $prefix = $main_table ? $main_table . '.':'';
        if(!$prefix && $pre = $this->model()->__get_table()){
            $prefix = $pre.'.';
        }
        // tao query builder
        $query = $this->_model->where($prefix.'id','>',0);

        // các tham số mặc định
        if(count($this->default_params)){
            foreach ($this->default_params as $key => $param) {
                $param[0] = (count(explode('.',$param[0])) > 1)? $param[0] : $prefix . $param[0];
                call_user_func_array([$query,'where'],$param);
            }
        }
        // kiểm tra và tạo query các tham số truyền vào
        if(is_array($args)){

            // duyệt mảng tham số truyền vào
            foreach($args as $field => $vl){
                if(is_numeric($field)){
                    // do action
                    $this->doAction([$vl], $query, $prefix);
                    continue;
                }
                $k = strtolower($field);
                // kiểm tra các lệnh đặc biệt bắt đầu với ký tự '@'
                if(substr($k,0,1) == '@'){
                    $f = substr($k,1);
                    switch ($f) {
                        case 'search':
                            // tim kiem
                            if(!is_array($vl)){
                                $keywords = $vl;
                            }else{
                                if(isset($vl['keywords'])){
                                    $keywords = $vl['keywords'];
                                }
                                elseif(isset($vl['keyword'])){
                                    $keywords = $vl['keyword'];
                                }
                                if(isset($vl['by'])){
                                    $search_by = $vl['by'];
                                }
                            }
                            break;
                        
                        case 'search_by':
                            // tim kiem
                            $search_by = $vl;
                            break;
                        
                        case 'order_by':
                            // order by
                            $orderby = $vl;
                            break;
                        
                        case 'limit':
                            // limit (skip & take)
                            $limit = $vl;
                            break;
                        
                        case 'actions':
                            // thược hiện các hành động với model thông qua các mảng con chứa phương thức và các tham số
                            $actions = $vl;
                            break;
                        
                        default:
                            // nếu không rơi vào các TH trên thì kiểm tra key truyền vào có phải là phương thức của query builder hay không

                            if(in_array($func = substr($field,1),$this->sqlclause)){ 
                                // la method cua query buildr
                                if(is_array($vl) && isset($vl[0])){
                                    
                                    if(is_array($vl[0]) && isset($vl[0][0])){
                                        foreach($vl as $p){
                                            call_user_func_array([$query,$func],$p);
                                        }
                                    }else{
                                        call_user_func_array([$query,$func],$vl);
                                    }
                                }else{
                                    $param = is_array($vl)?$vl:[$vl];
                                    call_user_func_array([$query,$func],$param);
                                }
                            }
                            break;
                    }
                }else{
                    // không bắt đầu bằng @ thì sẽ gọi hàm where với column là key và so sánh '=' 
                    $hasPrefix = (count(explode('.',$field)) > 1);
                    if(!$hasPrefix){
                        // nếu không có prefix và ko có trong fillable thì bỏ qua
                        if(!in_array($field, $this->_model->fillable) && $field!='id') continue;
                        $f = $prefix . $field;
                    }
                    else $f = $field;
                    
                    if(is_array($vl)){
                        // nếu value là mảng sẽ gọi where in
                        $query->whereIn($f,$vl);
                    }else{
                        $query->where($f,$vl);
                    }
                }
            }
        }

        
        $actions = array_merge($param_actions, $actions);
        
        // tim kiem trong bang dua tren cac cot
        $query = $this->buildSearchQuery($query, $keywords, $search_by, $prefix);
        // thao tac voi query builder thong qua tham so actions
        $query = $this->doAction($actions, $query);
        // build orderby
        $query = $this->buildOrderByQuery($query,$orderby, $prefix);
        // build limit
        $query = $this->buildLimitQuery($query, $limit);

        $this->_params = [];
        
        return $query;
    }

    protected function buildSearchQuery($query, $keywords, $search_by=null, $prefix = null)
    {
        if(is_string($keywords) && strlen($keywords) > 0){
            if($search_by){
                if(is_string($search_by)){
                    // tim mot cot
                    $f = (count(explode('.',$search_by)) > 1)? $search_by : $prefix . $search_by;
                    $query->where($f,'like',"%$keywords%");
                }elseif(is_array($search_by)){
                    // tim theo nhieu cot
                    $query->where(function($q) use($keywords,$search_by, $prefix){
                        $b = $search_by;
                        $c = array_shift($b);
                        $f2 = (count(explode('.',$c)) > 1)? $c : $prefix . $c;
                        $k2 = str_slug($keywords);
                        $q->where($f2,'like', "%$keywords%");
                        foreach($b as $col){
                            $f3 = (count(explode('.',$col)) > 1)? $col : $prefix . $col;
                            $q->orWhere($f3,'like', "%$keywords%")->orWhere($f3,'like', "%$k2%");
                        }
                    });
                }
            }else{
                // mac dinh
                $query->where($prefix.'name','like',"%$keywords%");
            }
        }
        return $query;
    }
    protected function doAction($actions, $query=null, $prefix=null){
        if(!$query) $query = $this->_model->where('id','>',0);
        if(is_array($actions)){
            
            foreach ($actions as $act) {
                // duyet qua cac action
                if(is_array($act)){
                    $aract = $act;
                    // array action
                    $f = array_shift($aract);

                    if(is_string($f) && in_array($f,$this->sqlclause)){
                        // map:
                        // $actions = [
                        //     // ....
                        //     ['where', 'name', 'doan'], // tham số đầu tiên là tên phương thức
                        //     // ....
                        // ]
                        // neu action la 1 mang 
                        
                        if(is_array($aract)){
                            if(is_array($aract[0]) && isset($aract[0][0])){
                                // map:
                                // $actions = [
                                //     // ....
                                //     ['where', ['column1', 'value1']], 
                                //     // ....
                                // ]
                                // neu action la 1 mang 
                                

                                foreach($aract[0] as $p){
                                    // goi ham
                                    call_user_func_array([$query,$f],$p);
                                }
                            }else{
                                call_user_func_array([$query,$f],$aract);
                            }
                        }
                    }
                    elseif(in_array($f,$this->sqlclause)){
                        // map:
                        // $actions = [
                        //     // ....
                        //     ['where'=>['name','doan']],
                        //     // ....
                        // ]
                        // neu action la 1 mang 
                        foreach ($act as $func => $param) {
                            // duyet qua mang day lay ten action
                            if(is_numeric($func) && is_array($param) && count($param)>1){
                                $f = array_shift($param);
                                if(in_array($f,$this->sqlclause) && count($param)){
                                    if(is_array($param[0]) && isset($param[0][0])){
                                        foreach($param as $p){
                                            call_user_func_array([$query,$f],$p);
                                        }
                                    }else{
                                        call_user_func_array([$query,$f],$param);
                                    }
                                }
                            }elseif(in_array($func,$this->sqlclause)){
                                if(!is_array($param)){
                                    call_user_func_array([$query,$func],[$param]);
                                }
                                if(is_array($param[0]) && isset($param[0][0])){
                                    foreach($param as $p){
                                        call_user_func_array([$query,$func],$p);
                                    }
                                }else{
                                    call_user_func_array([$query,$func],$param);
                                }
                            }
                        }
                    }
                    
                }
            }
        }
        return $query;
    }

    protected function buildOrderByQuery($query, $orderby = null, $prefix = null)
    {
        if($orderby){
            // order by mot hoac nhieu cot
            if(is_string($orderby)){
                // mot cot
                if(count($odb = explode('-',$orderby))==2){
                    $b = strtoupper($odb[1]);
                    if($b!='DESC') $b = 'ASC';
                    $f = (count(explode('.',$odb[0])) > 1)? $odb[0] : $prefix . $odb[0];
                    $query->orderBy($f, $b);
                }else{
                    // ngau nhien
                    if(strtolower($orderby) == 'rand()'){
                        $query->orderByRaw($orderby);
                    }
                    else{
                        // mac dinh
                        $f = (count(explode('.',$orderby)) > 1)? $orderby : $prefix . $orderby;
                        $query->orderBy($f);
                    }
                }
            }elseif(is_array($orderby)){
                // nhieu cot
                foreach($orderby as $col => $type){
                    if(is_numeric($col) && is_string($type)){
                        $f = (count(explode('.',$type)) > 1)? $type : $prefix . $type;
                        $query->orderBy($f);
                    }else {
                        $f = (count(explode('.',$col)) > 1)? $col : $prefix . $col;
                        $query->orderBy($f,$type);
                    }
                }
            }
        }
        return $query;
    }
    public function buildLimitQuery($query, $limit=null)
    {
        // limit
        if($limit){
            if(is_numeric($limit)){
                $query->skip(0)->take($limit);
            }elseif (is_string($limit)) {
                if(count($l = explode(',', str_replace(' ','',$limit)))==2){
                    $query->skip($l[0])->take($l[1]);
                }
            }
            elseif (is_array($limit) && isset($limit[0]) && isset($limit[1])) {
                $query->skip($limit[0])->take($limit[1]);
            }
        }
        return $query;
    }

    /**
     * kiểm tra isset vd isset($light->prop)
     * @param string $name
     */
	
    public function __isset($name)
    {
        return isset($this->_params[$$name]);
    }

    /**
     * loại bỏ thuộc tính qua tên thuộc tính
     */
    public function __unset($name)
    {
        unset($this->_params[$name]);
	}

     /**
     * gắn giá trị cho thuộc tính với name là tên thuộc tính
     * value là giá trị của thuộc tính
     * @param string $name
     * 
     * 
     */
	public function __set($name, $value)
    {
        $this->_params[$name] = $value;
        
    }

    /**
     * them chuoi tim kiem
     * @param string $keywords
     * @param string/array $search_by
     * 
     * @return object
     */
    public function addsearch(string $keywords = null, $search_by = null)
    {
        $this->_params['@search'] = [
            'keyword' => $keywords,
            'by' => $search_by
        ];
        return $this;
    }

    /**
     * order by
     * @param mixed
     * @param string
     */
    public function order_by($column = null, $type='asc')
    {
        $orderby = is_array($column)?$column:[$column=>$type];
        if(array_key_exists('@order_by', $this->_params)){
            $this->_params['@order_by'] = array_merge($this->_params['@order_by'], $orderby);
        }else{
            $this->_params['@order_by'] = $orderby;
        }
        return $this;
    }

    public function limit($start=null,$length=0)
    {
        if(is_array($start)){
            $this->_params['@limit'] = $start;
        }elseif($length){
            $this->_params['@limit'] = [$start, $length];
        }else{
            $this->_params['@limit'] = $start;
        }
        return $this;
    }


	public function __call($method, $params)
	{
		if (in_array($method, $this->sqlclause)) {
            if(!isset($this->_params['@actions'])){
                $this->_params['@actions'] = [];
            }
			$this->_params['@actions'][] = array_merge([$method], $params);
        }
        return $this;
    }
    
    public function __toString()
    {
        return json_encode($this->_params);
    }
}