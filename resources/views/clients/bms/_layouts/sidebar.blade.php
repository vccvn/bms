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

        
        <section >
            <div class="container">
                <div class="row mt-4 ">
                    <div class="col-lg-8 col-md-12">
                        @yield('content')
                    </div>
                    <div class="col-lg-4 col-md-12">
                        @include($__components.'sidebar')
                    </div>
                </div>
            </div>
        </section>


        @include($__components.'footer')

        @include($__utils.'modals')

        @include($__templates.'js')

        @include($__utils.'js')

        @include($__utils.'setting-data', ['prefix'=>'body_bottom'])
        
    </body>
</html>