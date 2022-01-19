<?php

/**
 * @author Doanln
 * @copyright 2017
 */

namespace Cube;
define('HTMLINPUTDEFAULTVALUE','<!-- Doan Dep Trai -->');

class HtmlInput{
    public $type = 'text';
    public $name = '';
    public $id = '';
    public $className = '';
    public $value = null;
    public $data = null;
    public $default = null;
    public $label = null;
    public $props = [];
    public $placeholder = '';

    public function __construct()
    {
        
        if(func_num_args()>0){
            $args = func_get_args();
            if(is_array($args[0])){
                $this->setAttr($args[0]);
            }else{
                $list = ['type','name','value', 'data', 'default', 'id','className','props', 'placeholder','label'];
                $listData = [];
                $t = count($args);
                for($i = 0; $i < $t; $i++){
                    $listData[$list[$i]] = $args[$i];
                }
                $this->setAttr($listData);
            }
        }
    }

    public function addClass($className)
    {
        $this->className .= ' '.$className;
    }
    public function setAttr($attrs = null, $value = HTMLINPUTDEFAULTVALUE)
    {
        if(is_array($attrs)){
            foreach($attrs as $attr => $val){
                $this->{$attr} = $val;
            }
        }elseif(is_string($attrs) && $val != HTMLINPUTDEFAULTVALUE){
            $this->{$attrs} = $value;
        }
    }
    public function render()
    {
        
        $type = $this->type;
        $name = $this->name;
        $val = is_null($this->value)?$this->default:$this->value;
        $data = $this->data;
        $properties = self::arr_parse(['id'=>$this->id,'class'=>$this->className,'placeholder' => $this->placeholder],$this->props);
        $label = $this->label;



        $inp = null;
        if($val == HTMLINPUTDEFAULTVALUE){
            $val = null;
        }
        
        $t = strtolower($type);
        if($t=='select'){
            $inp = self::getSelectTag($name,$data,$val,$properties);
        }elseif($t=='checkbox'){
            $inp = self::getCheckBox($name,$val,$label,$properties);
        }elseif($t=='radio'){
            $inp = self::getRadioButtons($name,$data,$val,$properties);
        }elseif($t=='textarea'){
            $inp = self::createTag('textarea',$val,self::arr_parse(array('name'=>$name),$properties));
        }else{
            $inp = self::createTag('input',$val,self::arr_parse(array('type' => $type, 'name'=>$name, 'value' => $val),$properties));
        }

        return $inp;
    }
    public static function create($type='text',$name=null,$val=HTMLINPUTDEFAULTVALUE,$data=array(),$properties=array())
    {
        //$properties['name'] = $name;
        $inp = null;
        if($val == HTMLINPUTDEFAULTVALUE){
            $val = null;
        }
        
        $t = strtolower($type);
        if($t=='select'){
            $inp = self::getSelectTag($name,$data,$val,$properties);
        }elseif($t=='checkbox'){
            $inp = self::getCheckBox($name,$val,$label,$properties);
        }elseif($t=='radio'){
            $inp = self::getRadioButtons($name,$data,$val,$properties);
        }elseif($t=='textarea'){
            $inp = self::createTag('textarea',$val,self::arr_parse(array('name'=>$name),$properties));
        }else{
            $inp = self::createTag('input',$val,self::arr_parse(array('type' => $type, 'name'=>$name, 'value' => $val),$properties));
        }

        return $inp;

    }
    protected static $head_tags = array('link','script','meta','style');
    protected static $head_meta = array();
    protected static $_simple_tags = array('link','input','img','meta','hr','br');
    
    
    public static function arr_parse($main=null,$push=null,$keepIndex=false){
        $main = (array) $main;
        if(is_array($push)){
            foreach($push as $k => $v){
                if(is_numeric($k)) {
                    if($keepIndex){
                        $main[$k] = $v;
                    }
                    else{
                        $main[] = $v;
                    }
                }
                else $main[$k] = $v;
            }
        }
        return $main;
    }
    

    public static function createTag($tag,$content=null,$properties=null){
        if(!$tag) return null;
        if(preg_match('/<.*>/',$tag,$m)){
            return $tag;
        }
        if($content == HTMLINPUTDEFAULTVALUE){
            $content = null;
        }
        $htmltag = '<'.$tag;
        if(is_array($properties)){
            foreach($properties as $p => $v){
                if($v && $v==HTMLINPUTDEFAULTVALUE){
                    $htmltag .= ' '.$p;
                }
                elseif(($v || $v==0 )&&$v!=''){
                    $htmltag .= ' '.$p.'="'.$v.'"';
                }
            }
        }
        if(in_array(strtolower($tag),self::$_simple_tags)){
            $htmltag.=' />';
        }
        else{
            $htmltag .=">";
            if(!is_null($content)) $htmltag.=$content;
            $htmltag .="</$tag>";
        }
        return $htmltag;    
    }
    
    

    /**
    * tra ve the <select>
    * @param string $name
    * @param array $list danh sach tuy chon co dang array($value=>$text)
    * @param string $default gia tri mac dinh se duc selected neu trong list co gia tri do, neu khong se tra ve gia tri dung dau list
    * @param array $properties danh sach tuy chon co dang array($value=>$text)
    */ 

