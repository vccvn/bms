<?php

namespace Cube\Html;

class Label extends HtmlObject{
    protected $_data = [
        'text'                => '',
    ];

    protected $orginalData = [];

    public function __construct($args=[])
    {
        if(is_array($args)){
            parent::__construct('label');
            $this->orginalData = $args;
            $this->setOption($args);    
        }
    }

    public function setOption($name = null,$value = null)
    {
        $options = [];
        $attrs = [];
        $data = [];
        if(is_string($name)){
            return $this->setOpt($name,$value);
        }elseif(is_array($name)){
            foreach($name as $key => $val){
                $this->setOpt($key,$val);
            }
        }
    }

    protected function setOpt($name,$value=null)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
            if($name=='text'){
                $this->html($value);
            }
        }else{
            return $this->attr($name,$value);
        }
    }
    public function reset()
    {
        return $this->setOption($this->orginalData);
    }
}