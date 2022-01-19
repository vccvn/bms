$(function(){
    //four Item Carousel
    if ($('.bms-carousel').length) {
        var $cic = $('.bms-carousel');
        var dataResponsive={
            1:{0:{items:1},1024:{items:1}},
            2:{0:{items:1},767:{items:2}},
            3:{0:{items:1},600:{items:2},1024:{items:3}},
            4:{0:{items:1},600:{items:2},992:{items:4},1200:{items:4}},
            5:{0:{items:1},600:{items:3},800:{items:4},1024:{items:4},1200:{items:5}},
            6:{0:{items:1},600:{items:3},800:{items:4},1024:{items:4},1200:{items:6}},
            8:{0:{items:1},600:{items:2},800:{items:4},1024:{items:6},1200:{items:8}}
        };
        var banned = [undefined, null, NaN];
        $cic.each(function(index, elem) {
            var $el          = $(elem);
            var mg           = $el.data('margin');
            var spd          = $el.data('padding');
            var sp           = $el.data('speed');
            var tmo          = $el.data('timeout');
            var sh           = $el.data('show');
            var show         = (banned.indexOf(sh) == -1 && sh !== null)?parseInt(sh):4;
            
            var loop         = $el.data('loop')?true:false;
            var margin       = (banned.indexOf(mg) == -1 && mg !== null)?parseInt(mg):30;
            var dots         = $el.data('dots')?true:false;
            var nav          = $el.data('nav')?true:false;
            var smartSpeed   = (banned.indexOf(sp) == -1 && sp !== null)?parseInt(sp):1000;
            var autoplay     = $el.data('autoplay')?true:false;
            var hoverPause   = $el.data('hover-pause')?true:false;
            var apt          = (banned.indexOf(tmo) == -1 && tmo !== null)?parseInt(tmo):2000;
            var stagePadding = (banned.indexOf(spd) == -1 && spd !== null)?parseInt(spd):0;
            var responsive   = (typeof dataResponsive[show] != 'undefined')?dataResponsive[show]:dataResponsive[4];
            var option = {
                loop: loop,
                margin: margin,
                stagePadding: stagePadding,
                nav: nav,
                dots: dots,
                smartSpeed: smartSpeed,
                autoplay: autoplay,
                autoplayTimeout:apt,
                autoplayHoverPause:hoverPause,
                navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                responsive: responsive
            };
            $el.owlCarousel(option);
        });
    }


    if($('.navbar-search .btn-show-form').length){
        $('.navbar-search .btn-show-form').click(function(e){
            if($('.navbar-search .search-input').val().length)
            {
                $(this).parent().find('.dynamic-search-form').submit();
            }else{
                $(this).parent().find('input').focus();
            }

            return false;
        });
    }

    if($('.main-menu .has-sub').length){
        $('.main-menu .has-sub>a.nav-link').after('<a href="javascript:void(0);" class="btn-show-sub"><i class="fa fa-angle-down"></i></a>');
        $('.main-menu .has-sub').on('click', 'a.btn-show-sub', function(e){
            $(this).parent().toggleClass('show-sub');
            
        })
    }
});