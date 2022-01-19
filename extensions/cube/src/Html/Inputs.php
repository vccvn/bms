<?php
namespace Cube\Html;

use Cube\Files;
use Cube\Arr;
class Inputs extends HtmlObject{
    protected $_data = [];

    protected $_attrs = [
        'error_class' => 'has-error',
        'className' => null,
    ];

    protected $input_list = [];

    protected $input_file = 'common';

    /**
     * @var object cacv thong bao loi cua laravel
     */
    
    protected $errors = null;

    /**
     * @var array du lieu form dang nang 
     */
    
    protected $form_data = null;
    
    /**
     * @var array mang input
     */
    
    protected $inputs = null;

    protected $actions = [];

    
    /**
     * khoi tao doi tuong form
     * @param string $input_file ten file json
     * @param string|array $input_list danh sach 
     * @param array $form_data du lieu
     * @param array|object $errors thong bao loi
     * @param array $options cac option
     */
    public function __construct($input_file = 'common', $input_list = '*', $form_data = [], $errors = null, $options=null)
    {
        parent::__construct(null,null,$options);
        $this->input_file = $input_file;
        $this->input_list = $input_list;
        $this->form_data = is_a($form_data,'Cube\\Arr')?$form_data:(new Arr($form_data));
        $this->errors = $errors;
        $this->inputs = new InputList($this->getInputFields());
        $this->prepare();
    }

    public function prepare()
    {
        $inputs = $this->inputs->get();
        $data = $this->form_data;
        $errors = $this->errors;
        $i = 0;
        foreach($inputs as $inp){
            $name = $inp['name'];
            $id = isset($inp['id'])?$inp['id']:$name;
            $lbl = isset($inp['label'])?$inp['label']:(isset($inp['text'])?$inp['text']:$name);

            $inp['placeholder'] = array_key_exists('placeholder', $inp)?$inp['placeholder']:(array_key_exists('text', $inp)?$inp['text']:null);
            $inp['label'] = $lbl;
            $nasp = preg_replace('/\[\]/i','',$name);
            $old = old($nasp);
            $vl = ($old!==null)?$old:$data->get($nasp);
            if($vl!==null) $inp['value'] = $vl;
            if($errors->has($nasp)){
                $inp['error'] = $errors->first($nasp);
            }
            $input = new Input($inp);
            $input->setOption($this->_attrs);
            if(!$input->id){
                $input->id = $id;
            }
            $input->parent = $this;
            $this->_data[$nasp] = $input;
            $i++;
        }
        
    }

    public function get($name=null)
    {
        if(is_null($name)) return $this->_data;
        return $this->$name;
    }
        
    public function getInputFields()
    {
        if(is_string($this->input_file)){
            return self::getInputList($this->input_file,$this->input_list);
        }
        if(is_array($this->input_file)){
            return $this->input_file;
        }
        return [];
    }


    // lay danh sach input tu file json
	public static function getInputList($filename,$fieldList='*')
	{
		$s=null;
		if(is_string($fieldList)){
			if($fieldList!="*"){
				$s = explode(',', str_replace(' ', '', $fieldList));
			}
		}elseif(is_array($fieldList)){
			$s = $fieldList;
		}
		$inputs = array();
		$files = new files();
		$files->cd('json/forms');
		if($inps = $files->getJSON($filename)){
			if(is_array($s)){
				foreach ($s as $name) {
					if(isset($inps->{$name})){
						$inp = $inps->{$name};
						if(!isset($inp->name)){
							$inp->name = $name;
                        }
                        $inputs[] = self::convertToArray($inp);
					}
				}
			}else{
				foreach ($inps as $name => $inp) {
					if(!isset($inp->name)){
						$inp->name = $name;
                    }
                    $inputs[] = self::convertToArray($inp);
				}
			}
		}
		return $inputs;
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