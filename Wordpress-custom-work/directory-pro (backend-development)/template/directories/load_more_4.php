<?php
	$dir_style5_perpage=get_option('dir_style5_perpage');
	if($dir_style5_perpage==""){$dir_style5_perpage=20;}
	$main_class = new wp_iv_directories;
	
	$dirs_data =array();
	$directory_url=get_option('_iv_directory_url');					
	if($directory_url==""){$directory_url='directories';}
	
	$dirs_data =array();$post_data='';$loadmorebutton='show';							
	$args = array(
	'post_type' => $directory_url, // enter your custom post type
	'paged' => sanitize_text_field($_POST['paged']), 
	'orderby' => 'title',
	'order' => 'ASC',
	'post_status' => 'publish',
	'posts_per_page' => $dir_style5_perpage,
	);
	
	$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
	
	if( isset($form_data[$directory_url.'-category'])){
		if($form_data[$directory_url.'-category']!=''){
			$postcats = $form_data[$directory_url.'-category'];
			$args[$directory_url.'-category']=$postcats;							
		}		
	}
	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($form_data['dirsearchtype'])){
		$dirsearch=sanitize_text_field($form_data['dirsearch']);
		$dirsearchtype=sanitize_text_field($form_data['dirsearchtype']);
		$locationtype=sanitize_text_field($form_data['locationtype']);
		$location=sanitize_text_field($form_data['location']);
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
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivdirectories');}
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
	if(isset($form_data['dir_city']) AND $form_data['dir_city']!=''){							
		$city_mq2 = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => sanitize_text_field($form_data['dir_city']),
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq='';
	
	
	
	$args['meta_query'] = array(
	$city_mq, $country_mq, $zip_mq,$area_mq,$city_mq2, 
	);		
	
	$dir_style5_sms=get_option('dir_style5_sms');
	if($dir_style5_sms==""){$dir_style5_sms='yes';}
	$active_filter=get_option('active_filter');
	if($active_filter==""){$active_filter='category';}
	$moreload_query = new WP_Query( $args ); 
	
	if ( $moreload_query->have_posts() ) : 
	
	while ( $moreload_query->have_posts() ) : $moreload_query->the_post();
	
	$id = get_the_ID();	
	if(get_post_meta($id, 'dirpro_featured', true)!='featured'){		
		$gallery_ids=get_post_meta($id ,'image_gallery_ids',true);
		$gallery_ids_array = array_filter(explode(",", $gallery_ids));
		
		$dir_data['link']=get_the_permalink($id);
		$dir_data['title']=get_the_title($id); 				
		$dir_data['lat']=get_post_meta($id,'latitude',true);
		$dir_data['lng']=get_post_meta($id,'longitude',true);
		if(get_post_meta($id,'latitude',true)!=''){$ins_lat=get_post_meta($id,'latitude',true);}
		if(get_post_meta($id,'longitude',true)!=''){$ins_lng=get_post_meta($id,'longitude',true);}
		$dir_data['address']=get_post_meta($id,'address',true); 
		$dir_data['image']= '';
		$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail' ); 
		if(isset($feature_image[0])){ 			
			$dir_data['image']=  $feature_image[0];
		}
		$dir_data['marker_icon']=wp_iv_directories_URLPATH."/assets/images/map-marker/map-marker.png";				
		$currentCategoryId='';
		$terms =get_the_terms($id, $directory_url."-category");				
		if($terms!=""){
			foreach ($terms as $termid) {  
				if(isset($termid->term_id)){
					$currentCategoryId= $termid->term_id; 
				}					  
			} 
		}
		$marker = get_option('_cat_map_marker_'.$currentCategoryId,true);
		if($marker!=''){
			$image_attributes = wp_get_attachment_image_src( $marker ); // returns an array
			if( $image_attributes ) {
				
				$dir_data['marker_icon']= $image_attributes[0];
			}							
		}
		if($dir_data['lat']!='' AND $dir_data['lng']!='' ){				
			array_push( $dirs_data, $dir_data );
		}
		
		
		
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
		
		
		// VIP image***************	
		$vip_image='';	$have_vip_badge='';
		
		$post_author_id= get_post_field( 'post_author', $id );
		
		$author_package_id=get_user_meta($post_author_id, 'iv_directories_package_id', true); 
		$have_vip_badge= get_post_meta($author_package_id,'iv_directories_package_vip_badge',true);
		$exprie_date= strtotime (get_user_meta($post_author_id, 'iv_directories_exprie_date', true));	
		$current_date=time();
		if($have_vip_badge=='yes'){
			if($exprie_date >= $current_date){ 	
				if(get_option('vip_image_attachment_id')!=""){
					$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'));
					if(isset($vip_img[0])){									
						$vip_image='<img style="width:30px;"   src="'.$vip_img[0] .'">';
					}							
					}else{
					$vip_image='<img style="width:35px;"   src="'. wp_iv_directories_URLPATH."/assets/images/vipicon.png".'">';
				}
				
			}	
		}	
		
		$review_text='';
		$dir_single_review_show=get_option('dir5_review_show');	
		if($dir_single_review_show==""){$dir_single_review_show='no';}
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
			$review_text='';						
			
			if($avg_review >=.75 ){ 
				$review_text=$review_text.'<i class="fas fa-star off-white"></i>'; 
				}elseif($avg_review >=.1){ 
				$review_text=$review_text.'<i class="fas fa-star-half-alt  half-off-white"></i>';
				}else{ 
				$review_text=$review_text.'<i class="far fa-star off-white"></i>';
			} 
			
			if($avg_review >=1.75 ){ 
				$review_text=$review_text.'<i class="fas fa-star off-white"></i>';
				}elseif($avg_review >=1.1){ 
				$review_text=$review_text.'<i class="fas fa-star-half-alt  half-off-white"></i>';
				}else{ 
				$review_text=$review_text.'<i class="far fa-star off-white"></i>';
			} 
			
			if($avg_review >=2.75 ){ 
				$review_text=$review_text.'<i class="fas fa-star off-white"></i>'; 
				}elseif($avg_review >=2.1){ 
				$review_text=$review_text.'<i class="fas fa-star-half-alt  half-off-white"></i>';
				}else{ 
				$review_text=$review_text.'<i class="far fa-star off-white"></i>';
			}
			
			if($avg_review >=3.75 ){ 
				$review_text=$review_text.'<i class="fas fa-star off-white"></i>'; 
				}elseif($avg_review >=3.1){ 
				$review_text=$review_text.'<i class="fas fa-star-half-alt  half-off-white"></i>';
				}else{ 
				$review_text=$review_text.'<i class="far fa-star off-white"></i>';
			}
			
			if($avg_review >=4.75 ){ 
				$review_text=$review_text.'<i class="fas fa-star off-white"></i>'; 
				}elseif($avg_review >=4.1){ 
				$review_text=$review_text.'<i class="fas fa-star-half-alt  half-off-white"></i>';
				}else{ 
				$review_text=$review_text.'<i class="far fa-star off-white"></i>';
			}
			
			
			$review_text=$review_text.'<div class="cbp-l-grid-projects-review" style="display:none">'. $avg_review.'</div>';
			
		}	
		
		
		$post_data=$post_data.'<div class="cbp-item '. esc_attr($cat_slug).'"><div class="card card-border-round bg-white">';
		
		$dir_top_img=get_option('dir_top_img');
		if($dir_top_img==""){$dir_top_img='yes';}
		if($dir_top_img =='yes'){							
			$post_data=$post_data.'<div class="card-img-container">
			<a href="'.get_the_permalink($id).'"><img src="'.esc_url($feature_img).'" class="card-img-top"></a>
			</div>';
		}		
		
		
		if(get_post_meta($id,'dirpro_featured',true)=="featured"){ 
			$post_data=$post_data.'<div class="overlay_content1">
			<p>'. esc_html__("Featured", "ivdirectories" ).'</p>
			</div>';
			
		}								
		
		$post_data=$post_data.'
		<div class="card-body px-4 mt-0 card-body-min-height">
		<p class="title mt-3 p-0">
		<a href="'. get_permalink($id).'" class="m-0 p-0 cbp-l-grid-projects-title">'.get_the_title($id).'</a>
		</p>
		<p class="card-text p-0 mt-2 address"><i class="fas fa-map-marker-alt"></i> '. get_post_meta($id,'address',true).' '. get_post_meta($id,'postcode',true).' '. get_post_meta($id,'city',true).' '.get_post_meta($id,'country',true).'</p>';
		
		
		$post_data=$post_data.'
		<p class="mt-2 categories"><i class="fas fa-bookmark"></i> '.ucfirst($cat_name2).' </p>
		<p class="d-flex mt-1"><span class="review">'.$review_text.'</span></p>';
		
		$phone='';
		$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
		if($listing_contact_source==''){$listing_contact_source='new_value';}
		if($listing_contact_source=='new_value'){
			$phone=	get_post_meta($id,'phone',true);									
			}else{
			$post_author_id= $moreload_query->post->post_author;
			
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
		
	
		$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
		if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
		
		if($dir_style5_sms=="yes" AND $dirpro_sms_button=='yes'){
			$sms_button='yes';
			if($phone==''){$sms_button='no';}
			}else{
			$sms_button='no';
		}
		$smsbody =esc_html__('I would like to inquire about the listing. The listing can be found on the site :','ivdirectories').site_url();
		
		$post_data=$post_data.'<p class="client-contact">';
		
		
		if($call_button=='yes'){
			$post_data=$post_data.'<span class="number" id="'.$id.'"><i class="fas fa-phone-volume"></i>'.esc_html($phone).'</span>
			<span class="mcall"><a href="tel:'.esc_html($phone).'">'.esc_html__( 'Call', 'ivdirectories' ).'</a></span>';
		}
		
		if($email_button=='yes'){ 
			$post_data=$post_data.' <span class="email"  onclick="call_popup('.$id.')">'. esc_html__( 'Email', 'ivdirectories' ).'</span>';
		}
		
		if($sms_button=='yes'){
			$post_data=$post_data.'<span class="sms d-block d-md-none"><a href="sms:'.esc_html($phone).'?&body='.esc_html($smsbody).'">'. esc_html__( 'SMS', 'ivdirectories' ).'</a></span>';
			
		}
		
		$post_data=$post_data.'</p><p class="clientContactDetails d-flex justify-content-between justify-content-md-start">
		</p>';
		
		
		$post_data=$post_data.'</div> 
		</div>			
		<div class="cbp-l-grid-projects-date" style="display:none">'. esc_html(strtotime($moreload_query->post->post_date)).'</div>
		</div>';
	}		
	
	endwhile; 
	
	else:
	$loadmorebutton='hide';
	
	endif;		
	
