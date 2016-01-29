jQuery(document).ready(function($){

	//scroll to top functionality
	$(".scroll-top").click(function() {
	  $("html, body").animate({ scrollTop: 0 });
	  return false;
	});


	//magnific popup stuff
	//portfolio popup
	$('.portfolio-popup-link').magnificPopup({
		type: 'ajax',
		removalDelay: 250,
		mainClass: 'mfp-fade',
		ajax: {
			settings: {
				method: 'POST',
				url: sustainableIncludes.ajaxurl,
				data: {
					action: 'portfolio_popup'
				}
			}
		},
		callbacks: {
			elementParse: function(item){
				var mp = $.magnificPopup.instance;
				// Get the post id to display
				mp.st.ajax.settings.data.post_id = $(item.el).data('postid');
			},
			ajaxContentAdded: function(){
				initiateFlexslider();

				$('.mfp-content').addClass('loaded');
			}
		}
	});

	//product popup
	$('.product-popup-link').magnificPopup({
		type: 'ajax',
		removalDelay: 250,
		mainClass: 'mfp-fade',
		ajax: {
			settings: {
				method: 'POST',
				url: sustainableIncludes.ajaxurl,
				data: {
					action: 'product_popup',
					post_id: 0 //TODO
				}
			}
		},
		callbacks: {
			ajaxContentAdded: function(){
				$('.mfp-content').addClass('loaded');
			}
		}
	});
	/*$('.ajax-popup-link').magnificPopup({
		type: 'ajax',
		removalDelay: 250,
		mainClass: 'mfp-fade',
		callbacks: {
			ajaxContentAdded: function(){
				initiateFlexslider();

				$('.mfp-content').addClass('loaded');
			}
		}
	});*/

	function initiateFlexslider(){
		$('#carousel').flexslider({
	      animation: "slide",
	      controlNav: false,
	      animationLoop: false,
	      slideshow: false,
	      itemWidth: 180,
	      itemMargin: 15,
	      asNavFor: '#slider'
	    });

	    $('#slider').flexslider({
	      animation: "slide",
	      controlNav: false,
	      animationLoop: false,
	      slideshow: false,
	      sync: "#carousel",
	      start: function(slider){
	        $('#slider, #carousel').addClass('loaded');
	      }
	    });
	}

	//hero slider for homepage
  var $flexslider = $('#hero .flexslider');
   $flexslider.flexslider({
     initDelay: 0,
		 pauseOnHover: false,
     animation: "fade",
     slideshowSpeed: 7000,
     animationLoop: true,
     manualControls: ".flex-control-nav li",
     useCSS: false,
     start: function(slider){
       //slide index
       var showingSlideIndex = slider.currentSlide;
       transitionHeroCaption(showingSlideIndex);
     },
     after: function(slider){
       //slide index
       var showingSlideIndex = slider.currentSlide;
       transitionHeroCaption(showingSlideIndex);
     }
    });

   var $slides = jQuery("#hero .flexslider .slides li");
   function transitionHeroCaption(showingSlideIndex){
     //hide any showing captions
     jQuery('.caption').each(function(){
       jQuery(this).attr("style", "");
     });

     //slide in active slides caption
     jQuery($slides[showingSlideIndex]).find(".caption").animate({
       top: "0",
       opacity: "1",
       filter: 'alpha(opacity=100)'
     }, 650, 'easeOutCubic', function() {});
   }


	//testimonial carousel
	$('#testimonials .flexslider').flexslider({
    animation: "slide",
    animationLoop: true,
		controlNav: false,
		directionNav: true,
    itemWidth: 1300,
    itemMargin: 0
  });


	//navigation for mobile
	var menuOpen = false,
		$wrapper = $('.site-wrapper'),
		$nav = $('.main-navigation'),
		$menuButton = $('.menu-btn'),
		closeNav = function(){
				$wrapper.removeClass('menu-open');
				$menuButton.removeClass('active');
				$nav.removeClass('active');

				//remove any inline styles from subnavigation
				$('.main-navigation ul').removeAttr('style');

				menuOpen = false;

		},
		menuBtnFn = function(){

				$menuButton.bind( 'touchstart, click', function(ev){

						ev.stopPropagation();
						ev.preventDefault();

						if ( menuOpen ) {
							closeNav();
						}

						else{
							$nav.addClass('active');
							$wrapper.addClass('menu-open');
							$(this).addClass('active');

							menuOpen = true;
						}


				});

		},
		secondlevelNav = function(){
				$('.main-navigation ul li a').each(function(){
						$(this).bind('touchstart, click', function(ev){

										if ( menuOpen && !$(this).next().is(':visible') && $(this).next().length > 0) {

														ev.stopPropagation();
														ev.preventDefault();

														//close whats already open
														$('.main-navigation ul li ul').slideUp();

														//expand current click
														$(this).parent().children('ul').slideDown();
										}

						});
				});
		};


	menuBtnFn();
	secondlevelNav();

	$(window).resize(function(){
		if( !$menuButton.is(':visible') ) {
			closeNav();
		}
	});//resize function

	$(window).trigger('resize');
});//.ready


// Init Skrollr
jQuery(window).load(function(){
	if ( jQuery('html').hasClass('no-touch') ) {
		var s = skrollr.init({
			forceHeight: false,
			smoothScrolling: false,
			render: function(data) {
					//Debugging - Log the current scroll position.
					//console.log(data.curTop);
			}
		});
	}
});


//equalizeHeight function
(function($){
	'use strict';
	$.fn.equalizeHeight = function(){
		var tallestHeight = 0,
		$box = this;

		$box.each(function(i, e){
			var elHeight = $(e).outerHeight();

			if(elHeight > tallestHeight) {
				tallestHeight = elHeight;
			}
		});

		$box.css('height', tallestHeight);

		return this;
	}
}(jQuery));
