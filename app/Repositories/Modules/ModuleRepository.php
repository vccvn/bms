<?php

namespace App\Repositories\Modules;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\Module;
use App\Models\ModuleRole;

use Illuminate\Support\Facades\Hash;

class ModuleRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Module::class;
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

    /**
     * lay danh sach user
     * @param  string $keyywords Từ khóa tìm kiếm
     * @param  string $search_by tìm theo tên cột
     * @param  integer $paginate  số kết quả mỗi trang
     * @return App\Module          Trả về mảng
     *
     * @suthor doanln
     * @created 2018-01-26
     * 
     */
    public function list($keyywords = null, $search_by=null, $paginate=null)
    {
        $query = $this->_model->where('status','>',0);
        if(is_string($keyywords) && strlen($keyywords) > 0){
            if($search_by){
                if(is_string($search_by)){
                    $query->where($search_by,'like',"%$keyywords%");
                }elseif(is_array($search_by)){
                    $data = [$keyywords,$search_by];
                    $query->where(function($q) use($data){
                        $b = $data[1];
                        $q->where(array_shift($b),'like', "%$data[0]%");
                        foreach($b as $col){
                            $q->orWhere($col,'like', "%$data[0]%");
                        }
                    });
                }
            }else{
                $query->where('name','like',"%$keyywords%");
            }
        }
        if(is_numeric($paginate) && $paginate > 0){
            $rs = $query->paginate($paginate);
        }else{
            $rs = $query->get();
        }
        return $rs;
    }

    public static function getParentSelectOption()
    {
        $repository = new static();
        return $repository->getParentSelection();

    }
    public function getParentSelection()
    {
        $data = ["không"];

        $query = $this->_model->where('type','default');
        if(self::$activeID){
            $query->where('ld','!=',self::$activeID);
        }
        if($list = $query->get()){
            foreach ($list as $module) {
                $data[$module->id] = $module->name;
            }
        }
        return $data;
    }

    public function getRoute($type = 'uri', $route = null)
    {
        $t = strtolower($type);

        if(in_array($t, ['uri', 'name', 'prefix']) && $route){
            return $this->_model->where('type', 'route_'.$t)->where('route',$route)->fieat();
        }
        return null;
    }

}