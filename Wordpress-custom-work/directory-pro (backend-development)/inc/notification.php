<?php
global $wpdb;	
		
	$email_body = get_option( 'iv_directories_contact_email');
	$contact_email_subject =  esc_html__( 'New listing added', 'ivdirectories' ); 
	$message =  esc_html__( 'New listing added to your site. You can publish or delete from your site dashboard', 'ivdirectories' ); 
	$admin_mail = get_option('admin_email');
	$wp_title = get_bloginfo();
	
	$dir_id=$newpost_id;	
	
	$dir_detail= get_post($dir_id); 
	$dir_title= '<a href="'.get_edit_post_link($dir_id).'">'.$dir_detail->post_title.'</a>';		
	// Email for Client	
		
	
	$email_body = str_replace("[iv_member_sender_email]", '', $email_body);
	$email_body = str_replace("New Message", $contact_email_subject, $email_body); 
	$email_body = str_replace("Sender Email:",'', $email_body); 
	$email_body = str_replace("Your Directory",'New Listing', $email_body); 
	
	
	$email_body = str_replace("[iv_member_directory]", $dir_title, $email_body);
	$email_body = str_replace("[iv_member_message]", $message, $email_body);	
	
				
	$auto_subject= $contact_email_subject; 
	
	$headers = array("From: " . $wp_title . " <" . $admin_mail . ">", "Reply-To: ".$admin_mail  ,"Content-Type: text/html");
	
	
	$h = implode("\r\n", $headers) . "\r\n";
	wp_mail($admin_mail, $auto_subject, $email_body, $h);	
	
	
