<?php 

namespace Cube\Html;

class FormGroup extends HtmlObject{
    protected $_data = [
        'tag'                      => null,
        'attrs'                    => [],
        'label_wrapper'            => null,
        'label_wrapper_class'      => '',
        'label_wrapper_attrs'      => [],
        'input_wrapper'            => null,
        'input_wrapper_class'      => '',
        'input_wrapper_attrs'      => [],
        'use_label'                => false,
        'label_class'              => '',
        'label_attrs'              => [],
        'input_class'              => '',
        'input_attrs'              => [],
        'error_class'              => '',
        'error_tag'                => null,
        'total'                    => 0,
        'index'                    => 0
    ];

    protected $orginalData = [];

    public $input = null;

    public $label = null;

    public $error = null;

    public $labelWrapper = null;
    
    public $inputWrapper = null;
    

    protected $actions = [];

    /**
     * khoi tao form group
     */

    public function __construct($args=[])
    {
        if(is_array($args)){
            parent::__construct(isset($args['tag'])?$args['tag']:null);
            $this->orginalData = $args;
            $this->setOption($args);    
        }
    }

    public function render($action=null)
    {
        $this->addAction($action);
        $input = $this->input;
        $label = $this->label;
        
        $d = $this->_data;
        
        if($d['use_label']){
            $label_wrapper = new HtmlObject($d['label_wrapper'], $label,$d['label_wrapper_attrs']);
            $label_wrapper->addClass($d['label_wrapper_class']);
            
            $this->labelWrapper = $label_wrapper;
            $this->append($label_wrapper);
        }
        
        $input_wrapper = new HtmlObject($d['input_wrapper'],$input,$d['input_wrapper_attrs']);
        $input_wrapper->addClass($d['input_wrapper_class']);
        
        $this->inputWrapper = $input_wrapper;
        $this->append($input_wrapper);
        
        if($this->hasError()){
            $error = new HtmlObject($d['error_tag'],$this->error);
            $error->addClass($d['error_class']);
            $input_wrapper->append($error->render());
        }
        if(count($this->actions)>0){
            foreach($this->actions as $act){
                $act($this,$input,$label);
            }
        }
        if(!$input) return parent::render();
        
        
        if($input->type=='hidden'){
            $html = '
            '.$input->render().'
            ';
            return $html;
        }
        
        return parent::render();
    }

    protected function setOpt($name,$value=null)
    {
        if (array_key_exists($name, $this->_data)) {
            $this->_data[$name] = $value;
            if($name=='group_class' || $name=='class' || $name=='className'){
                return $this->attr('class',$value);
            }
            if($name=='group_attrs' || $name=='attrs'){
                return $this->attr($value);
            }
        }elseif($name=='group_class' || $name=='class' || $name=='className'){
            return $this->attr('class',$value);
        }elseif($name=='group_attrs' || $name=='attrs'){
            return $this->attr($value);
        }elseif($name=='input' || $name="label"){
            $this->{$name} = $value;
        }else{
            return $this->attr($name,$value);
        }
    }
    public function setField($input=[],$label=[],$error=null)
    {
        $inp = new Input($this->_data['input_attrs']);
        $inp->setOption($input);
        if($this->_data['input_class']){
            $inp->addClass($this->_data['input_class']);
        }
        $id = $inp->id?$inp->id:$inp->name;
        if(!$inp->id) $inp->id = $id;
        $lbl = new Label($this->_data['label_attrs']);
        $lbl->setOption($label);
        if($this->_data['label_class']){
            $lbl->addClass($this->_data['label_class']);
        }
        $lbl->attr('for',$id);
        $this->input = $inp;
        $this->label = $lbl;
        $this->error = $error;
    }

    public function hasError()
    {
        return $this->error?true:false;
    }
    public function getError()
    {
        return $this->error;
    }
    
    public function reset()
    {
        $this->input = null;
        $this->label = null;
        $this->error = null;
        return $this->setOption($this->orginalData);
    }

    public function index()
    {
        return $this->_data['index'];
    }
    public function isFirst()
    {
        return ($this->_data['index'] == 0);
    }
    public function isLast()
    {
        return ($this->_data['total'] - $this->_data['index'] == 1);
    }
    public function inList()
    {
        return !($this->isFirst() || $this->isLast());
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


    public function __toString()
    {
        return $this->render();
    }


}