<?php

namespace App\Models;



class Company extends Model
{
    protected $table = 'companies';
    public $fillable = [
        'name','address','email','phone_number',
        'google_ map', 'website', 'facebook', 'status'
    ];

    protected $_route = 'company';


    public function getUpdateUrl()
    {
        return route('admin.'.$this->_route.'.update',['id' => $this->id]);
    }

    public function buses()
    {
        return $this->hasMany('App\Models\Bus', 'company_id', 'id');
    }

    public function canDelete()
    {
        if($this->buses()->count()) return false;
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        if($this->buses){
            foreach ($this->buses as $bus) {
                $bus->delete();
            }
        }
        return true;
    }

}
