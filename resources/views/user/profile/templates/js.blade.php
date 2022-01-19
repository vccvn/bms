    <!-- Reference block for JS -->
    <div class="ref" id="ref">
        <div class="color-primary"></div>
        <div class="chart">
            <div class="color-primary"></div>
            <div class="color-secondary"></div>
        </div>
    </div>
    <script>
        var theme_css_url = '{{asset('themes/admin/css')}}';
        var theme_js_url = '{{asset('js/admin/plugins')}}';
        var ajaxBaseUrl = '{{url('admin')}}';
    </script>
    <script src="{{asset('themes/admin/js/vendor.js')}}"></script>

    <script src="{{asset('js/admin/plugins/start.js')}}"></script>
    <script src="{{asset('js/admin/plugins/chart.js')}}"></script>
    <script src="{{asset('js/admin/plugins/form.js')}}"></script>
    <script src="{{asset('js/admin/plugins/sidebar.js')}}"></script>
    <script src="{{asset('js/admin/plugins/settings.js')}}"></script>
    <script src="{{asset('js/admin/plugins/end.js')}}"></script>
    
    <script src="{{asset('js/admin/main.js')}}"></script>
    <script src="{{asset('js/admin/str.js')}}"></script>
    <script src="{{asset('js/admin/jquery.cropit.js')}}"></script>
    