<?php
use Cube\Html\Inputs;
use Cube\Html\Input;
use Cube\Html\HTML;
use Cube\Html\FormData;
$fd = isset($formdata)?$formdata:null; // form data
$inputs = new Inputs($formJSON,$fieldList, $fd, $errors,['class' => 'form-control']);

?>



@if(isset($form_list) && count($form_list))

<ul class="item-form-list">

@foreach($form_list as $group)

    <li class="form-list-item item-group {{(old('item_group') && old('item_group') == $group['id'])?'active':'' }}" id="{{$group['id']}}">
        <a href="#" class="item-link nav-item">{{$group['label']}} <i class="fa fa-chevron-right"></i></a>
        <div class="item-form">
            <form method="POST" action="{{route('admin.menu.item.save')}}" class="menu-item-form add" novalidate>
            @csrf
            <input type="hidden" name="menu_id" value="{{ $detail->id }}" class="item-inp">
            <input type="hidden" name="type" value="{{$group['type']}}" class="item-inp">
            <input type="hidden" name="sub_type" value="default" class="item-inp">
            <input type="hidden" name="item_group" value="{{$group['id']}}">
            @if($group['hidden'])
                @foreach($group['hidden'] as $hInp)
                <input type="hidden" name="{{$hInp['name']}}" class="item-inp" value="{{$hInp['value']}}">
                @endforeach
            @endif

            @if($group['inputs'])
                @foreach($group['inputs'] as $inp)
                    <?php
                        if(is_array($inp)){
                            $input = new Input($inp);
                        }else{
                            $input = $inputs->get($inp);
                        }
                        if(!$input) {
                                echo $inp.' lỗi sml<br>';
                                continue;
                            }
                        if(!in_array($input->type,['radio','checkbox','checklist'])){
                            $input->addClass('form-control');
                        }
                        $input->id = $group['id'].'-'.$input->id;
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
                            <label for="{{ $group['id'].$input->id }}" class="form-control-label">{{ $input->label }}</label>
                            @endif
                            {!! $input !!}
                            {!! ($input->error && old('item_group') && old('item_group') == $group['id'])?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                        </div>
                    @endif
                @endforeach
            @endif

            <div class="buttons mt-3">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            </form>
        </div>
    </li>

@endforeach

</ul>

@endif