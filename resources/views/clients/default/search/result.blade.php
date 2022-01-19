@extends($__theme.'_layouts.main')
@section('title','Tìm kiếm')
@section('content')

             <!--Main Slider-->
            @include($__current.'templates.header')
            <!--End Main Slider-->
            <!--Sidebar Page-->
             <div class="sidebar-page-container right-side-bar">
                <div class="auto-container">
                    <div class="row clearfix">
                        
                        <!--Content Side--> 
                        <div class="content-side col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            
                        @if(count($list))
                            @if($current_cate == 'post')
                                @include($__theme.'post.templates.list-style-default')
                            @elseif($current_cate == 'product')
                                @include($__theme.'product.templates.list')
                            @elseif($current_cate == 'du-an')
                                @include($__theme.'page.templates.list-style-3')
                            @elseif($current_cate == 'dich-vu')
                                @include($__theme.'page.templates.list-style-4')
                            @else
                                @include($__current.'templates.list-style-2')
                            @endif
                            {{$list->links('vendor.pagination.lightsolution')}}
                
                        @else
                
                            <div class="alert alert-info">Không có kết quả phù hợp</div>
                
                        @endif
                            
                        </div>
                        <!--Content Side-->
                        
                        <!--Sidebar-->  
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            
                            @include($__theme.'_components.sidebar-default')
                            
                        </div>
                        <!--Sidebar-->  
                        
                    </div>
                </div>
            </div>
            <!-- /.content -->

@endsection