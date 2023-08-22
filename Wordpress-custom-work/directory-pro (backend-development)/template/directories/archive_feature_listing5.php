<?php
	$dir_top_img=get_option('dir_top_img');
	if($dir_top_img==""){$dir_top_img='yes';}
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
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
	$city_mq, $country_mq, $zip_mq,$features,$area_mq,
	);
	$feature_listing = new WP_Query( $feature_listing_all ); 
	if ( $feature_listing->have_posts() ) : 
	while ( $feature_listing->have_posts() ) : $feature_listing->the_post();
	$dir_data=array();
	$id = get_the_ID();
	$dir_data['featured']='Featured';
	$dir_data['id']=$id;
	$dir_data['link']=get_permalink($id);
	$dir_data['title']=$post->post_title;
	$feature_img='';
	if(has_post_thumbnail()){
		$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
		if($feature_image[0]!=""){
			$feature_img =$feature_image[0];
		}
		}else{
		$feature_img= $this->get_dirpro_listing_default_image();
	}
	$dir_data['imageURL']=  $feature_img;
	$cat_arr=array();
	$currentCategory = $main_class->eplisting_get_categories_caching($id,$directory_url);
	$cat_name2='';
	if(isset($currentCategory[0]->slug)){
		$cat_name2 = $currentCategory[0]->name;
		$cc=0;
		foreach($currentCategory as $c){
			$cat_arr[]=ucfirst($c->name);
		}
	}
	$dir_data['category']=$cat_arr;
	$dir_data['dir_top_img']=$dir_top_img; 
	if($dir5_review_show=='yes'){
		$dir_data['review_show']='yes';
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
		$dir_data['avg_review']=$avg_review;
		if($avg_review>=1){
			if($avg_review==1){
				$dir_data['review']=(int)$avg_review.esc_html__(' Star','ivdirectories');
			}
			if($avg_review>1){
				$dir_data['review']=(int)$avg_review.esc_html__(' Stars','ivdirectories');
			}
			}else{
		}
		}else{
		$dir_data['review_show']='no';
	}
	$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
	if($listing_contact_source==''){$listing_contact_source='new_value';}
	$dir_data['phone']='';
	if($listing_contact_source=='new_value'){
		$dir_data['phone']=	get_post_meta($id,'phone',true);
		$dir_data['email']=get_post_meta($id,'email',true);	
		}else{		
		$post_author_id= $feature_listing->post->post_author;
		$agent_info = get_userdata($post_author_id);
		if(get_user_meta($post_author_id,'phone',true)!=""){
			$dir_data['phone']=	get_user_meta($post_author_id,'phone',true);
		}
		$dir_data['email']=$agent_info->user_email;	
	}
	
	$dirpro_call_button=get_post_meta($id,'dirpro_call_button',true);
	if($dirpro_call_button==""){$dirpro_call_button='yes';}
	if($dir_style5_call=="yes" AND $dirpro_call_button=='yes'){
		$dir_data['call_button']='yes';	
		if($dir_data['phone']==''){$dir_data['call_button']='no';}		
		}else{
		$dir_data['call_button']='no';
	}	
	
	$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
	if($dirpro_email_button==""){$dirpro_email_button='yes';}
	if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
		$dir_data['email_button']='yes';						
		}else{
		$dir_data['email_button']='no';
	}	
	
	$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
	if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
	if($dir_style5_sms=="yes" AND $dirpro_sms_button=='yes'){
		$dir_data['sms_button']='yes';	
		if($dir_data['phone']==''){$dir_data['sms_button']='no';}	
		}else{
		$dir_data['sms_button']='no';
	}	
	$loc_arr=array();
	$dir_data['address']= get_post_meta($id,'address',true);
	if(get_post_meta($id,'area',true)!=""){							
		$dir_data['area']= get_post_meta($id,'area',true);								
	}	
	$dir_data['city']=ucwords( get_post_meta($id,'city',true));
	if(trim(get_post_meta($id,'city',true))!=""){	
		array_push( $loc_arr, ucwords(trim(get_post_meta($id,'city',true))) );
	}	
	$dir_data['state']= get_post_meta($id,'state',true);
	$dir_data['zipcode']= ucfirst(get_post_meta($id,'postcode',true));
	$dir_data['country']= get_post_meta($id,'country',true);					
	if (!empty($loc_arr)) {
		$dir_data['location']=  $loc_arr;
	}
	// Tag***
	
	if($dir_tags=='yes'){
		$tag_array= $tag_array=$currentCategory = $main_class->eplisting_get_tag_caching($id,$directory_url);
		}else{
		$tag_array= wp_get_post_tags( $id );
	}
	$tagg_arr=array();
	foreach($tag_array as $one_tag){
		$tagg_arr[]=ucfirst($one_tag->name);
	}
	if (!empty($tagg_arr)) {
		$dir_data['feature']=  $tagg_arr;
	}
	array_push( $dirs_data, $dir_data );
	endwhile; 	
endif; ?>