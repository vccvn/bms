@extends($__theme.'_layouts.main')


@section('content')

        <!--Main Slider-->
        @include($__current.'templates.slider')
        <!--End Main Slider-->

        @include($__current.'templates.demo')
        <!-- About Us -->
        @include($__current.'templates.about-us')
        <!-- End About Us -->
        
        <!-- services -->
        @include($__current.'templates.services')
        <!--Fun Facts Section-->


        @include($__current.'templates.fun-facts')
        <!--Fun Facts Section-->

        <!-- Projects Section-->
        @include($__current.'templates.projects')
        <!--End Projects Section-->

        <!--News Section-->
        @include($__current.'templates.posts')
        <!--News Section-->

        <!--Testimonail Section-->
        {{-- @include($__current.'templates.team') --}}
        <!--End Testimonail Section-->
        
        <!--Sponsors Style Two-->
        @include($__current.'templates.partner')


@endsection