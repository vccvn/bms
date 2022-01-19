<?php

namespace App\Repositories\WebOptions;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

class WebOptionRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\WebOption::class;
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
     * @param  integer $paginate số kết quả mỗi trang
     * @return App\WebSetting    Trả về mảng
     *
     * @suthor doanln
     * @created 2018-01-26
     * 
     */
    public function list($option_group = 'siteinfo', $keyywords = null, $search_by=null, $paginate=null)
    {
        $query = $this->_model::where('option_group',$option_group);
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

    public function form($option_group = 'siteinfo', $keyywords = null, $search_by=null, $paginate=null)
    {
        if($list = $this->list($option_group, $keyywords,$search_by,$paginate)){
            $arr = [];
            foreach ($list as $item) {
                $arr[] = [
                    'id' => $item->id,
                    'type' => $item->type,
                    'name' => $item->name,
                    'value' => $item->value,
                    'comment' =>$item->comment
                ];
            }
            return $arr;
        }
        return [];
    }

    public function listFileField($option_group = 'siteinfo')
    {
        if($list = $this->_model->where('option_group',$option_group)->where('type','file')->get()){
            $arr = [];
            foreach($list as $item){
                $arr[] = $item->name;
            }
            return $arr;
        }
        return null;
    }

    public function listNotFileField($option_group = 'siteinfo')
    {
        if($list = $this->_model->where('option_group',$option_group)->where('type','!=','file')->get()){
            $arr = [];
            foreach($list as $item){
                $arr[] = $item->name;
            }
            return $arr;
        }
        return null;
    }
    public function addItem($option_group = 'siteinfo', $name,$type,$value=null,$comment=null)
    {
        if(!$this->_model->where('option_group',$option_group)->where('name',$name)->first()){
            $this->_model->fill(compact('option_group','name','type','value','comment'));
            $this->_model->save();
            return $this->_model;
        }
        return null;
        
    }
    public function saveValue($option_group = 'siteinfo', $name,$value=null)
    {
        if($item = $this->_model::where('option_group',$option_group)->where('name',$name)->first()){
            $item->value = $value;
            $item->update();
            return true;
        }
        return false;
    }


}