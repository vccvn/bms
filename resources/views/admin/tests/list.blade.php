@extends($__layouts.'main')

@section('title', 'Test')

@section('content')


<article class="content items-list-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Module test
                        <a href="{{route('admin.tests.add')}}" class="btn btn-primary btn-sm rounded-s"> Thêm mới </a>
                    </h3>
                    
                </div>
            </div>
        </div>
        @include($__templates.'list-search',['search_route'=>'admin.tests.list'])
    </div>
    <!-- list content -->
    <div class="card">
        <div class="card-block">
            <div class="card-title-block">
                <h3 class="title"> Danh sách Module Mẫu </h3>
            </div>
            <section class="card-body">
                @if($list->count()>0)
                <div class="">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Menu</th>
                                <th class="text-right">
                                
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>
                                    <a href="{{$item->getDetailUrl()}}">{{$item->name}}</a>
                                </td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                    <a href="#test" class="btn btn-danger btn-sm btn-delete-item"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        {{$list->links('vendor.pagination.bs4')}}
                    </nav>
                </div>
                @endif
            </section>
        </div>
    </div>


</article>

@endsection