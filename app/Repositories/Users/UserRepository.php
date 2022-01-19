<?php

namespace App\Repositories\Users;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\UserMeta;

use Illuminate\Support\Facades\Hash;

class UserRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function save(array $attributes, $id=null)
    {
        if($id && $m = $this->_model->find($id)){
            $model = $m;
        }else{
            $model = $this->_model;
        }
        if(array_key_exists('password', $attributes) && $attributes['password']){
            $attributes['password'] = bcrypt($attributes['password']);
        }
        else{
            unset($attributes['password']);
        }
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    public function saveMetaSimple($id, $name,$value=null,$type='text')
    {
        if($user = $this->find($id)){
            $user->saveMetaSimple($name,$value,$type);
            return true;
        }
        return false;
    }


    public function getData($data=[])
    {
        $tags = [];
        $s = vn_to_lower(isset($data['@search'])?$data['@search']['keywords']:(isset($data['@find'])?$data['@find']:''));
        if($list = $this->get($data)){
            if($s){
                foreach($list as $t){
                    if($s == strtolower($t->name) || $s == $t->email || $s == $t->username){
                        $t->active = 1;
                    }else{
                        $t->active = 0;
                    }
                    $tags[] = $t;
                }
            }
            else{
                foreach($list as $t){
                    $t->active = 0;
                    $tags[] = $t;
                }
            }
        }
        return $tags;
    }

    /**
     * get user option 
     * @param array $args
     * @param boolean $with_email
     * 
     * @return array
     */
    public function getUserSelectOPtions(array $args = [], $with_email = false)
    {
        $options = ['Chọn tác giả'];
        if($list = $this->get($args)){
            if($with_email){
                foreach ($list as $user) {
                    $options[$user->id] = $user->name . " ($user->email)";
                }
            }else{
                foreach ($list as $user) {
                    $options[$user->id] = $user->name;
                }
            }
        }
        return $options;
    }

    /**
     * get user option 
     * @param boolean $with_email
     * 
     * @return array
     */
    public static function getAuthorSelectOption($with_email = true)
    {
        $users = new static();
        return $users->getUserSelectOPtions([], $with_email);
    }
}