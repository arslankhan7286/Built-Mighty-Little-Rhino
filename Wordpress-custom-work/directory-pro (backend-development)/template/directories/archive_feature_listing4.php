<?php
	$features = array(
		'relation' => 'AND',
			array(
				'key'     => 'dirpro_featured',
				'value'   => 'featured',
				'compare' => '='
			),
		);
	$feature_listing_all['posts_per_page']='-1';
	$feature_listing_all['meta_query'] = array(
		$city_mq, $country_mq, $zip_mq,$city_mq2,
	);
	$dir_style5_email=get_option('dir_style5_email');
	if($dir_style5_email==""){$dir_style5_email='yes';}
$feature_listing = new WP_Query( $feature_listing_all );
 if ( $feature_listing->have_posts() ) :
	while ( $feature_listing->have_posts() ) : $feature_listing->the_post();
			$id = get_the_ID();
			if(get_post_meta($id, 'dirpro_featured', true)=='featured'){
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
						$post_author_id= get_post_field( 'post_author', $id );;
						$author_package_id=get_user_meta($post_author_id, 'iv_directories_package_id', true);
						$have_vip_badge= get_post_meta($author_package_id,'iv_directories_package_vip_badge',true);
						$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_directories_exprie_date', true));
						$current_date=time();
						$vip_image='';
						if($have_vip_badge=='yes'){
							if($exprie_date >= $current_date){
								if(get_option('vip_image_attachment_id')!=""){
										$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'),'large');
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
								$dir_top_img=get_option('dir_top_img');
								if($dir_top_img==""){$dir_top_img='yes';}
								if($dir_top_img =='yes'){
								?>
								<div class="card-img-container">
									<a href="<?php echo get_the_permalink($id);?>"><img src="<?php echo esc_html($feature_img);?>" class="card-img-top"></a>
								</div>
							<?php
								}
							?>
							<div class="card-img-overlay card-img-overlay__img text-white">
									<?php 
									if($have_vip_badge=='yes'){ ?>
										<img style="width:35px;"   src="<?php echo esc_html($vip_image);?>">
									<?php
									}	
									?>
							</div>
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
							<div class="card-body px-4 mt-0 card-body-min-height">
								<p class="title mt-3 p-0">
									<a href="<?php echo get_permalink($id); ?>" class="m-0 p-0 cbp-l-grid-projects-title">
										<?php echo esc_html($post->post_title);?>
									</a>
								</p>
								<p class="card-text p-0 mt-2 address"><i class="fas fa-map-marker-alt"></i> <?php echo get_post_meta($id,'address',true);?> <?php echo get_post_meta($id,'postcode',true);?> <?php echo get_post_meta($id,'city',true);?> <?php echo get_post_meta($id,'country',true);?></p>
								<p class="mt-2 categories"><i class="fas fa-bookmark"></i><?php echo ' '.ucfirst($cat_name2); ?></p>
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
									 <div class="cbp-l-grid-projects-review" style="display:none"><?php echo esc_html($avg_review);?></div>
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
								
								$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
								if($dirpro_email_button==""){$dirpro_email_button='yes';}
								if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
									$email_button='yes';
								}else{
									$email_button='no';
								}
								
								$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
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
		}
	endwhile;
 endif; ?>