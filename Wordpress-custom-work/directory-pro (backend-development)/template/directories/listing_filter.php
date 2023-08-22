<?php
wp_enqueue_script("jquery");
wp_enqueue_style('iv_directories-style-64', wp_iv_directories_URLPATH . 'assets/cube/css/cubeportfolio.css');
wp_enqueue_style('iv_directories-style-11222', wp_iv_directories_URLPATH . 'admin/files/css/listing_style_4.css');
wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111', wp_iv_directories_URLPATH . 'admin/files/css/styles.css');

$dir_style_font=get_option('dir_style_font');
if($dir_style_font==""){$dir_style_font='no';}
if($dir_style_font=='yes'){
	wp_enqueue_style('epdirpro-font-110', wp_iv_directories_URLPATH . 'admin/files/css/quicksand-font.css');

}

$directory_url=get_option('_iv_directory_url');
if($directory_url==""){$directory_url='directories';}
$current_post_type=$directory_url;

$post_limit='9999';
if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
 $post_limit=sanitize_text_field($atts['post_limit']);
}


	$args = array(
			'post_type' => $current_post_type, // enter your custom post type
			'post_status' => 'publish',			
			'posts_per_page'=> $post_limit,  // overrides posts per page in theme settings
			'orderby' => 'title',
			'order' => 'ASC',
			);
	if(isset($atts['category'] )){
		$postcats = get_query_var($current_post_type.'-'.$atts['category']);
		$args[$current_post_type.'-category']=esc_html($atts['category']);
		$selected=$postcats;
		$args['posts_per_page']='9999';
	}

	// Meta Query***********************
	$city_mq ='';
	if(isset($atts['city']) AND $atts['city']!=''){
			$city_mq = array(
			'relation' => 'AND',
				array(
					'key'     => 'city',
					'value'   => sanitize_text_field($atts['city']),
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
	$filter_query = new WP_Query( $args );

		$div_id=rand(1, 500);
?>


	<section class="bootstrap-wrapper" style="background: transparent !important;">
		<div class="container ">
			<div class="row">
				<div class="col-md-12 mb-5">
<?php
		if ( $filter_query->have_posts() ) : ?>

			<div id="js-grid-meet-the-<?php echo esc_html($div_id);?>" class="cbp cbp-l-grid-team" >

				<?php
				while ( $filter_query->have_posts() ) : $filter_query->the_post();
				$id = get_the_ID();
				$feature_img='';
				if(has_post_thumbnail()){
					$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'medium' );
					if($feature_image[0]!=""){
						$feature_img =$feature_image[0];
					}
				}else{
					$feature_img= $this->get_dirpro_listing_default_image();

				}
				$currentCategory=wp_get_object_terms( $id, $current_post_type.'-category');
				$cat_name = (isset($currentCategory[0]->name)?$currentCategory[0]->name:'' );

				?>

					<div class="cbp-item">
							<a href="<?php echo get_permalink($id); ?>" class="cbp-caption ">
								<div class="cbp-caption-defaultWrap">
									<div class="image-container" style="background: url('<?php echo esc_attr($feature_img);?>') center center no-repeat; background-size: cover;">
									</div>

								</div>
								<div class="cbp-caption-activeWrap for-hospital">
									<div class="cbp-l-caption-alignCenter">
										<div class="cbp-l-caption-body">
											<div class="cbp-l-caption-text"><?php esc_html_e('VIEW DETAIL', 'ivdirectories' ); ?></div>
										</div>
									</div>
								</div>
							</a>
						<a href="<?php echo get_permalink($id); ?>" class="cbp-l-grid-team-name" >
						 <?php echo substr(get_the_title($id),0,28); ?>

						</a>	<div class="cbp-l-grid-team-position"><?php echo '&nbsp;'; ?></div>
					</div>

	<?php
				endwhile;
				?>
				</div>
	<?php
		endif;
		
		
	?>				</div>
			</div>
		</div>
	</section>

	<script>
	function loadBackupScript(callback) {
			var script;
			script = document.createElement('script');
			script.onload = callback;
			script.src = '<?php echo wp_iv_directories_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js';?>';
			document.head.appendChild(script);
		}

		loadBackupScript(function() {

			setTimeout(function(){
					(function($, window, document, undefined) {
				'use strict';

				// init cubeportfolio
				jQuery('#js-grid-meet-the-<?php echo esc_html($div_id);?>').cubeportfolio({
					defaultFilter: '*',
					filters: '#js-filters-meet-the-<?php echo esc_html($div_id);?>',
					layoutMode: 'grid',
					animationType: 'sequentially',
					gapHorizontal: 50,
					gapVertical: 40,
					gridAdjustment: 'responsive',
					mediaQueries: [{
						width: 1500,
						cols: 5
					}, {
						width: 1100,
						cols: 3
					}, {
						width: 800,
						cols: 3
					}, {
						width: 480,
						cols: 2
					}, {
						width: 320,
						cols: 1
					}],
					caption: 'fadeIn',
					displayType: 'lazyLoading',
					displayTypeSpeed: 100,

					// singlePage popup
					singlePageDelegate: '.cbp-singlePage',
					singlePageDeeplinking: true,
					singlePageStickyNavigation: true,
					singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
					singlePageCallback: function(url, element) {
						// to update singlePage content use the following method: this.updateSinglePage(yourContent)
						var t = this;

						$.ajax({
								url: url,
								type: 'GET',
								dataType: 'html',
								timeout: 10000
							})
							.done(function(result) {
								t.updateSinglePage(result);
							})
							.fail(function() {
								t.updateSinglePage('AJAX Error! Please refresh the page!');
							});
					},
				});
			})(jQuery, window, document);

				},1000);

 });

	</script>

