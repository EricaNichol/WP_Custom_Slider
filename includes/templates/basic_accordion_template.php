<?php
$args = array('post_type' 		 => (string)$content_type,
'posts_per_page' => -1,
'orderby'        => 'menu_order',
'order'          => 'ASC'
);

ob_start();

?>
<div id="basic_accordion_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?>
  codingbydave_accordion_list codingbydave_<?php echo $view_type; ?>_container field_container custom_<?php echo $custom_id; ?> ">
	<?php

	$query 						= new WP_Query( $args );
	$count 						= 0;

	while($query->have_posts()) : $query->the_post();
  $id 							= get_the_ID();
  $item             = get_post($id);
  $count 						= $count + 1;
  $body             = $item->post_content;

    $img_url = false;
    if (has_post_thumbnail($post_id)) {
      $img_url      = get_the_post_thumbnail_url($id, 'full');
    }
    //the content filter passes the value through sequence of functions
  $formatted =  apply_filters( 'the_content', $item->post_content );

		// $img_url = false;
		// if (has_post_thumbnail($id)) {
		// 	$img_url      = get_the_post_thumbnail_url($id,'full');
		// }
	//
	// print "<pre>";
  // print_r(get_post($id));
	// print "</pre>";
	//
	// print $img_url;
	?>


  <a class="anchor_link" id="post-<?php echo $post_id; ?>"></a>
  	<div class="field_item field_item_<?php echo $count; ?>">
  		<div class="field_container accordion_wrapper">

  				<div class="field_header accordion_header">
  					<h5><?php the_title() ?></h5>
  				</div>

  				<div class="field_content accordion_content">

  					<?php if ($img_url ) : ?>
  						<div class="field_image">
  							<img src="<?php echo $img_url; ?>">
  						</div>
  					<?php endif; ?>

  					<?php echo $formatted; ?>

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
