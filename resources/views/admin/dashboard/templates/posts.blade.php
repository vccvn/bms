<section class="section">
    <div class="row sameheight-container">
        <div class="col-xl-8">
            <div class="card sameheight-item items" data-exclude="xs,sm,lg">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="title"> Tin bài </h3>
                        <a href="{{route('admin.post.add')}}" class="btn btn-primary btn-sm"> Thêm mới </a>
                    </div>
                    <div class="header-block pull-right">
                        <label class="search">
                            <input class="search-input" placeholder="search...">
                            <i class="fa fa-search search-icon"></i>
                        </label>
                        <div class="pagination">
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <ul class="item-list striped">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col item-col-header fixed item-col-img xs"></div>
                            <div class="item-col item-col-header item-col-title">
                                <div>
                                    <span>Tiêu đề</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-sales item">
                                <div>
                                    <span>Mô tả</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Lượt xem</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-date">
                                <div>
                                    <span>Published</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @forelse($posts as $item)
                    <li class="item">
                        <div class="item-row">
                            <div class="item-col fixed item-col-img xs">
                                <a href="">
                                    <div class="item-img xs rounded" style="background-image: url({{$item->getFeatureImage()}})"></div>
                                </a>
                            </div>
                            <div class="item-col item-col-title no-overflow">
                                <div>
                                    <a href="{{$item->getViewUrl()}}" class="">
                                        <h4 class="item-title no-wrap"> {{$item->title}} </h4>
                                    </a>
                                </div>
                            </div>
                            <div class="item-col item-col-sales">
                                <div class="item-heading">Mô tả</div>
                                <div> {{$item->getShortDesc(20)}} </div>
                            </div>
                            <div class="item-col item-col-stats">
                                <div class="item-heading">Lượt xem</div>
                                <div class="no-overflow">
                                        {{$item->views}}
                                </div>
                            </div>
                            <div class="item-col item-col-date">
                                <div class="item-heading">Published</div>
                                <div> {{date('M d - H:i:s', strtotime($item->created_at))}} </div>
                            </div>
                        </div>
                    </li>
                    @empty

                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown" data-exclude="xs,sm,lg">
                <div class="card-header">
                    <div class="header-block">
                        <h3 class="title"> Chủ đề được quan tâm </h3>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart"></div>
                </div>
            </div>
        </div>
    </div>
</section>
