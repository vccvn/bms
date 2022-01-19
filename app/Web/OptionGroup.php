<?php

namespace App\Web;

use App\Repositories\WebOptions\WebOptionRepository;

class OptionGroup{
	protected static $data = [
		'option' => [],
		'setting' => [],
		'siteinfo' => [],
		'embed' => [],
	];
	protected $attrs = [];
	protected $group = 'siteinfo';
	
	public function __construct($option_group='siteinfo')
	{
		$this->group = $option_group;
		$this->init();
	}

	public function init()
	{
		if(count(self::$data[$this->group])){
			$this->attrs = self::$data[$this->group];
			return true;
		}
		$repository = new WebOptionRepository;
		if($list = $repository->list($this->group)){
			$arr = [];
			foreach ($list as $item) {
				$t = $item->type;
				$name = $item->name;
				$val = $item->value;
				if($t=='file'){
					if($val){
						$val = url('contents/options/'.$item->option_group.'/'.$val);
					}
				}elseif($t=='number'){
					$number = ($val == (int) $val) ? (int) $val : (float) $val;
					$val = $number;
				}
				$arr[$name] = $val;
			}
			self::$data[$this->group] = $arr;
			$this->attrs = $arr;

		}
	}
	public function prefix($prefix = '')
	{
		$data = [];
		foreach($this->attrs as $name => $value){
			if(preg_match('/^'.$prefix.'_/i', $name)){
				$data[$name] = $value;
			}
		}
		return $data;
	}

	public function __set($name, $value)
    {
        $this->attrs[$name] = $value;
        
    }
    public function __get($name)
    {
        if (array_key_exists($name, $this->attrs)) {
            return $this->attrs[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return isset($this->attrs[$name]);
    }

    public function __unset($name)
    {
        unset($this->attrs[$name]);
	}
	
	public function __call($method, $params)
	{
		$t = (is_array($params) && isset($params[0])) ? $params[0] : null;
		if (array_key_exists($method, $this->attrs)) {
			if(!$this->attrs[$method] && $t){
				return $t;
			}
			return $this->attrs[$method];
        }
        return $t;
	}
}

?>