<!DOCTYPE html>
<html>
<head>
    @include('clients._templates.meta')

    @include($__theme.'_templates.links')
    
    @include('clients._templates.setting-data', ['prefix'=>'head'])
</head>

<body>
    @include('clients._templates.setting-data', ['prefix'=>'body_top'])
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- Main Header -->
        @include($__theme.'_components.header')
        <!--End Main Header -->

        <!-- content -->

        <!--Page Title-->

        @include($__theme.'_components.page-title')

        <!--End Page Title-->

        <!--Sidebar Page-->
        <div class="sidebar-page-container right-side-bar">
            <div class="auto-container">
                <div class="row clearfix">
                    
                    <!--Content Side--> 
                    <div class="content-side col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        
                        @yield('content')
                        
                    </div>
                    <!--Content Side-->
                    
                    <!--Sidebar-->  
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        
                        @include($__theme.'_components.sidebar-'.(
                            in_array($__env->yieldContent('sidebar'),['default','shop'])?$__env->yieldContent('sidebar'):'default'
                        ))
                        
                    </div>
                    <!--Sidebar-->  
                    
                </div>
            </div>
        </div>
        <!-- /.content -->

        <!--Main Footer-->
        @include($__theme.'_components.footer')
        <!--End Main Footer-->

    </div>
    <!--End pagewrapper-->

    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="fa fa-long-arrow-up"></span></div>

    @include($__theme.'_templates.modals')

    <!--Search Popup-->

    @include($__theme.'_components.search-popup')

    <!--End Search Popup-->


    @include($__theme.'_templates.js')
    @include('clients._templates.setting-data', ['prefix'=>'body_bottom'])
</body>

</html>