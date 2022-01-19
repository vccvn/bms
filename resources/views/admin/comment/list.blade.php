@extends($__layouts.'main')

@section('title', 'Phản hồi')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Phản hồi </h3>
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        @include($__templates.'list-filter',['filter_list'=>['created_at' => 'Thời gian']])
        @if($list->count()>0)

        <ul class="item-list striped list-body list-item">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-title">
                        <div>
                            <span>Phản hồi</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same item-col-stats">
                        <div class="no-overflow">
                            <span>Chi tiết</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm item-col-stats">
                        <div class="no-overflow">
                            <span>Ngưởi gửi</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same-md item-col-stats"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="comments[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Tiêu đề</div>
                        <div>
                            <a href="{{$item->getDetailUrl()}}" class="">
                                <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->id}}"> {{$item->title()}} </h4>
                                
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-same item-col-stats no-overflow">
                        <div class="item-heading">Tóm tắt</div>
                        <div class="no-overflow">
                            {{$item->getShortDesc(100)}}
                        </div>
                    </div>
                    <div class="item-col item-col-stats item-col-same-sm no-overflow">
                        <div class="item-heading">Thông tin người gữi</div>
                        <div class="no-overflow text-left">
                            <span>Họ tên: </span> <span class="bold">{{$item->author_name}}</span>
                            @if($item->author_phone)
                            <br>
                            <span>Số điện thoại: </span> <span class="bold">{{$item->author_phone}}</span>
                            @endif
                            @if($item->author_email)
                            <br>
                            <span>Email: </span> <span class="bold">{{$item->author_email}}</span>
                            @endif
                            
                        </div>
                    </div>
                    <div class="item-col fixed item-col-stats item-col-same-md pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-right">
                                @if(!$item->approved)
                                <li>
                                    <a href="#" class="btn-approve-comment" data-id="{{$item->id}}" title="Duyệt phản hồi này">
                                        <i class="fa fa-check"></i>
                                    </a>
                                </li>
                                @else
                                <li>
                                    <a href="#" class="btn-unapprove-comment" data-id="{{$item->id}}" title="Ẩn phản hồi này">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </li>
                                
                                @endif
                                <li>
                                    <a href="{{$item->getDetailUrl()}}#replay" class="btn-replay-comment" title="trả lời">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-item" data-id="{{$item->id}}" title="xóa">
                                        <i class="fa fa-trash"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="card card-block ">
            <div class="row pt-4">
                <div class="col-12 col-md-6">
                    <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-item"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        {{$list->links('vendor.pagination.custom')}}
                    </nav>
                </div>
            </div>
        </div>
        @else
            <p class="alert alert-danger text-center">
                Danh sách trống
            </p>
        @endif
    </div>
    



</article>

@endsection

@section('jsinit')
<script>
    window.itemsInit = function() {
        Cube.items.init({
            urls:{
                delete_url: '{{route('admin.comment.delete')}}'
            }
        });
    };

    window.commentsInit = function() {
        Cube.comments.init({
            urls:{
                approve_url: '{{route('admin.comment.approve')}}',
                unapprove_url: '{{route('admin.comment.unapprove')}}'
            }
        });
    };
</script>
@endsection
@section('js')
<script src="{{asset('js/admin/comments.js')}}"></script>
@endsection