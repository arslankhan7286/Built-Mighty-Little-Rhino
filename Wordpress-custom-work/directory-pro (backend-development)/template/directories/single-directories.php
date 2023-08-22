<?php
	get_header();
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('iv_directories-style-111', wp_iv_directories_URLPATH . 'admin/files/css/single_page.css');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	
	wp_enqueue_script('iv-bootstrap-4-popper', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('iv-bootstrap-4-js', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('iv_directories-ar-slick-214', wp_iv_directories_URLPATH . 'admin/files/css/slick/slick.js');
	wp_enqueue_style('colorbox', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
		
	$dir_background_color=get_option('dir5_background_color');
	if($dir_background_color==""){$dir_background_color='#EFEFEF';}
	$directory_url=get_option('_iv_directories_url');
	if($directory_url==""){$directory_url='directories';}
	global $post,$wpdb, $current_user;
	$id = get_the_ID();
	$post_id_1 = get_post($id);
	$post_id_1->post_title;
	
	$wp_directory= new wp_iv_directories();
	// View Count***
	$current_count=get_post_meta($id,'dirpro_views_count',true);
	$current_count=(int)$current_count+1;
	update_post_meta($id,'dirpro_views_count',$current_count);
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');


?>
<style>
	.fa{
    font: normal normal normal 14px/1 FontAwesome !important;
	}
	.agent-info{
	background:<?php echo esc_html($dir_background_color);?>!important;
	}
</style>
<title><?php echo get_the_title($id); ?></title>
<?php
	wp_enqueue_style('iv_directories-slick-185', wp_iv_directories_URLPATH . 'admin/files/css/slick/slick.css');
	wp_enqueue_style('iv_directories-fancybox-111', wp_iv_directories_URLPATH . 'admin/files/css/jquery.fancybox.css');
	wp_enqueue_script('iv_directories-ar-fancybox-24', wp_iv_directories_URLPATH . 'admin/files/js/jquery.fancybox.js');
	while ( have_posts() ) : the_post();
	if(has_post_thumbnail()){
		$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
		if($feature_image[0]!=""){
			$feature_img =$feature_image[0];
		}
		}else{
		$feature_img= $wp_directory->get_dirpro_listing_default_image();
	}
?>
<!-- menubar  -->
<div class="bootstrap-wrapper">
	<div class="container">
		<div class="row d-block d-md-none">
			<div class="col">
				<div class="menubar" id="menubar">
					<span>
						<?php echo '<a style="text-decoration: none;" href="http://maps.google.com/maps?saddr=Current+Location&amp;daddr='.esc_html(get_post_meta($id,'address',true)).'+'.esc_html(get_post_meta($id,'city',true)).'+'.esc_html(get_post_meta($id,'postcode',true)).'+'.esc_html(get_post_meta($id,'state',true)).'+'.esc_html(get_post_meta($id,'country',true)).'" target="_blank"><i class="fas fa-map-marker-alt"></i><br>'. esc_html__('Direction', 'ivdirectories' ).'</a>'; ?>
					</span>
					<span>
						<a href="#overView"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i><br><?php esc_html_e('Overview', 'ivdirectories' ); ?></a>
					</span>
					<span>
						<a href="#openTime"><i class="far fa-clock"></i><br><?php esc_html_e('Time', 'ivdirectories' ); ?></a>
					</span>
				</div>
			</div>
		</div>
		<?php
			$phone='';
			$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
			if($listing_contact_source==''){$listing_contact_source='new_value';}
			if($listing_contact_source=='new_value'){
				$phone=	get_post_meta($id,'phone',true);
				}else{
				$post_author_id= get_post_field( 'post_author', $id );
				$agent_info = get_userdata($post_author_id);
				if(get_user_meta($post_author_id,'phone',true)!=""){
					$phone=	get_user_meta($post_author_id,'phone',true);
				}
			}
			$dir_style5_call=get_option('dir_style5_call');
			if($dir_style5_call==""){$dir_style5_call='yes';}
			$dirpro_call_button=get_post_meta($id,'dirpro_call_button',true);
			if($dirpro_call_button==""){$dirpro_call_button='yes';}
			if($dir_style5_call=="yes" AND $dirpro_call_button=='yes'){
				$call_button='yes';
				if($phone==''){$call_button='no';}
				}else{
				$call_button='no';
			}
			$dir_style5_email=get_option('dir_style5_email');
			if($dir_style5_email==""){$dir_style5_email='yes';}
			$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
			if($dirpro_email_button==""){$dirpro_email_button='yes';}
			if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
				$email_button='yes';
				}else{
				$email_button='no';
			}
			$dir_style5_sms=get_option('dir_style5_sms');
			if($dir_style5_sms==""){$dir_style5_sms='yes';}
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
		<div class="row">
			<div class="col">
				<div class="phone-menubar" id="phone-menubar">
					<?php
						if($call_button=='yes'){
						?>
						<span>
							<a href="tel:<?php echo esc_html($phone);?>"> <i class="fas fa-phone-volume"></i><br><?php esc_html_e('CALL', 'ivdirectories' ); ?></a>
						</span>
						<?php
						}
					?>
					<?php
						if($email_button=='yes'){
						?>
						<span>
							<a href="#" onclick="call_popup('<?php echo esc_html($id);?>')" > <i class="fas fa-envelope"></i><br> <?php esc_html_e('Email', 'ivdirectories' ); ?></a>
						</span>
						<?php
						}
					?>
					<?php
						if($sms_button=='yes'){
						?>
						<span>
							<a href="sms:<?php echo esc_html($phone);?>?&body=<?php echo esc_html($smsbody);?>"><i class="fas fa-comment-alt"></i> <br><?php esc_html_e('SMS', 'ivdirectories' ); ?></a>
						</span>
						<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end of  menubar -->
<!-- SLIDER SECTION -->
<?php
	$directories_top_slider=get_option('directories_top_slider');
	if($directories_top_slider==""){$directories_top_slider='yes';}
	if($directories_top_slider=='yes'){
	?>
	<div class="bootstrap-wrapper" id="slider-wrapper">
		<section class=" container-fluid m-0 p-0">
			<div class="slider-section">
				<div class="slick-controls">
					<p class="next"><i class="fas fa-angle-right"></i></p>
					<p class="previous"><i class="fas fa-angle-left"></i></p>
				</div>
				<div class="slider variable-width">
					<?php
						$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
						$gallery_ids_array = array_filter(explode(",", $gallery_ids));
						$i=1;
						foreach($gallery_ids_array as $slide){
							if($slide!=''){ ?>
							<div class="item border">
								<img src="<?php echo wp_get_attachment_url( $slide ); ?> " >
							</div>
							<?php
								$i++;
							}
						}
						//image_gallery_urls
						$gallery_urls=get_post_meta($id ,'image_gallery_urls',true);
						$gallery_urls_array = array_filter(explode(",", $gallery_urls));
						foreach($gallery_urls_array as $slide){
							if($slide!=''){ ?>
							<div class="item border">
								<img src="<?php echo esc_url($slide); ?>" >
							</div>
							<?php
								$i++;
							}
						}
						if($i<3){
							for($iii=$i;$iii<3;$iii++){
								if(has_post_thumbnail($id)){?>
								<div class="item border">
									<?php echo get_the_post_thumbnail($id, 'large');?>
								</div>
								<?php
									}else{
									$feature_img= $wp_directory->get_dirpro_listing_default_image();
								?>
								<div class="item border">
									<img   src="<?php echo esc_url($feature_img);?>">
								</div>
								<?php
								}
							}
						}
					?>
				</div>
			</div>
		</section>
	</div>
	<?php
	}
?>
<!-- END OF SLIDER SECTION -->
<?php
	$directories_layout_single=get_option('directories_layout_single');
	if($directories_layout_single==""){$directories_layout_single='two';}
?>
<!-- ********** Agent Info Section ************** -->
<section class="bootstrap-wrapper">
	<section class="agent-info py-5 mt-0">
		<div class="container">
			<div class="row mb-5">
				<div class="<?php echo($directories_layout_single=='one'?'col-md-12':'col-md-8') ?>  agent-info__content">
					<div class="row my-5 px-5 d-flex">
						<div class="col-md-10 d-flex flex-column">
							<h2><?php echo get_the_title($id); ?> <?php
								if(get_post_meta($id,'dirpro_featured',true)=="featured"){ ?>
								<span class="text-white agent-info__feature"><?php esc_html_e('Featured', 'ivdirectories' ); ?></span>
								<?php
								}
									// VIP
									$post_author_id= get_post_field( 'post_author', $id );;
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
										?>
										<img style="height:30px"   src="<?php echo esc_html($vip_image);?>">
									<?php
									}
									?>

							</h2>


							<p class="agent-info__address m-0 p-0">
								<?php
									if(get_post_meta($id,'address',true)!='' OR get_post_meta($id,'zipcode',true)!='' OR get_post_meta($id,'city',true)!=''){
									?>
									<i class="fas fa-map-marker-alt"></i>
									<?php
									}
								?>
								<?php echo esc_html(get_post_meta($id,'address',true));?> <?php echo ' '.esc_html(get_post_meta($id,'zipcode',true));?> <?php echo ' '.esc_html(get_post_meta($id,'city',true));?> <?php echo ' '.esc_html(get_post_meta($id,'state',true));?> <?php echo ' '.esc_html(get_post_meta($id,'country',true));?>
								<?php
									$dir_single_review_show=get_option('dir5_review_show');
									if($dir_single_review_show==""){$dir_single_review_show='yes';}
									if($dir_single_review_show=='yes'){
										$total_reviews_point = $wpdb->get_col($wpdb->prepare( "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
										INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
										WHERE pm.meta_key = 'review_value'
										AND p.post_status = 'publish'
										AND p.post_type = 'dirpro_review' AND p.post_author = '%s'",$id ));
										$argsreviw = array( 'post_type' => 'dirpro_review','author'=>$id,'post_status'=>'publish' );
										$ratings = new WP_Query( $argsreviw );
										$total_review_post = $ratings->post_count;
										$avg_review=0;
										if(isset($total_reviews_point[0])){
											$avg_review= (float)$total_reviews_point[0]/(float)$total_review_post;
										}
									?>
									<br>
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
									<?php
									}
								?>
							</p>
						</div>
					</div>
					<!-- card section -->
					<?php
						$directories_top_4_icons=get_option('directories_top_4_icons');
						if($directories_top_4_icons==""){$directories_top_4_icons='yes';}
						if($directories_top_4_icons=="yes"){
						?>
						<div class="row d-flex hide-on-mobile">
							<div class="col-lg-3 m-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border agent-info__card--no-border-left">
									<div class="card-body">
										<?php
											$directory_top_1_title=get_option('directory_top_1_title');
											if($directory_top_1_title==""){$directory_top_1_title=esc_html__('Call Now', 'ivdirectories' );}
											$directory_top_1_icon=get_option('directory_top_1_icon');
											if($directory_top_1_icon==""){$directory_top_1_icon='fas fa-phone-volume';}
										?>
										<i class="<?php echo esc_html($directory_top_1_icon);?>"></i>
										<h5 class="card-title text-muted mt-3 text-center"><?php echo esc_html($directory_top_1_title); ?> </h5>
										<h6 class="">
											<?php $directories_status=get_post_meta($id , 'phone',true);  ?><?php esc_html_e($directories_status, 'ivdirectories' ); ?>
										</h6>
									</div>
								</div>
							</div>
							<div class="col-lg-3 m-0 p-0">
								<div class="card agent-info__card agent-info__card--no-border">
									<div class="card-body p-0 m-0">
										<?php
											$directory_top_2_title=get_option('directory_top_2_title');
											if($directory_top_2_title==""){$directory_top_2_title= esc_html__('Get Directions', 'ivdirectories' );}
											$directory_top_2_icon=get_option('directory_top_2_icon');
											if($directory_top_2_icon==""){$directory_top_2_icon='fas fa-map-marker';}
										?>
										<i class="<?php echo esc_html($directory_top_2_icon); ?>"></i>
										<h5 class="card-title text-muted mt-3">
											<?php echo '<a style="text-decoration: none;" href="http://maps.google.com/maps?saddr=Current+Location&amp;daddr='.get_post_meta($id,'address',true).'+'.get_post_meta($id,'city',true).'+'.get_post_meta($id,'postcode',true).'+'.get_post_meta($id,'state',true).'+'.get_post_meta($id,'country',true).'" target="_blank">'.$directory_top_2_title.'</a>'; ?>
										</h5>
									</div>
								</div>
							</div>
							<div class="col-lg-3 ml-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border">
									<div class="card-body p-0 m-0">
										<a style="text-decoration: none;" href="#review">
											<?php
												$directory_top_3_title=get_option('directory_top_3_title');
												if($directory_top_3_title==""){$directory_top_3_title=esc_html__('Leave a Review', 'ivdirectories' );}
												$directory_top_3_icon=get_option('directory_top_3_icon');
												if($directory_top_3_icon==""){$directory_top_3_icon='fas fa-comment-alt';}
											?>
											<i class="<?php echo esc_html($directory_top_3_icon);?>"></i>
											<h5 class="card-title text-muted mt-3"> <?php echo esc_html($directory_top_3_title); ?> </h5>
										</a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 m-0 p-0">
								<div class="card text-center agent-info__card agent-info__card--no-border">
									<div class="card-body">
									  <span  id="fav_dir<?php echo esc_html($id); ?>">
											<?php
												$directory_top_4_title=get_option('directory_top_4_title');
												if($directory_top_4_title==""){$directory_top_4_title=esc_html__('Bookmark', 'ivdirectories' );}
												$directory_top_4_icon=get_option('directory_top_4_icon');
												if($directory_top_4_icon==""){$directory_top_4_icon='fas fa-heart';}
												$user_ID = get_current_user_id();
												if($user_ID>0){
													$my_favorite = get_post_meta($id,'_favorites',true);
													$all_users = explode(",", $my_favorite);
													if (in_array($user_ID, $all_users)) { ?>
													<a style="text-decoration: none;color:#6f9a37;" data-toggle="tooltip"  title="<?php esc_html_e('Added to Favorites','ivdirectories'); ?>" href="javascript:;" onclick="save_unfavorite('<?php echo esc_html($id); ?>')" >
													<i class="<?php echo esc_html($directory_top_4_icon);?>" style="color:#6f9a37;"></i></a>
													<?php
														$bookmark=esc_html__('Bookmarked', 'ivdirectories' );
													}else{ $bookmark=$directory_top_4_title; ?>
													<a style="text-decoration: none;color:#bdc3c7;" data-toggle="tooltip"  title="<?php esc_html_e('Add to Favorites','ivdirectories'); ?>" href="javascript:;" onclick="save_favorite('<?php echo esc_html($id); ?>')" >
														<i class="<?php echo esc_html($directory_top_4_icon);?>" style="color:#bdc3c7;"></i>
													</a>
													<?php
													}
												}else{ $bookmark=$directory_top_4_title; ?>
												<a style="text-decoration: none;color:#bdc3c7;" data-toggle="tooltip"  title="<?php esc_html_e('Add to Favorites','ivdirectories'); ?>" href="javascript:;" onclick="save_favorite('<?php echo esc_html($id); ?>')" >
													<i class="<?php echo esc_html($directory_top_4_icon);?>" style="color:#bdc3c7;"></i>
												</a>
												<?php
												}
											?>
										</span>
										<h5 class="card-title text-muted mt-3" id="fav_title"> <?php echo esc_html($bookmark); ?> </h5>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
					?>
					<!-- end of card section -->
					<!-- about listing section -->
					<div class="row px-5 mt-5">
						<div class="col">
							<h3 class="font-weight-bold" id="overView"><?php esc_html_e('About','ivdirectories'); ?></h3>
						</div>
					</div>
					<div class="agent-info__separator mx-5"></div>
					<div class="row mb-0 mb-md-5 px-5">
						<div class="col mt-2">
							<p class="text-justify">
								<?php
									if($wp_directory->check_reading_access('description',$id)){
										$my_postid = $id;//This is page id or post id
										$content_post = get_post($my_postid);
										$content = $content_post->post_content;
										$content = apply_filters('the_content', $content);
										$content = str_replace(']]>', ']]&gt;', $content);
										echo do_shortcode($content);
									}
								?>
							</p>
						</div>
					</div>
					<?php
						$directories_details=get_option('directories_details');
						if($directories_details==""){$directories_details='yes';}
						if($directories_details=="yes"){
						?>
						<!-- details section -->
						<?php
							if($wp_directory->check_reading_access('description',$id)){
							?>
							<div class="row px-5">
								<div class="col">
									<h3 class="font-weight-bold m-0 py-2"><?php esc_html_e('Details','ivdirectories'); ?></h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row mt-5 px-5">
								<?php
									$i=1;
									$field_set=get_option('iv_directories_fields' );
									if($field_set!=""){
										$default_fields=get_option('iv_directories_fields' );
										}else{
										$default_fields['business_type']='Business Type';
										$default_fields['main_products']='Main Products';
										$default_fields['number_of_employees']='Number Of Employees';
										$default_fields['main_markets']='Main Markets';
										$default_fields['total_annual_sales_volume']='Total Annual Sales Volume';
									}
									if(get_option( 'iv_membership_field_type')!=''){
										$field_type_opt= get_option( 'iv_membership_field_type');	
									}else{
										$field_type_opt= array();
									}	
									if(get_option( 'iv_membership_field_type_roles')!=''){
										$field_type_roles= get_option( 'iv_membership_field_type_roles');	
									}else{
										$field_type_roles= array();
									}
									$user = new WP_User( $post_author_id);
									
								?>
								<div class="row col">
									<?php
										if(sizeof($default_fields)>0){
											foreach ( $default_fields as $field_key => $field_value ) {
												$field_value_trim=trim($field_value);
												if(get_post_meta($id,$field_key,true)!=""){
													$role_access='no';
													if(in_array('all',$field_type_roles[$field_key] )){
														$role_access='yes'; 
													}
													
													if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
														foreach ( $user->roles as $role ){
															if(in_array($role,$field_type_roles[$field_key] )){
																	
																 $role_access='yes';
															}
															if('administrator'==$role){
																$role_access='yes';
															}
														}	
													}													
													if($role_access=='yes'){
														if(isset($field_type_opt[$field_key])){ 
														if($field_type_opt[$field_key]=='url'){							
															?>
															<div class="col-md-6">
																<p><i class="fas fa-angle-right"></i> <?php echo esc_html_e($field_value_trim, 'ivdirectories'); ?>: <strong><?php echo esc_url(get_post_meta($id,$field_key,true)); ?></strong></p>
															</div>
															<?php
														}elseif($field_type_opt[$field_key]=='textarea'){ 
															?>
															<div class="col-md-6">
																<p><i class="fas fa-angle-right"></i> <?php echo esc_html_e($field_value_trim, 'ivdirectories'); ?>: <strong><?php echo esc_textarea(get_post_meta($id,$field_key,true)); ?></strong></p>
															</div>
															<?php
														}elseif($field_type_opt[$field_key]=='datepicker'){ 
														?>
															<div class="col-md-6">
																<p><i class="fas fa-angle-right"></i> <?php echo esc_html_e($field_value_trim, 'ivdirectories'); ?>: <strong><?php echo date('M d, Y',strtotime(get_post_meta($id,$field_key,true))); ?></strong></p>
															</div>
														<?php
														}else{
															?>
															<div class="col-md-6">
																<p><i class="fas fa-angle-right"></i> <?php echo esc_html_e($field_value_trim, 'ivdirectories'); ?>: <strong><?php echo esc_html(get_post_meta($id,$field_key,true)); ?></strong></p>
															</div>
															<?php
														}
													}
													}	
												}
											}
										}
									?>
								</div>
							</div>
							<?php
							}
						}
					?>
					<!-- Contact info -->
					<?php
						$contact_info=get_option('_contact_info');
						if($contact_info==""){$contact_info='yes';}
						if($directories_layout_single=="two"){$directories_layout_single='two';}
						if($contact_info=="yes"){
						if($directories_layout_single=="one"){
						?>
						<div class="row px-5 mt-5">
							<div class="col">
								<h3 class="font-weight-bold" id="overView">
									<?php
										$dir_addedit_contactinfotitle=get_option('dir_addedit_contactinfotitle');
										if($dir_addedit_contactinfotitle==""){$dir_addedit_contactinfotitle=esc_html__('Contact Info' ,'ivdirectories');}
										echo esc_html($dir_addedit_contactinfotitle);
									?>
								</h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row mt-5 px-5">
							<div class="row col">
								<?php
									if($wp_directory->check_reading_access('contact info',$id)){
										$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
										if($listing_contact_source==''){$listing_contact_source='new_value';}
										if($listing_contact_source=='new_value'){
										?>
										<?php
											if(get_post_meta($id,'contact_name',true)!=""){
											?>
											<div class="col-md-4"><p><?php esc_html_e('Name','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo esc_html(get_post_meta($id,'contact_name',true));?></p>
											</div>
											<?php
											}
										?>
										<?php
											if(get_post_meta($id,'phone',true)!=""){
											?>
											<div class="col-md-4"><p><?php esc_html_e('Phone','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="tel:'.get_post_meta($id,'phone',true).'">'.get_post_meta($id,'phone',true).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<?php
												if(get_post_meta($id,'fax',true)!=""){
												?>
												<div class="col-md-4"><p><?php esc_html_e('Fax','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue" style="text-decoration: none;">'.get_post_meta($id,'fax',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
										<?php
											if(get_post_meta($id,'contact-email',true)!=""){
											?>
											<div class="col-md-4"><p><?php esc_html_e('Email','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="mailto:'.get_post_meta($id,'contact-email',true).'">'.get_post_meta($id,'contact-email',true).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<?php
											if(get_post_meta($id,'contact_web',true)!=""){
												$contact_web=get_post_meta($id,'contact_web',true);
												$contact_web=str_replace('https://','',$contact_web);
												$contact_web=str_replace('http://','',$contact_web);
											?>
											<div class="col-md-4"><p><?php esc_html_e('Website','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a style="text-decoration: none;" href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web).'&nbsp; </a>';?></p>
											</div>
											<?php
											}
										?>
										<?php
										}else{ ?>
										<?php
											$post_author_id= get_post_field( 'post_author', $id );
											$agent_info = get_userdata($post_author_id);
											if(get_user_meta($post_author_id,'phone',true)!=""){
											?>
											<div class="col-md-4"><p><?php esc_html_e('Phone','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="tel:'.get_user_meta($post_author_id,'phone',true).'">'.get_user_meta($post_author_id,'phone',true).'</a>' ;?></p>
											</div>
											<?php
											}
										?>
										<div class="col-md-4"><p><?php esc_html_e('Email','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="mailto:'.$agent_info->user_email.'">'.$agent_info->user_email.'</a>' ;?></p>
										</div>
										<?php
											if(get_user_meta($post_author_id,'web_site',true)!=""){
												$contact_web=get_user_meta($post_author_id,'web_site',true);
												$contact_web=str_replace('https://','',$contact_web);
												$contact_web=str_replace('http://','',$contact_web);
											?>
											<div class="col-md-4"><p><?php esc_html_e('Website','ivdirectories'); ?></p></div><div class="col-md-8"><p><?php echo '<a style="text-decoration: none;" href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web).'&nbsp; </a>';?></p>
											</div>
											<?php
											}
										?>
										<?php
										}
									}
								?>
								<div class="my-4 px-2 ">
									<?php
										$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
										if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle=esc_html__('Contact US','ivdirectories');}
										$contact_form=get_option('_dir_contact_show');
										$dir_contact_form=get_option('dir_contact_form');

										if($contact_form==""){$contact_form='yes';}
										if($contact_form=='yes'){
											$contact_form=get_option('_contact_form_modal');
											if($contact_form==""){$contact_form='popup';}
											if($contact_form=='popup'){
												if($dir_contact_form=='yes'){
												?>
														<button onclick="call_popup('<?php echo esc_html($id);?>')" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button" id="no-border-radius"><i class="far fa-envelope"></i> <?php echo esc_html($dir_addedit_contactustitle); ?></button>
											<?php
												}else{
														$dir_form_shortcode=get_option('dir_form_shortcode');
														echo do_shortcode($dir_form_shortcode);
												}

											}else{?>
											<h3 class="m-0 py-3"><?php echo esc_html($dir_addedit_contactustitle); ?></h3>
											<?php

												if($dir_contact_form==""){$dir_contact_form='yes';}
												if($dir_contact_form=='yes'){
												include(wp_iv_directories_template.'directories/contact-form.php');?>
												<div class="form-group ">
													<label class="col-md-8"  for="message"></label>
													<button type="button" onclick="contact_send_message_iv();" class="btn btn-primary sm"><?php esc_html_e( 'Send', 'ivdirectories' ); ?></button>
												</div>
												<?php
													}else{
													$dir_form_shortcode=get_option('dir_form_shortcode');
													echo do_shortcode($dir_form_shortcode);
												}
											}
										?>
										<?php
										}
									?>
								</div>
							</div>
						</div>
						<?php
							}
						}
					?>
					<!-- pic gallery section -->
					<div class="row col agent-info__gallery-pics mt-5">
						<?php
							$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
							$gallery_ids_array = array_filter(explode(",", $gallery_ids));
							$i=1;
							foreach($gallery_ids_array as $slide){
								if(trim($slide)!=''){ ?>
								<div class=" p-0 m-0 col-md-3">
									<a data-fancybox="gallery" href="<?php echo wp_get_attachment_url( $slide ); ?>">
										<img class="img-fluid" src="<?php echo wp_get_attachment_url( $slide ); ?>">
									</a>
								</div>
								<?php
									$i++;
								}
							}
							//image_gallery_urls
							$gallery_urls=get_post_meta($id ,'image_gallery_urls',true);
							$gallery_urls_array = array_filter(explode(",", $gallery_urls));
							foreach($gallery_urls_array as $slide){
								if(trim($slide)!=''){ ?>
								<div class=" p-0 m-0 col-md-3">
									<a data-fancybox="gallery" href="<?php echo esc_url($slide); ?>">
										<img class="img-fluid" src="<?php echo esc_url($slide); ?>">
									</a>
								</div>
								<?php
									$i++;
								}
							}
						?>
					</div>
					<!-- end of pic gallery -->
					<!-- features secton -->
					<?php
						$dir_features=get_option('_dir_features');
						if($dir_features==""){$dir_features='yes';}
						if($dir_features=="yes"){
						?>
						<div class="row px-5">
							<div class="col">
								<h3 class="font-weight-bold m-0 py-2"><?php esc_html_e( 'Features', 'ivdirectories' ); ?></h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row my-md-5 px-5">
							<div class="row col">
								<?php
									$tag_array= wp_get_post_tags( $id );
									$directory_url=get_option('_iv_directory_url');
									if($directory_url==""){$directory_url='directories';}
									$dir_tags=get_option('_dir_tags');
									if($dir_tags==""){$dir_tags='yes';}
									if($dir_tags=='yes'){
										$tag_array= wp_get_object_terms( $id,  $directory_url.'_tag');
										}else{
										$tag_array= wp_get_post_tags( $id );
									}
									foreach($tag_array as $one_tag){
										echo'<div class="col-md-6"><p><i class="fas fa-angle-right"></i> <a style="text-decoration: none;" href="'.get_tag_link($one_tag->term_id) .'">'.$one_tag->name.'</a></p></div>';
									}
									$currentCategory=wp_get_object_terms( $id, $directory_url.'-category');
									if(isset($currentCategory[0]->slug)){
										$cat_slug = $currentCategory[0]->slug;
										$cat_name = $currentCategory[0]->name;
										$cc=0;
										foreach($currentCategory as $c){
											echo'<div class="col-md-6"><p><i class="fas fa-angle-right"></i> <a style="text-decoration: none;" href="'.get_tag_link($c->term_id) .'">'.$c->name.'</a></p></div>';
										}
									}
								?>
							</div>
						</div>
						<!-- end of feature section -->
						<?php
						}
					?>
				  <!-- Time secton -->
					<?php
						$dir_opening_time=get_option('dir_opening_time');
						if($dir_opening_time==""){$dir_opening_time='yes';}
						if($dir_opening_time=='yes'){
							$openin_days =get_post_meta($id ,'_opening_time',true);
							if($openin_days!=''){
								if(sizeof($openin_days)>0){
								?>
								<div class="row px-5">
									<div class="col">
										<h3 class="font-weight-bold m-0 py-2" id="openTime">
											<?php
												$dir_addedit_openingtimetitle=get_option('dir_addedit_openingtimetitle');
												if($dir_addedit_openingtimetitle==""){ $dir_addedit_openingtimetitle=esc_html__( 'Opening Time', 'ivdirectories' );}
											echo esc_html($dir_addedit_openingtimetitle); ?>
										</h3>
									</div>
								</div>
								<div class="agent-info__separator mx-5"></div>
								<div class="row my-md-5 px-5">
									<div class="row col">
										<?php
											foreach($openin_days as $key => $item){
												$day_time = explode("|", $item);
												echo'<div class="col-md-6"><p><i class="fas fa-angle-right"></i> '.$key.' :'.  $day_time[0].' - '.$day_time[1].'</p></div>';
											}
										?>
									</div>
								</div>
								<!-- end of feature section -->
								<?php
								}
							}
						}
					?>
				  <!-- Booking secton -->
					<?php
						if($wp_directory->check_reading_access('booking')){
							if(trim(get_post_meta($id, 'booking', true))!="" || trim(get_post_meta($id, 'booking_detail', true))!=""){
							?>
							<div class="row px-5">
								<div class="col">
									<h3 class="font-weight-bold m-0 py-2">
										<?php
											$dir_addedit_bookingtitle=get_option('dir_addedit_bookingtitle');
											if($dir_addedit_bookingtitle==""){$dir_addedit_bookingtitle=esc_html__( 'Booking', 'ivdirectories' );}
											echo esc_html($dir_addedit_bookingtitle);
										?>
									</h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row my-md-5 px-5">
								<div class="row col">
									<?php
										if(get_post_meta($id, 'booking_detail', true)!="" OR get_post_meta($id, 'booking', true)!=""){	?>
										<div class="col-md-12"><p><?php echo esc_html(get_post_meta($id, 'booking_detail', true)); ?></p></div>
										<div class="col-md-12"><p><?php
											$booking_short_code= esc_html(get_post_meta($id, 'booking', true));
											$booking_shortcode_main = str_replace("[", '', $booking_short_code);
											$booking_shortcode_main = str_replace("]", '', $booking_shortcode_main);
											if($booking_short_code!=''){
												echo do_shortcode($booking_short_code);
											}
										?>
										</p>
										</div>
										<?php
										}
									?>
								</div>
							</div>
							<!-- end of feature section -->
							<?php
							}
						}
					?>
					<!-- map section -->
					<?php
						$dir_map=get_option('directories_dir_map');
						if($dir_map==""){$dir_map='yes';}
						if($dir_map=='yes'){
							$address=get_post_meta($id,'address',true).'+'.get_post_meta($id,'city',true).'+'.get_post_meta($id,'postcode',true).'+'.get_post_meta($id,'country',true);
						?>
						<div class="agent-info__separator"></div>
						<div class="row mb-5">
							<div class="col">
								<iframe width="100%" height="325" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo esc_html($address); ?>&amp;ie=UTF8&amp;&amp;output=embed"></iframe>
							</div>
						</div>
						<?php
						}
					?>
					<!-- end of map section -->
					<!-- video section -->
					<?php
						$dir_video=get_option('directories_dir_video');
						if($dir_video==""){$dir_video='yes';}
						if($dir_video=='yes'){
							$video_vimeo_id= get_post_meta($id,'vimeo',true);
							$video_youtube_id=get_post_meta($id,'youtube',true);
							if($video_vimeo_id!='' || $video_youtube_id!=''){
							?>
							<div class="row px-5">
								<div class="col">
									<h3 class="font-weight-bold m-0 py-2">
										<?php
											$dir_addedit_videostitle=get_option('dir_addedit_videostitle');
											if($dir_addedit_videostitle==""){$dir_addedit_videostitle=esc_html__('Video','ivdirectories');}
										echo esc_html($dir_addedit_videostitle); ?>
									</h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row m-0 p-0">
								<div class="col video px-5 py-0 m-0">
									<?php
										if($wp_directory->check_reading_access('video',$id)){
										?>
										<?php
											$v=0;
											$video_vimeo_id= get_post_meta($id,'vimeo',true);
											if($video_vimeo_id!=""){ $v=$v+1; ?>
											<iframe src="https://player.vimeo.com/video/<?php echo esc_html($video_vimeo_id); ?>" width="100%" height="100%" class="w-100 m-0 p-0" frameborder="0"></iframe>
											<?php
											}
										?>
										<br/>
											<?php
											$video_youtube_id=get_post_meta($id,'youtube',true);
											if($video_youtube_id!=""){
												echo($v==1?'<hr>':'');
											?>
											<iframe width="100%" height="415px" src="https://www.youtube.com/embed/<?php echo esc_html($video_youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100"></iframe>
											<?php
											}
										}
									?>
								</div>
							</div>
							<?php
							}
						}
					?>
					<!-- end of video section -->
					<!-- Award -->
					<?php
						$dir_addedit_awardtitle=get_option('dir_addedit_awardtitle');
						if($dir_addedit_awardtitle==""){$dir_addedit_awardtitle=esc_html__('Awards','ivdirectories');}
						$dir_addedit_award=get_option('dir_addedit_award');
						if($dir_addedit_award==""){$dir_addedit_award='yes';}
						if($dir_addedit_award=="yes"){
							if(trim(get_post_meta($id,'_award_title_0',true))!='' || trim(get_post_meta($id,'_award_description_0',true))|| trim(get_post_meta($id,'_award_year_0',true))|| trim(get_post_meta($id,'_award_image_id_0',true)) ){
							?>
							<div class="row mt-0 mt-md-5 px-5">
								<div class="col">
									<h3 class="m-0 py-2"><?php echo esc_html($dir_addedit_awardtitle); ?> </h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row mt-0 px-5" >
								<?php
									include(wp_iv_directories_template.'directories/award.php');
								?>
							</div>
							<?php
							}
						}
					?>
					<?php
						$dir_addedit_eventtitle=get_option('dir_addedit_eventtitle');
						if($dir_addedit_eventtitle==""){$dir_addedit_eventtitle='Event';}
						$dir_addedit_event=get_option('dir_addedit_event');
						if($dir_addedit_event==""){$dir_addedit_event='no';}
						if($dir_addedit_event=="yes"){
							if(trim(get_post_meta($id,'event_title',true))!='' || trim(get_post_meta($id,'event_detail',true))!=''  || trim(get_post_meta($id,'_event_image_id',true))!=''  ){
							?>
							<div class="row mt-0 mt-md-5 px-5">
								<div class="col">
									<h3 class="m-0 py-2"><?php echo esc_html($dir_addedit_eventtitle); ?> </h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<div class="row mt-0 px-5" >
								<?php	if($wp_directory->check_reading_access('event')){
									include(wp_iv_directories_template.'directories/event.php');
								}
								?>
							</div>
							<?php
							}
						}
					?>
					<!-- review section -->
					<?php
						$dir_single_review_show=get_option('dir5_review_show');
						if($dir_single_review_show==""){$dir_single_review_show='yes';}
						if($dir_single_review_show=='yes'){
						?>
						<div class="row mt-0 mt-md-5 px-5">
							<div class="col">
								<h3 class="font-weight-bold m-0 py-2"><?php esc_html_e('Review','ivdirectories'); ?> </h3>
							</div>
						</div>
						<div class="agent-info__separator mx-5"></div>
						<div class="row mt-0 px-5" id="review">
							<?php
								include(wp_iv_directories_template.'directories/reviews.php');
							?>
						</div>
						<?php
						}
					?>
					<!-- end of review section -->
					<!-- similar directories -->
					<?php
						$similar_directories=get_option('_similar_directories');
						if($similar_directories==""){$similar_directories='yes';}
						if($similar_directories=="yes"){
							$properties = get_posts(array(
							'numberposts'	=> '4',
							'post_type'		=> $directory_url,
							'post__not_in' => array(esc_html($id)),
							'post_status'	=> 'publish',
							'orderby'		=> 'rand',
							));
							if ( ! empty( $properties ) ) {
							?>
							<div class="row">
								<div class="col-md-12 py-3 bg-separator"></div>
							</div>
							<div class="row mt-0 px-5">
								<div class="col">
									<h3 class="font-weight-bold m-0 py-2"><?php esc_html_e('Similar Listing','ivdirectories'); ?></h3>
								</div>
							</div>
							<div class="agent-info__separator mx-5"></div>
							<!-- directories slider -->
							<div id="similarPrppertycarousel" class="carousel slide px-5" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#similarPrppertycarousel" data-slide-to="0" class="active"></li>
									<li data-target="#similarPrppertycarousel" data-slide-to="1"></li>
								</ol>
								<div class="carousel-inner">
									<?php
										$i=0;
										foreach( $properties as $directories ) :
									?>
									<div class="carousel-item <?php echo($i==0?'active':'');?>">
										<div class="row bg-white agent-info__similar-directories p-3 mt-3">
											<div class="col-md-4 p-0 m-0 agent-info__similar-directories-img">
												<a href="<?php echo get_the_permalink($directories->ID);?>">
													<?php	if(has_post_thumbnail($directories->ID)){
														$fsrc= wp_get_attachment_image_src( get_post_thumbnail_id( $directories->ID ), 'large' );
														if($fsrc[0]!=""){
															$fsrc =$fsrc[0];
														}
													?>
													<img src="<?php  echo esc_url($fsrc);?>" class="img-thumbnail">
													<?php
													}else{	
														$feature_img= $wp_directory->get_dirpro_listing_default_image();
													?>
													<img src="<?php echo  esc_url($feature_img);?>" class="img-thumbnail">
													
													<?php
													}
													?>
												</a>
											</div>
											<div class="col-md-8 mt-3 mt-md-0 px-5 pl-md-5 pt-md-5">
												<a href="<?php echo get_the_permalink($directories->ID);?>"><h6><?php echo get_the_title($directories->ID); ?></h6></a>
												<p><?php echo get_post_meta($directories->ID,'address',true);?> <?php echo get_post_meta($directories->ID,'city',true);?> <?php echo get_post_meta($directories->ID,'zipcode',true);?> <?php echo get_post_meta($directories->ID,'country',true);?></p>
											</div>
										</div>
									</div>
									<?php
										$i++;
										endforeach;
									?>
								</div>
								<a class="carousel-control-prev" href="#similarPrppertycarousel" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only"><?php esc_html_e('Previous','ivdirectories'); ?></span>
								</a>
								<a class="carousel-control-next" href="#similarPrppertycarousel" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only"><?php esc_html_e('Next','ivdirectories'); ?></span>
								</a>
							</div>
							<!-- end of directories slider & end of similar directories -->
							<!-- end of similar directories -->
							<?php
							}
						}
					?>
				</div>
				<?php
					if($directories_layout_single!='one'){
					?>
					<div class="col-md-4 ml-auto agent-info__booking-section-container">
						<?php
							if($directories_layout_single=='right_feature_image'){
								$feature_img='';
								if(get_post_thumbnail_id($id)){
									$img_url= wp_get_attachment_url( get_post_thumbnail_id($id ,'large') );
									echo '<img src="'.esc_url( $img_url).'" style="width:100%">';
								}	
							}
						?>
						<?php
							$contact_info=get_option('_contact_info');
							if($contact_info==""){$contact_info='yes';}
							if($contact_info=="yes"){
							?>
							<div class="agent-info__booking-section">
								<h2 class="text-center py-3 mx-0 h2bg"> <?php
									$dir_addedit_contactinfotitle=get_option('dir_addedit_contactinfotitle');
									if($dir_addedit_contactinfotitle==""){$dir_addedit_contactinfotitle=esc_html__('Contact Info' ,'ivdirectories');}
									echo esc_html($dir_addedit_contactinfotitle);
								?>
								</h2>
							<div class="agent-info__separator mx-5"></div>
								<div class="row my-3 px-3">
									<?php
										if($wp_directory->check_reading_access('contact info',$id)){
											$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
											if($listing_contact_source==''){$listing_contact_source='new_value';}
											if($listing_contact_source=='new_value'){
											?>
											<?php
												if(get_post_meta($id,'contact_name',true)!=""){
												?>
												<div class="col-md-1"><p><i class="far fa-user"></i></p></div><div class="col-md-10"><p><?php echo get_post_meta($id,'contact_name',true);?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'phone',true)!=""){
												?>
												<div class="col-md-1"><p><i class="fas fa-phone-alt"></i></p></div><div class="col-md-10"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="tel:'.get_post_meta($id,'phone',true).'">'.get_post_meta($id,'phone',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'fax',true)!=""){
												?>
												<div class="col-md-1"><p><i class="fas fa-fax"></i></p></div><div class="col-md-10"><p><?php echo '<a class="icon-blue" style="text-decoration: none;">'.get_post_meta($id,'fax',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'contact-email',true)!=""){
												?>
												<div class="col-md-1"><p><i class="fas fa-envelope"></i></p></div><div class="col-md-10"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="mailto:'.get_post_meta($id,'contact-email',true).'">'.get_post_meta($id,'contact-email',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<?php
												if(get_post_meta($id,'contact_web',true)!=""){
													$contact_web=get_post_meta($id,'contact_web',true);
													$contact_web=str_replace('https://','',$contact_web);
													$contact_web=str_replace('http://','',$contact_web);
													$contact_web_s=substr($contact_web, 0, 200); 
													
												?>
												<div class="col-md-1"><p><i class="fas fa-globe"></i></p></div><div class="col-md-10"><p><?php echo '<a style="text-decoration: none;" href="'. esc_url($contact_web).'" target="_blank"">'. $contact_web.'</a>';?></p>
												</div>
												<?php
												}
											?>
											<?php
											}else{ ?>
											<?php
												$post_author_id= get_post_field( 'post_author', $id );
												$agent_info = get_userdata($post_author_id);
												if(get_user_meta($post_author_id,'phone',true)!=""){
												?>
												<div class="col-md-1"><p><i class="fas fa-phone-alt"></i></p></div><div class="col-md-10"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="tel:'.get_user_meta($post_author_id,'phone',true).'">'.get_user_meta($post_author_id,'phone',true).'</a>' ;?></p>
												</div>
												<?php
												}
											?>
											<div class="col-md-1"><p><i class="fas fa-envelope"></i></p></div><div class="col-md-10"><p><?php echo '<a class="icon-blue" style="text-decoration: none;" href="mailto:'.$agent_info->user_email.'">'.$agent_info->user_email.'</a>' ;?></p>
											</div>
											<?php
												if(get_user_meta($post_author_id,'web_site',true)!=""){
													$contact_web=get_user_meta($post_author_id,'web_site',true);
													$contact_web=str_replace('https://','',$contact_web);
													$contact_web=str_replace('http://','',$contact_web);
													$contact_web_s=substr($contact_web, 0, 200); 
													
												?>
												<div class="col-md-1"><p><i class="fas fa-globe"></i></p></div><div class="col-md-10"><p><?php echo '<a style="text-decoration: none;" href="'. esc_url($contact_web).'" target="_blank"">'. esc_url($contact_web_s).'</a>';?></p>
												</div>
												<?php
												}
											?>
											<?php
											}
										}
									?>
								</div>
								<?php
								}
							?>
							<?php
								$dir_social_show=get_option('_dir_social_show');
								if($dir_social_show==""){$dir_social_show='yes';}
								if($dir_social_show=='yes'){
								?>
								<div class="row my-3 px-5 d-flex justify-content-around">
									<?php
										if(get_post_meta($id,'facebook',true)!=""){
											$web_link=get_post_meta($id,'facebook',true);
											$web_link=str_replace('https://','',$web_link);
											$web_link=str_replace('http://','',$web_link);
										?>
										<div class="">
											<a data-toggle="tooltip" data-placement="bottom" class="icon-blue"  title="<?php esc_html_e('Facebook Profile','ivdirectories'); ?>" href="<?php echo esc_url($web_link);?>" target="_blank"><i class="fab fa-facebook fa-2x"></i>
											</a>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'twitter',true)!=""){
											$web_link=get_post_meta($id,'twitter',true);
											$web_link=str_replace('https://','',$web_link);
											$web_link=str_replace('http://','',$web_link);
										?>
										<div class="">
											<a data-toggle="tooltip" data-placement="bottom" class="icon-blue"  title="<?php esc_html_e('Twitter Profile','ivdirectories'); ?>" href="<?php echo esc_url($web_link);?>" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
										</div>
										<?php
										}
									?>
									<?php
										if(get_post_meta($id,'linkedin',true)!=""){
											$web_link=get_post_meta($id,'linkedin',true);
											$web_link=str_replace('https://','',$web_link);
											$web_link=str_replace('http://','',$web_link);
										?>
										<div class="">
											<a data-toggle="tooltip" data-placement="bottom" class="icon-blue"  title="<?php esc_html_e('linkedin Profile','ivdirectories'); ?>" href="<?php echo esc_url($web_link);?>" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
										</div>
										<?php
										}
									?>
									<?php
										
										if(get_post_meta($id,'instagram',true)!=""){
											$web_link=get_post_meta($id,'instagram',true);
											$web_link=str_replace('https://','',$web_link);
											$web_link=str_replace('http://','',$web_link);
										?>
										<div class="">
											<a data-toggle="tooltip" class="icon-blue" data-placement="bottom" title="<?php esc_html_e('instagram Profile','ivdirectories'); ?>" href="<?php echo esc_url($web_link);?>" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
										</div>
										<?php
										}
										if(get_post_meta($id,'youtube_social',true)!=""){
											$web_link=get_post_meta($id,'youtube_social',true);
											$web_link=str_replace('https://','',$web_link);
											$web_link=str_replace('http://','',$web_link);
										?>
										<div class="">
											<a data-toggle="tooltip" class="icon-blue" data-placement="bottom" title="<?php esc_html_e('Youtube Profile','ivdirectories'); ?>" href="<?php echo esc_url($web_link);?>" target="_blank"><i class="fab fa-youtube fa-2x"></i></a>
										</div>
										<?php
										}
									?>
								</div>
								<?php
								}
							?>
							<div class="my-4 px-5">
								<div class="agent-info__form-separator mb-3"></div>
								<?php
									$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
									if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle=esc_html__('Contact US','ivdirectories');}
									$contact_form=get_option('_dir_contact_show');
									$dir_contact_form=get_option('dir_contact_form');

									if($contact_form==""){$contact_form='yes';}
									if($contact_form=='yes'){
										$contact_form=get_option('_contact_form_modal');
										if($contact_form==""){$contact_form='popup';}
										if($contact_form=='popup'){
												if($dir_contact_form=='yes'){
												?>
													<button onclick="call_popup('<?php echo esc_html($id);?>')" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button" id="no-border-radius"><i class="far fa-envelope"></i> <?php echo esc_html($dir_addedit_contactustitle); ?></button>
										<?php
												}else{
														$dir_form_shortcode=get_option('dir_form_shortcode');
														echo do_shortcode($dir_form_shortcode);

											}
										}else{?>
										<h3 class="m-0 py-3"><?php echo esc_html($dir_addedit_contactustitle); ?></h3>
										<?php

											if($dir_contact_form==""){$dir_contact_form='yes';}
											if($dir_contact_form=='yes'){
											include(wp_iv_directories_template.'directories/contact-form.php');?>
											<!-- <div class="form-group dirpro_btn"> -->

												<button type="button" onclick="contact_send_message_iv();" class="btn btn-secondary pull-right dirpro_btn"><?php esc_html_e( 'Send Message', 'ivdirectories' ); ?></button>
											<!-- </div> -->


												<label class="col-md-12"  for="message"></label>
													<div class="pull-right" id="update_message_popup"></div>
											<?php
												}else{
												$dir_form_shortcode=get_option('dir_form_shortcode');
												echo do_shortcode($dir_form_shortcode);
											}
										}
									?>
									<?php
									}
									$dir_claim_show=get_option('_dir_claim_show');
									if($dir_claim_show==""){$dir_claim_show='yes';}
									if($dir_claim_show=="yes"){
										if(get_post_meta($id,'iv_directories_approve',true)!='yes'){
											$dir_addedit_claimtitle=get_option('dir_addedit_claimtitle');
											if($dir_addedit_claimtitle==""){$dir_addedit_claimtitle=esc_html__('Report','ivdirectories');}
										?>
										<button onclick="call_popup_claim('<?php echo esc_html($id);?>')" class="btn btn-block btn-outline-secondary custom-button  my-2 py-2" type="button" name="button" id="no-border-radius"><i class="far fa-flag"></i> <?php echo esc_html($dir_addedit_claimtitle); ?></button>
										<?php
										}
									}
								?>
							</div>
							<div class="d-flex justify-content-between align-items-center py-2 agent-info__form-footer">
								<?php
									$dir_share=get_option('_dir_share_show');
									if($dir_share==""){$dir_share='yes';}
									if($dir_share=="yes"){
									?>
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();  ?>"><i class="fab fa-facebook-f"></i></a>
									<a  href="https://twitter.com/home?status=<?php echo the_permalink();  ?>"><i class="fab fa-twitter"></i></a>
									<a href=" http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo esc_url($feature_img); ?>&description=<?php the_title(); ?>"><i class="fab fa-pinterest "></i></a>
									<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source="><i class="fab fa-linkedin"></i></a>
									<?php
									}
								?>
							</div>
						</div>
					</div>
					<?php
					}
				?>
			</div>
		</div>
	</section>
</section>
<!-- end of bootstrap-wrapper -->
<?php
	endwhile;
	$directories_slider_autorun=get_option('directories_slider_autorun');
	if($directories_slider_autorun==""){$directories_slider_autorun='yes';}
	if($directories_slider_autorun=="yes"){$autorun=true; }else{ $autorun=false;}
	$directories_slider_threeimage=get_option('directories_slider_threeimage');
	if($directories_slider_threeimage==""){$directories_slider_threeimage='yes';}
	wp_enqueue_script('iv_directories-ar-script-38', wp_iv_directories_URLPATH . 'admin/files/js/single-listing.js');
	wp_localize_script('iv_directories-ar-script-38', 'realpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'ivdirectories' ),
	'Add_to_Favorites'=>esc_html__('Add to Favorites', 'ivdirectories' ),
	'Added_to_Favorites'=>esc_html__('Added to Favorites', 'ivdirectories' ),
	'Please_put_your_message'=>esc_html__('Please put your name, email & message', 'ivdirectories' ),
	'Bookmarked'=>esc_html__('Bookmarked', 'ivdirectories' ),
	'autorun'=>$autorun,
	'Bookmark'=>esc_html__('Bookmark', 'ivdirectories' ),
	'dirwpnonce'=> wp_create_nonce("listing"),
	'comment'=> esc_html__('Please put your comment', 'ivdirectories' ),
	'wp_iv_directories_URLPATH'=> wp_iv_directories_URLPATH,
	) );
?>
<?php
	
	get_footer();
?>
