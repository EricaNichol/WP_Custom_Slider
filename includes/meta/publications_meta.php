<?php
	//Add meta boxes
	add_action('add_meta_boxes','publications_meta_box_add');
	function publications_meta_box_add() {
		add_meta_box('publications_meta','Publication Citation','publication_meta_box_callback','publications','normal','high');
	}

	function publication_meta_box_callback($post) {
		$values 	   	= get_post_meta($post->ID);
		$text 				= isset($values['publication_text']) ? esc_attr($values['publication_text'][0]) : '';
		wp_nonce_field('publication_text_nonce','publication_nonce');
		?>
		<!--  text  styling for this is admin.css -->
		<div>
			<textarea type="text" name="publication_text" id="publication_text"><?php echo $text; ?></textarea>
		</div>

		<?php
		// print "<pre>";
		// print_r($values);
		// print "</pre>";
	}

	add_action('save_post','publication_meta_save');

	//Meta Data Only for Feature Slider
	function publication_meta_save($post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'publication_nonce' ] ) && wp_verify_nonce( $_POST[ 'publication_nonce' ], 'publication_text_nonce'  ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return ;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'publication_text' ] ) ) {
			update_post_meta( $post_id, 'publication_text', sanitize_text_field( $_POST[ 'publication_text' ] ) );
		}
	}
