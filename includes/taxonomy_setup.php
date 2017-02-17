<?php
if( !class_exists('Taxonomy_Categories') ) {
	class Taxonomy_Categories {
		public $content_type;

		public function __construct($content_type) {
			$this->content_type  			= strtolower($content_type);
			$this->category_name 			= strtolower($content_type.'_categories');
			$this->category_singular  = ucfirst($content_type.' Category');
			add_action( 'init', array($this,'add_custom_taxonomies'));

		}

		public function add_custom_taxonomies() {
			$labels = array(
		     'name' 								=> _x( $this->category_singular, 'taxonomy general name' ),
		     'singular_name' 				=> _x( $this->category_singular , 'taxonomy singular name' ),
		     'search_items' 				=> __( $this->category_singular ),
		     'all_items' 						=> __( "All $this->category_singular" ),
		     'parent_item' 					=> __( "Parent $this->category_singular" ),
		     'parent_item_colon'		=> __( "Parent $this->category_singular:" ),
		     'edit_item' 						=> __( "Edit $this->category_singular" ),
		     'update_item' 					=> __( "Update $this->category_singular" ),
		     'add_new_item' 				=> __( "Add $this->category_singular" ),
		     'new_item_name' 				=> __( "New $this->category_singular" ),
		   );

		   register_taxonomy($this->category_name, $this->content_type ,array(
		     'hierarchical' 				=> true,
		     'show_ui'           		=> true,
		     'show_admin_column' 		=> true,
		     'labels' 							=> $labels
		   ));
		}
	}
}
