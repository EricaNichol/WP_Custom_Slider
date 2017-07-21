<?php
define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));

//Add meta boxes
add_action('add_meta_boxes','resources_meta_box_add');
function resources_meta_box_add() {
	add_meta_box('url_meta','External Media Links','url_meta_box_callback', 'resources' ,'normal','high');
	add_meta_box('resources_meta','Resources File','resources_meta_box_callback','resources','side','high');
}

function resources_meta_box_callback($post) {
	$values 	   	= get_post_meta($post->ID,'resources_file', true );
	$text 				= isset( $values['url'] ) ? $values['url'] : '';
	wp_nonce_field('resources_file_nonce','resources_nonce');
	?>
	<!--  text  styling for this is admin.css -->
	<div>
		<input type="file" name="resources_file" id="resources_file" value="" size="30"/>
		<input type="text" id="resources_file_url" name="resources_file_url" value="<?php echo $text ?>" size="30" />
		<p>Current:</p>
		<p style="word-break: break-all; "><?php echo $text; ?></p>

		<?php if ( !empty($text) ): ?>
			<a href="javascript:;" id="resources_file_delete"><?php echo  __('Delete File') ?></a>
		<?php endif; ?>

	</div>
	<?php
	// print "<pre>";
	// print_r($values);
	// print "</pre>";
}

add_action('save_post','resources_meta_save');


	function url_meta_box_callback($post) {
		$values 	   	= get_post_meta($post->ID);
		$text 				= isset($values['url_text']) ? esc_attr($values['url_text'][0]) : '';
		wp_nonce_field('url_text_nonce','url_nonce');
		?>

		<!--  text  styling for this is admin.css -->

		<div>
			<input type="text" name="url_text" id="url_text" value="<?php echo $text; ?>">
			<p>External Media Link to Youtube for Presentations</p>
		</div>

		<?php
		// print "<pre>";
		// print_r($values);
		// print "</pre>";
	}
	add_action('save_post','url_meta_save');

	//Meta Data Only for Feature Slider
	function url_meta_save($post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'url_nonce' ] ) && wp_verify_nonce( $_POST[ 'url_nonce' ], 'url_text_nonce'  ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return ;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'url_text' ] ) ) {
			update_post_meta( $post_id, 'url_text', sanitize_text_field( $_POST[ 'url_text' ] ) );
		}
	}


//Meta Data Only for Feature Slider
function resources_meta_save($post_id) {
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'resources_nonce' ] ) && wp_verify_nonce( $_POST[ 'resources_nonce' ], 'resources_file_nonce'  ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return ;
	}


	// Argument IF ELSE for saving
	if(!empty($_FILES['resources_file']['name'])) {
		// Setup the array of supported file types. In this case, it's just PDF.
		$supported_types = array('application/pdf',"application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document");

		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['resources_file']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(in_array($uploaded_type, $supported_types)) {
			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['resources_file']['name'], null, file_get_contents($_FILES['resources_file']['tmp_name']));

			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($post_id, 'resources_file', $upload);
				update_post_meta($post_id, 'resources_file', $upload);
			} // end if/else

		} else {
			wp_die("The file type that you've uploaded is not a PDF.");
		} // end if/else

	} else if (empty($_POST['resources_file_url'] ) ) {

//new value which is 0
		$doc = get_post_meta($post_id, 'resources_file', true);
		// / Grab the value for the URL to the file stored in the text element
		$delete_flag = get_post_meta($post_id, 'resources_file_url', true);

//if current url is longer than 0 and deleted field == 0
		if(strlen(trim($doc['url'])) > 0 && strlen(trim($delete_flag)) == 0) {
			// Attempt to remove the file. If deleting it fails, print a WordPress error.
			// one liner for deleting
			if(unlink($doc['file'])) {
				// Delete succeeded so reset the WordPress meta data
				update_post_meta($post_id, 'resources_file', null);
				update_post_meta($post_id, 'resources_file_url', '');
			} else {
				wp_die('There was an error trying to delete your file.');
			} // end if/el;se
		} // end if
	}
}





?>
