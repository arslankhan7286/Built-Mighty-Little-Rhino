<?php
global $current_user;
$directory_url=get_option('_iv_directory_url');					
if($directory_url==""){$directory_url='directories';}
$main_class = new wp_iv_directories;
			
$csv =  get_attached_file($csv_file_id) ;

$eppro_total_row = floatval( get_option( 'eppro_total_row' ));	

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

$done_status='not-done';

$row=$row_start;
$row_max=$row+5;
$iii=1;
if (($handle = fopen($csv, 'r' )) !== FALSE) {					
	$top_header = fgetcsv($handle,1000, ",");
	while (($data = fgetcsv($handle)) !== FALSE) {
		
		if($iii>=$row  AND $row<$row_max){	
			$i=0;
			
			$post_id=0; $post_data=array();
			foreach($data as $one_col){
						
				if(in_array("ID", $top_header) OR in_array("Id", $top_header) OR in_array("id", $top_header)){
					// Check ID 
					if(strtolower($top_header[$i])=='id'){		
						if(trim($one_col)!=''){
							$post_check=get_post($one_col);													
							if ( isset($post_check->post_type) and $post_check->post_type==$directory_url ) {								
								$post_id=$one_col;	
							}else{
								$post_id=0;								
							}							
						}
					}else{						
						$top_header_i=str_replace (' ','-', $top_header[$i]);						
						$post_data[$form_data[$top_header_i]]=$one_col;
					}					
				}else{					
					$top_header_i=str_replace (' ','-', $top_header[$i]);					
					$post_data[$form_data[$top_header_i]]=$one_col;					
					$post_id=0;
					
				}
				$i++;
			}
			
							
			if($post_id==0){
				// Insert Post
				$my_post=array();
				$my_post['post_title'] = sanitize_text_field($post_data['post_title']);
				$my_post['post_content'] =$post_data['post_content'];
				$my_post['post_author'] =$current_user->ID;
				$my_post['post_date'] =date("Y-m-d H:i:s");
				$my_post['post_status'] = 'publish';	
				$my_post['post_type'] = $directory_url;		
				$post_id= wp_insert_post( $my_post );				
			}else{
				$my_post=array();				
				$my_post['ID'] = $post_id;
				$my_post['post_title'] = sanitize_text_field($post_data['post_title']);
				$my_post['post_content'] =$post_data['post_content'];
				$my_post['post_status'] = 'publish';	
				$my_post['post_type'] = $directory_url;		
				wp_update_post($my_post);
			}
			
			if(isset($post_data['category'])) {  
				$post_cat_arr =explode(",",$post_data['category']) ;
				wp_set_object_terms( $post_id, $post_cat_arr, $directory_url.'-category');
			}
			if(isset($post_data['tag'])) { 
				$post_tag_arr =explode(",",$post_data['tag']) ;
				wp_set_object_terms( $post_id, $post_tag_arr, $directory_url.'_tag');
			}
			if(isset($post_data['featured-image'])){
				$main_class->eppro_upload_featured_image($post_data['featured-image'] ,$post_id);				
			}			
			if(isset($post_data['image_gallery_urls'])) {				
			
				update_post_meta($post_id, 'image_gallery_urls', $post_data['image_gallery_urls']); 	
			}
			if(isset($post_data['address'])){
				update_post_meta($post_id, 'address', sanitize_textarea_field($post_data['address'])); 				
			}				
			if(isset($post_data['area'])){
				update_post_meta($post_id, 'area', sanitize_textarea_field($post_data['area'])); 				
			}
			if(isset($post_data['latitude'])){
				update_post_meta($post_id, 'latitude', sanitize_textarea_field($post_data['latitude'])); 				
			}
			if(isset($post_data['longitude'])){
				update_post_meta($post_id, 'longitude', sanitize_textarea_field($post_data['longitude'])); 				
			}
			if(isset($post_data['city'])){
				update_post_meta($post_id, 'city', sanitize_textarea_field($post_data['city'])); 				
			}
			if(isset($post_data['postcode'])){
				update_post_meta($post_id, 'postcode', sanitize_textarea_field($post_data['postcode'])); 				
		}
			
			if(isset($post_data['state'])){
				update_post_meta($post_id, 'state', sanitize_textarea_field($post_data['state'])); 				
			}
			if(isset($post_data['country'])){
				update_post_meta($post_id, 'country', sanitize_textarea_field($post_data['country'])); 				
			}
			if(isset($post_data['phone'])){
				update_post_meta($post_id, 'phone', sanitize_textarea_field($post_data['phone'])); 				
			}
			if(isset($post_data['contact-email'])){
				update_post_meta($post_id, 'contact-email', sanitize_email($post_data['contact-email'])); 				
			}
			if(isset($post_data['contact_web'])){
				update_post_meta($post_id, 'contact_web', $post_data['contact_web']); 				
			}
			if(isset($post_data['youtube-video'])){
				update_post_meta($post_id, 'youtube', $post_data['youtube-video']); 				
			}
			if(isset($post_data['facebook'])){
				update_post_meta($post_id, 'facebook', sanitize_textarea_field($post_data['facebook'])); 				
			}
			if(isset($post_data['linkedin'])){
				update_post_meta($post_id, 'linkedin', sanitize_textarea_field($post_data['linkedin'])); 				
			}
			if(isset($post_data['vimeo'])){
			update_post_meta($post_id, 'vimeo', $post_data['vimeo']); 				
			}
									
			if(sizeof($default_fields )){			
				foreach( $default_fields as $field_key => $field_value ) { 
					update_post_meta($post_id, $field_key, $post_data[$field_key] );							
				
				}					
			}
			
			////////// Update meta			
					
			$row++;
			update_option( 'eppro_current_row',$row);	
			
		}		
		
		$iii++;	
 }
}

$row_done=$row_max;
if($row_max >=$eppro_total_row){$done_status='done';}

fclose($handle);


?>