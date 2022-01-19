<?php
namespace Cube\Html;

use Cube\Files;
use Cube\Arr;
class Form extends HtmlObject
{
    protected $_attrs = [
        /**
         * @var string id
         */

        'id' => '',
        
        /**
         * @var string class name
         */
        
        'className' => '',
        
        /**
         * @var string method
         */

        'method' => 'get',
        
        
        /**
         * @var string url 
         */
        'action' => '',

        /**
         * @var string ma hoa du lieu
         */
        'enctype' => null,

        
    ];
    protected $_data = [
        
        /**
         * @var string 
         *
         */
        'laravel_form' => false,
        /**
         * @var string 
         *
         */
        'type' => 'laravel',


        /**
         * @var string 
         *
         */
        'style' => null,


        /**
         * @var string 
         */
        
        'form_group' => null,

        /**
        * @var string thuoc tinh cua the form group
        */
    
        'form_group_class' => '',

        /**
        * @var array thuoc tinh cua the form group
        */
    
        'form_group_attrs' => [],

        /**
        * @var string label_wrapper
        */
        'label_wrapper' => null,

        /**
        * @var string thuoc tinh cua the form group
        */
    
        'label_wrapper_class' => '',

        /**
        * @var array thuoc tinh cua the label_wrapper
        */
    
        'label_wrapper_attrs' => [],

        /**
        * @var string input_wrapper
        */
        'input_wrapper' => null,

        /**
        * @var string thuoc tinh cua the form group
        */
    
        'input_wrapper_class' => '',

        /**
        * @var array thuoc tinh cua the input_wrapper
        */
    
        'input_wrapper_attrs' => [],

        
        
        /**
        * @var string label_class
        */
        'use_label' => false,

        /**
        * @var string label_class
        */
        'label_class' => '',


        /**
        * @var array thuoc tinh cua the label
        */
    
        'label_attrs' => [],

        /**
        * @var string input_class
        */
        'input_class' => '',

        'input_error_class' => '',

        /**
        * @var array thuoc tinh cua the input
        */
    
        'input_attrs' => [],

        /**
         * @var string 'error_tag' 
         */

         'error_tag' => 'span',
         
         'error_class' => 'has-error',

         'btn_submit_text' => 'Save',
         'btn_submit_id' => '',
         'btn_submit_class' => '',
         'btn_submit_icon' => '',
         'btn_submit_attrs' => [],
         'btn_cancel_text' => 'Cancel',
         'btn_cancel_id' => '',
         'btn_cancel_class' => '',
         'btn_cancel_icon' => '',
         'btn_cancel_attrs' => [],
         'btn_group' => 'div',
         'btn_group_class' => 'buttons',
         'btn_wrapper' => '',
         'btn_wrapper_class' => '',
         
    ];
    
    /**
    * @var string danh chac ca bien la mang
    */
    protected $arr_list = ['form_group_attr','label_wrapper_attrs', 'input_wrapper_attrs', 'label_attrs', 'input_attrs','btn_submit_attrs','btn_cancel_attrs'];


    /**
     * @var array danh sact ten input
     */
    
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
    
    public $inputs = null;

    protected $actions = [];

