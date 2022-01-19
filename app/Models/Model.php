<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

use Carbon\Carbon;

class Model extends BaseModel
{
    protected $defaultStatus = 200;
    public function __get_table()
    {
        return $this->table;
    }
    
    /**
     * chuyển trạng thái về đã xoa
     * @return boolean
     */
    public function moveToTrash()
    {
        if(in_array('status', $this->fillable)){
            $this->beforeMoveToTrash();
            $this->status = -1;
            $this->save();
            $this->afterMoveToTrash();
            return true;
        }else{
            return $this->erase();
        }
    }

    /**
     * phương thức sẽ được gọi trước khi chuyển bản ghi vào thùng rác
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeMoveToTrash()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi chuyển bản ghi vào thùng rác
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterMoveToTrash()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * chuyển trạng thái từ đã xoa đã xóa về mình thường
     * @return boolean
     */
    public function restore()
    {
        if(in_array('status', $this->fillable)){
            $defaultStatus = $this->defaultStatus ? $this->defaultStatus : 200;
            $this->beforeRestore();
            $this->status = $defaultStatus;
            $this->save();
            $this->afterRestore();
            
        }
    }

    /**
     * phương thức sẽ được gọi trước khi khôi phục bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeRestore()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi khôi phục bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterRestore()
    {
        # code...
        # do something...
        return true;
    }

    

    /**
     * xóa vĩnh viễn bản ghi
     * @return boolean
     */
    public function erase()
    {
        $this->beforeErase();
        $delete = parent::delete();
        $this->afterErase();
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeErase()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterErase()
    {
        # code...
        # do something...
        return true;
    }


    

    /**
     * xóa vĩnh viễn bản ghi
     * @return boolean
     */
    public function delete()
    {
        $this->beforeDelete();
        $delete = parent::delete();
        $this->afterDelete();
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function beforeDelete()
    {
        # code...
        # do something...
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
     * vui lòng override lại phương thức này nếu muốn sử dụng
     * @return mixed
     */
    public function afterDelete()
    {
        # code...
        # do something...
        return true;
    }

    public function canDelete()
    {
        return true;
    }

    //
    public function getShortDesc($length=null, $after = '...')
    {
        $desc = null;
        $trim = true;;
        if(isset($this->description) && $this->description){
            $desc = $this->description;
        }
        elseif(isset($this->short_desc) && $this->short_desc){
            return $this->short_desc;
        }
        elseif(isset($this->content) && $this->content){
            $desc = $this->content;
        }
        elseif(isset($this->detail) && $this->detail){
            $desc = $this->detail;
        }
        if($trim){
            if(!$length) $length = 120;
            $cnt = strip_tags(html_entity_decode($desc));
            if($length < strlen($cnt)){
                $a = explode(' ', str_limit(strip_tags($cnt),$length));
                $b = array_pop($a);
                return implode(' ', $a).$after;
            }else{
                return strip_tags($desc);
            }
        }
        return $desc;
    }


    public function shortContent($length=null, $after = '...')
    {
        $desc = null;
        $trim = true;;
        if(isset($this->content) && $this->content){
            $desc = $this->content;
        }
        if($trim){
            if(!$length) $length = 120;
            
            $cnt = strip_tags(html_entity_decode($desc));
            if($length < strlen($cnt)){
                $a = explode(' ', str_limit(strip_tags($cnt),$length));
                $b = array_pop($a);
                return implode(' ', $a).$after;
            }else{
                return strip_tags($desc);
            }
        }
        return $desc;
    }


    /**
     * tinh thoi gian
     * toi uu sau
     */
    public function calculator_time($date1=null,$date2 = null){
        if(!$date1) $date1 = 'created_at';
        $date = time();
        if($this->{$date1}){
            $date = strtotime($this->{$date1});
        }else{
            $date = strtotime($date1);
        }
        if(!$date2) $date2 = Carbon::now()->toDateTimeString();
        $diff = abs(strtotime($date2) - $date);
        $years = floor($diff / (365*60*60*24));
        if($years > 0)
            return $years.' năm trước';
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        if($months > 0)
            return $months.' tháng trước';
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
        if($days > 0)
            return $days.' ngày trước';
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
        if($hours > 0)
            return $hours.' giờ trước';
        $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
        if($minutes > 0)
            return $minutes.' phút trước';
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
            return $seconds.' giây trước';
    }
}
