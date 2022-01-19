@extends($__layouts.'main')

@section('title', 'Người dùng')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Người dùng
                        <a href="{{route('admin.user.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        @include($__templates.'list-filter',['filter_list'=>['name'=>'Tên','email'=>'email','created_at' => 'Thời gian đăng ký']])
        @if($list->count()>0)
        <ul class="item-list striped list-body list-user">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="area-check">
                            <input type="checkbox" class="checkbox check-all">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header fixed item-col-img md">
                        <div>
                            <span>Avatar</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-name item-col-title">
                        <div>
                            <span>Họ tên</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-email item-col-stats">
                        <div class="no-overflow">
                            <span>Email</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-roles item-col-stats">
                        <div class="no-overflow">
                            <span>Quyền</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
            @foreach($list as $item)
            <li class="item" id="user-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="users[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <a href="#">
                            <div class="item-img rounded" style="background-image: url({{$item->getAvatar()}})"></div>
                        </a>
                    </div>
                    <div class="item-col fixed pull-left item-col-name item-col-title">
                        <div class="item-heading">Họ tên</div>
                        <div>
                            <a href="#" class="">
                                <h4 class="item-title"> {{$item->name}} </h4>
                            </a>
                        </div>
                    </div>
                    <div class="item-col item-col-email item-col-stats no-overflow">
                        <div class="item-heading">Email</div>
                        <div class="no-overflow">
                            {{$item->email}}
                        </div>
                    </div>
                    <div class="item-col item-col-roles item-col-stats no-overflow">
                        <div class="item-heading">Quyền</div>
                        <div class="no-overflow">
                            @if($roles = $item->getRoles())
                                @foreach($roles as $role)
                                    {{$role->name.($loop->last?'':', ')}}
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="item-col fixed item-col-actions-dropdown">
                        <div class="item-actions-dropdown">
                            <a class="item-actions-toggle-btn">
                                <span class="inactive">
                                    <i class="fa fa-cog"></i>
                                </span>
                                <span class="active">
                                    <i class="fa fa-chevron-circle-right"></i>
                                </span>
                            </a>
                            <div class="item-actions-block">
                                <ul class="item-actions-list">
                                    <li>
                                        <a href="{{$item->getUpdateUrl()}}" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="remove btn-delete-user" data-id="{{$item->id}}">
                                            <i class="fa fa-trash-o"></i></a>
                                    </li>
                                </ul>
                            </div>
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
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-user"><i class="fa fa-trash"></i></a>
                    
                </div>
                <div class="col-12 col-md-6">
                    <nav aria-label="Page navigation example" class="text-right">
                        {{$list->links('vendor.pagination.custom')}}
                    </nav>
                </div>
            </div>
        </div>
        @else
            <div class="alert alert-danger text-center">
                Danh sách trống
            </div>
        @endif

    </div>
        


</article>

@endsection

@section('jsinit')
<script>
    window.usersInit = function() {
        Cube.users.init({
            urls:{
                delete_user_url: '{{route('admin.user.delete')}}'
            }
        });
    };
</script>
@endsection