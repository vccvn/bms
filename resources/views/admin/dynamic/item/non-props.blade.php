<?php
use Cube\Html\Inputs;
use Cube\Html\HTML;
use Cube\Html\Input;
?>
                        <h3 class="text-center">Thông tin {{isset($post)?'chi tiết':"mục"}}</h3>
                        @foreach(['title','slug','description','content'] as $name)
                            @php 
                            $input = $inputs->get($name);
                            if(!$input || !in_array($input->name, $required_fields)) continue;
                            if(in_array($input->type,['radio','checkbox','checklist'])){
                                $input->removeClass('form-control');
                            }
                            @endphp
                            @if($name=='slug')
                                <?php if(!$inputs->custom_slug->val())$input->attr('readonly',"true");?>
                                <div class="form-group {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                    <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                    <div class="input-{{$input->type}}-wrapper">
                                        <div class="input-group input-slug">
                                            <div class="input-group-prepend input-group-addon">
                                                <label class="input-group-text mb-0" id="label-for-{{$input->name}}">
                                                    <input type="checkbox" name="custom_slug" id="custom_slug" class="checkbox" {{$inputs->custom_slug->val()?"checked=\"true\"":""}}>
                                                    <span>Tùy chỉnh</span>
                                                </label>
                                            </div>
                                            {!!$input!!}
                                            <div class="input-group-append input-group-addon"><span>.html</span></div>
                                        </div>
                                        {!! HTML::span($input->error,['class'=>'slug-message has-error slug-message']) !!}
                                    </div>
                                </div>
                                @if($post->post_type=='gallery')
                                <div class="library mb-4">
                                        <h4 class="text-center">Thư viện ảnh</h4>
                                        <?php
                                            $input = $inputs->gallery_images;
                                            
                                        ?>
                                        <div class="form-group required {{$input->error?'has-error':''}}" id="form-group-{{$input->name}}">
                                            <div class="input-{{$input->type}}-wrapper">
                                                <?php
                                                    $input->name.='[]';
                                                ?>
                                                {!!$input!!}
                                                {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                                <div class="uploader-preview-frame" style="display:{{count($model->gallery)?'block':'none'}};">
                                                    <h4>Xem trước</h4>
                                                    <div class="uploader-preview">
                                                        @if($model->gallery)
                                                            @foreach($model->gallery as $ga)
                                                            <div id="upload-item-{{$ga->id}}" class="upload-preview-item " title="{{$ga->original_filename}}">
                                                                <a class="btn-delete btn-delete-uploaded-item" href="#" data-id="{{$ga->id}}">X</a>
                                                                <img class="upload-preview-item-image" src="{{$ga->getUrl()}}">
                                                            </div>
                                                            @endforeach
                                                        @endif
            
                                                        
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    
                                @elseif ($post->post_type=='video')
                                    <?php
                                        $input = $inputs->video_url;
                                    ?>
                                    <div class="form-group {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                        <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                        <div class="input-{{$input->type}}-wrapper">
                                            {!!$input!!}
                                            {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="form-group {{$name=='type'?"dev-only":""}} {{$input->error?'has-error':''}} " id="form-group-{{$input->name}}">
                                    <label for="{{$input->id}}" class="form-control-label " id="label-for-{{$input->name}}">{{$input->label}}</label>
                                    <div class="input-{{$input->type}}-wrapper">
                                        {!!$input!!}
                                        {!! $input->error?(HTML::span($input->error,['class'=>'has-error'])):'' !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
