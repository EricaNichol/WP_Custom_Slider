<?php
$args = array('post_type' 		 => (string)$content_type,
'posts_per_page' => -1,
'orderby'        => 'menu_order',
'order'          => 'ASC'
);

ob_start();
?>
<div id="announcements_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?> <?php echo $view_type; ?>_container field_container custom_<?php echo $custom_id; ?> ">
	<?php

	$query 						= new WP_Query( $args );
	$count 						= 0;

	while($query->have_posts()) : $query->the_post();
		$id 							= get_the_ID();
		$item             = get_post($id);
		$count 						= $count + 1;
		$values 	   		  = get_post_meta($id);
    $date             = $item->post_date;
    $day              = date('d',strtotime($date));
    $month            = date('M Y',strtotime($date));
		$body             = $item->post_content;

		// $img_url = false;
		// if (has_post_thumbnail($id)) {
		// 	$img_url      = get_the_post_thumbnail_url($id,'full');
		// }
	//


	// print $img_url;
	?>

  <div class="field_item field_item_<?php echo $count; ?>">
		<div class="field_container">
				<div class="field_time left">
          <span class="field_day"><?php echo $day; ?></span>
          <span class="field_month"><?php echo $month; ?></span>
				</div>
			<div class="field_content right">
				<h4><?php the_title() ?></h4>
				<div><?php echo $body; ?></div>
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
