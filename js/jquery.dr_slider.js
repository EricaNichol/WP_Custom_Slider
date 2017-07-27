(function($){
	'use strict';
	// var php_vars;

	var accordionByDave = function() {
		// accordion
		$('.accordion_header').click(function() {

			var w = $(this).parent('.accordion_wrapper');

			if (w.hasClass('active')) {
				w.removeClass('active');
				w.children('.accordion_content').slideUp(500);
			} else {
				$('.accordion_wrapper.active').removeClass('active').children('.accordion_content').slideUp(500);
				w.addClass('active').children('.accordion_content').slideDown(500);
			}
		}); // End accordion click

		$('.codingbydave_accordion_list .field_item .accordion_wrapper').eq(0).addClass('active').find('.accordion_content').slideDown(500);

	};


	var thumbSlider = function() {
		var thumbnails = $('.sliders.test_container.owl-carousel');

		thumbnails.owlCarousel({
			loop:false,

		}).on('click', '.owl-item' , function(e){

			$('.owl-item').removeClass('main_image');

			var activeImage = $(this).addClass('activeImage').html();

			$('.main_image').find('.field_item').remove();
			$('.main_image').append(activeImage);

		});
   	// Put Main image div before carousel
			var initImage  = thumbnails.find('.owl-stage .owl-item').eq(0).html();
			thumbnails.before('<div class="main_image">' + initImage +'</div>');
			// console.log(initImage);
	}


	$(document).ready(function(){

		thumbSlider();

		accordionByDave();

  });

})(jQuery);
