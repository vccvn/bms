<?php
namespace Cube\Html;

use Cube\Arr;
class FormData{
    protected $_data = [];
    
    /**
     * khoi tao doi tuong form Data
     * @param array $data du lieu
     * 
     */
    public function __construct($data=[])
    {
        $this->_data = (array) (self::convertToArray($data));
    }

    public function get($name=null)
    {
        if(is_null($name)) return $this->_data;
        return $this->$name;
    }
        

    public static function convertToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
    
        if (is_array($d)) {
            return array_map(__METHOD__, $d);
        }
        else {
            return $d;
        }
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;       
    }
    public function __get($name)
    {
        if(array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

    public function __unset($name)
    {
        unset($this->_data[$name]);
    }
    
}