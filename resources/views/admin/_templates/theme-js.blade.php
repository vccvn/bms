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
        var theme_js_url = '{{asset('themes/admin/js')}}';
        var ajaxBaseUrl = '{{url('admin')}}';
    </script>
    <script src="{{asset('themes/admin/js/vendor.js')}}"></script>

    <script src="{{asset('themes/admin/js/start.js')}}"></script>
    <script src="{{asset('themes/admin/js/chart.js')}}"></script>
    <script src="{{asset('themes/admin/js/form.js')}}"></script>
    <script src="{{asset('themes/admin/js/sidebar.js')}}"></script>
    <script src="{{asset('themes/admin/js/settings.js')}}"></script>
    <script src="{{asset('themes/admin/js/end.js')}}"></script>
    