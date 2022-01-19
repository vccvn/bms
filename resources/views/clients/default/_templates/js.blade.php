
    <script src="{{get_theme_url('js/jquery.js')}}"></script>
    <script src="{{get_theme_url('js/bootstrap.min.js')}}"></script>
    <script src="{{get_theme_url('js/revolution.min.js')}}"></script>
    <script src="{{get_theme_url('js/jquery.fancybox.pack.js')}}"></script>
    <script src="{{get_theme_url('js/jquery.fancybox-media.js')}}"></script>
    <script src="{{get_theme_url('js/owl.js')}}"></script>
    <script src="{{get_theme_url('js/wow.js')}}"></script>
    <script src="{{get_theme_url('js/parallax.js')}}"></script>
    <script src="{{get_theme_url('js/sidemenu.js')}}"></script>
    <script src="{{get_theme_url('js/isotope.js')}}"></script>
    <script src="{{get_theme_url('js/appear.js')}}"></script>
    <script src="{{get_theme_url('js/nouislider.js')}}"></script>
    <script src="{{get_theme_url('js/jquery.bootstrap-touchspin.js')}}"></script>
    
    <script src="{{get_theme_url('js/validate.js')}}"></script>
    <script src="{{get_theme_url('js/mailer.js')}}"></script>
    
    
    <script src="{{get_theme_url('js/script.js')}}"></script>
    <script>
        window.cartInit = function() {
            Cube.cart.init({
                urls:{
                    add: '{{route('client.cart.add')}}',
                    remove: '{{route('client.cart.remove')}}',
                    update: '{{route('client.cart.update')}}',
                    update_by_key: '{{route('client.cart.update-by-key')}}',
                    update_cart: '{{route('client.cart.update-cart')}}',
                    refresh: '{{route('client.cart.refresh')}}',
                    empty: '{{route('client.cart.empty')}}',
                    checkout: '{{route('client.cart.checkout')}}'
                    
                },
                VAT: {{$__setting->VAT?$__setting->VAT:0}}
            });
        };

        window.authInit = function() {
            Cube.auth.init({
                urls:{
                    check: '{{route('client.auth.check')}}'
                },
                templates:{
                    auth: 'Xin chào, <a class="theme_color" href="{{route('user.profile')}}">{$name}</a> [ <a class="theme_color" href="{{route('client.auth.logout')}}">Thoát</a> ]',
                    guest: "Chào mừng bạn đã đến với {{$siteinfo->site_name}}"
                }
            });
        };


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
    <script src="{{asset('js/client/auth.js')}}"></script>
    <script src="{{asset('js/client/cart.js')}}"></script>
    <script src="{{asset('js/client/comments.js')}}"></script>
    <script src="{{asset('js/client/utils.js')}}"></script>
    
    @yield('js')

    @yield('template.js')

    