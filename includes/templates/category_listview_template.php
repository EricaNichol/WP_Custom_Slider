<?php
$category_args = array(
    'show_option_all'    => '',
    'orderby'            => 'name',
    'order'              => 'DESC',
    'style'              => 'list',
    'show_count'         => 0,
    'hide_empty'         => 1,
    'use_desc_for_title' => 1,
    'child_of'           => 0,
    'feed'               => '',
    'feed_type'          => '',
    'feed_image'         => '',
    'exclude'            => '',
    'exclude_tree'       => '',
    'include'            => '',
    'hierarchical'       => 1,
    'title_li'           => '',
    'show_option_none'   => __( '' ),
    'number'             => null,
    'echo'               => 0,
    'depth'              => 0,
    'current_category'   => 0,
    'pad_counts'         => 0,
    'taxonomy'           => $content_type.'_categories',
    'walker'             => null
);

$categories = get_categories($category_args);

ob_start();
?>
<div id="category_listview_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?> <?php echo $view_type; ?>_container field_container custom_<?php echo $custom_id; ?> ">
	<?php
	$count = 0;
	foreach ( $categories as $category ):
		$cat_title = $category->name;
		$cat_name  = $category->taxonomy;
		$cat_id    = $category->term_id;
	?>
	<h4 id="term-<?php echo $cat_id ?>"class="cat_subheader lightgrey"><?php echo $cat_title; ?></h4>
	<?php
		$post_items = get_posts(
				array(
						'posts_per_page' 		=> -1,
						'post_type' 				=> $content_type,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
						'tax_query' 				=> array(
								array(
										'taxonomy' 	=> $cat_name,
										'field' 		=> 'term_id',
										'terms' 		=> $cat_id
								)
						)
				)
		);
		foreach ($post_items as $post_item):
			$count++;
			$post_id      = $post_item->ID;
			$post_title   = $post_item->post_title;
			$post_content = $post_item->post_content;
			$values 	   		  = get_post_meta($post_id);
			$text 		        = isset($values['publication_text']) ? esc_attr($values['publication_text'][0]) : '';
				$img_url = false;
				if (has_post_thumbnail($post_id)) {
					$img_url      = get_the_post_thumbnail_url($post_id, 'full');
				}
        //the content filter passes the value through sequence of functions
      $formatted =  apply_filters( 'the_content', $post_item->post_content );
	// print $img_url;
	?>
<a class="anchor_link" id="post-<?php echo $post_id; ?>"></a>
	<div class="field_item field_item_<?php echo $count; ?>">
		<div class="field_container">
			<?php if ($img_url ) : ?>
				<div class="field_image left">
					<img src="<?php echo $img_url; ?>">
				</div>
			<?php endif; ?>
			<div class="field_content right">
				<h5 class="p1"><?php echo $post_title; ?></h5>
				<?php if( $text ): ?>
					<div class="sub_header"><?php echo $text; ?></div>
				<?php endif; ?>
				<div><?php echo $formatted; ?></div>
			</div>
		</div>
	</div>

	<?php
endforeach;
	endforeach;
  ?>
</div>
<?php
	$output = ob_get_clean();
		return $output;
