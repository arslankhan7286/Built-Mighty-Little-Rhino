<?php
global $wpdb;			
	$email_body = get_option( 'iv_directories_signup_email');
	$signup_email_subject = get_option( 'iv_directories_signup_email_subject');			
					
		$admin_mail = get_option('admin_email');	
		if( get_option( 'admin_email_iv_directories' )==FALSE ) {
			$admin_mail = get_option('admin_email');						 
		}else{
			$admin_mail = get_option('admin_email_iv_directories');								
		}						
		$wp_title = get_bloginfo();
	
	$user_info = get_userdata( $user_id);	
					
	

				
	// Email for Admin		
				
	
	$email_body = str_replace("[user_name]", $user_info->display_name, $email_body);
	$email_body = str_replace("[iv_member_user_name]", $user_info->display_name, $email_body);
	$email_body = str_replace("[iv_member_password]", $userdata['user_pass'], $email_body);	
			
	$cilent_email_address =$user_info->user_email;
					
	
			
	$auto_subject=  $signup_email_subject; 
							
	$headers = array("From: " . $wp_title . " <" . $admin_mail . ">", "Content-Type: text/html");
	$h = implode("\r\n", $headers) . "\r\n";
	wp_mail($cilent_email_address, $auto_subject, $email_body, $h);
			

					
		// Send Mailchimp
	if(get_option('iv_directories_mailchimp_api_key')!=""){						
			$firstname='';
			$lastname='';
			$words= array();
			if(isset($data_a['iv_member_fname'])){
				if(isset($data_a['iv_member_fname'])){
					$firstname = $data_a['iv_member_fname'];
				}
				if(isset($data_a['iv_member_lname'])){
					$lastname = $data_a['iv_member_lname'];
				}									
				
			}else{
				if(isset($data_a['iv_member_user_name'])){
					$firstname = $data_a['iv_member_user_name'];
				}
			}	
							
			if( ! class_exists('MailChimp' ) ) {
				include(wp_iv_directories_DIR . '/inc/MailChimp.php');
			}
			$iv_mailchimp_api_key='';
			if( get_option( 'iv_directories_mailchimp_api_key' )==FALSE ) {
				$iv_mailchimp_api_key = get_option('iv_directories_mailchimp_api_key');						 
			}else{
				$iv_mailchimp_api_key = get_option('iv_directories_mailchimp_api_key');								
			}
			$iv_directories_mailchimp_confirmation='yes';
			if( get_option( 'iv_directories_mailchimp_confirmation' )==FALSE ) {
				$iv_directories_mailchimp_confirmation = get_option('iv_directories_mailchimp_confirmation');						 
			}else{
				$iv_directories_mailchimp_confirmation = get_option('iv_directories_mailchimp_confirmation');								
			}
			
			$api = new MailChimp($iv_mailchimp_api_key);
			$list_id=get_option('iv_directories_mailchimp_list');
			
			$api->post("lists/$list_id/members", [
				'email_address' => $cilent_email_address,
				'status'        => 'subscribed',
			]);
			
			
	}		
			
	// End Send Mailchimp
	
	

