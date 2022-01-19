
    <script src="{{asset('js/admin/jquery.cropit.js')}}"></script>
    <script src="{{asset('js/cube/main.js')}}"></script>
    <script src="{{asset('js/cube/str.js')}}"></script>
    <script src="{{asset('js/cube/arr.js')}}"></script>
    <script src="{{asset('js/cube/fn.js')}}"></script>
    <script src="{{asset('js/cube/videos.js')}}"></script>
    <script src="{{asset('js/cube/select.js')}}"></script>
    <script src="{{asset('js/cube/uploader.js')}}"></script>
    <script src="{{asset('js/cube/datetime.js')}}"></script>
    
    
    <script src="{{asset('js/admin/items.js')}}"></script>
    <script src="{{asset('js/admin/users.js')}}"></script>
    <script src="{{asset('js/admin/modules.js')}}"></script>
    <script src="{{asset('js/admin/menus.js')}}"></script>
    <script src="{{asset('js/admin/permissions.js')}}"></script>
    <script src="{{asset('js/admin/categories.js')}}"></script>
    <script src="{{asset('js/admin/products.js')}}"></script>
    <script src="{{asset('js/admin/product-categories.js')}}"></script>
    <script src="{{asset('js/admin/posts.js')}}"></script>
    <script src="{{asset('js/admin/pages.js')}}"></script>
    <script src="{{asset('js/admin/sliders.js')}}"></script>
    <script src="{{asset('js/admin/slugs.js')}}"></script>
    

    @if($user = Auth::user())
        @if($user->meta('user_group')=='dev')
            <script>
                $(function(){
                    $('.dev-only').removeClass('dev-only');
                });
            </script>
        @endif
    @endif