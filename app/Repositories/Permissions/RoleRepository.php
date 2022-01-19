<?php

namespace App\Repositories\Permissions;
/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;


class RoleRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Role::class;
    }
    
    
    /**
     * lay danh sach Role
     * @param  string $keyywords Từ khóa tìm kiếm
     * @param  string $search_by tìm theo tên cột
     * @param  integer $paginate  số kết quả mỗi trang
     * @return App\Role          Trả về mảng
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

    
}