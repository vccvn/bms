<?php
use Cube\Html\Inputs;
use Cube\Html\Input;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$fmact = isset($form_action)?route($form_action):'';
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);
?>


    <input type="hidden" name="id" value="{{ $model->id }}" class="item-inp">
    @if($group_inputs)
        @foreach($group_inputs as $inp)
            <?php
                if(is_array($inp)){
                    $input = new Input($inp);
                }else{
                    $input = $inputs->get($inp);
                }
                if(!$input) {
                        continue;
                    }
                if(!in_array($input->type,['radio','checkbox','checklist'])){
                    $input->addClass('form-control');
                }
                $input->id = 'menu-item-'.$input->id;
                if($input->name == 'icon'){
                    $input->addClass('input-icon');
                }
                $input->addClass('item-inp');
            ?>
            @if($input->type=='hidden')
            {!! $input !!}
            @else
                <div class="form-group">
                    @if(!in_array($input->type,['radio','checkbox','checklist']))
                    <label for="{{ 'menu-item-'.$input->id }}" class="form-control-label">{{ $input->label }}</label>
                    @endif
                    {!! $input !!}
                    {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                </div>
            @endif
        @endforeach
    @endif
    