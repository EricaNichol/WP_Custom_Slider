<?php
define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));

if( !class_exists('Query_Type') ) {
	class Query_Type {

		// const VC_PARAMS = $atts;
		public function __construct() {
			add_shortcode('dr_slider', 'get_vc_params' );
		}

	}
}

if ( class_exists('Query_type') ) {

	/****
	Get params from shortcode
	Save+Param+Values+in+Shortcode+String
	****/
	function get_vc_params($atts) {

		$atts = vc_map_get_attributes('dr_slider', $atts);

		extract( $atts );

	params_var_to_javascript($atts);

	return render_slider_shortcode($atts);
}
/****
Php Variables to Javascript Variables
****/
function params_var_to_javascript($atts) {
	wp_enqueue_script('banner_script', plugin_dir_url(__FILE__) . '../js/jquery.dr_slider.js');
	wp_localize_script('banner_script', 'php_vars_'.$atts['custom_id'], $atts);
}

/****
Render Template
****/
function render_slider_shortcode($atts) {

	$content_type = str_replace(' ', '_' ,strtolower($atts['content_type']));
	$custom_id    = (string)$atts['custom_id'];
	$view_type    = str_replace(' ', '_' ,strtolower($atts['list_view']));

	// print '<pre>';
	// print $content_type;
	// print '</pre>';

	// $args = array('post_type' 		 => (string)$content_type,
	// 'posts_per_page' => -1,
	// 'orderby'        => 'menu_order',
	// 'order'          => 'ASC'
	// );

switch($view_type) {
	case 'feature_slider':
		include( PLUGIN_PATH . 'templates/feature_slider_template.php');
	break;
	case 'announcements':
		include( PLUGIN_PATH . 'templates/annoucements_template.php');
	break;
	case 'publications':
		include( PLUGIN_PATH . 'templates/publications_template.php');
	break;
	case 'basic_list':
		include( PLUGIN_PATH . 'templates/basic_template.php');
	break;
	case 'download_list':
		include( PLUGIN_PATH . 'templates/basic_download_template.php');
	break;
	default:
		include( PLUGIN_PATH . 'templates/default_template.php');
}

return $output;
}


}
