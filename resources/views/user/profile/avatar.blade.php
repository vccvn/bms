
@extends('user.profile.layout')

@section('title', $profile->name)

@section('content')

<article class="content items-list-page">
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> {{$profile->name}} </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card items profile-info">
        <div class="card card-block sameheight-item">
            <h3>Đổi avatar</h3>
            <form method="POST" action="{{route('user.profile.setting.save-avatar')}}" id="setting-avatar-form" enctype="multipart/form-data" novalidate>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-8">
                        <div class="select-file image-editor">
                            <div class="cropit-preview"></div>
                            <input type="range" class="cropit-image-zoom-input" style="margin-top:10px; width:100%" />
                            <input type="hidden" name="image_data" class="hidden-image-data" />
                            <div class="change-icon-wrapper">
                                <div class="file-select">
                                    <div class="choose-icon">
                                        <i class="fa fa-camera"></i> Chọn ảnh
                                    </div>
                                    <input type="file" name="avatar" class="cropit-image-input" id="avatar" accept="image/jpeg,image/png,image/gif">
                                </div>
                            </div>
                        </div>
                        <div class="message">
                            <span class="message-text" id="avatar-msg"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 text-center">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <button type="button" class="btn btn-cancel btn-danger">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</article>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('js')
<script>
    function saveImageData(){
        var imageData = $('.image-editor').cropit('export');
        $('.hidden-image-data').val(imageData);
    };
    $(function() {
        $('.image-editor').cropit({ 
            imageState: { 
                src:  '{{$profile->getAvatar()}}'
            },
            smallImage:'allow',
            onFileChange:function() {
                setTimeout(saveImageData,100);
            }
        });

        $('.cropit-image-zoom-input').change(saveImageData);
        $('#setting-avatar-form').submit(function() {
            saveImageData();
            return true;
        });
        @if(session('alert'))
        
        @endif
        @if($errors->has('avatar'))
        modal_alert('{{$errors->first('avatar')}}');
        @endif
    });

</script>



@endsection