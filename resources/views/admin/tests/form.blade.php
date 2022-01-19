@extends($__layouts.'main')

@section('title', 'Module')

@section('content')


<article class="content form-page">
            
    <!-- list header -->
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Module Mẫu
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
                <h3 class="title"> Module form </h3>
            </div>
            <section class="card-body">
                <form class="" method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{old('id')}}">
                    
                
                    <!-- form group -->
                    <div class="form-group row {{$errors->has('name')?'has-error':''}}" id="form-group-name">
                
                        <label for="name" class="col-sm-2 form-control-label" id="label-for-name">Tên</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{old('name')}}" id="name" class=" form-control" placeholder="Nhâp Tên" />
                            @if($errors->has('name'))
                                <div class="has-error">{{$errors->first('name')}}</div>
                            @endif
                        </div>

                    </div>
                    <!-- end form group -->
                        
                    <!-- buttons -->
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button class="btn btn-primary" type="submit">Thêm</button> 
                            <button class="btn btn-danger btn-cancel" type="button">Hủy</button>
                        </div>
                    </div>
                    <!-- end buttons -->
                
                </form>
                <!-- end form -->
            </section>
        </div>
    </div>


</article>

@endsection


{-- 

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/bootstrap.css')}}" />

@endsection

@section('js')
    @include($__templates.'form-js')
@endsection
--}