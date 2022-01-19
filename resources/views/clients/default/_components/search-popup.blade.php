    <div id="search-popup" class="search-popup">
        <div class="close-search theme-btn"><span class="fa fa-close"></span></div>
        <div class="popup-inner">

            <div class="search-form">
                <form method="get" action="{{route('client.search')}}">
                    <div class="form-group">
                        <fieldset>
                            <input type="search" class="form-control" name="s" value="" placeholder="Nhập từ khóa...." required>
                            <input type="submit" value="Tìm kiếm" class="theme-btn">
                        </fieldset>
                    </div>
                </form>

                <br>
                @if($tags = get_popular_tags(['@limit'=>6]))
                <h3>Từ khóa nổi bật</h3>
                <!-- Tags -->
                <ul class="recent-searches">
                    @foreach($tags as $tag)

                    <li><a href="{{route('client.search',['s'=>$tag->lower])}}">{{$tag->keywords}}</a></li>

                    @endforeach
                </ul>
                
                @endif
                
            </div>

        </div>
    </div>