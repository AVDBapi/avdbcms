(function($) {
    "use strict";
    $(window).load(function() {
        $('#ovoo-preloader').addClass('loaded');
        $('body').removeClass('no-scroll-y');
        setTimeout(function() {
            $('#preloader').remove();
        }, 1000);
    });
    $(document).ready(function(){
    	$('.lazy').lazy({
    		effect: "fadeIn",
        effectTime: 1000
      });

    if (window.innerWidth > 400) {
      $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
          placement: 'auto',
          boundary: 'window',
          trigger: 'hover',
          delay: {
            "show": 1000
          },
          html: true,
          container: 'body'
        });
      });
    } else {
      $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
          placement: 'auto',
          boundary: 'window',
          trigger: 'click',
          html: true,
          container: 'body'
        });
      });
    }
    // scroll-to-top
    var ScrollTop = $(".scrollToTop");
    $(window).on('scroll', function () {
      if ($(this).scrollTop() < 800) {
          ScrollTop.removeClass("active");
      } else {
          ScrollTop.addClass("active");
      }
    });
    $('a[href="#search"]').on("click", function(event) {
        event.preventDefault();
        $("#search").addClass("open");
        $('#search > form > input[type="search"]').focus();
    });

    $("#search, #search button.close").on("click keyup", function(event) {
        if (
            event.target == this ||
            event.target.className == "close" ||
            event.keyCode == 27
        ) {
            $(this).removeClass("open");
        }
    });
  })
})(jQuery);