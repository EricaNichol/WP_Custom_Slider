<?php
$category_args = array(
    'show_option_all'    => '',
    'orderby'            => 'name',
    'order'              => 'ASC',
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
<div id="basic_<?php echo $custom_id; ?>" class="<?php echo $content_type; ?> <?php echo $view_type; ?>_container custom_<?php echo $custom_id; ?>">
	<?php
  $count = 0;
foreach ( $categories as $category ):
	$cat_title = $category->name;
	$cat_name  = $category->taxonomy;
	$cat_id    = $category->term_id;
	?>
	<h4 id="term-<?php echo $cat_id ?>"class="cat_subheader lightgrey"><?php echo $cat_title; ?></h4>
<?php
// ** IMPORTANT must specify content_type
	$post_items = get_posts(
			array(
					'posts_per_page' 		=> -1,
					'post_type' 				=> $content_type,
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
			$post_title   = $post_item->post_title;
			$post_content = $post_item->post_content;


	?>
	<div class="field_item field_item_<?php echo $count; ?>">
		<h4 class="post_title"><?php echo $post_title; ?></h4>
		<div class="field_body_container">
			<?php echo $post_content ?>
		</div>
	</div>

	<?php
endforeach;
	endforeach;
	$output = ob_get_clean();
	?>
</div>
<?php
		return $output;
