<?php
namespace Cube\Html;

class InputList{
    protected $list = [];
    /**
     * @param array $list
     */
    public function __construct($list=[])
    {
        if(is_array($list)){
            $this->list = $list;
        }
    }

    public function attr($name=null,$value='<!---DEFAULT--->')
    {
        if(is_string($name)){
            if($value=='<!---DEFAULT--->'){
                if(!$this->list) return null;
                $return = [];
                foreach($this->list as $index => $input){
                    if(isset($input['attrs']) && isset($input['attrs'][$name])){
                        $return[$input['name']] = $input['attrs'][$name];
                    }
                }
                return $return;
            }
            return $this->setAttr($name,$value);
        }
        elseif(is_array($name)){
            if(!$this->list) return $this;
            foreach($name as $k => $v){
                if(!is_numeric($k)){
                    $this->setAttr($k,$v);
                }
            }
        }
        return $this;
    }

    public function setAttr($name=null,$value='<!---DEFAULT--->')
    {
        if(!$this->list) return $this;
        if($value!='<!---DEFAULT--->'){
            if(strtolower($name)=='class'){
                return $this->addClass($value,true);
            }
            foreach($this->list as $index => $input){
                if(isset($input['attrs'])){
                    $input['attrs'][$name] = $value;
                }else{
                    $input['attrs'] = [$name => $value];
                }
                $this->list[$index] = $input;

            }
        }
        return $this;
    }

    public function addClass($class=null,$new=false)
    {
        if(!$this->list) return $this;
        if(!is_null($class)){
            foreach($this->list as $index => $input){
                if(isset($input['className'])){
                    if(!$new){
                        $input['className'].= ' '. $class;
                    }else{
                        $input['className'] = $class;
                    }
                }else{
                    $input['className'] = $class;
                }
                $this->list[$index] = $input;

            }
        }
        return $this;
    }

    public function removeClass($class=null)
    {
        if(!$this->list) return $this;
        if(!is_null($class)){
            foreach($this->list as $index => $input){
                if(isset($input['className'])){
                    $c = str_replace($class,'', $input['className']);
                    $d = preg_replace('/\s+/', '', $c);
                    $input['className'] = $d;
                    $this->list[$index] = $input;
                }
            }
        }
        else{
            foreach($this->list as $index => $input){
                if(isset($input['className'])){
                    $input['className'] = '';
                    $this->list[$index] = $input;
                }
            }
        }
        return $this;
    }

    public function get($index = null)
    {
        if(is_null($index)) return $this->list;
        return isset($this->list[$index])?$this->list[$index]:null;
    }
}
?>