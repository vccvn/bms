
    <script>
            
    
    
            window.commentsInit = function() {
                Cube.comments.init({
                    urls:{
                        save_url: '{{route('client.comment.ajax-save')}}'
                        
                    }
                });
            };
    
            
        </script>
        @yield('jsinit')
    
        <script src="{{asset('js/cube/main.js')}}"></script>
        <script src="{{asset('js/cube/storage.js')}}"></script>
        <script src="{{asset('js/cube/str.js')}}"></script>
        <script src="{{asset('js/cube/videos.js')}}"></script>
        <script src="{{asset('js/cube/select.js')}}"></script>
        {{-- <script src="{{asset('js/client/auth.js')}}"></script> --}}
        {{-- <script src="{{asset('js/client/cart.js')}}"></script> --}}
        <script src="{{asset('js/client/validate.js')}}"></script>
        <script src="{{asset('js/client/comments.js')}}"></script>
        <script src="{{asset('js/client/utils.js')}}"></script>
        <script src="{{asset('js/client/subcribe.js')}}"></script>
        
        @yield('js')
    
        @yield('template.js')