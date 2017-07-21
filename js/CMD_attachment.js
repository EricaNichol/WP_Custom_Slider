(function($){
	'use strict';
	$(document).ready(function(){

		var items = ['syllabi','resources'];

		$.each(items, function(key, val) {

				// Since the link exists, we need to handle the case when the user clicks on it...
				$('#'+ val +'_file_delete').click(function(e) {

					// We don't want the link to remove us from the current page
					// so we're going to stop it's normal behavior.
					e.preventDefault();

					// Find the text input element that stores the path to the file
					// and clear it's value.
					$('#'+ val +'_file_url').val('');

					// Hide this link so users can't click on it multiple times
					$(this).hide();

				});

		});

  });

})(jQuery);
