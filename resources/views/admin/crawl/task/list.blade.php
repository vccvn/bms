@extends($__layouts.'main')

@section('title', 'Crawl Task')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Task
                        <a href="{{route('admin.crawler.task.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- list content -->
    
        
    <div class="card items">
        @include($__templates.'list-filter',[
            'filter_list'=>[
                'url' => 'Dường dẫn',
                'created_at' => 'Thời gian'
            ]
        ])
        @if($list->count()>0)
        <ul class="item-list striped list-body list-task">
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
                            <span>Dường dẫn</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Kênh</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Danh mục</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Nguồn</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Thời gian</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-same-sm">
                        <div class="no-overflow">
                            <span>Trạng thái</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-same-md item-col-stats">
                        <div class="no-overflow">
                            <span>Hành động</span>
                        </div>
                    </div>
                </div>
            </li>
            @foreach($list as $item)
            <?php $category = $item->category; $frame = $item->frame; $author = $item->author; ?>
            <li class="item" id="task-item-{{$item->id}}">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check">
                            <input type="checkbox" name="frames[{{$loop->index}}][id]" class="check-item checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed pull-left item-col-same item-col-title">
                        <div class="item-heading">Dường dẫn</div>
                        <div>
                            <h4 class="item-title" id="item-name-{{$item->id}}" data-name="{{$item->url}}"> 
                                <a href="{{$item->url}}" class="">{{$item->url}}</a>
                            </h4>
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            {{$item->getChannelName()}}
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Danh mục</div>
                        <div class="no-overflow">
                            {{$category?$category->name:'Không'}}
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Nguồn</div>
                        <div class="no-overflow">
                            <a href="{{$frame?$frame->url:''}}">{{$frame?$frame->name:'nudefined'}}</a>
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm no-overflow">
                        <div class="item-heading">Thời gian</div>
                        <div class="no-overflow">
                            {{$item->getTimeAgo()}}
                        </div>
                    </div>
                    <div class="item-col item-col-same-sm">
                        <div class="item-heading">Trạng thái</div>
                        <div class="">
                            <div class="btn-group task-status-select select-dropdown">
                                <button type="button" class="btn btn-secondary text-{{$item->status?'primary':'secondary'}} btn-sm dropdown-toggle status-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$item->getStatusText()}}
                                </button>
                                <div class="dropdown-menu status-select select-dropdown-menu">
                                    @forelse($item->getStatusMenu() as $st => $t)
                                    <a data-id="{{$item->id}}" data-status="{{$st}}" id="task-item-{{$item->id}}-{{$st}}" href="#" title="chuyển sang {{$t}}" class="dropdown-item nav-link pt-1 pb-1 {{$st==$item->status?'active':''}}"> {{$t}} </a>
                                    @empty

                                    @endforelse
                                </div>    
                            </div>
                        </div>
                    </div>
                    
                    <div class="item-col fixed item-col-stats item-col-same-md pull-right">
                        <div class="item-actions">
                            <ul class="actions-list text-center">
                                <li>
                                    <a href="#" class="run btn-run-task text-warning" data-id="{{$item->id}}">
                                        <i class="fa fa-copy"></i> Crawl
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$item->getUpdateUrl()}}" class="edit text-success">
                                        <i class="fa fa-pencil"></i> Sửa
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="remove btn-delete-task text-danger" data-id="{{$item->id}}" title="xóa">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
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
                    <a href="#" class="btn btn-sm btn-success btn-run-all-task"><i class="fa fa-bolt"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete-all-task"><i class="fa fa-trash"></i></a>
                    
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
                delete_url: '{{route('admin.crawler.task.delete')}}'
            }
        });
    };
    window.tasksInit = function() {
        Cube.tasks.init({
            urls:{
                delete_url: '{{route('admin.crawler.task.delete')}}',
                run_url: '{{route('admin.crawler.task.run')}}',
                change_status_url:  '{{route('admin.crawler.task.status')}}',
                view_url: '{{route('admin.order.view')}}'
            }
        });
    };
</script>
@endsection
@section('js')
    <script src="{{asset('js/admin/tasks.js')}}"></script>
@endsection