<?php
global $current_user; global $wpdb;	
	$directory_url=get_option('_iv_directory_url');					
	if($directory_url==""){$directory_url='directories';}
		
	$post_names = array('La Salle','BURJ AL ARAB','Top Hat Home Services','Jeunesse Spa','THE PENINSULA SPA','The Five Fields','Aqua Shard');
	$post_cat = array('	Bars','Beauty & Spas','Arts & Entertainment','Cafe','Fashion','Food','Home Service','Hotel','Restaurant');	
	$post_tag = array('Free WiFi','Indoor Pool','Laundry','Private Garden','Swing Pool','Weddings','Good for Groups','Has TV','Hot waitresses','Parking','SPA','Takes Reservations','Waiter Service','Wheelchair Accessible','Accepts Credit Cards');
	$post_city = array('New York ','new york ','dubai','Dubai','Bretagne','New South Wales','London');	
	$post_aear = array('Central Brooklyn','Chelsea','Midtown','Shoreditch  Upper Manhattan');
	
$i=0;	
	foreach($post_names as $one_post){ 
	
	$my_post = array();
	
	$my_post['post_title'] = $one_post;
	$my_post['post_content'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, ';	
	
	$my_post['post_status'] = 'publish';	
	$my_post['post_type'] = $directory_url;	
	
	$newpost_id= wp_insert_post( $my_post );		
	
		
	$rand_keys = array_rand($post_cat, 2);	
	
	$new_post_arr=array();
	$new_post_arr[]=$post_cat[$rand_keys[0]];
	$new_post_arr[]=$post_cat[$rand_keys[1]];
	
	wp_set_object_terms( $newpost_id, $new_post_arr, $directory_url.'-category');	
	
	
	$default_fields = array();
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
	if(sizeof($default_fields )){			
		foreach( $default_fields as $field_key => $field_value ) { 
			update_post_meta($newpost_id, $field_key, 'lorem ipsum' );							
		
		}					
	}
	$opening_day=array();
	$opening_day['Sunday']='10:00 AM'.'|'.'10:00 PM';	
	$opening_day['Monday']='10:00 AM'.'|'.'10:00 PM';	
	update_post_meta($newpost_id, '_opening_time', $opening_day); 
	
	
	// For Tag Save tag_arr	
	$rand_keys = array_rand($post_tag, 6);	
	$new_post_arr=array();
	$new_post_arr[]=$post_tag[$rand_keys[0]];
	$new_post_arr[]=$post_tag[$rand_keys[1]];
	$new_post_arr[]=$post_tag[$rand_keys[2]];
	$new_post_arr[]=$post_tag[$rand_keys[3]];
	$new_post_arr[]=$post_tag[$rand_keys[4]];
	$new_post_arr[]=$post_tag[$rand_keys[5]];
	
	wp_set_object_terms( $newpost_id, $new_post_arr, $directory_url.'_tag');	
		

	
	
	
	update_post_meta($newpost_id, 'address', '129-133 West 22nd Street'); 
	$rand_keys = array_rand($post_aear, 1);	
	
	update_post_meta($newpost_id, 'area', $post_aear[$rand_keys]); 
	update_post_meta($newpost_id, 'latitude', '40.7427704'); 
	update_post_meta($newpost_id, 'longitude','-73.99455039999998');
	
	
	$rand_keys = array_rand($post_city, 1);		
	update_post_meta($newpost_id, 'city', $post_city[$rand_keys]); 
	 
	update_post_meta($newpost_id, 'postcode', '10011'); 
	update_post_meta($newpost_id, 'country', 'USA'); 
											
	
	update_post_meta($newpost_id, 'phone', '212245-4606'); 
	update_post_meta($newpost_id, 'fax', '212245-4606'); 
	update_post_meta($newpost_id, 'contact-email', 'test@test.com'); 
	update_post_meta($newpost_id, 'contact_web', 'e-plugin.com'); 
	
							
	update_post_meta($newpost_id, 'listing_contact_source', 'new_value'); 	
			
	update_post_meta($newpost_id, 'youtube', 'yvUbza_QQ2c'); 
	
	update_post_meta($newpost_id, 'facebook', 'test'); 
	update_post_meta($newpost_id, 'linkedin', 'test'); 
	update_post_meta($newpost_id, 'twitter', 'test');	
	update_post_meta($newpost_id, 'instagram', 'test');
	update_post_meta($newpost_id, 'youtube_social', 'test');
	
	
	
 
 $i++; 
}
?>