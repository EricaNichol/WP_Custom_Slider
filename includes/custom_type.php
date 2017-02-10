
<?php
define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));

if( !class_exists('Custom_Type') ) {
	class Custom_Type {

		public $content_type;

		public function __construct($content_type) {
			$this->content_type = $content_type;
			$this->content_name = ucfirst(str_replace('_',' ',$content_type));
			add_action('setup_theme', array($this,'register_post_type'));
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
				'builtin'             => false,
				//'taxonomies' => array( 'categories' ),
				'supports' 						=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
			);
			//Register Custom Post Type.
			register_post_type( $this->content_type, $args );
		}
	}
}

include( PLUGIN_PATH . 'publications_meta.php');
include( PLUGIN_PATH . 'feature_slider_meta.php');
