    <div class="row social-buttons">
        <div class="col-xs-6 col-sm-4">
            <div class="fb-like" data-href="{{$link}}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
        </div>
        <div class="col-xs-6 col-sm-4">
            <div class="fb-share-button" data-href="{{$link}}" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode($link)}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
        </div>
        <div class="col-xs-6 col-sm-4">
            <div id="tweet-btn" class="tweet-btn"></div>
        </div>
    </div>
    
    @section('final.js')
        <script>
            $(window).load(function () {
                twttr.widgets.createShareButton(
                  '{{$link}}',
                  document.getElementById('tweet-btn'),
                  {
                    text: '{{$title}}'
                  }
                );
            })
        </script>
    @endsection