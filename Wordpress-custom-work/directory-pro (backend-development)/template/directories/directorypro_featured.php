<?php
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('iv_directories-style-111', wp_iv_directories_URLPATH . 'admin/files/css/styles.css');
	global $post,$wpdb,$tag;
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$current_post_type=$directory_url;
	
	$feature_post_ids =array();
	if(isset($atts['post_ids'])){
		$feature_post_ids = explode(",", $atts['post_ids']);
	}
	
	$args = array(
	'post_type' => $current_post_type, 
	'post__in'=>$feature_post_ids,
	'post_status' => 'publish',
	'posts_per_page'=> '-1',  
	);
	if(isset($atts['category'] )){
		$postcats = get_query_var($current_post_type.'-'.$atts['category']);
		$args[$current_post_type.'-'.$atts['category']]=$postcats;
		$selected=$postcats;
	}
	$args['posts_per_page']='99999';
	if(isset($atts['post_limit'])){
		$args['posts_per_page']=sanitize_text_field($atts['post_limit']);			
	}
	if(!isset($atts['post_ids'])){
		$features = array(
		'relation' => 'AND',
		array(
		'key'     => 'dirpro_featured',
		'value'   => 'featured',
		'compare' => '='
		),
		);		
		$args['meta_query'] = array(
		$features,
		);
	}	
	$filter_query = new WP_Query( $args );
?>
<section id="destination" style="background: transparent;">
	<section class="bootstrap-wrapper" style="background: transparent !important;">
		<div class="container dynamic-bg">

			<div class="row">
				<?php
					if ( $filter_query->have_posts() ) : 
					while ( $filter_query->have_posts() ) : $filter_query->the_post();
					$id = get_the_ID();
					$feature_img='';
					if(has_post_thumbnail()){
						$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
						if($feature_image[0]!=""){
							$feature_img =$feature_image[0];
						}
						}else{
						$feature_img= $this->get_dirpro_listing_default_image();
					}
				?>
				<div class="col-12 col-md-6 col-lg-4 mb-5">
					<div class="img_overlay_container">
						<div class="img_overlay rounded mr-5"></div>
						<a href="<?php echo get_the_permalink( $id ); ?>">
							<img   src="<?php echo  esc_url($feature_img);?>" class="rounded cities_img w-100 img-fluid">
						</a>
						<h6 class="cities_title text-center text-white"><?php echo get_the_title($id);?></h6>
					</div>
				</div>
				<?php
					endwhile;	
					endif;
				?>
			</div>
		</div>
	</section>
</section>