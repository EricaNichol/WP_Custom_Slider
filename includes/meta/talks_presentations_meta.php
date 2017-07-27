<?php

	add_action('add_meta_boxes','url_meta_box_add');
	function url_meta_box_add() {
			add_meta_box('url_meta','External Media Links','url_meta_box_callback', "talks" ,'normal','high');
	}

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
