<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 'username', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $_meta = [];

    protected $_route = 'admin.user';


    protected $defaultStatus = 200;

    ############################## Các kết nối ##############################

    public function __get_table()
    {
        return 'users';
    }

    protected $_roles = [];








    /**
     * ket noi voi bang user_meta
     * @return queryBuilder 
     */
    public function userMeta()
    {
        return $this->hasMany('App\\Models\\UserMeta','user_id','id');
    }
    
    public function userRole()
    {
        return $this->hasMany('App\\Models\\UserRole','user_id','id');
    }

    public function pages()
    {
        return $this->hasMany('App\\Models\\Page','user_id','id');
    }

    public function posts()
    {
        return $this->hasMany('App\\Models\\Post','user_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\\Models\\Product','user_id','id');
    }

    public function profile()
    {
        return $this->hasOne('App\\Models\\Profiles\\Profile','user_id','id');
    }


    public function checkRoles()
    {
        if(!$this->_roles && count($roles = $this->userRole()->get())>0){
            foreach($roles as $role){
                $roleName = strtolower($role->role()->name);
                if(!in_array($role, $this->_roles)){
                    $this->_roles[] = $roleName;
                }
            }
        }
        
    }

    public function hasRole($role = null)
    {
        $this->checkRoles();
        return in_array(strtolower($role), $this->_roles);
    }
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function is($role=null)
    {
        return $this->hasRole($role);
    }

    public function hasOnly($role = null)
    {
        $this->checkRoles();
        if(is_null($role)) return false;
        if(is_array($role)){
            if(count($role) == count($this->_roles)){
                $roles = array_unique($role);
                foreach($roles as $r){
                    if(!in_array(strtolower($r), $this->_roles)) return false;
                }
                return true;
            }
        }else{
            if(in_array(strtolower($role))) return true;
        }
        return false;
    }


    ############################## Các hàm lấy dữ liệu ###########################










    /**
     * kiem tra va set meta cho user
     * @return boolean
     */
    public function checkMeta()
    {
        if(!$this->_meta){
            if($list = $this->userMeta()->get()){
                $meta = [];
                foreach ($list as $m) {
                    $meta[$m->name] = $m->value;
                }
                $this->_meta = $meta;
                return true;
            }
            return false;
        }
        return true;
    }
    public function applyMeta()
    {
        $this->checkMeta();
        if($this->_meta){
            foreach ($this->_meta as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * lay ra 1 hoac tat ca cac thong tin trong bang user_meta
     * @param  string $meta_name ten cua meta can lay thong tin
     * @return mixed             du lieu trong bang meta
     */
    public function meta($meta_name = null)
    {
        if(!$this->checkMeta()) return null;
        if(is_null($meta_name)) return $this->_meta;
        if(array_key_exists($meta_name, $this->_meta)) return $this->_meta[$meta_name];
        return null;
    }
    




    // lay dang sach user_role
    public function rolelist()
    {
        return $this->hasMany('App\\Models\\UserRole','user_id','id')->get();
    }
    

    public function getRoles()
    {
        if($list = $this->hasMany('App\\Models\\UserRole','user_id','id')->get()){
            $arr = [];
            foreach($list as $item){
                $arr[] = $item->role();
            }
            return $arr;
        }
        return null;
    }
    // lấy ra tất cả các role_id mà người này dc tick
    public function getRoleIDList()
    {
        $arr = [];
        if($list = $this->rolelist()){
            foreach($list as $item){
                $arr[] = $item->role_id;
            }
        }
        return $arr;
    }




    public function toFormData()
    {
        $data = [];
        $fields = ['id','name','email','username','work','job'];
        $this->applyMeta();
        foreach ($fields as $f) {
            $data[$f] = $this->{$f};
        }
        return $data;
    }



    // ham ghet username khong dung hang

    public function getUsername($str=null,$id=null)
    {
        if(!$str && !isset($this->id) && !$id) return null;
        elseif($id){
            if($u = self::find($id)){
                if(!$str) $str = $u->name;
            }
        }
        elseif(isset($this->id) && $this->id){
            $id = $this->id;
        }
        $aslug = str_slug($str,'');
        $slug = null;
        $i = 1;
        $c = '';
        $s = true;
        do{
            $sl = $aslug.$c;
            if($item = self::where('username',$sl)->first()){
                if($id && $item->id == $id){
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
    /**
     * get avatar url
     * @param boolean $urlencode mã hóa url
     * @return string url of user's avatar
     */
    public function getAvatar($urlencode=false)
    {
        if($a = $this->meta('avatar')){
            $avatar = $a;
        }else{
            $avatar = 'default.png';
        }
        $url = url('contents/users/avatar/'.$avatar);
        if($urlencode) return urlencode($url);
        return $url;
    }

    public function getUpdateUrl()
    {
        return route($this->_route.'.update',['id' => $this->id]);
    }
    public function getDeleteUrl()
    {
        return route($this->_route.'.delete',['id' => $this->id]);
    }
    public function getProfileUrl()
    {
        return route('profile',['username' => $this->username]);
    }

    public function saveMetaSimple($name,$value=null,$type='text')
    {
        if($meta = $this->userMeta->where('name',$name)->first()){
            $meta->value = $value;
            $meta->save();
        }else{
            $meta = new UserMeta();
            $user_id = $this->id;
            $meta->fill(compact('user_id', 'type', 'name', 'value'));
            $meta->save();
        }
    }


    
    /**
     * chuyển trạng thái về đã xoa
     * @return boolean
     */
    public function moveToTrash()
    {
        $this->beforeMoveToTrash();
        $this->status = -l;
        $this->save();
        $this->afterMoveToTrash();
        return true;
    }

    /**
     * phương thức sẽ được gọi trước khi chuyển bản ghi vào thùng rác
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
        $defaultStatus = $this->defaultStatus ? $this->defaultStatus : 200;
        $this->beforeRestore();
        $this->status = $defaultStatus;
        $this->save();
        $this->afterRestore();
            
    }

    /**
     * phương thức sẽ được gọi trước khi khôi phục bản ghi
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
        if(!$this->canDelete()) return false;
        $this->beforeErase();
        $delete = parent::delete();
        $this->afterErase();
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
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
        if(!$this->canDelete()) return false;
        $this->beforeDelete();
        $delete = parent::delete();
        $this->afterDelete();
        return $delete;
    }

    /**
     * phương thức sẽ được gọi trước khi xóa bản ghi
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
        if($this->is('admin')) return false;
        return true;
    }

}
