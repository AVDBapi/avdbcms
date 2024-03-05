(function($) {
    "use strict";
    $(document).ready(function(){
    	if( window.innerWidth <= 820 ) { 
		  var swiper = new Swiper('.swiper-container', {
		    lazy: true,
		    effect: "coverflow",
		    grabCursor: true,
		    centeredSlides: true,
		    loop: true,
		    slidesPerView: "2",
		    spaceBetween: 10,
		    freeMode: true,
		    autoplay: {
		      delay: 3000,
		      disableOnInteraction: false,
		    },
		    coverflowEffect: {
		          rotate: 0,
		          stretch: 0,
		          depth: 100,
		          modifier: 5,
		          slideShadows: false
		        },
		    pagination: {
		    el: ".swiper-pagination",
		    clickable: true,
		        }
		    
		  });

		}else{

		  var swiper = new Swiper('.swiper-container', {
		    lazy: true,
		    effect: "coverflow",
		    grabCursor: true,
		    centeredSlides: true,
		    loop: true,
		    freeMode: true,
		    slidesPerView: "3",
		    spaceBetween: 65,
		    autoplay: {
		      delay: 3000,
		      disableOnInteraction: false,
		    },
		    coverflowEffect: {
		          rotate: 0,
		          stretch: 0,
		          depth: 100,
		          modifier: 5,
		          slideShadows: false
		        },
		    pagination: {
		    el: ".swiper-pagination",
		    clickable: true,
		        }
		    
		  });
		}
		  var swiper = new Swiper('#star-slider', {
		    lazy: true,
		    grabCursor: true,
		    centeredSlides: true,
		    loop: true,
			  breakpoints: {
				  124: {
					  slidesPerView: 1,
					  spaceBetween: 20,
				  },
				  248: {
					  slidesPerView: 2,
					  spaceBetween: 20,
				  },
				  372: {
					  slidesPerView: 3,
					  spaceBetween: 20,
				  },
				  496: {
					  slidesPerView: 4,
					  spaceBetween: 20,
				  },
				  620: {
					  slidesPerView: 5,
					  spaceBetween: 20,
				  },
				  744: {
					  slidesPerView: 6,
					  spaceBetween: 20,
				  },
				  868: {
					  slidesPerView: 7,
					  spaceBetween: 20,
				  },
				  992: {
					  slidesPerView: 8,
					  spaceBetween: 20,
				  },
				  1116: {
					  slidesPerView: 9,
					  spaceBetween: 20,
				  }
			  }
		    
		  });

    })

    var swiper = new Swiper('#slider', {
      lazy: true,
      effect: 'fade',
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      effect: 'fade',
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
        // type: 'fraction',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });	
})(jQuery);
