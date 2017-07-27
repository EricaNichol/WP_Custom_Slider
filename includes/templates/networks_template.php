<?php
$args = array('post_type' 		 => (string)$content_type,
'posts_per_page' => -1,
'orderby'        => 'menu_order',
'order'          => 'ASC'
);

ob_start();
?>
<div id="networks_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?>
	<?php echo $view_type; ?>_container codingbydave_image_title field_container custom_<?php echo $custom_id; ?> ">

	<?php

	$query 						= new WP_Query( $args );
	$count 						= 0;

	while($query->have_posts()) : $query->the_post();
		$id 							= get_the_ID();
		$item             = get_post($id);
		$count 						= $count + 1;
		$values 	   		  = get_post_meta($id);
		$url 		       		 = isset($values['network_text']) ? esc_attr($values['network_text'][0]) : '';
		$body             = $item->post_content;

		$img_url = false;
		if (has_post_thumbnail($id)) {
			$img_url      = get_the_post_thumbnail_url($id,'full');
		}

		$link = false;
		if ( strpos('http',$url)  ) {
			$link = $url;
		} else {
			$link = 'http://'.$url;
		}

	// print "<pre>";
  // print_r($link);
	// print "</pre>";
	
	// print $img_url;
	?>

	<div class="field_item field_item_<?php echo $count; ?>">
		<div class="field_container">


			<?php if ($img_url ) : ?>
				<?php if( $link ) : ?>
				<?php endif; ?>

				<div class="field_image">
					<img src="<?php echo $img_url; ?>">
				</div>

			<?php endif; ?>
			<div class="field_content">
				<a href="<?php echo $link; ?>" class="anchor_link">
						<?php the_title(); ?>
				</a>
				<!-- <div><?php// echo $body; ?></div> -->
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
