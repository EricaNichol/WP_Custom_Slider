<?php
	//Add meta boxes
	add_action('add_meta_boxes','networks_meta_box_add');
	function networks_meta_box_add() {
		add_meta_box('networks_meta','Network External Link','network_meta_box_callback','networks','normal','high');
	}

	function network_meta_box_callback($post) {
		$values 	   	= get_post_meta($post->ID);
		$text 				= isset($values['network_text']) ? esc_attr($values['network_text'][0]) : '';
		wp_nonce_field('network_text_nonce','network_nonce');
		?>
		<!--  text  styling for this is admin.css -->
		<div>
			<input type="text" name="network_text" id="network_text"><?php echo $text; ?></input>
		</div>

		<?php
		// print "<pre>";
		// print_r($values);
		// print "</pre>";
	}

	add_action('save_post','network_meta_save');

	//Meta Data Only for Feature Slider
	function network_meta_save($post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'network_nonce' ] ) && wp_verify_nonce( $_POST[ 'network_nonce' ], 'network_text_nonce'  ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return ;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'network_text' ] ) ) {
			update_post_meta( $post_id, 'network_text', sanitize_text_field( $_POST[ 'network_text' ] ) );
		}
	}
