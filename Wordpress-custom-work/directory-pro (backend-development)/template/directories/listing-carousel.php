<?php
  wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
  wp_enqueue_style('epdirpro-style-111', wp_iv_directories_URLPATH . 'admin/files/css/styles.css');
	wp_enqueue_script('iv_property-ar-script-25', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('iv-bootstrap-4-js', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('iv_directories-ar-slick-2014', wp_iv_directories_URLPATH . 'admin/files/css/slick/slick.js');
	$dir_style_font=get_option('dir_style_font');
	if($dir_style_font==""){$dir_style_font='no';}
	if($dir_style_font=='yes'){
		wp_enqueue_style('epdirpro-font-110', wp_iv_directories_URLPATH . 'admin/files/css/quicksand-font.css');
	}
	// slick-------
	$dir_background_color=get_option('dir_background_color');
	if($dir_background_color==""){$dir_background_color='#EFEFEF';}
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$post_limit='10';
	if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
		$post_limit=sanitize_text_field($atts['post_limit']);
	}
	$dirs_data =array();
	$tag_arr= array();
	$paged =1;
	$args = array(
	'post_type' => $directory_url, // enter your custom post type
	'paged' => $paged,
	'post_status' => 'publish',	
	'orderby'	=> 'rand',
	'posts_per_page'=> $post_limit,  // overrides posts per page in theme settings
	);
	$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
	// Add new shortcode only category
	if(isset($atts['category']) and $atts['category']!="" ){
		$postcats = sanitize_text_field($atts['category']);
		$args[$directory_url.'-category']=$postcats;
	}
	// Meta Query***********************
	$city_mq ='';
	if(isset($atts['dir_city']) AND $atts['dir_city']!=''){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => sanitize_text_field($atts['dir_city']),
		'compare' => 'LIKE'
		),
		);
	}
	$zip_mq='';
	if(isset($atts['zipcode']) AND $atts['zipcode']!=''){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => sanitize_text_field($atts['zipcode']),
		'compare' => 'LIKE'
		),
		);
	}
	$args['meta_query'] = array(
	$city_mq, $zip_mq,
	);
	global $wpdb;
	$rand_div=rand(10,100);
	$properties = new WP_Query( $args );
		$dir_background_color='transparent';
		if(isset($atts['background_color']) and $atts['background_color']!="" ){
			$dir_background_color=$atts['background_color'];
		}
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('iv_directories-slick-195', wp_iv_directories_URLPATH . 'admin/files/css/slick/slick.css');
?>
<style>
	.main-container{
	background:<?php echo esc_html($dir_background_color);?>;
	}
</style>
<style>
	.next1,.previous1{
	background:<?php echo "#bdc3c7";?>;
	}
	.title{color:#949ca5 ;}
</style>
<!-- slick slider -->
<section class="property-carousel" style="background:<?php echo esc_html($dir_background_color);?> !important;">
  <div class="bootstrap-wrapper" style="background: transparent !important;">
    <div class="container main-container py-3" style="background: transparent !important;">
      <div class="slick-controls<?php echo esc_html($rand_div);?>">
				<p class="next1" id="next1<?php echo esc_html($rand_div);?>"><i class="fas fa-angle-right"></i></p>
				<p class="previous1" id="previous1<?php echo esc_html($rand_div);?>"><i class="fas fa-angle-left"></i></p>
			</div>
      <div class="row multiple-items mb-2" id="multiple-items<?php echo esc_html($rand_div);?>">
  			<?php
  				$i=0;
					if ( $properties->have_posts() ) :
					while ( $properties->have_posts() ) : $properties->the_post();
					$id = get_the_ID();
				?>
				<div class="col-md-12">
					<div class="card rounded">
						<a href="<?php echo get_the_permalink($id);?>">
							<?php	if(has_post_thumbnail($id)){
								$fsrc= wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
								if($fsrc[0]!=""){
									$fsrc =$fsrc[0];
								}
							?>
							<img src="<?php  echo esc_html($fsrc);?>" class="rounded-top card-img-top w-100" style="height:200px !important;">
							<?php
							}else{	
							$feature_img= $this->get_dirpro_listing_default_image();
							?>
							<img src="<?php echo esc_html($feature_img);?>" class="rounded-top w-100 card-img-top" style="height:200px !important;">
							<?php
							}
							?>
						</a>
						<div class="card-body card-body-min-height pt-1 pb-0 mt-2 text-justify">
							<a href="<?php echo get_the_permalink($id);?>"><p class="title m-0 text-center class="cbp-l-grid-team-name""><?php echo get_the_title($id); ?></p></a>
								<p class="address mt-1"><?php echo esc_html(get_post_meta($id,'address',true));?> <?php echo esc_html(get_post_meta($id,'city',true));?> <?php echo esc_html(get_post_meta($id,'zipcode',true));?> <?php echo esc_html(get_post_meta($id,'country',true));?></p>
							</div>
						</div>
					</div>
					<?php
						$i++;
						endwhile;
						endif;
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- slic slider js -->
	<?php
	wp_enqueue_script("jquery");
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#multiple-items<?php echo esc_html($rand_div);?>').slick({
				arrows: true,
				dots: false,
				infinite: true,
				slidesToShow: 3,
				slidesToScroll: 3,
				nextArrow: '#next1<?php echo esc_html($rand_div);?>',
				prevArrow: '#previous1<?php echo esc_html($rand_div);?>',
				responsive: [{
					breakpoint: 1024,
					settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: false
					}
					}, {
					breakpoint: 770,
					settings: {
            slidesToShow: 2,
            slidesToScroll: 2
					}
					}, {
					breakpoint: 480,
					settings: {
            slidesToShow: 1,
            slidesToScroll: 1
					}
				}]
			});
		});
	</script>	