<?php
$args = array('post_type' 		 => (string)$content_type,
'posts_per_page' => -1,
'orderby'        => 'menu_order',
'order'          => 'ASC'
);

ob_start();
?>

<div id="slider_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?> <?php echo $view_type; ?>_container owl-carousel field_container custom_<?php echo $custom_id; ?>">
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
		wp_reset_query();
		?>
	</div>
<?php
$output = ob_get_clean();
	return $output;
