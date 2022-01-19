(function($) {

    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(200).fadeOut(300);
        }
    }


    //Update Header Style and Scroll to Top
    function headerStyle() {
        if ($('.main-header').length) {
            var windowpos = $(window).scrollTop();
            var t = 200;
            if ($('#header-bottom-static').length) {
                t = $('#header-bottom-static').offset().top+50;
            }
            var siteHeader = $('.sticky-header');
            var scrollLink = $('.scroll-to-top');
            if (windowpos >= t) {
                siteHeader.addClass('now-visible');
                scrollLink.fadeIn(300);
            } else {
                siteHeader.removeClass('now-visible');
                scrollLink.fadeOut(300);
            }
        }
    }

    headerStyle();



    //Submenu Dropdown Toggle
    if ($('.main-header li.dropdown ul').length) {
        $('.main-header li.dropdown').append('<div class="dropdown-btn"><Span class="fa fa-angle-down"></span></div>');

        //Dropdown Button
        $('.main-header li.dropdown .dropdown-btn').on('click', function() {
            $(this).prev('ul').slideToggle(500);
        });


        //Disable dropdown parent link
        // $('.navigation li.dropdown > a').on('click', function(e) {
        //     // e.preventDefault();
        // });
    }


    //Revolution Slider
    if ($('.main-slider .tp-banner').length) {

        var MainSlider = $('.main-slider');
        var strtHeight = MainSlider.attr('data-start-height');
        var slideOverlay = "'" + MainSlider.attr('data-slide-overlay') + "'";

        $('.main-slider .tp-banner').show().revolution({
            dottedOverlay: slideOverlay,
            delay: 100000,
            startwidth: 1200,
            startheight: strtHeight,
            hideThumbs: 600,

            thumbWidth: 80,
            thumbHeight: 50,
            thumbAmount: 5,

            navigationType: "bullet",
            navigationArrows: "0",
            navigationStyle: "preview3",

            touchenabled: "on",
            onHoverStop: "off",

            swipe_velocity: 0.7,
            swipe_min_touches: 1,
            swipe_max_touches: 1,
            drag_block_vertical: false,

            parallax: "mouse",
            parallaxBgFreeze: "on",
            parallaxLevels: [7, 4, 3, 2, 5, 4, 3, 2, 1, 0],

            keyboardNavigation: "off",

            navigationHAlign: "center",
            navigationVAlign: "bottom",
            navigationHOffset: 0,
            navigationVOffset: 50,

            soloArrowLeftHalign: "left",
            soloArrowLeftValign: "center",
            soloArrowLeftHOffset: 20,
            soloArrowLeftVOffset: 0,

            soloArrowRightHalign: "right",
            soloArrowRightValign: "center",
            soloArrowRightHOffset: 20,
            soloArrowRightVOffset: 0,

            shadow: 0,
            fullWidth: "on",
            fullScreen: "off",

            spinner: "spinner4",

            stopLoop: "off",
            stopAfterLoops: -1,
            stopAtSlide: -1,

            shuffle: "off",

            autoHeight: "off",
            forceFullWidth: "on",

            hideThumbsOnMobile: "on",
            hideNavDelayOnMobile: 1500,
            hideBulletsOnMobile: "on",
            hideArrowsOnMobile: "on",
            hideThumbsUnderResolution: 0,

            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            startWithSlide: 0,
            videoJsPath: "",
            fullScreenOffsetContainer: ""
        });
    }

    //Search Popup / Hide Show
    if ($('#search-popup').length) {

        //Show Popup
        $('.search-box-btn').on('click', function(e) {
            e.preventDefault();
            $('#search-popup').addClass('popup-visible');
        });

        //Hide Popup
        $('.close-search').on('click', function() {
            $('#search-popup').removeClass('popup-visible');
        });
    }

    //Testimonial Style One
    if ($('.testimonial-style-two').length) {
        $('.testimonial-style-two').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            smartSpeed: 700,
            dots: false,
            autoplay: 5000,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        });
    }

    // Fact Counter
    function factCounter() {
        if ($('.fact-counter').length) {
            $('.fact-counter .counter-column.animated').each(function() {

                var $t = $(this),
                    n = $t.find(".count-text").attr("data-stop"),
                    r = parseInt($t.find(".count-text").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text()
                    }).animate({
                        countNum: n
                    }, {
                        duration: r,
                        easing: "linear",
                        step: function() {
                            $t.find(".count-text").text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $t.find(".count-text").text(this.countNum);
                        }
                    });
                }

            });
        }
    }

    //Fact Counter + Text Count
    if ($('.count-box').length) {
        $('.count-box').appear(function() {

            var $t = $(this),
                n = $t.find(".count-text").attr("data-stop"),
                r = parseInt($t.find(".count-text").attr("data-speed"), 10);

            if (!$t.hasClass("counted")) {
                $t.addClass("counted");
                $({
                    countNum: $t.find(".count-text").text()
                }).animate({
                    countNum: n
                }, {
                    duration: r,
                    easing: "linear",
                    step: function() {
                        $t.find(".count-text").text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $t.find(".count-text").text(this.countNum);
                    }
                });
            }

        }, { accY: 0 });
    }


    //Accordion Box
    if ($('.accordion-box').length) {
        $(".accordion-box").on('click', '.acc-btn', function() {

            var target = $(this).parents('.accordion');

            if ($(this).hasClass('active') !== true) {
                $('.accordion .acc-btn').removeClass('active');
            }

            if ($(this).next('.acc-content').is(':visible')) {
                //$(this).removeClass('active');
                return false;
                //$(this).next('.accord-content').slideUp(300);
            } else {
                $(this).addClass('active');
                $('.accordion').removeClass('active-block');
                $('.accordion .acc-content').slideUp(300);
                target.addClass('active-block');
                $(this).next('.acc-content').slideDown(300);
            }
        });
    }

    //Product Tabs
    if ($('.prod-tabs .tab-btn').length) {
        $('.prod-tabs .tab-btn').on('click', function(e) {
            e.preventDefault();
            var target = $($(this).attr('href'));
            $('.prod-tabs .tab-btn').removeClass('active-btn');
            $(this).addClass('active-btn');
            $('.prod-tabs .tab').fadeOut(0);
            $('.prod-tabs .tab').removeClass('active-tab');
            $(target).fadeIn(500);
            $(target).addClass('active-tab');
        });

    }

    //Progress Bar / Levels
    if ($('.progress-levels .progress-box .bar-fill').length) {
        $(".progress-box .bar-fill").each(function() {
            var progressWidth = $(this).attr('data-percent');
            $(this).css('width', progressWidth + '%');
            //$(this).parents('.progress-box').children('.percent').html(progressWidth+'%');
        });
    }


    //Single Item Carousel
    if ($('.single-item-carousel').length) {
        $('.single-item-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
            smartSpeed: 1000,
            autoplay: false,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        });
    }

    //two Item Carousel
    if ($('.two-item-carousel').length) {
        $('.two-item-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 1000,
            autoplay: true,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                }
            }
        });
    }

    //three Item Carousel
    if ($('.three-item-carousel').length) {
        $('.three-item-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 1000,
            autoplay: false,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        });
    }

    //four Item Carousel
    if ($('.four-item-carousel').length) {
        $('.four-item-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 1000,
            autoplay: false,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    }



    //five Item Carousel
    if ($('.five-item-carousel').length) {
        $('.five-item-carousel').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 1000,
            autoplay: false,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                800: {
                    items: 4
                },
                1024: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        });
    }


    //Sponsors Carousel Two
    if ($('.sponsors-carousel-one').length) {
        $('.sponsors-carousel-one').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: false,
            smartSpeed: 500,
            autoplay: 4000,
            navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                800: {
                    items: 4
                },
                1024: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        });
    }

    //four Item Carousel
    if ($('.custom-item-carousel').length) {
        var $cic = $('.custom-item-carousel');
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
            var sp           = $el.data('speed');
            var sh           = $el.data('show');
            var show         = (banned.indexOf(sh) == -1 && sh !== null)?parseInt(sh):4;
            
            var loop         = $el.data('loop')?true:false;
            var margin       = (banned.indexOf(mg) == -1 && mg !== null)?parseInt(mg):30;
            var dots         = $el.data('dots')?true:false;
            var nav          = $el.data('nav')?true:false;
            var smartSpeed   = (banned.indexOf(sp) == -1 && sp !== null)?parseInt(sp):1000;
            var autoplay     = $el.data('autoplay')?true:false;
            var responsive   = (typeof dataResponsive[show] != 'undefined')?dataResponsive[show]:dataResponsive[4];
            var option = {
                loop: loop,
                margin: margin,
                nav: nav,
                dots: dots,
                smartSpeed: smartSpeed,
                autoplay: autoplay,
                navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                responsive: responsive
            };
            $el.owlCarousel(option);
        });
    }


    //LightBox / Fancybox
    if ($('.lightbox-image').length) {
        $('.lightbox-image').fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            helpers: {
                media: {}
            }
        });
    }

    //Jquery Spinner / Quantity Spinner
    if ($('.quantity-spinner').length) {
        $("input.quantity-spinner").TouchSpin({
            verticalbuttons: true
        });
    }

    //Price Range Slider
    if ($('.range-slider-price').length) {

        var priceRange = document.getElementById('range-slider-price');

        noUiSlider.create(priceRange, {
            start: [30, 300],
            limit: 1000,
            behaviour: 'drag',
            connect: true,
            range: {
                'min': 10,
                'max': 500
            }
        });

        var limitFieldMin = document.getElementById('min-value-rangeslider');
        var limitFieldMax = document.getElementById('max-value-rangeslider');

        priceRange.noUiSlider.on('update', function(values, handle) {
            (handle ? limitFieldMax : limitFieldMin).value = values[handle];
        });
    }


    //Masonary Gallery
    function enableMasonry() {
        if ($('.masonary-layout').length) {
            $('.masonary-layout').isotope({
                layoutMode: 'masonry'
            });
        }

        if ($('.post-filter').length) {
            $('.post-filter li').children('span').click(function() {
                var Self = $(this);
                var selector = Self.parent().attr('data-filter');
                $('.post-filter li').children('span').parent().removeClass('active');
                Self.parent().addClass('active');


                $('.filter-layout').isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 500,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        }

        if ($('.post-filter.diferent-choose').length) {
            $('.post-filter.diferent-choose').each(function(ind, e){
                var $ch = $(e).children('li.active');
                if($ch.length){
                    $ch.each(function(i, li){
                        $(li).children('span').click();
                    });
                }
            });
            
        }


        if ($('.post-filter.has-dynamic-filter-counter').length) {
            // var allItem = $('.single-filter-item').length;

            var activeFilterItem = $('.post-filter.has-dynamic-filter-counter').find('li');

            activeFilterItem.each(function() {
                var filterElement = $(this).data('filter');
                console.log(filterElement);
                var count = $('.gallery-content').find(filterElement).length;

                $(this).children('span').append('<span class="count"><b>' + count + '</b></span>');
            });
        };
    }


    // // Contact Form Validation
    // if ($('#contact-form').length) {
    //     $("#contact-form").validate({
    //         submitHandler: function(form) {
    //             var form_btn = $(form).find('button[type="submit"]');
    //             var form_result_div = '#form-result';
    //             $(form_result_div).remove();
    //             form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
    //             var form_btn_old_msg = form_btn.html();
    //             form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
    //             $(form).ajaxSubmit({
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     var msg = '';
    //                     if (data.status) {
    //                         $(form).find('.form-control').val('');
    //                         msg = "Gá»­i liĂªn há»‡ thĂ nh cĂ´ng!";
    //                     }else if(data.errors.length){
    //                         msg = data.errors.join("<br />>");
    //                     }else{
    //                         msg = "lá»—i khĂ´ng xĂ¡c Ä‘á»‹nh";
    //                     }
    //                     form_btn.prop('disabled', false).html(form_btn_old_msg);
    //                     $(form_result_div).html(msg).fadeIn('slow');
    //                     setTimeout(function() { $(form_result_div).fadeOut('slow') }, 6000);
    //                 }
    //             });
    //         }
    //     });
    // }

    // Scroll to a Specific Div
    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function() {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

        });
    }

    // Elements Animation
    if ($('.wow').length) {
        var wow = new WOW({
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 0, // distance to the element when triggering the animation (default is 0)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true // act on asynchronously loaded content (default is true)
        });
        wow.init();
    }


    /* ==========================================================================
       When document is Scrollig, do
       ========================================================================== */

    $(window).on('scroll', function() {
        headerStyle();
        factCounter();
    });

    /* ==========================================================================
       When document is loaded, do
       ========================================================================== */

    $(window).on('load', function() {
        handlePreloader();
        enableMasonry();
    });


    /* ==========================================================================
       When document is Resized, do
       ========================================================================== */

    $(window).on('resize', function() {
        enableMasonry();
    });


})(window.jQuery);