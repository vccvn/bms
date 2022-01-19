<!DOCTYPE html>
<html>
    <head>
        @include($__utils.'meta')

        @include($__templates.'links')
        
        @include($__utils.'setting-data', ['prefix'=>'head'])
        

    </head>
    <body>
        @include($__utils.'setting-data', ['prefix'=>'body_top'])
        @include($__components.'header')

        @include($__components.'page-header')

        
        <main class="main d-block ">
            @yield('content')
        </main>


        @include($__components.'footer')

        @include($__utils.'modals')

        @include($__templates.'js')

        @include($__utils.'js')

        @include($__utils.'setting-data', ['prefix'=>'body_bottom'])
        
    </body>
</html>