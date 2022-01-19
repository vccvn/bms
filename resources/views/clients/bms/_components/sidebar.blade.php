<div class="sidebar">

    <div class="orther-list mb-4">
        <h5>Tìm kiếm</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>
        <div class="search-form-block">
            <form action="{{route('client.search')}}" method="get">
                <div class="form-group">
                    <div class="input-group">
                        <input type="search" name="s" class="form-control" placeholder="Nhập từ khóa...">
                        <button type="submit" class="btn btn-warning input-group-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (count($lastest_posts = get_posts(['@orderBy'=>['id','DESC'], '@limit'=>5])))
    


    <div class="orther-list">
        <h5>Bài viết mới nhất</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>

        <div class="post-list row">
            @foreach ($lastest_posts as $item)
                
            
            <div class="post-item col-lg-12 col-md-6 col-sm-6 col-12 mb-4">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <a href="{{$u = $item->getViewUrl()}}">
                            <img src="{{$item->getImage()}}" alt="{{$item->slug}}">
                        </a>
                    </div>
                    <div class="col-12 col-sm-8">
                        <a href="{{$u}}" class="text-dark">{{$item->title}}</a>
                    </div>
                                        
                </div>
                
            </div>
            @endforeach

        </div>
    </div>

@endif

@if (count($categories = get_categories(['@orderBy'=>['id','DESC'], '@limit'=>5])))
    


    <div class="orther-list">
        <h5>Thể loại</h5>
        <p class="col-lg-12 col-md-12 text-subline"></p>

        <ul class="categories">
            @foreach ($categories as $item)
                <li class="category-item">
                    <a href="{{$u = $item->getViewUrl()}}">
                        {{$item->name}}
                    </a>
                </li>
            @endforeach
            

        </ul>
    </div>

@endif

</div>