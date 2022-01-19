@extends($__layouts.'main')

@section('title', 'Module')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Module
                        <a href="{{route('admin.module.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.module.list'])
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card-block">
            <div class="card-title-block">
                <h3 class="title"> Danh sách module </h3>
            </div>

            <section class="card-body">
                @if($list->count()>0)
                <div class="row list-header">
                    <div class="col-2 col-sm-4">
                        <div class="row">
                            <div class="col-12 col-sm-4 col-md-3 col-lg-2 pl-0 pr-0 text-center">
                                <label class="d-block">
                                    <input type="checkbox" name="check_all" class="check-all checkbox">
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-3 col-lg-4 pl-0 pr-0 text-center">
                                <span class="d-none d-sm-block">
                                    <strong>ID</strong>
                                </span>
                            </div>
                            <div class="col-12 col-sm-4 col-md-6 text-center">
                                <span class="d-none d-sm-block">
                                    <strong>Loại</strong>
                                </span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-10 col-sm-8">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <span class="d-none d-lg-block">
                                    <strong>Tên</strong>
                                </span>
                                <span class="d-block d-lg-none">
                                    <strong>Chi tiết</strong>
                                </span>
                            </div>
                            <div class="col-12 col-lg-5 text-center">
                                <span class="d-none d-lg-block">
                                    <strong>Tham chiếu</strong>
                                </span>
                            </div>
                            
                            <div class="col-12 col-lg-3 text-right">
                                <span class="d-none d-lg-block">
                                    
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="list-body list-module">
                    @foreach($list as $item)
                    <div class="row" id="module-item-{{$item->id}}">
                        <div class="col-2 col-sm-4">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-3 col-lg-2 pl-0 pr-0 text-center">
                                    <label class="d-block">
                                        <input type="checkbox" name="modules[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-12 col-sm-4 col-md-3 col-lg-4 pl-0 pr-0 text-center">
                                    <span class="d-none d-sm-block">
                                        {{$item->id}}
                                    </span>
                                </div>
                                <div class="col-12 col-sm-4 col-md-6 text-center">
                                    <span class="d-none d-sm-block">
                                        {{$item->type}}
                                    </span>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="col-10 col-sm-8">
                            <div class="row">
                                <div class="col-9 col-lg-4">
                                    <p><a target="_blank" href="#">{{$item->name}}</a></p>
                                    <p class="d-block d-lg-none">
                                        {{$item->type}}: {{$item->route}}
                                    </p>
                                </div>
                                <div class="col-3 col-lg-5 text-center">
                                    <span class="d-none d-lg-block">
                                        {{$item->route}}
                                    </span>
                                    <span class="d-block d-lg-none text-right">
                                        <a href="{{$item->getUpdateUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm btn-delete-module" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                    </span>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <span class="d-none d-lg-block text-right">
                                        <a href="{{$item->getUpdateUrl()}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm btn-delete-module" data-id="{{$item->id}}"><i class="fa fa-trash"></i></a>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row pt-4">
                    <div class="col-12 col-md-6">
                        <a href="#" class="btn btn-sm btn-primary btn-check-all"><i class="fa fa-check"></i></a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete-all-module"><i class="fa fa-trash"></i></a>
                        
                    </div>
                    <div class="col-12 col-md-6">
                        <nav aria-label="Page navigation example" class="text-right">
                            {{$list->links('vendor.pagination.bs4')}}
                        </nav>
                    </div>
                </div>
                @endif
            </section>


        </div>
    </div>


</article>

@endsection

@section('jsinit')
<script>
    window.modulesInit = function() {
        Cube.modules.init({
            urls:{
                delete_module_url: '{{route('admin.module.delete')}}'
            }
        });
    };
</script>
@endsection