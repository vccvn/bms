<?php

namespace Cube\Html;

use Cube\Files;

class Input extends HtmlObject{
    protected $_attrs = [
        'type' => null,
        'name' => null,
        'id'   => null,
        'className' => null,
        'placeholder' => 'Viết gì đó'
    ];
    protected $_data = [
        'value'               => '<!---DEFAULT--->',
        'default'             => null,
        'action'              => '',
        'data'                => [],
        'func'                => '',
        'file'                => '',
        'call'                => '',
        'param'               => '',
        'param_list'          => [],
        'text'                => '',
        'label'               => '',
        'check_label'         => '',
        'error'               => null,
        'error_class'         => null,
        'comment'             => ''
    ];

    protected $orginalData = [];

    public $parent = null;

    public function __construct($args=[])
    {
        if(is_array($args)){
            parent::__construct(isset($args['type'])?$args['type']:'input');
            $this->orginalData = $args;
            $this->setOption($args);    
        }elseif(is_string($args)){
            parent::__construct('input');
            $this->_data['type'] = $args;
        }
    }

    public function render($action = null)
    {
        $this->tagName = 'input';
        if(is_callable($action)){
            $action($this);
        }
        
        $data = $this->_data;
        $type = $this->get('type');
        
        switch(strtolower($type)){
            case 'select':
                $this->attr('type',null);
                $this->tagName = 'select';
                
                $opts = $this->getInputData();
                if(is_array($opts) || is_object($opts)){
                    
                    $df = $this->defVal();
                    $slt = self::toSelectOptions($opts, $df);
                    
                    

                    $this->html($slt);
                }

            
                return parent::render();
            break;

            case 'cubeselect':
                $this->attr('type',null);
                $this->tagName = 'div';
                
                $def = [];
                $opts = $this->getInputData();
                if(is_array($opts) || is_object($opts)){
                    
                    $df = $this->defVal();
                    $slt = $this->toCubeSelectOptions($opts, $df);
                    $def = $this->getDefaultOption($opts, $df);
                    

                    $this->html($slt);
                }
                $select_type = $this->data('select-type');
                if(!$select_type){
                    $select_type = 'static';
                }
                $this->removeClass('form-control');
                $this->prepend('
                <input type="hidden" name="'.$this->name.'" value="'.($def?$def[0]:'').'" id="'.$this->id.'" class="'.$this->className.' d-none" />
                <div class="btn-group cube-select-group '.$select_type.' '.$this->className.'">
                    <button type="button" class="btn btn-secondary btn-block dropdown-toggle show-text-value" id="'.$this->id.'-dropdown" value="'.($def?$def[0]:'').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.($def?$def[1]:"Chưa chọn giá trị").'
                    </button>
                    <div class="dropdown-menu" data-ref="'.$this->id.'">
                    
                        <div class="search-block p-2 pt-0">
                            <input type="search" name="" class="form-control search-option-input" placeholder="Tìm kiếm..." />
                        </div>
                        <div class="message p-2 text-center" style="display:none;">Không có kết quả phù hợp</div>
                        <div class="option-list">
                ');
                $this->append('</div></div></div>');
                $this->removeClass('form-control');
                $this->addClass('cube-select');
                
                $this->name = null;
                $this->id.="-wrapper-select";

            
                return parent::render();
            break;

            
            
            case 'checklist':
                $properties = $this->_attrs;
                unset($properties['value']);
                $tag = self::checkliat($this->name,$this->getInputData(),$this->defVal(),$properties);
                return $tag->render(); 
            break;
            case 'radio':
                $opts = $this->getInputData();
                $slt = '';
                $this->attr('type',null);
                $this->tagName = null;
                if(is_array($opts) || is_object($opts)){
                    $properties = $this->_attrs;
                    $df = $this->defVal();
                    foreach($opts as $k => $v){
                        $slt .= ' <label class="inp-label pr-3"><input type="radio" name="'.$this->name.'" value="'.$k.'"'.(($df==$k)?' checked="checked"':"").' class="'.$this->className.'"';
                        // if(is_array($properties)){

                        //     foreach($properties as $key => $val){
                        //         if(!is_array($val))
                        //         $slt .= ' '.$key.'="'.$val.'"';
                        //     }
                        // }
                        $slt .='> <span>'.$v.'</span></label>';
                    }
                    $this->html($slt);
                }
                return parent::render();
            break;
            case 'checkbox':
                $check = $this->defVal();
                if($check && strtolower($check)!='off'){
                    $this->attr('checked','checked');
                }
                $this->before('<label class="'.$this->label_class.'">');
                $this->after(' <span class="check-spacing"></span><span class="checkbox-label">'.$this->_data['check_label'].'</span></label>');
                return parent::render();
            break;
            case 'textarea':
                //
                $this->attr('type',null);
                $this->tagName = $type;
                if(!$this->attr('placeholder')){
                    $this->attr('placeholder',($this->_data['label']?$this->_data['label']:$this->_data['text']));
                }
                $this->text($this->defVal());
                return parent::render();
            break;
            default:
                if(!$this->attr('placeholder')){
                    $this->attr('placeholder',($this->_data['label']?$this->_data['label']:$this->_data['text']));
                }
                $val = $this->defVal();
                $this->attr('value',$val);
                return parent::render();
            break;
        }
        return null;
    }


    public static function toSelectOptions($opts, $default = null, $html = '')
    {
        $slt = $html;
        $df = $default;
        foreach($opts as $k => $v){
            if(is_array($v)){
                $opt = $v;
                $lbl = $k;
                
                if((array_key_exists('label',$v) || array_key_exists('text',$v)) && ((array_key_exists('data',$v)  && is_array($v['data'])) || (array_key_exists('list',$v) && is_array($v['list'])))){
                    $lbl = isset($v['label'])?$v['label']:$v['text'];
                    $opt = isset($v['data'])?$v['data']:$v['list'];
                }
                $slt.= '<optgroup label="'.$lbl.'">';
                $slt = self::toSelectOptions($opt, $default, $slt);
                    
                $slt.= '</optgroup>';
            }else{
                $slt .= '<option value="'.$k.'"'.(($df==$k)?' selected="selected"':"").'>'.$v.'</option>';
            }
        }
        return $slt;
    }

    public function toCubeSelectOptions($opts, $default = null, $slt='', $level = 0)
    {
        $group_header = $this->getOptionLabelType();
        //die($group_header);
        $df = $default;
        foreach($opts as $k => $v){
            if(is_array($v)){
                $opt = $v;
                $lbl = $k;
                
                if((array_key_exists('label',$v) || array_key_exists('text',$v)) && ((array_key_exists('data',$v)  && is_array($v['data'])) || (array_key_exists('list',$v) && is_array($v['list'])))){
                    $lbl = isset($v['label'])?$v['label']:$v['text'];
                    $opt = isset($v['data'])?$v['data']:$v['list'];
                }
                $slt.= '<div class="option-group">';
                
                if($group_header!='value'){
                    $slt.="<h6 class=\"dropdown-header\">$lbl</h6>";
                }else{
                    $slt .= '<a href="javascript:void(0);" data-value="'.$k.'" data-text="'.htmlentities($lbl).'" class="dropdown-item dropdown-header option-item '.(($df==$k)?'active':'').' pb-1 pt-1 found">'.$lbl.'</a>';
                }
                $slt = $this->toCubeSelectOptions($opt, $default, $slt, $level+1);
                    
                $slt.= '</div>';
            }else{
                $slt .= '<a href="javascript:void(0);" data-value="'.$k.'" data-text="'.htmlentities($v).'" class="dropdown-item option-item '.(($df==$k)?'active':'').' pb-1 pt-1 found">'.$v.'</a>';
            }
        }
        return $slt;
    }

    protected function getDefaultOption($opts, $default=null, $arr = [])
    {
        $group_header = $this->getOptionLabelType();
        foreach($opts as $k => $v){
            if(is_array($v)){
                $opt = $v;
                $lbl = $k;
                
                if((array_key_exists('label',$v) || array_key_exists('text',$v)) && ((array_key_exists('data',$v)  && is_array($v['data'])) || (array_key_exists('list',$v) && is_array($v['list'])))){
                    $opt = isset($v['data'])?$v['data']:$v['list'];
                    $lbl = isset($v['label'])?$v['label']:$v['text'];
                }
                if($group_header == 'value' && $default == $k){
                    return [$k, $lbl];
                }
                $arr = $this->getDefaultOption($opt, $default, $arr);
                    
                
            }else{
                if($default == $k || !count($arr)){
                    $arr = [$k,$v];
                }
            }
        }
        return $arr;
    }

    protected function getOptionLabelType()
    {
        $group_label = 'header';
        if($this->option_label_type && in_array(($t = strtolower($this->option_label_type)), ['header','value','label'])){
            $group_label = $t;
        }
        return $group_label;
    }

    public function getInputData()
    {
        $opts = [];
        if($d = $this->get('data')){
            if(is_callable($d)){
                $opts = $d();
            }
            elseif (is_string($d)) {
                if(is_array($dr = json_decode($d, true))){
                    $opts = $dr;
                }elseif(count(explode('=', $d))>1){
                    $o = [];
                    try{
                        if(parse_str($d,$a)){
                            if($a){
                                $o = $a;
                            }
                        }
                    }catch(exception $err){

                    }
                    if(!$o && count($arr = explode(','))>1){
                        foreach ($arr as $pr) {
                            if($s = trim($pr)){
                                if(count($arp = explode('=',$pr))==2){
                                    $o[trim($arp[0])] = trim($arp[1]);
                                }
                            }
                        }
                    }
                    if(!$o){
                        $ar = explode('=', $d);
                        $o[trim($ar[0])] = trim($ar[1]);
                    }
                    $opts = $o;
                }else{
                    $o = [];
                    $arr = explode(',', $d);
                    if(count($arr)){
                        foreach ($arr as $value) {
                            if($a = trim($value)){
                                $o[$a] = $a;
                            }
                        }
                    }
                    $opts = $o;
                }
            }
            else{
                $opts = $d;
            }
            
        }elseif($f = $this->get('file')){
            if($d = (new Files())->cd('json/InputData')->getJSON($f)){
                $opts = $d;
            }
        }else{
            $cf = null;
            if($a = $this->get('action')){
                $cf = $a;
            }
            elseif($c = $this->get('call')){
                $cf = $c;
            }elseif($f = $this->get('func')){
                $cf = $f;
            }
            if(is_callable($cf)){
                if($pl = $this->get('param_list')){
                    $opts = call_user_func_array($a,Helper::toArray($pl));
                }elseif($p = $this->get('param')){
                    if(is_string($p) && preg_match('/^:([A-z]+[A-z0-9_]*)$/',$p,$m)){
                        $p = $this->get($m[1]);
                    }elseif(is_string($p) && preg_match('/^@([A-z]+[A-z0-9_]*)$/',$p,$m)){
                        if($this->parent){
                            if($inp = $this->parent->get($m[1])){
                                $p = $inp->defVal();
                            }
                        }
                    }
                    if(!is_array($p)) $p = [$p];
                    $opts = call_user_func_array($cf,$p);
                }else{
                    $opts = call_user_func($cf);
                }
            }
        }
        return Helper::toArray($opts);
    }

    public function defVal()
    {
        $data = $this->_data;
        $v = $data['value'];
        $d = $data['default'];
        $df = '<!---DEFAULT--->';
        if($v !== $df){
            $val = $v;
        }
        else{
            $val = $d;
        }
        return $val;
    }
    public function val($content = "<!---DEFAULT--->")
    {
        if($content=="<!---DEFAULT--->"){
            return (($this->_data['value']!='<!---DEFAULT--->')?$this->_data['value']:null);
        }
        $this->_data['value'] = $content;
        return $this;
    }

    
    
    public function get($name=null)
    {
        if(is_null($name)){
            return $this->_data;
        }
        return (array_key_exists($name, $this->_data)?$this->_data[$name]:(array_key_exists($name, $this->_attrs)?$this->_attrs[$name]:null));
    }

    public function reset()
    {
        return $this->setOption($this->orginalData);
    }

    protected static function checkliat($name,$data=null,$dataCheck=null,$properties=null)
    {
        $tag = new HTML('span',null,['class'=>'checkbox-list checkbox-group']);
        if(is_callable($data)){
            $opts = $data();
        }
        else{
            $opts = $data;
        }
        
        if(is_array($opts) || is_object($opts)){
            if(is_array($dataCheck)){
                $check = $dataCheck;
            }
            else{
                $check = [$dataCheck];
            }
            foreach($opts as $k => $v){
                $label = new HTML('label',null,['class'=>'check-item-label']);
                $checkbox = new HTML('input',null,Helper::array_parse(['type'=>'checkbox','name'=>$name,'value'=>$k],$properties));
                if(in_array($k,$check)){
                    $checkbox->checked=true;
                }
                $checkbox->after((new HTML('span',$v,['class'=>'checkbox-item-text'])));
                $checkbox->appendTo($label);
                $label->appendTo($tag);
            }
        }
        
        return $tag;

    }
    /**
     * create input tag with text type
     * @param string $name name of input
     * @param mixed $value value of input
     * @param array $properties properties of input
     */

    // public static function text($name,$value='<!---DEFAULT--->',$properties=[])
    // {
    //     $input = new static(Helper::array_parse(['name'=>$name,'type'=>'text','value'=>$value],$properties));
    //     return $input;
    // }

    /**
     * create input tag with text type
     * @param string $name name of input
     * @param mixed $value value of input
     * @param array $properties properties of input
     */

    public static function number($name,$value='<!---DEFAULT--->',$properties=[])
    {
        $input = new static(Helper::array_parse(['name'=>$name,'type'=>'number','value'=>$value],$properties));
        return $input;
    }

    public function __toString()
    {
        $a = clone $this;
        return $a->render();
    }

    protected function setOpt($name,$value=null)
    {
        $n = strtolower($name);
        if (array_key_exists($n, $this->_data)) {
            $this->_data[$n] = $value;
            
            if($n=='class' || $n=='classname'){
                return $this->addClass($value);
            }
            
        }elseif($n=='class' || $n=='classname'){
            return $this->addClass($value);
        }
        else{
            return $this->attr($name,$value);
        }
    }

}