    public static function getSelectTag($name='select',$list=null,$default=null,$properties=null){
        $slt = '
        ';
        if(!is_array($list) && !is_object($list) && is_callable($list)) $list = call_user_func($list);
        if(is_array($list) || is_object($list)){
            foreach($list as $k => $v){
                $slt .= '
        <option value="'.$k.'"'.(($default==$k)?' selected="selected"':"").'>'.$v.'</option>';
            }
        }
            $slt .= '
    ';
    $slt = self::createTag('select',$slt,self::arr_parse(array('name'=>$name),$properties));
        
        return $slt;
    }
    /**
    * tra ve the <select>
    * @param String $name
    * @param int $start nam bat dau
    * @param int $end Nam ket thuc
    * @param String $default gia tri mac dinh se duc selected neu trong list co gia tri do, neu khong se tra ve gia tri dung dau list
    * @param Strig
    * @param Strig
    * @param Strig
    */ 

    public static function getSelectNumber($name='number',$start=1,$end=10,$default='select-number',$properties=null){
        $list = array();
        if($start>$end) 
            for($i=$start;$i>=$end;$i--)
                $list[$i] = $i;
        else
            for($i=$start;$i<=$end;$i++)
                $list[$i] = $i;
        return self::getSelectTag($name,$list,$default,$properties);
    }


    public static function getCheckBox($name='checkbox',$check=null,$label=null,$property=null){
        if(!is_array($property)) $property = array();
        if($check&&strtolower($check)!='off') $property['checked'] = "checked";
        $tag = "<label><input type=\"checkbox\" name=\"$name\"";
        if(is_array($property)){
            foreach($property as $n=>$v){
                if(!is_null($v)){
                    $tag .=" ".$n.="=\"".$v."\"";
                }
            }
        }
        $tag .= " /> $label</label>";
        return $tag;
    }
    public static function getRadioButtons($name='radio',$list=null,$default=null,$properties=null){
        $slt = '';
        if(!is_array($list) && !is_object($list) && is_callable($list)) $list = call_user_func($list);
        if(is_array($list) || is_object($list)){
            foreach($list as $k => $v){
                $slt .= ' <label class="inp-label"><input type="radio" name="'.$name.'" value="'.$k.'"'.(($default==$k)?' checked="checked"':"");
                if(is_array($properties)){
                    foreach($properties as $key => $val){
                        $slt .= ' '.$key.'="'.$val.'"';
                    }
                }
                $slt .='> <span>'.$v.'</span></label>';
            }
        }
        return $slt;
    }
    public static function convert_to_array($d) {
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
		$files = new Files();
		$files->cd('json/forms');
		if($inps = $files->getJSON($filename)){
            if(is_array($s)){
				foreach ($s as $name) {
					if(isset($inps->{$name})){
						$inp = $inps->{$name};
						if(!isset($inp->name)){
							$inp->name = $name;
                        }
                        if(!isset($inp->default)){
							$inp->default = null;
                        }
                        if(!isset($inp->data)){
							$inp->data = null;
                        }
                        if(!isset($inp->label)){
							$inp->label = $inp->text;
						}
						if(!isset($inp->className)){
							$inp->className = 'inp-'.$inp->name;
						}
						if(!isset($inp->props)){
							$inp->props = array();
						}
                        if(!isset($inp->placeholder)){
                            $inp->placeholder = $inp->label;
                        }
                        $input = new static([
                            'type' => $inp->type,
                            'name' => $inp->name,
                            'text' => $inp->text,
                            'data' => $inp->data,
                            'label' => $inp->label,
                            'className' => $inp->className,
                            'default' => $inp->default,
                            'placeholder' => $inp->placeholder,
                            'props' => \Cube\convert_obj_to_arr($inp->props),
                        ]);
                        
						$inputs[] = $input;
					}
				}
			}else{
				foreach ($inps as $name => $inp) {
					if(!isset($inp->name)){
						$inp->name = $name;
                    }
                    if(!isset($inp->default)){
						$inp->default = null;
                    }
                    if(!isset($inp->data)){
						$inp->data = null;
                    }
                    if(!isset($inp->label)){
						$inp->label = $inp->text;
                    }
                    if(!isset($inp->className)){
						$inp->className = 'inp-'.$inp->name;
					}
					if(!isset($inp->props)){
						$inp->props = array();
					}
                    if(!isset($inp->placeholder)){
                            $inp->placeholder = $inp->label;
                        }
                    $input = new static([
                        'type' => $inp->type,
                        'name' => $inp->name,
                        'text' => $inp->text,
                        'data' => $inp->data,
                        'label' => $inp->label,
                        'className' => $inp->className,
                        'default' => $inp->default,
                        'placeholder' => $inp->placeholder,
                        'props' => \Cube\convert_obj_to_arr($inp->props),
                    ]);
                    
					$inputs[] = $input;
				}
			}
		}
		return $inputs;
	}

}