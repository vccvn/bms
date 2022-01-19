
@isset($categories)
<?php
    $status_texts = [1=>"Đang xử lý", 2=>"Đã hoàn thành", 3=>"Bị hủy bỏ"];
    $data = [];
    foreach ($categories as $cat) {
        $data[] = [
            'label' => $cat->name,
            'value' => $cat->views
        ];
    }
?>
<script>
$(function() {

    var $dashboardSalesBreakdownChart = $('#dashboard-sales-breakdown-chart');

    if (!$dashboardSalesBreakdownChart.length) {
        return false;
    }

    function drawSalesChart() {

        $dashboardSalesBreakdownChart.empty();

        Morris.Donut({
            element: 'dashboard-sales-breakdown-chart',
            data: {!! json_encode($data) !!},
            resize: true,
            colors: [
                tinycolor(config.chart.colorPrimary.toString()).lighten(10).toString(),
                tinycolor(config.chart.colorPrimary.toString()).darken(8).toString(),
                config.chart.colorPrimary.toString()
            ],
        });

        var $sameheightContainer = $dashboardSalesBreakdownChart.closest(".sameheight-container");

        setSameHeights($sameheightContainer);
    }

    drawSalesChart();

    $(document).on("themechange", function() {
        drawSalesChart();
    });

})
</script>
@endisset


@isset($trip_chart)
<?php 
    $order_data = [];
    $money_data = [];
    $data = [];
    foreach($trip_chart as $trip){
        $data[] = [
            'label' => $trip->trip_date,
            'a' => $trip->trip_total
        ];
    }
?>
<script>

$(function(){
    if (!$('#monthly-orders-chart').length) {
        return false;
    }

    $('#monthly-orders-chart').empty();
    Morris.Line({
        element: 'monthly-orders-chart',
        data: {!! json_encode($data) !!},
        xkey: 'label',
        ykeys: ['a'],
        labels: ['Số chuyến'],
        hideHover: 'auto',
        resize: true,
        lineColors: [
            config.chart.colorPrimary.toString(),
            config.chart.colorSecondary.toString(),
            
            tinycolor(config.chart.colorPrimary.toString()).darken(10).toString()
        ]
    });



});

</script>
@endisset