<?php
$args = array('post_type' 		 => (string)$content_type,
'posts_per_page' => -1,
'orderby'        => 'menu_order',
'order'          => 'ASC'
);

ob_start();
?>
<div id="basic_download_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?> <?php echo $view_type; ?>_container resources_field_container custom_<?php echo $custom_id; ?>">
	<?php

	$query 						= new WP_Query( $args );
	$count 						= 0;

	while($query->have_posts()) : $query->the_post();
		$id 							= get_the_ID();
		$item             = get_post($id);
		$count 						= $count + 1;
		$values 	   		  = get_post_meta($id);
		$youtube 	        = isset($values['url_text']) ? esc_attr($values['url_text'][0]) : '';

    $file_item        = get_post_meta($id, 'resources_file', true);
    $download_url     = !empty($file_item['url']) ? $file_item['url'] : '';

	?>

  <div class="field_item field_item_<?php echo $count; ?>">

		<h4 class="post_title"><?php echo the_title(); ?></h4>

		<?php if ( !empty($download_url) ) : ?>
			<div class="field_btn_container">
	      <a href='<?php echo $download_url; ?>' target="_blank">Download</a>
	    </div>
		<?php endif ; ?>

      <?php if ( !empty($youtube) ) : ?>
        <div class="youtube_container">
          <iframe src="https://www.youtube.com/embed/<?php echo $youtube; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
      <?php endif ; ?>

      <?php echo the_content(); ?>

	</div>

	<?php
		endwhile;
		wp_reset_query();
		?>
	</div>
<?php
$output = ob_get_clean();
	return $output;
