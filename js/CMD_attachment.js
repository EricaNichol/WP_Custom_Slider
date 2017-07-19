(function($){
	'use strict';
	$(document).ready(function(){

		var items = ['syllabi','resources'];



		for(var i = 0; i < items.length ; i++ ) {
			var name = items[i];
			// Check to see if the 'Delete File' link exists on the page...
			if($('a#'+ name +'_file_delete').length === 1) {

				// Since the link exists, we need to handle the case when the user clicks on it...
				$('#'+ name +'_file_delete').click(function(e) {

					// We don't want the link to remove us from the current page
					// so we're going to stop it's normal behavior.
					e.preventDefault();

					// Find the text input element that stores the path to the file
					// and clear it's value.
					$('#'+ name +'_file_url').val('');

					// Hide this link so users can't click on it multiple times
					$(this).hide();

				});

			} // end if
		}



  });

})(jQuery);
