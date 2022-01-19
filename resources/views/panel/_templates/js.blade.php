
    <script src="{{asset('js/admin/jquery.cropit.js')}}"></script>
    <script src="{{asset('js/cube/main.js')}}"></script>
    <script src="{{asset('js/cube/str.js')}}"></script>
    <script src="{{asset('js/cube/arr.js')}}"></script>
    <script src="{{asset('js/cube/fn.js')}}"></script>
    <script src="{{asset('js/cube/videos.js')}}"></script>
    <script src="{{asset('js/cube/select.js')}}"></script>
    <script src="{{asset('js/cube/uploader.js')}}"></script>
    

    @if($user = Auth::user())
        @if($user->meta('user_group')=='dev')
            <script>
                $(function(){
                    $('.dev-only').removeClass('dev-only');
                });
            </script>
        @endif
    @endif