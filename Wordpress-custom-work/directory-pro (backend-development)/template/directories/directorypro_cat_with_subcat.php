<?php
wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('dirpro_categories_tree', wp_iv_directories_URLPATH . 'admin/files/css/dirpro_categories.css');
wp_enqueue_script('iv-bootstrap-4-js', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min-4.js');
wp_enqueue_script('dirpro_categories_tree_ppjs', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
wp_enqueue_script('category_tree', wp_iv_directories_URLPATH . 'admin/files/js/category_tree.js', array('jquery'),"1.0", true);

global $post,$wpdb,$tag;
$directory_url=get_option('_iv_directory_url');
if($directory_url==""){$directory_url='directories';}
$post_limit='9999';
if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
$post_limit=$atts['post_limit'];
}

$postcats_arr=array();
if(isset($atts['slugs'])){
	$postcats = $atts['slugs'];
	$postcats_arr=explode(',',$postcats);
}
wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>


<section id="destination" style="background: transparent !important;">
<section class="bootstrap-wrapper" style="background: transparent !important;">
	<div class="dynamic-bg container">
		<div class="row mt-5" id="dirpro_categories_tree">
		<?php
			$taxonomy = $directory_url.'-category';
			$args = array(
				'orderby'           => 'name',
				'order'             => 'ASC',
				'hide_empty'        => true,
				'exclude'           => array(),
				'exclude_tree'      => array(),
				'include'           => array(),
				'number'            => $post_limit,
				'fields'            => 'all',
				'slug'              => $postcats_arr,			
				'hierarchical'      => true,
				'child_of'          => false,
				'childless'         => false,
				'show_count'        => '1',

			);
			$terms = get_terms($taxonomy,$args); // Get all terms of a taxonomy


			if ( $terms && !is_wp_error( $terms ) ) :
					$i=0;
					foreach ( $terms as $term_parent ) {

						if($term_parent->count>0 && $term_parent->parent==0){
							$cat_link= get_term_link($term_parent , $directory_url.'-category');
						?>
							<div class="mb-5 column">
								<div class="dirpro_categories">
									<div class="dirpro_categories_img">
									</div>
									<div class="dirpro_categories_title p-0 m-0">
										<!-- <i class="dirpro_parent_icon far fa-lightbulb"></i> -->
										<img src="<?php echo wp_iv_directories_URLPATH."/assets/images/cat.png";?>" alt="" class="dirpro_parent_icon">
										<a href="<?php echo esc_url($cat_link); ?>">
											<?php 
												echo esc_html($term_parent->name);
											?>
										</a>
									</div>
								<?php 
									$parent_term_id = $term_parent->term_id; // term id of parent term
									$taxonomies2 = array( 
										$directory_url.'-category',
									);
									$args2 = array(
										'parent'         => $parent_term_id,
										// 'child_of'      => $parent_term_id, 
									); 
									 $terms2 = get_terms($taxonomies2, $args2);
									foreach ($terms2 as $child) {
										$child_link= get_term_link($child , $directory_url.'-category');
									?>
										<a href="<?php echo esc_url($child_link); ?>" class="sub_cat">
											<span class="sub_name">
												<?php echo $child->name; ?>
											</span>
											<span class="sub_count">
												<?php echo $child->count; ?>
												
											</span>
										</a>
									<?php
									}
							?>
								</div>
							</div>
					<?php
					}
				}
			endif;
			?>
		</div>
	</div>
</section>
</section>