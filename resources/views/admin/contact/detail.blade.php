@extends($__layouts.'main')

@section('title', 'Chi tiết liên hệ')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Chi tiết liên hệ </h3>
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.contact.list'])
    </div>
    <!-- list content -->
        
    <div class="card items">
        <div class="card card-block">
            <h4>{{$detail->subject?$detail->subject:$detail->name . ' vừa gửi liên hệ'}}</h4>
            <div class="row mt-3">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Người gửi</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->name}}
                </div>
            </div>

            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Email</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->email}}
                </div>
            </div>
            @if($detail->phone_number)
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>Số điện thoại</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                    {{$detail->phone_number}}
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-4 col-sm-3 col-lg-2">
                    <strong>nội dung</strong>
                </div>
                <div class="col-8 col-sm-9 col-lg-10">
                        {!! nl2br($detail->content) !!}
                </div>
            </div>
            
            

            <div class="clearfix replies mt-4">
                <?php $replies = $detail->replies; ?>
                <p><strong>Trả lời ({{count($replies)}})</strong></p>
                @if(count($replies))
                    @foreach($replies as $rep)
                        <div class="contact-reply pb-3">
                            <p class="mb-0 pb-0"><strong>{{$rep->author->name}}</strong></p>
                            <div class="reply-content pl-5">{!! nl2br($rep->content) !!}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="reply-form mt-4">
                <form action="{{route('admin.contact.send-reply')}}" method="POST">
                    @csrf
                    <input type="hidden" name="contact_id" value="{{$detail->id}}">
                    <p><strong>Trả lời</strong></p>
                    @if(session('success'))
                        <p class="alert alert-success">Bạn đã gửi trả lời thành công</p>
                    @elseif(session('fail'))
                        <p class="alert alert-warning">Lỗi bất ngờ vui lòng thử lại</p>
                    @endif
                    <div class="form-group {{$errors->has('content')?'has-error':''}}">
                        <label for="reply-content" class="form-control-label">Nội dung</label>
                        <textarea name="content" id="reply-content" class="form-control">{{old('content')}}</textarea>
                        @if($errors->has('content'))
                            <span class="has-error">{{$errors->first('content')}}</span>
                        @endif
                    </div>
                    <div class="buttons">
                        <button type="submit" class="btn btn-primary">Gữi câu trả lời</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</article>

@endsection


@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.contact.delete')}}'
            }
        });
    };
</script>
@endsection

@section('css')
    <style>
        .contact-reply{
            border-bottom: 1px silver solid;
        }
    </style>
@endsection