
<?php
if( !class_exists('Custom_Type') ) {
	class Custom_Type {
		public $content_type;

		public function __construct($content_type) {
			$this->content_type = $content_type;
			$this->content_name = ucfirst(str_replace('_',' ',$content_type));
			add_action('init', array($this,'register_post_type'));
		}

		//Custom Post Type Arguments
		public function register_post_type() {
			$labels = array(
				'name' 								=> _x($this->content_name, 'post type general name'),
				'singular_name' 			=> _x($this->content_name, 'post type singular name'),
				'add_new' 						=> _x('Add New', $this->content_name),
				'add_new_item' 				=> __("Add New $this->content_name"),
				'edit_item'						=> __("Edit $this->content_name"),
				'new_item' 						=> __("New $this->content_name"),
				'all_items' 					=> __("All $this->content_name"),
				'view_item' 					=> __("View $this->content_name"),
				'search_items' 				=> __("Search $this->content_name"),
				'not_found' 					=>  __('Nothing found'),
				'not_found_in_trash' 	=> __('Nothing found in Trash'),
				'parent_item_colon' 	=> ''
			);

			//Custom Post Type Arguments
			$args = array(
				'labels' 							=> $labels,
				'public' 							=> true,
				'has_archive' 				=> true,
				'publicly_queryable' 	=> true,
				'show_ui' 						=> true,
				'query_var' 					=> true,
				'rewrite' 						=> array('slug' => "$this->content_type",'with_front' => FALSE),
				'capability_type'		 	=> 'post',
				'hierarchical' 				=> true,
				'menu_position'			 	=> 3,
				//'taxonomies' => array( 'categories' ),
				'supports' 						=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
			);
			//Register Custom Post Type.
			register_post_type( "$this->content_type", $args );
		}
	}
}

if ( post_type_exists('feature_slider') == true ) {
	//Meta Data Only for Feature Slider
	add_action('add_meta_boxes','slideshow_meta_box_add');
	add_action('save_post','slideshow_meta_save');
	add_action('init','add_categories_to_slideshow');

	function slideshow_meta_save($post_id) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'slideshow_nonce' ] ) && wp_verify_nonce( $_POST[ 'slideshow_nonce' ], 'slideshow_position_nonce'  ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return ;
		}

		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'slideshow_position' ] ) ) {
			update_post_meta( $post_id, 'slideshow_position', sanitize_text_field( $_POST[ 'slideshow_position' ] ) );
		}
		if( isset( $_POST[ 'slideshow_btn_text' ] ) ) {
			update_post_meta( $post_id, 'slideshow_btn_text', sanitize_text_field( $_POST[ 'slideshow_btn_text' ] ) );
		}
		if( isset( $_POST[ 'slideshow_btn_url' ] ) ) {
			update_post_meta( $post_id, 'slideshow_btn_url', sanitize_text_field( $_POST[ 'slideshow_btn_url' ] ) );
		}
		if( isset( $_POST[ 'slideshow_image_position' ] ) ) {
			update_post_meta( $post_id, 'slideshow_image_position', sanitize_text_field( $_POST[ 'slideshow_image_position' ] ) );
		}
	}

	function slideshow_meta_box_callback($post) {
		$values 	   	= get_post_meta($post->ID);
		$selected 	  = isset($values['slideshow_position']) ? esc_attr($values['slideshow_position'][0]) : '';
		$selected_img = isset($values['slideshow_image_position']) ? esc_attr($values['slideshow_image_position'][0]) : '';
		$text 				= isset($values['slideshow_btn_text']) ? esc_attr($values['slideshow_btn_text'][0]) : '';
		$url		 			= isset($values['slideshow_btn_url']) ? esc_attr($values['slideshow_btn_url'][0]) : '';
		wp_nonce_field('slideshow_position_nonce','slideshow_nonce');
		?>
		<!--  Position -->
		<div>
			<label for="slide_show_dropdown">Slide Content Position</label>
			<select name="slideshow_position" id="slideshow_position" >
				<option value="top" <?php selected($selected, 'top'); ?>>Top</option>
				<option value="middle" <?php selected($selected, 'middle'); ?>>Middle</option>
				<option value="bottom" <?php selected($selected, 'bottom'); ?>>Bottom</option>
			</select>
		</div>
		<!-- background image -->
		<div>
			<label for="slide_show_dropdown">Slider Image Focal Point</label>
			<select name="slideshow_image_position" id="slideshow_image_position" >
				<option value="top" <?php selected($selected_img, 'top'); ?>>Top</option>
				<option value="middle" <?php selected($selected_img, 'middle'); ?>>Middle</option>
				<option value="bottom" <?php selected($selected_img, 'bottom'); ?>>Bottom</option>
			</select>
		</div>
		<!--  text  -->
		<div>
			<label for="slideshow_btn_text">Slider Button Title</label>
			<input type="text" name="slideshow_btn_text" id="slideshow_btn_text" value="<?php echo $text; ?>" />
		</div>
		<!-- Url -->
		<div>
			<label for="slideshow_btn_text">Slider Button Link</label>
			<input type="text" name="slideshow_btn_url" id="slideshow_btn_url" value="<?php echo $url; ?>" />
		</div>

		<?php
		// print "<pre>";
		// print_r($values);
		// print "</pre>";
	}
	//Add meta boxes
	function slideshow_meta_box_add() {
		add_meta_box('slideshow_meta','Slider Content','slideshow_meta_box_callback','feature_slider','normal','high');
	}

	function add_categories_to_slideshow(){
		register_taxonomy_for_object_type( 'category', 'slideshow' );
	}

}
