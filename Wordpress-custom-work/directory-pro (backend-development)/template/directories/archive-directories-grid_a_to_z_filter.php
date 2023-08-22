<?php
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('epdirpro-style-111', wp_iv_directories_URLPATH . 'admin/files/css/listing_style_alphabet_sort.css');	
	wp_enqueue_style('colorbox', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_style('alphabet-listing', wp_iv_directories_URLPATH . 'assets/alphabet-sorting/css/listnav.css');
	wp_enqueue_script('alphabet-sorting-js', wp_iv_directories_URLPATH . 'assets/alphabet-sorting/js/jquery-listnav.js',array('jquery'),1.0,true);
	$main_class = new wp_iv_directories;
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
	}
	elseif(isset($_REQUEST['dirsearch']) AND $_REQUEST['dirsearch']!=''){
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
	$dir_style5_perpage=99999;
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
	
</style>
<?php
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
	$full_width=100;
?>
<!-- wrap everything for our isolated bootstrap -->
<div class="bootstrap-wrapper">
	<!-- archieve page own design font and others -->
	<section class="archieve-page py-5">
		<div class="container archieve-page"  >
			<!-- Search Form -->
			<?php
				$search_show=0;
				$dir_top_img=get_option('dir_top_img');
				if($dir_top_img==""){$dir_top_img='yes';}
				$dir_popup=get_option('_dir_popup');
				if($dir_popup==""){$dir_popup='yes';}
				$dir5_review_show=get_option('dir5_review_show');
				if($dir5_review_show==""){$dir5_review_show='no';}
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}
				$dir_style5_call=get_option('dir_style5_call');
				if($dir_style5_call==""){$dir_style5_call='yes';}
				$dir_style5_sms=get_option('dir_style5_sms');
				if($dir_style5_sms==""){$dir_style5_sms='yes';}
				$dir_style5_email=get_option('dir_style5_email');	
				if($dir_style5_email==""){$dir_style5_email='yes';} 
				$dir_searchbar_show=get_option('_dir_searchbar_show');
				$dir_single_review_show=get_option('dir5_review_show');
				if($dir_single_review_show==""){$dir_single_review_show='no';}
				if($dir_searchbar_show=="yes"){$search_show=1;}
				if($search_show==1){
					include(wp_iv_directories_template.'directories/archive-top-search-a-z.php');
				}
			?>
			<!-- end of search form -->
			<div class="row" id="dirpro_directories">
				<?php
					include( wp_iv_directories_template. 'directories/archive_feature_listing_a_to_z.php');
					$i=1;
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
						
						$cat_link='';$cat_name='';$cat_slug='';
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
					<div class="mt-4 column" id="column">
						<div class="card card-border-round bg-white">
							<div class="card-img-container <?php if($dir_top_img == 'no'){echo "d-none";} ?>">
								<a href="<?php echo get_the_permalink($id);?>"><img src="<?php echo esc_html($feature_img);?>" class="card-img-top"></a>
							</div>
							<?php
								if($have_vip_badge=='yes'){ ?>
								<div class="card-img-overlay card-img-overlay__img text-white">
									<img style="width:35px"   src="<?php echo esc_html($vip_image);?>">
								</div>
								<?php
								}
							?>
							<?php
								if(get_post_meta($id,'dirpro_featured',true)=="featured"){ ?>
								<div class="overlay_content1">
									<p><?php esc_html_e('Featured', 'ivdirectories' ); ?></p>
								</div>
								<?php
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
	</section>
	<!-- end of arhiece page -->
</div>
<!-- end of bootstrap wrapper -->
<?php
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
?>
<?php
	wp_enqueue_script('epdirpro-ar-script-25', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('epdirpro-ar-script-27', wp_iv_directories_URLPATH . 'admin/files/js/archive-listing.js');
	wp_enqueue_script('shortcode-data-display', wp_iv_directories_URLPATH . 'admin/files/js/shortcode-col.js');
	wp_localize_script('epdirpro-ar-script-27', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'dirwpnonce'=> wp_create_nonce("listing"),
	'message'=>esc_html__('Please put your email','ivdirectories'),
	'wp_iv_directories_URLPATH'=> wp_iv_directories_URLPATH,
	) );
	$adminurl = admin_url();
	$filepath = wp_iv_directories_URLPATH.'template/directories/archive-directories-grid_left_filter.php';
	$shortcode_col = array(
	'admin_url' => admin_url('admin-ajax.php'),
	'file_url' => $filepath,
	);
	wp_localize_script('shortcode-data-display','alphabet_sort',$shortcode_col);
?>