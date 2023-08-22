<?php
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('epdirpro-style-111', wp_iv_directories_URLPATH . 'admin/files/css/styles-6.css');
	wp_enqueue_style('epdirpro-style-64', wp_iv_directories_URLPATH . 'assets/cube/css/cubeportfolio.css');
	wp_enqueue_style('colorbox', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	$dir_style_font=get_option('dir_style_font');
	if($dir_style_font==""){$dir_style_font='no';}
	if($dir_style_font=='yes'){
		wp_enqueue_style('epdirpro-font-110', wp_iv_directories_URLPATH . 'admin/files/css/quicksand-font.css');
	}
	global $post,$wpdb,$tag;
	$search_show=0;
	$search_button_show='no';
	$dir_searchbar_show=get_option('_dir_searchbar_show');
	if($dir_searchbar_show=="yes"){$search_show=1;}
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$current_post_type=$directory_url;
	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($_REQUEST['dirsearchtype']) AND $_REQUEST['dirsearchtype']!=''){  	
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
		$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);		
		}elseif(isset($_REQUEST['dirsearch']) AND $_REQUEST['dirsearch']!=''){
		$dirsearchtype='Title';  
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
	}
	if(isset($_REQUEST['locationtype']) AND $_REQUEST['locationtype']!=""){ 
		$locationtype=sanitize_text_field($_REQUEST['locationtype']);
		$location=sanitize_text_field($_REQUEST['location']);
		}elseif(isset($_REQUEST['location']) AND $_REQUEST['location']!=''){
		$locationtype='City'; 
		$location=sanitize_text_field($_REQUEST['location']);
	}
	$form_action='';
	if ( is_front_page() ) {
		$form_action='action='.get_post_type_archive_link($current_post_type).'';
	}
	$search_button_show=get_option('_search_button_show');
	if($search_button_show==""){$search_button_show='yes';}
	$dir_style5_perpage=get_option('dir_style5_perpage');
	if($dir_style5_perpage==""){$dir_style5_perpage=20;}
	$dirs_data =array();
	$tag_arr= array();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
	'post_type' => $directory_url, // enter your custom post type
	'paged' => $paged,
	'post_status' => 'publish',
	'posts_per_page'=> $dir_style5_perpage,  // overrides posts per page in theme settings
	);
	$dir_listing_sort=get_option('_dir_listing_sort');
	if($dir_listing_sort==""){$dir_listing_sort='date';}
	if($dir_listing_sort=='ASC'){
		$args['orderby']='title';
		$args['order']='ASC';
	}
	if($dir_listing_sort=='DESC'){
		$args['orderby']='title';
		$args['order']='DESC';
	}
	// Date
	if($dir_listing_sort=='date'){
		$args['orderby']='date';
		$args['order']='DESC';
	}
	if($dir_listing_sort=='old-date'){
		$args['orderby']='date';
		$args['order']='ASC';
	}
	if($dir_listing_sort=='rand'){
		$args['orderby']='rand';
		$args['order']='ASC';
	}
	$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
	// Add new shortcode only category
	if(isset($atts['category']) and $atts['category']!="" ){
		$postcats = $atts['category'];
		$args[$directory_url.'-category']=$postcats;
		$args['posts_per_page']='9999';
	}
	if(get_query_var($directory_url.'-category')!=''){
		$postcats = get_query_var($directory_url.'-category');
		$args[$directory_url.'-category']=$postcats;
		$selected=$postcats;
		$search_show=1;
	}
	if( isset($_POST[$directory_url.'-category'])){
		if($_POST[$directory_url.'-category']!=''){
			$postcats = sanitize_text_field($_POST[$directory_url.'-category']);
			$args[$directory_url.'-category']=$postcats;
			$selected=$postcats;
			$search_show=1;
		}
	}
	if(get_query_var($directory_url.'_tag')!=''){
		$postcats = get_query_var($directory_url.'_tag');
		$args[$directory_url.'_tag']=$postcats;
		$search_show=1;
	}
	$dir_facet_title=get_option('dir_facet_cat_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args[$directory_url.'-category']=$dirsearch;
	}
	$dir_facet_title=get_option('dir_facet_features_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args[$directory_url.'_tag']=$dirsearch;
	}
	$dir_facet_title= esc_html__('Title','ivdirectories');
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args['s']= $dirsearch;
	}
	if($dirsearchtype=="" AND $dirsearch!=''){
		$args['s']= $dirsearch;
	}
	$dir_facet_title=get_option('dir_facet_location_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivdirectories');}
	$city_mq ='';
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$area_mq='';
	$dir_facet_title=get_option('dir_facet_area_title');
	if($dir_facet_title==""){$dir_facet_title=esc_html__('Area','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$area_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'area',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq='';
	$zip_mq='';
	$dir_facet_title=get_option('dir_facet_zipcode_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	// Meta Query***********************
	$city_mq2 ='';
	if(isset($_REQUEST['dir_city']) AND $_REQUEST['dir_city']!=''){
		$city_mq2 = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => sanitize_text_field($_REQUEST['dir_city']),
		'compare' => 'LIKE'
		),
		);
	}
	// For featrue listing***********
	$feature_listing_all =array();
	$feature_listing_all =$args;
	$args['meta_query'] = array(
	$city_mq, $country_mq, $zip_mq,$area_mq,$city_mq2,
	);
	if(isset($atts['category']) and $atts['category']!="" ){
		$args['posts_per_page']='999';
		}else{
		$args['posts_per_page']=$dir_style5_perpage;
	}
	$the_query = new WP_Query( $args );
	$main_class = new wp_iv_directories;
	$dir_background_color=get_option('dir5_background_color');
	if($dir_background_color==""){$dir_background_color='#EBEBEB';}
	if(isset($atts['main_background_color'])){
		$dir_background_color=$atts['main_background_color'];
		if($dir_background_color==""){$dir_background_color='#EBEBEB';}
	}
	$active_filter='';
?>
<style>
	.fa{
    font: normal normal normal 14px/1 FontAwesome !important;
	}
	.archieve-page{
	background:<?php echo esc_html($dir_background_color);?>;
	}
</style>
<?php
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
	$full_width=100;
	$dir_style_4top_filter=get_option('dir_style_4top_filter');
	if($dir_style_4top_filter==""){$dir_style_4top_filter='yes';}
	if($dir_style_4top_filter=='yes'){$full_width=$full_width - 50;}
	if($dir_searchbar_show=="yes"){$full_width=$full_width -50;}
?>
<!-- wrap everything for our isolated bootstrap -->
<div class="bootstrap-wrapper">
	<!-- archieve page own design font and others -->
	<section class="archieve-page py-5">
		<div class="container archieve-page px-0"  >
			<div class="row">
				<?php if($full_width!=100 ){ ?>
					<div class="col-md-3">
						<!-- Search Form -->
						<?php
							if($search_show==1){
								include(wp_iv_directories_template.'directories/archive-top-search.php');
							}
						?>
						<!-- end of search form -->
						<!-- sction for sort by catagory -->
						<!-- ##################################################################### -->
						<?php
							if($dir_style_4top_filter=='yes'){
							?>
							<div class="filterSearch"><?php esc_html_e( 'Filter', 'ivdirectories' ); ?><i class="fas fa-align-center"></i></div>
							<div class="container archieve-page">
								<div class="clearfix">
									<div id="js-sort-juicy-projects" class="cbp-l-sort cbp-l-filters-right">
										<div class="cbp-l-dropdown">
											<div class="cbp-l-dropdown-wrap">
												<div class="cbp-l-dropdown-header"><?php esc_html_e( 'Date', 'ivdirectories' ); ?></div>
												<div class="cbp-l-dropdown-list">
													<div class="cbp-l-dropdown-item cbp-sort-item cbp-l-dropdown-item--active" data-sort=".cbp-l-grid-projects-date" data-sortBy="int:desc"   ><?php esc_html_e( 'Date', 'ivdirectories' ); ?></div>
													<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-title" data-sortBy="string:asc" ><?php esc_html_e( 'Title', 'ivdirectories' ); ?></div>
													<?php
														$dir_single_review_show=get_option('dir5_review_show');
														if($dir_single_review_show==""){$dir_single_review_show='yes';}
														if($dir_single_review_show=='yes'){
														?>
														<div class="cbp-l-dropdown-item cbp-sort-item" data-sort=".cbp-l-grid-projects-review" data-sortBy="string:desc"><?php esc_html_e( 'Review', 'ivdirectories' ); ?></div>
														<?php
														}
													?>
												</div>
											</div>
										</div>
										<div class="cbp-l-direction cbp-l-direction--second">
											<div class="cbp-l-direction-item cbp-sort-item" data-sortBy="string:asc"></div>
											<div class="cbp-l-direction-item cbp-sort-item" data-sortBy="string:desc"></div>
										</div>
									</div>
									<div id="js-filters-meet-the-team" class="cbp-l-filters-button cbp-l-filters-alignLeft" >
										<?php
											$active_filter=get_option('active_filter');
											if($active_filter==""){$active_filter='category';}
											if($active_filter=="category"){
												if($postcats==''){	?>
												<div data-filter="*" class="cbp-filter-item">
													<?php esc_html_e('Show All', 'ivdirectories' ); ?>
												</div>
												<?php
													$argscat = array(
													'type'                     => $directory_url,
													'orderby'                  => 'name',
													'order'                    => 'ASC',
													'hide_empty'               => true,
													'hierarchical'             => 1,
													'exclude'                  => '',
													'include'                  => '',
													'number'                   => '',
													'taxonomy'                 => $directory_url.'-category',
													'pad_counts'               => false
													);
													$categories = get_categories( $argscat );
													if ( $categories && !is_wp_error( $categories ) ) :
													foreach ( $categories as $term ) {
														echo '<div data-filter=".'.$term->slug.'" class="cbp-filter-item"> '.$term->name.' <div class="cbp-filter-counter"></div></div>';
													}
													endif;
												?>
												<?php
												}
												if($postcats!=''){ ?>
												<div data-filter="" class="cbp-filter-item"><a href="<?php echo get_post_type_archive_link( $directory_url) ; ?>">
													<?php esc_html_e('Show All', 'ivdirectories' ); ?>
												</a> </div>
												<?php
													$term = get_term_by('slug', $postcats, $directory_url.'-category');
													$name = (isset($term->name)? $term->name: $postcats);
													echo '<div data-filter=".'.$postcats.'"  class="cbp-filter-item-active cbp-filter-item"> '.$name.' <div class="cbp-filter-counter"></div></div>';
												}
											}
											if($active_filter=="tag"){
											?>
											<div data-filter="*" class="cbp-filter-item">
												<?php esc_html_e('Show All', 'ivdirectories' ); ?>
											</div>
											<?php
												$args2 = array(
												'type'                     => $directory_url,
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'hide_empty'               => true,
												'hierarchical'             => 1,
												'exclude'                  => '',
												'include'                  => '',
												'number'                   => '',
												'taxonomy'                 => $directory_url.'_tag',
												'pad_counts'               => false
												);
												$main_tag = get_categories( $args2 );
												if ( $main_tag && !is_wp_error( $main_tag ) ) :
												foreach ( $main_tag as $term_m ) {
													$checked='';
													echo '<div data-filter=".'.$term_m->slug.'" class="cbp-filter-item"> '.$term_m->name.' <div class="cbp-filter-counter"></div></div>';
												}
												endif;
											}
										?>
									</div>
								</div>
							</div>
							<!-- Item Filter Section -->
							<?php
							}
						?>
						<!-- ######################################################################### -->
					</div>
					<?php
					}
				?>
				<div class="<?php echo($full_width==100?'col-md-12':'col-md-9' ); ?>">
					<div class="direc-item">
						<div id="js-grid-meet-the-team" class="cbp cbp-l-grid-team" >
							<?php
								$dir_single_review_show=get_option('dir5_review_show');
								if($dir_single_review_show==""){$dir_single_review_show='no';}
								$dir_top_img=get_option('dir_top_img');
								if($dir_top_img==""){$dir_top_img='yes';}
								$dir_style5_call=get_option('dir_style5_call');
								if($dir_style5_call==""){$dir_style5_call='yes';}
								$dir_style5_email=get_option('dir_style5_email');
								if($dir_style5_email==""){$dir_style5_email='yes';}
								$dir_style5_sms=get_option('dir_style5_sms');
								if($dir_style5_sms==""){$dir_style5_sms='yes';}
								
								include( wp_iv_directories_template. 'directories/archive_feature_listing4.php');
								$i=1;
								$dir_popup=get_option('_dir_popup');
								if($dir_popup==""){$dir_popup='yes';}
								if ( $the_query->have_posts() ) :
								while ( $the_query->have_posts() ) : $the_query->the_post();
								$id = get_the_ID();
								if(get_post_meta($id, 'dirpro_featured', true)!='featured'){
									$feature_img='';
									if(has_post_thumbnail()){
										$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
										if($feature_image[0]!=""){
											$feature_img =$feature_image[0];
										}
										}else{
										$feature_img= $this->get_dirpro_listing_default_image();
									}
									if($active_filter=="tag"){
										$currentCategory = $main_class->eplisting_get_tag_caching($id,$directory_url);
										}else{
										$currentCategory = $main_class->eplisting_get_categories_caching($id,$directory_url);
									}
									$cat_link='';$cat_name='';$cat_slug='';
									$cat_name2='';
									if(isset($currentCategory[0]->slug)){
										$cat_name2 = $currentCategory[0]->name;
										$cc=0;
										foreach($currentCategory as $c){
											if($cc==0){
												$cat_name2 =$c->name;
												$cat_slug =$c->slug;
												}else{
												$cat_slug = $cat_slug .' '.$c->slug;
												$cat_name2 = $cat_name2 .', '.$c->name;
											}
											$cc++;
										}
									}
									// VIP
									$post_author_id= $the_query->post->post_author;
									$author_package_id=get_user_meta($post_author_id, 'iv_directories_package_id', true);
									$have_vip_badge= get_post_meta($author_package_id,'iv_directories_package_vip_badge',true);
									$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_directories_exprie_date', true));
									$current_date=time();
									$vip_image='';
									if($have_vip_badge=='yes'){
										if($exprie_date >= $current_date){
											if(get_option('vip_image_attachment_id')!=""){
												$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'));
												if(isset($vip_img[0])){
													$vip_image=$vip_img[0];
												}
												}else{
												$vip_image=wp_iv_directories_URLPATH."/assets/images/vipicon.png";
											}
										}
									}
								?>
								<div class="cbp-item  <?php echo esc_attr($cat_slug); ?>" >
									<div class="card card-border-round bg-white">
										<?php
											
											if($dir_top_img =='yes'){
											?>
											<div class="card-img-container">
												<a href="<?php echo get_the_permalink($id);?>"><img src="<?php echo esc_html($feature_img);?>" class="card-img-top"></a>
											</div>
											<?php
											}
										?>
										<?php
											if($have_vip_badge=='yes'){ ?>
											<div class="card-img-overlay card-img-overlay__img text-white">
												<img style="width:35px"   src="<?php echo esc_html($vip_image);?>">
											</div>
											<?php
											}
										?>
										<?php
											if($dir_top_img =='yes'){
												if(get_post_meta($id,'dirpro_featured',true)=="featured"){ ?>
												<div class="overlay_content1">
													<p><?php esc_html_e('Featured', 'ivdirectories' ); ?></p>
												</div>
												<?php
												}
											}	
										?>
										<div class="card-body mt-0 card-body-min-height">
											<p class="title mt-3 p-0">
												<a href="<?php echo get_permalink($id); ?>" class="m-0 p-0 cbp-l-grid-projects-title">
													<?php echo esc_html($post->post_title);?>
												</a>
											</p>
											<p class="card-text p-0 mt-2 address">
												<i class="fas fa-map-marker-alt"></i> <?php echo esc_html(get_post_meta($id,'address',true));?> <?php echo esc_html(get_post_meta($id,'city',true));?> <?php echo get_post_meta($id,'zipcode',true);?> <?php echo esc_html(get_post_meta($id,'country',true));?>
											</p>
											<p class="mt-2 categories">
												<i class="fas fa-bookmark"></i> <?php echo esc_html(ucfirst($cat_name2)).' '; ?>
											</p>
											<p class="d-flex mt-1">
												<span class="review">
													<?php
														if($dir_single_review_show=='yes'){
															$total_reviews_point = $wpdb->get_col( $wpdb->prepare( "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
															INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
															WHERE pm.meta_key = 'review_value'
															AND p.post_status = 'publish'
															AND p.post_type = 'dirpro_review' AND p.post_author = %s", $id ));
															$argsreviw = array( 'post_type' => 'dirpro_review','author'=>$id,'post_status'=>'publish' );
															$ratings = new WP_Query( $argsreviw );
															$total_review_post = $ratings->post_count;
															$avg_review=0;
															if(isset($total_reviews_point[0])){
																$avg_review= (float)$total_reviews_point[0]/(float)$total_review_post;
															}
														?>
														<?php
														if($avg_review >=.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
														<?php
														if($avg_review >=1.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=1.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
														<?php
														if($avg_review >=2.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=2.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
														<?php
															if($avg_review >=3.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=3.1){ ?>
														<i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
														<?php
														if($avg_review >=4.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=4.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
														<div class="cbp-l-grid-projects-review" style="display:none"><?php  echo esc_html($avg_review); ?></div>
														<?php
														}
													?>
												</span>
											</p>
											<?php
												$phone='';
												$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
												if($listing_contact_source==''){$listing_contact_source='new_value';}
												if($listing_contact_source=='new_value'){
													$phone=	get_post_meta($id,'phone',true);
													}else{
													$post_author_id= $the_query->post->post_author;
													$agent_info = get_userdata($post_author_id);
													if(get_user_meta($post_author_id,'phone',true)!=""){
														$phone=	get_user_meta($post_author_id,'phone',true);
													}
												}
												
												$dirpro_call_button=get_post_meta($id,'dirpro_call_button',true);
												if($dirpro_call_button==""){$dirpro_call_button='yes';}
												if($dir_style5_call=="yes" AND $dirpro_call_button=='yes'){
													$call_button='yes';
													if($phone==''){$call_button='no';}
													}else{
													$call_button='no';
												}
												
												$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
												if($dirpro_email_button==""){$dirpro_email_button='yes';}
												if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
													$email_button='yes';
													}else{
													$email_button='no';
												}
												
												$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
												if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
												if($dir_style5_sms=="yes" AND $dirpro_sms_button=='yes'){
													$sms_button='yes';
													if($phone==''){$sms_button='no';}
													}else{
													$sms_button='no';
												}
												$smsbody =esc_html__('I would like to inquire about the listing. The listing can be found on the site :','ivdirectories').site_url();
											?>
											<p class="client-contact">
												<?php
													if($call_button=='yes'){?>
													<span class="number" id="<?php echo esc_html($id);?>"><i class="fas fa-phone-volume"></i> <?php echo esc_html($phone);?></span>
													<span class="mcall"><a href="tel:<?php echo esc_html($phone);?>"><?php esc_html_e( 'Call', 'ivdirectories' ); ?></a></span>
													<?php
													}
												?>
												<?php
													if($email_button=='yes'){ ?>
													<span class="email"  onclick="call_popup('<?php echo esc_html($id);?>')"><?php esc_html_e( 'Email', 'ivdirectories' ); ?></span>
													<?php
													}
												?>
												<?php
													if($sms_button=='yes'){
													?>
													<span class="sms"><a href="sms:<?php echo esc_html($phone);?>?&body=<?php echo esc_html($smsbody);?>"><?php esc_html_e( 'SMS', 'ivdirectories' ); ?></a></span>
													<?php
													}
												?>
											</p>
											<p class="clientContactDetails d-flex justify-content-between justify-content-md-start">
											</p>
										</div>
									</div>
									<div class="cbp-l-grid-projects-date" style="display:none"><?php echo esc_html(strtotime($post->post_date));?></div>
								</div>
								<?php
									$i++;
								}
								endwhile;
							?>
							<?php else :
							$dirs_json=''; ?>
							<?php esc_html_e( 'Sorry, no posts matched your criteria.','ivdirectories' ); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			$total_count=0;
			$dir_style5_perpage=get_option('dir_style5_perpage');
			if($dir_style5_perpage==""){$dir_style5_perpage=20;}
			if(isset($the_query->found_posts)){
				$total_count=$the_query->found_posts;
			}
			if($total_count>$dir_style5_perpage){
			?>
			<div class="container my-5 archieve-page">
				<div class="row">
					<div class="col d-flex flex-column justify-content-center align-items-center"  id="loadmore_button" >
						<div id="dirpro_loadmore" style="display:none;"><img src="<?php echo wp_iv_directories_URLPATH.'admin/files/images/loader.gif';?>"></div>
						<button id="load-more" class="px-5 rounded" type="button" name="button" onclick="wpdirp_loadmore();" ><?php esc_html_e('Load More','ivdirectories'); ?></button>
					</div>
				</div>
			</div>
			<?php
			}
		?>
	</section>
	<!-- end of arhiece page -->
</div>
<!-- end of bootstrap wrapper -->
<?php
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
?>
<?php
	$grid_col1500=get_option('grid_col1500');
	if($grid_col1500==""){$grid_col1500='5';}
	$grid_col1100=get_option('grid_col1100');
	if($grid_col1100==""){$grid_col1100='3';}
	$grid_col768=get_option('grid_col768');
	if($grid_col768==""){$grid_col768='3';}
	$grid_col480=get_option('grid_col480');
	if($grid_col480==""){$grid_col480='2';}
	$grid_col375=get_option('grid_col375');
	if($grid_col375==""){$grid_col375='1';}
	wp_enqueue_script('epdirpro-ar-script-23', wp_iv_directories_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js');
	wp_enqueue_script('iv-bootstrap-4-js', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('epdirpro-ar-script-25', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('epdirpro-ar-script-26', wp_iv_directories_URLPATH . 'assets/cube/js/meet-team.js');
	wp_localize_script('epdirpro-ar-script-26', 'dirpro_data26', array(
	'grid_col1500'=>$grid_col1500,
	'grid_col1100'=>$grid_col1100,
	'grid_col768'=>$grid_col768,
	'grid_col480'=>$grid_col480,
	'grid_col375'=>$grid_col375,
	) );
	wp_enqueue_script('epdirpro-ar-script-27', wp_iv_directories_URLPATH . 'admin/files/js/archive-listing.js');
	wp_localize_script('epdirpro-ar-script-27', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'dirwpnonce'=> wp_create_nonce("listing"),
	'message'=>esc_html__('Please put your email','ivdirectories'),
	'wp_iv_directories_URLPATH'=> wp_iv_directories_URLPATH,
	) );
?>
<script type="text/javascript">
	var expandFilter = document.querySelector(".filterSearch");
	var expandClearfix = document.querySelector(".clearfix");
	var isOpen = false;
	function expandDiv(){
		if(!isOpen){
			expandClearfix.style.display = "block";
			isOpen=true;
		}
		else{
			expandClearfix.style.display = "none";
			isOpen=false;
		}
	}
	expandFilter.addEventListener('click', expandDiv);
</script>