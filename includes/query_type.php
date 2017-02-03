<?php

if( !class_exists('Query_Type') ) {
	class Query_Type {

		// const VC_PARAMS = $atts;
		public function __construct() {
			add_shortcode('dr_slider','get_vc_params');

		}

	}
}

/****
Get params from shortcode
Save+Param+Values+in+Shortcode+String
****/
function get_vc_params($atts) {

	$atts = vc_map_get_attributes('dr_slider', $atts);

	extract( shortcode_atts( array(
		'content_type' => 'feature_slider',
		'slider_speed' => 1
	), $atts ) );

	params_var_to_javascript($atts);

	return render_slider_shortcode($atts);
}

/****
Php Variables to Javascript Variables
****/
function params_var_to_javascript($atts) {
	wp_enqueue_script('banner_script', '../js/jquery.dr_slider.js');
	wp_localize_script('banner_script', 'php_vars', $atts);
}

function render_slider_shortcode($atts) {

	// $content_type = Feature_Slider::FEATURE_SLIDER;
	$content_type = str_replace(' ', '_' ,strtolower($atts['content_type']));


	$args = array('post_type' => (string)$content_type,
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC'
);
ob_start();
?>
<div id="slider_container" class="custom_feature field_container">
	<?php

	$query = new WP_Query( $args );
	$count = 0;
	while($query->have_posts()) : $query->the_post();
	$id = get_the_ID();
	$count = $count + 1;
	$values 	    = get_post_meta($id);
	$text 		    = isset($values['slideshow_btn_text']) ? esc_attr($values['slideshow_btn_text'][0]) : '';
	$url		 	    = isset($values['slideshow_btn_url']) ? esc_attr($values['slideshow_btn_url'][0]) : "#";
	$pos   		 	  = isset($values['slideshow_position']) ? esc_attr($values['slideshow_position'][0]) : "";
	$blk_class	  = isset($values['slideshow_image_position']) ? esc_attr($values['slideshow_image_position'][0]) : "";
	$background = '';

	if (has_post_thumbnail($id)) {
		$img_url      = get_the_post_thumbnail_url($id,'full');
		$background   = 'background-image:url(\''.$img_url. '\');';
	}
	?>
	<div class="field_item field_item_<?php echo $count; ?> <?php echo $blk_class; ?>">

		<div class="field_body_wrapper" style="<?php echo $background; ?>">
			<div class="field_body_container">
				<div class="field_body <?php echo $pos ?>">

					<?php print the_content(); ?>
					<?php if(!empty($text)): ?>
						<div class="field_btn">
							<a class="btn-theme" href="<?php print $url; ?>"><?php print $text; ?></a>
						</div>
					<?php endif;?>

				</div>
			</div>
		</div>
	</div>
	<?php
endwhile;
$output = ob_get_clean();
return $output;
wp_reset_query() ?>
</div>
<?php
}
