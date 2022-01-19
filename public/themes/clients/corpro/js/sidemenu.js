
var corpro = {};
 
 (function($){
  "use strict";

  var $window = $(window),
      $document = $(document),
      $body = $('body'),
      $counter = $('.counter');

  $.fn.exists = function () {
      return this.length > 0;
  };


 corpro.sidemenu = function () {
        var $menu_btn = $('.mobile-nav-button'),
            $overlay =  $('.menu-overlay'),
            $menucls =  $('.menu-close'),
            $slidemenu =  $('.side-content');


        $menu_btn.on('click', function () {
           if ($(".search").exists()){
             if ($(".search").hasClass('is-visible')){
                   return false;  
             }
           }


            toggleslidemenu();   
            return false;   
        });
       
        $overlay.on('click', function () {
            toggleslidemenu('close');
            return false;
        });
        $menucls.on('click', function () {
            toggleslidemenu('close');
            return false;
        });
        function toggleslidemenu(type) {
            if(type=="close") {
                $slidemenu.removeClass('side-content-open');
                $overlay.removeClass('is-visible');
              } else {         
                $slidemenu.addClass('side-content-open');
                $overlay.addClass('is-visible');
                
            }
         }
 }


    $document.ready(function () {

        corpro.sidemenu();

    });


})(jQuery);