    protected $buttonActions = [];


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
        parent::__construct('form');
        if(isset($options['style'])){
            $this->setStyle($options['style']);
        }
        $this->setup($options);
        $this->input_file = $input_file;
        $this->input_list = $input_list;
        $this->form_data = is_a($form_data,'Cube\\Arr')?$form_data:(new Arr($form_data));
        $this->inputs = new InputList($this->getInputFields());
        $this->errors = $errors;

    }
    /**
     * tao ra form html
     * @param object $action phuong thuc goi hanh dong
     */

    public function render($action = null)
    {
        $this->addAction($action);
        $d = $this->_data;
        $inputs = $this->inputs->get();
        $t = count($inputs);
        if($d['laravel_form'] || $d['type'] = 'laravel' || $t > 0){
            
            
        
            $html = '';
            $data = $this->form_data;
            $errors = $this->errors;
            if($d['laravel_form'] || $d['type'] = 'laravel'){
                $html .= '
                
                '.csrf_field().'
                <input type="hidden" name="id" value="'.(old('id')?old('id'):$data->get('id')).'">

                ';
            }
            $i = 0;
            $groupAttrs = [
                'tag'                      => $d['form_group'],
                'class'                    => $d['form_group_class'],
                'attrs'                    => $d['form_group_attrs'],
                'label_wrapper'            => $d['label_wrapper'],
                'label_wrapper_class'      => $d['label_wrapper_class'],
                'label_wrapper_attrs'      => $d['label_wrapper_attrs'],
                'input_wrapper'            => $d['input_wrapper'],
                'input_wrapper_class'      => $d['input_wrapper_class'],
                'input_wrapper_attrs'      => $d['input_wrapper_attrs'],
                'use_label'                => $d['use_label'],
                'label_class'              => $d['label_class'],
                'label_attrs'              => $d['label_attrs'],
                'input_class'              => $d['input_class'],
                'input_attrs'              => $d['input_attrs'],
                'error_class'              => $d['error_class'],
                'error_tag'                => $d['error_tag'],
                'total'                    => $t

            ];
            foreach($inputs as $inp){
                $group = new FormGroup($groupAttrs);
                
                $name = $inp['name'];
                $id = isset($inp['id'])?$inp['id']:$name;
                $lbl = isset($inp['label'])?$inp['label']:(isset($inp['text'])?$inp['text']:$name);

                $inp['placeholder'] = array_key_exists('placeholder', $inp)?$inp['placeholder']:(array_key_exists('text', $inp)?$inp['text']:null);
                
                $nasp = preg_replace('/\[\]/i','',$name);
                $old = old($nasp);
                $vl = ($old!==null)?$old:$data->get($nasp);
                if($vl!==null) $inp['value'] = $vl;
                
                $lab = [
                    'for' => $id,
                    'text' => $lbl,
                    'class' => $d['label_class']
                ];
                $group->index= $i;
                $group->setField($inp,$lab,$this->getError($name));
                $html .= '
                '. $group->render($this->actions).'
                ';
                
                $i++;
            }
            $s = 'btn_submit_';
            $c = 'btn_cancel_';
            $bs = new HtmlObject('button',$d[$s.'text'],$d[$s.'attrs']);
            $bs->addClass($d[$s.'class']);
            $bs->type='submit';
            if($d[$s.'icon']){
                $bs->prepend('<i class="fa fa-'.$d[$s.'icon'].'"></i>');
            }
            $bc = new HtmlObject('button',$d[$c.'text'],$d[$c.'attrs']);
            $bc->addClass($d[$c.'class']);
            $bc->type='button';
            if($d[$c.'icon']){
                $bc->prepend('<i class="fa fa-'.$d[$c.'icon'].'"></i>');
            }
            $bw = new HtmlObject($d['btn_wrapper']);
            $bw->addClass($d['btn_wrapper_class']);
            $bw->append($bs)->append(' ')->append($bc);
            $bg = new HtmlObject($d['btn_group'],$bw);
            $bg->addClass($d['btn_group_class']);
            if($d['style']=='bootstrap'){
                $bg->prepend('<div class="col-sm-4"></div>');
            }
            if($this->buttonActions){
                foreach($this->buttonActions as $act){
                    $act($bs,$bc,$bg);
                }
            }
            
            $html.=$bg;
            $this->append($html.'
            
            ');
            return parent::render();
        }
        

        return null;
    }

    /** 
     * thiet lap giao dien form
     * @param string $style kieu giao dien
     * @return object Form
     */
    public function setStyle($style = null)
    {
        $s = strtolower($style);
        if($s == 'bootstrap'){
            $this->setup([
                'form_group' => 'div',
                'form_group_class' => 'form-group row',
                'use_label' => true,
                'label_class' => 'col-sm-4 col-md-3 col-lg-2 form-control-label',
                'input_wrapper' => 'div',
                'input_wrapper_class' => 'col-sm-8 col-md-9 col-lg-10',
                'input_class' => 'form-control',
                'input_error_class' => 'has-error is-invalid',
                'error_tag' => 'span',
                'error_class' => 'has-error',
                'btn_submit_text' => 'Lưu',
                'btn_submit_id' => 'btn-submit',
                'btn_submit_class' => 'btn btn-primary',
                'btn_cancel_text' => 'Hủy',
                'btn_cancel_id' => 'btn-cancel',
                'btn_cancel_class' => 'btn btn-danger',
                'btn_group' => 'div',
                'btn_group_class' => 'form-group row',
                'btn_wrapper' => 'div',
                'btn_wrapper_class' => 'col-sm-12 text-center',
            ]);
        }
    }

    /**
     * thiet lap thong tin form
     * @param array|string $options ten thuoc tinh hoac mang thuoc tinh
     * @param mixed $value 
     */
    public function setup($options = null,$value=null)
    {
        if(is_string($options)){
            return $this->set($options,$value);
        }
        if(is_array($options)){
            foreach($options as $name => $val){
                $this->set($name,$val);
            }
        }
        return $this;
    }

    protected function set($name = null,$value=null)
    {
        if(is_string($name)){
            if(in_array(strtolower($name),['classname','form_class','class'])) $name = 'className';
            if(in_array($name,$this->arr_list)){
                if(is_array($value)){
                    $this->_data[$name] = array_merge($this->_data[$name],$value);
                }
            }else{
                $this->setOpt($name,$value);
            }
        }
        return $this;
    }

    public function button()
    {
        $args = func_get_args();
        $t = count($args);
        if($t>0){
            $tpb = ['submit', 'cancel'];
            $btns = ['text','id','class', 'icon'];
            for($i=0;$i<2;$i++){
                if(is_string($args[$i])){
                    $this->dara['btn_'.$tpb[$i].'_text'] = $args[$i];
                }elseif(is_array($args[$i])){
                    $b=$args[$i];
                    foreach($btns as $f){
                        if(isset($b[$f])){
                            $this->dara['btn_'.$tpb[$i].'_'.$f] = $b[$f];
                        }elseif(isset($b['submit_'.$f])){
                            $this->dara['btn_submit_'.$f] = $b['submit_'.$f];
                        }elseif(isset($b['cancel_'.$f])){
                            $this->dara['btn_cancel_'.$f] = $b['cancel_'.$f];
                        }
                    }
                }
            }
        }
        return $this;
    }

    public function buttonSubmit($args=null)
    {
        $btns = ['text','id','class', 'icon'];
        if(is_string($args)){
            $this->_data['btn_submit_text'] = $args;
        }elseif(is_array($args)){
            $b=$args;
            foreach($btns as $f){
                if(isset($b[$f])){
                    $this->_data['btn_submit_'.$f] = $b[$f];
                }
            }
        }
        return $this;
    }

    public function buttonCancel($args=null)
    {
        $btns = ['text','id','class', 'icon'];
        if(is_string($args)){
            $this->_data['btn_cancel_text'] = $args;
        }elseif(is_array($args)){
            $b=$args;
            foreach($btns as $f){
                if(isset($b[$f])){
                    $this->_data['btn_cancel_'.$f] = $b[$f];
                }
            }
        }
        return $this;
    }

    public function formGroupAttr($name = null,$value='<!---DEFAULT--->')
    {
        return $this->componentAttr('form_group_attrs',$name,$value);
    }
    public function labelWrapperAttr($name = null,$value='<!---DEFAULT--->')
    {
        return $this->componentAttr('label_wrapper_attrs',$name,$value);
    }
    public function inputWrapperAttr($name = null,$value='<!---DEFAULT--->')
    {
        return $this->componentAttr('input_wrapper_attrs',$name,$value);
    }

    public function getError($name=null)
    {
        $e = $this->errors;
        if($name){
            if(is_object($e)){
                if($e->has($name)) return $e->first($name);
            }else{
                $e = new Arr($e);
                return $e->get($name);
            }
        }
        return null;
    }
    public function addAction($action=null)
    {
        if(is_callable($action)){
            $this->actions[] = $action;
        }elseif(is_array($action)){
            foreach($action as $act){
                if(is_callable($act)){
                    $this->actions[] = $act;
                }
            }
        }
        return $this;
    }
    public function buttonAction($action=null)
    {
        if(is_callable($action)){
            $this->buttonActions[] = $action;
        }elseif(is_array($action)){
            foreach($action as $act){
                if(is_callable($act)){
                    $this->buttonActions[] = $act;
                }
            }
        }
        return $this;
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
    

    public function componentAttr($componentName,$name = null,$value='<!---DEFAULT--->')
    {
        if(!in_array($componentName, $this->arr_list)) return $this;
        if(!isset($this->_data[$componentName])) return null;
        if(is_null($name)) return $this->_data[$componentName];
        if(is_array($name)){
            return $this->set($componentName, $name);
        }
        elseif(is_string($name)){
            if($value=='<!---DEFAULT--->'){
                return isset($this->_data[$componentName][$name])?$this->_data[$componentName][$name]:null;
            }
            $this->_data[$componentName][$name] = $value;
            return $this;
        }elseif(is_numeric($name) && $name < count($this->_data[$componentName])){
            $i = 0;
            if($value=='<!---DEFAULT--->'){
                foreach($this->_data[$componentName] as $n => $v){
                    if($name == $i){
                        return $this->_data[$componentName][$n];
                    }
                    $i++;
                }
                return null;
            }
            else{
                foreach($this->_data[$componentName] as $n => $v){
                    if($name == $i){
                        $this->_data[$componentName][$n] = $value;
                        return $this;
                    }
                    $i++;
                }
            }
            return $this;
        }
        return null;
    }


    public function __toString()
    {
        return $this->render();
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
    
    protected function setOpt($name,$value=null)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
            // if($name=='text'){
            //     $this->innerHHTML = $value;
            // }
        }else{
            return $this->attr($name,$value);
        }
    }

    public function get($name=null)
    {
        if(is_null($name)){
            return $this->_data;
        }
        return (isset($this->_data[$name])?$this->_data[$name]:null);
    }

    public function reset()
    {
        return $this->setOption($this->orginalData);
    }
}
