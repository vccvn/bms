$(function() {

    $('.actions-list > li').on('click', '.check', function(e) {
        e.preventDefault();

        $(this).parents('.tasks-item')
            .find('.checkbox')
            .prop("checked", true);

        removeActionList();
    });

});
//LoginForm validation
$(function() {
    if (!$('.form-control').length) {
        return false;
    }

    $('.form-control').focus(function() {
        $(this).siblings('.input-group-addon').addClass('focus');
    });

    $('.form-control').blur(function() {
        $(this).siblings('.input-group-addon').removeClass('focus');
    });
});
$(function() {

    // set sortable options
    $('.images-container').sortable({
        animation: 150,
        handle: ".control-btn.move",
        draggable: ".image-container",
        onMove: function(evt) {
            var $relatedElem = $(evt.related);

            if ($relatedElem.hasClass('add-image')) {
                return false;
            }
        }
    });


    $controlsButtons = $('.controls');

    $controlsButtonsStar = $controlsButtons.find('.star');
    $controlsButtonsRemove = $controlsButtons.find('.remove');

    $controlsButtonsStar.on('click', function(e) {
        e.preventDefault();

        $controlsButtonsStar.removeClass('active');
        $controlsButtonsStar.parents('.image-container').removeClass('main');

        $(this).addClass('active');

        $(this).parents('.image-container').addClass('main');
    })

})
$(function() {

    if (!$('#select-all-items').length) {
        return false;
    }


    $('#select-all-items').on('change', function() {
        var $this = $(this).children(':checkbox').get(0);

        $(this).parents('li')
            .siblings()
            .find(':checkbox')
            .prop('checked', $this.checked)
            .val($this.checked)
            .change();
    });


    function drawItemsListSparklines() {
        $(".items-list-page .sparkline").each(function() {
            var type = $(this).data('type');

            // Generate random data
            var data = [];
            for (var i = 0; i < 17; i++) {
                data.push(Math.round(100 * Math.random()));
            }

            $(this).sparkline(data, {
                barColor: config.chart.colorPrimary.toString(),
                height: $(this).height(),
                type: type
            });
        });
    }

    drawItemsListSparklines();

    $(document).on("themechange", function() {
        drawItemsListSparklines();
    });

});
$(function() {

    $(".wyswyg").each(function() {

        var $toolbar = $(this).find(".toolbar");
        var $editor = $(this).find(".editor");


        var editor = new Quill($editor.get(0), {
            theme: 'snow'
        });

        editor.addModule('toolbar', {
            container: $toolbar.get(0) // Selector for toolbar container
        });



    });

});