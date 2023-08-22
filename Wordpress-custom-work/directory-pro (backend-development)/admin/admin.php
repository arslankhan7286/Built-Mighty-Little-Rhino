<?php
	if (!defined('ABSPATH')) {
		exit;
	}
	/**
		* The Admin Panel and related tasks are handled in this file.
	*/
	if (!class_exists('wp_iv_directories_Admin')) {
		class wp_iv_directories_Admin {
			static $pages = array();
			public function __construct() {
				add_action('admin_menu', array(&$this, 'admin_menu'));
				add_action('admin_print_scripts', array(&$this, 'load_scripts'));
				add_action('admin_print_styles', array(&$this, 'load_styles'));					
				add_action('wp_ajax_iv_directories_get_settings', array(&$this, 'iv_directories_get_settings'));					
				add_action('wp_ajax_iv_directories_save_package', array(&$this, 'iv_directories_save_package'));
				add_action('wp_ajax_iv_directories_update_package', array(&$this, 'iv_directories_update_package'));
				add_action('wp_ajax_iv_directories_update_paypal_settings', array(&$this, 'iv_directories_update_paypal_settings'));
				add_action('wp_ajax_iv_directories_update_stripe_settings', array(&$this, 'iv_directories_update_stripe_settings'));		
				add_action('wp_ajax_iv_directories_create_coupon', array(&$this, 'iv_directories_create_coupon'));
				add_action('wp_ajax_iv_directories_update_coupon', array(&$this, 'iv_directories_update_coupon'));		
				add_action('wp_ajax_iv_directories_update_payment_setting', array(&$this, 'iv_directories_update_payment_setting'));
				add_action('wp_ajax_iv_directories_update_page_setting', array(&$this, 'iv_directories_update_page_setting'));
				add_action('wp_ajax_iv_directories_update_email_setting', array(&$this, 'iv_directories_update_email_setting'));
				add_action('wp_ajax_iv_directories_update_mailchamp_setting', array(&$this, 'iv_directories_update_mailchamp_setting'));
				add_action('wp_ajax_iv_directories_update_package_status', array(&$this, 'iv_directories_update_package_status'));
				add_action('wp_ajax_iv_directories_gateway_settings_update', array(&$this, 'iv_directories_gateway_settings_update'));
				add_action('wp_ajax_iv_directories_update_account_setting', array(&$this, 'iv_directories_update_account_setting'));		
				add_action('wp_ajax_iv_directories_update_protected_setting', array(&$this, 'iv_directories_update_protected_setting'));
				add_action('wp_ajax_iv_directories_import_demo_xml', array(&$this, 'iv_directories_import_demo_xml'));			
				add_action('wp_ajax_iv_property_update_city_image', array(&$this, 'iv_property_update_city_image'));			
				add_action('wp_ajax_iv_directories_update_map_marker', array(&$this, 'iv_directories_update_map_marker'));	
				add_action('wp_ajax_iv_directories_update_vip_image', array(&$this, 'iv_directories_update_vip_image'));
				add_action('wp_ajax_iv_directories_update_default_image', array(&$this, 'iv_directories_update_default_image'));
				add_action('wp_ajax_iv_directories_update_cate_image', array(&$this, 'iv_directories_update_cate_image'));
				add_action('wp_ajax_iv_directories_update_user_settings', array(&$this, 'iv_directories_update_user_settings'));			
				add_action('wp_ajax_iv_directories_update_profile_fields', array(&$this, 'iv_directories_update_profile_fields'));
				add_action('wp_ajax_iv_directories_update_dir_fields', array(&$this, 'iv_directories_update_dir_fields'));
				add_action('wp_ajax_iv_directories_import_data', array(&$this, 'iv_directories_import_data'));
				add_action('wp_ajax_iv_update_dir_setting', array(&$this, 'iv_update_dir_setting'));			
				add_action('wp_ajax_iv_update_dir_cpt_save', array(&$this, 'iv_update_dir_cpt_save'));
				add_action( 'init', array(&$this, 'iv_directories_payment_post_type') );			
				add_filter( 'manage_edit-iv_payment_columns', array(&$this, 'set_custom_edit_iv_payment_columns')  );
				add_action( 'manage_iv_payment_posts_custom_column' ,  array(&$this, 'custom_iv_payment_column')  , 10, 2 );	
				
				add_action( 'manage_directorypro_message_posts_custom_column' , array($this,'directorypro_custom_directorypro_message_column' ));
				add_filter( 'manage_edit-directorypro_message_columns',  array($this,'directorypro_set_custom_edit_directorypro_message_columns' ), 10, 2);
			
				$this->action_hook();
				wp_admin_notifications::load();
			}
			// Hook into the 'init' action
			public function iv_directories_payment_post_type() {
				$args = array(
				'description' => 'iv_directories Payment Post Type',
				'show_ui' => true,   
				'exclude_from_search' => true,
				'labels' => array(
				'name'=> 'Payment History',
				'singular_name' => 'iv_payment',							 
				'edit' => 'Edit Payment History',
				'edit_item' => 'Edit Payment History',							
				'view' => 'View Payment History',
				'view_item' => 'View Payment History',
				'search_items' => 'Search ',
				'not_found' => 'No  Found',
				'not_found_in_trash' => 'No Found in Trash',
				),
				'public' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => 'flase',
				'hiearchical' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields'),							
				);
				register_post_type( 'iv_payment', $args );
			}
			public function iv_directories_update_map_marker(){					
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'map-image' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				if(isset($_REQUEST['category_id'])){
					$category_id=sanitize_text_field($_REQUEST['category_id']);	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('_cat_map_marker_'.$category_id,$attachment_id);
				}
				echo json_encode('success');
				exit(0);
			}
			
			public function iv_directories_update_default_image(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'vipimage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
				update_option('default_image_attachment_id',$attachment_id);					
				echo json_encode('success');
				exit(0);			
			}
			public function iv_directories_update_vip_image(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'vipimage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
				update_option('vip_image_attachment_id',$attachment_id);					
				echo json_encode('success');
				exit(0);			
			}
			
			public function directorypro_set_custom_edit_directorypro_message_columns($columns) {				
				$columns['Message'] = esc_html__('Message','jobboard');
				$columns['email'] = esc_html__('Email','jobboard');
				$columns['phone'] = esc_html__('Phone','jobboard');		
				return $columns;
			}
			public function directorypro_custom_directorypro_message_column( $column ) {
				global $post;
				switch ( $column ) {
					case 'Message' :		
						echo esc_html($post->post_content);
					break; 
					case 'phone' :			
						echo get_post_meta($post->ID,'from_phone',true);  
					break;
					case 'email' :
						echo get_post_meta($post->ID,'from_email',true);  
					break;
					
					
				}
			}	
			public function iv_directories_update_cate_image(){	
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'cat-image' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				if(isset($_REQUEST['category_id'])){
					$category_id=sanitize_text_field($_REQUEST['category_id']);	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('_cate_main_image_'.$category_id,$attachment_id);
				}
				echo json_encode('success');
				exit(0);
			}
			public function set_custom_edit_iv_payment_columns($columns) {
				$columns['title']='Package Name'; 
				$columns['User'] = 'User Name';
				$columns['Member'] = 'User ID';				
				$columns['Amount'] ='Amount';
				return $columns;
			}
			public function custom_iv_payment_column( $column, $post_id ) {
				global $post;
				switch ( $column ) {
					case 'User' :							
					if(isset($post->post_author) ){
						$user_info = get_userdata( $post->post_author);
						if($user_info!='' ){
							echo  $user_info->user_login ;
						}
					}
					break; 
					case 'Member' :
					echo esc_html($member_no=$post->post_author); 
					break;
					case 'Amount' :
					echo esc_html($post->post_content); 
					break;
				}
			}
			/**
				* Menus in the wp-admin sidebar
			*/
			public function admin_menu() {
				add_menu_page('WP iv_directories', 'Directory Pro Settings', 'manage_options', 'wp-iv_directories', array(&$this, 'menu_hook'),'dashicons-portfolio',4 );
				self::$pages['wp-iv_directories-package-all'] = add_submenu_page('wp-iv_directories', 'Package', 'Package', 'manage_options', 'wp-iv_directories-package-all', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_directories-coupons-form'] = add_submenu_page('wp-iv_directories', 'WP iv_directories Create', 'Coupons', 'manage_options', 'wp-iv_directories-coupons-form', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_directories-payment-setting'] = add_submenu_page('wp-iv_directories', 'WP iv_directories Settings', 'Payment Gateways', 'manage_options', 'wp-iv_directories-payment-settings', array(&$this, 'menu_hook'));
				add_submenu_page('wp-iv_directories', 'WP iv_directories', 'Payment  History', 'manage_options',  'edit.php?post_type=iv_payment');
				self::$pages['wp-iv_user-directory-admin'] = add_submenu_page('wp-iv_directories', 'WP iv_directories directory-admin', 'User Setting', 'manage_options', 'wp-iv_user-directory-admin', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_directories-settings'] = add_submenu_page('wp-iv_directories', 'WP iv_directories Settings', 'Settings', 'manage_options', 'wp-iv_directories-settings', array(&$this, 'menu_hook'));
				self::$pages['wp-iv_directories-profile-fields'] = add_submenu_page('', 'WP iv_directories profile-fields', '', 'manage_options', 'wp-iv_directories-profile-fields', array(&$this, 'profile_fields_setting'));
				self::$pages['wp-iv_directories-package-create'] = add_submenu_page('', 'WP iv_directories package', '', 'manage_options', 'wp-iv_directories-package-create', array(&$this, 'package_create_page'));
				self::$pages['wp-iv_directories-package-update'] = add_submenu_page('', 'WP iv_directories package', '', 'manage_options', 'wp-iv_directories-package-update', array(&$this, 'package_update_page'));
				self::$pages['wp-iv_directories-coupon-create'] = add_submenu_page('', 'WP iv_directories coupon', '', 'manage_options', 'wp-iv_directories-coupon-create', array(&$this, 'coupon_create_page'));
				self::$pages['wp-iv_directories-coupon-update'] = add_submenu_page('', 'WP iv_directories coupon', '', 'manage_options', 'wp-iv_directories-coupon-update', array(&$this, 'coupon_update_page'));
				self::$pages['wp-iv_directories-payment-paypal'] = add_submenu_page('', 'WP iv_directories Payment setting', '', 'manage_options', 'wp-iv_directories-payment-paypal', array(&$this, 'paypal_update_page'));
				self::$pages['wp-iv_directories-payment-authorize'] = add_submenu_page('', 'WP iv_directories Payment setting', '', 'manage_options', 'wp-iv_directories-payment-authorize', array(&$this, 'authorize_update_page'));
				self::$pages['wp-iv_directories-payment-stripe'] = add_submenu_page('', 'WP iv_directories Payment setting', '', 'manage_options', 'wp-iv_directories-payment-stripe', array(&$this, 'stripe_update_page'));
				self::$pages['wp-iv_directories-user_update'] = add_submenu_page('', 'WP iv_directories user_update', '', 'manage_options', 'wp-iv_directories-user_update', array(&$this, 'user_update_page'));
			}
			/**
				* Menu Page Router
			*/
			public function menu_hook() {
				$screen = get_current_screen();
				switch ($screen->id) {
					default:
					include ('pages/package_all.php');
					break;	
					case self::$pages['wp-iv_directories-coupons-form']:
					include ('pages/all_coupons.php');
					break;
					case self::$pages['wp-iv_directories-settings']:
					include ('pages/settings.php');
					break;
					case self::$pages['wp-iv_directories-package-all']:							
					include ('pages/package_all.php');
					break;
					case self::$pages['wp-iv_directories-payment-setting']:							
					include ('pages/payment-settings.php');
					break;
					case self::$pages['wp-iv_user-directory-admin']:							
					include ('pages/user_directory_admin.php');
					break;					
				}
			}
			public function  profile_fields_setting (){
				include ('pages/profile-fields.php');
			}
			public function coupon_create_page(){
				include ('pages/coupon_create.php');
			}
			public function coupon_update_page(){
				include ('pages/coupon_update.php');
			}
			public function package_create_page(){
				include ('pages/package_create.php');
			}
			public function package_update_page(){
				include ('pages/package_update.php');
			}
			public function authorize_update_page(){
				include ('pages/authorize_update.php');
			}
			public function paypal_update_page(){
				include ('pages/paypal_update.php');
			}
			public function stripe_update_page(){
				include ('pages/stripe_update.php');
			}
			public function user_update_page(){
				include ('pages/user_update.php');
			}
			/**
				* Page based Script Loader
			*/
			public function load_scripts() {
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_script('jquery-ui-core');
					wp_enqueue_script('jquery-ui-datepicker');
					wp_enqueue_script('iv_directories-script-4', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min.js');
					wp_enqueue_script('iv_directories-script-5', wp_iv_directories_URLPATH . 'admin/files/js/jquery.ui.touch-punch.min.js');	
					wp_enqueue_script('iv_directories-script-1', wp_iv_directories_URLPATH . 'admin/files/js/handlebars.min.js');
				}
			}
			/**
				* Page based Style Loader
			*/
			public function load_styles() {
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_style('wp-iv_directories-style-3', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');	
				}
				wp_enqueue_style('wp-iv_directories-style-2', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
			}
			/**
				* This function declares the different forms, sections and fields.
			*/
			public function settings_form() {
				register_setting('wp_iv_directories_settings', 'wp_iv_directories_settings', array(&$this, 'validate'));						
				// General Settings
				add_settings_section('general_section', 'General Settings', 'wp_admin_forms::section_description', 'wp_iv_directories_general_section');
				add_settings_field('text_field', 'Text Field', 'wp_admin_forms::textbox', 'wp_iv_directories_general_section', 'general_section', array('id' => 'text_field', 'text' => '', 'settings' => 'wp_iv_directories_settings'));
				add_settings_field('checkbox_field', 'Checkbox Field', 'wp_admin_forms::checkbox', 'wp_iv_directories_general_section', 'general_section', array('id' => 'checkbox_field', 'text' => '', 'settings' => 'wp_iv_directories_settings'));
				add_settings_field('textarea_field', 'Textbox Field', 'wp_admin_forms::textarea', 'wp_iv_directories_general_section', 'general_section', array('id' => 'textarea_field', 'settings' => 'wp_iv_directories_settings'));
			}
			/**
				* This functions validate the submitted user input.
				* @param array $var
				* @return array
			*/
			public function validate($var) {
				return $var;
			}
			/**
				* Use this function to execute actions
			*/
			public function action_hook() {
				if (!isset($_GET['action'])) {
					return;
				}
				switch ($_GET['action']) {
				}
			}
			public function iv_directories_save_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppackage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				if(isset($form_data['package_name'])){
					if(strtolower(trim($form_data['package_name']))=='administrator'){
						wp_die( 'Are you cheating:Admin Permission?' );
					}
				}
				global $wpdb;	
				$post_type = 'iv_directories_pack';	
				$last_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = %s ORDER BY `ID` DESC ", $post_type ));	
				$form_number = $last_post_id + 1;
				$role_name='';
				if($form_data['package_name']==""){
					$post_name = 'Package' . $form_number;
					$role_name = $post_name;
					}else{
					$post_name = $form_data['package_name'] .'-'. $form_number;
					$role_name = $form_data['package_name'];
				}					
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_content= sanitize_textarea_field($form_data['package_feature']); 
				$my_post_form = array('post_title' => wp_strip_all_tags($post_title), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_content,'post_type'=>$post_type, 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($my_post_form);						
				update_post_meta($newpost_id, 'iv_directories_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'iv_directories_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'iv_directories_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_directories_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_recurring', '');
				}
				
				update_post_meta($newpost_id, 'iv_directories_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
				update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
				update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
				update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
				if(isset($form_data['package_enable_trial_period'])){
					update_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', 'no');
				}
				update_post_meta($newpost_id, 'iv_directories_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
				update_post_meta($newpost_id, 'iv_directories_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
				update_post_meta($newpost_id, 'iv_directories_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'iv_directories_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
				}
				// Start User Role
				global $wp_roles;
				$contributor_roles = $wp_roles->get_role('contributor');							
				$role_name_new= str_replace(' ', '_', $role_name);
				$wp_roles->remove_role( $role_name_new );
				$role_display_name = $role_name;						
				$wp_roles->add_role($role_name_new, $role_display_name, array(
				'read' => true, // True allows that capability, False specifically removes it.
				'edit_posts' => true,
				'delete_posts' => true,
				'upload_files' => true //last in array needs no comma!
				));
				update_post_meta($newpost_id, 'iv_directories_package_user_role', $role_name_new);						
				update_post_meta($newpost_id, 'iv_directories_package_max_post_no', sanitize_text_field($form_data['max_pst_no']));				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'iv_directories_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_event'])){
					update_post_meta($newpost_id, 'iv_directories_package_event', sanitize_text_field($form_data['listing_event']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_event', 'no');
				}
				if(isset($form_data['listing_coupon'])){
					update_post_meta($newpost_id, 'iv_directories_package_coupon', sanitize_text_field($form_data['listing_coupon']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_coupon', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'iv_directories_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_video'])){
					update_post_meta($newpost_id, 'iv_directories_package_video', sanitize_text_field($form_data['listing_video']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_video', 'no');
				}
				if(isset($form_data['listing_booking'])){
					update_post_meta($newpost_id, 'iv_directories_package_booking', sanitize_text_field($form_data['listing_booking']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_booking', 'no');
				}
				// End User Role
				// For Stripe Plan Create*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('iv_directories_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_iv_directories_DIR . '/admin/files/init.php');
						$stripe_id = '';
						$post_name2='iv_directories_stripe_setting';
						$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name2 ));
						if ( $post ){
							$stripe_id=$post;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'iv_directories_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':$form_data['package_recurring_cycle_count']);
						$stripe_currency =get_post_meta($stripe_id, 'iv_directories_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;						
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=$form_data['package_recurring_cycle_type'];									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'iv_directories_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'iv_directories_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						\Stripe\Plan::create($stripe_array);
					}	
				}
				// End Stripe Plan Create*****	
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_update_dir_cpt_save(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'dir-url' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				$dir_url =strtolower($form_data['dir_url']);
				$dir_url = str_replace(' ', '', $dir_url);
				if($dir_url==''){
					$dir_url='directories';
				}
				update_option('_iv_directory_url',$dir_url);
				update_option( 'directoryprosinglepage' ,sanitize_text_field($form_data['directoryprosinglepage'])) ;
				
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_update_dir_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'dir-settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				update_option('_dir_load_listing_all',sanitize_text_field($form_data['dir_load_listing_all']));	
				update_option('_dir_approve_publish',sanitize_text_field($form_data['dir_approve_publish']));					    
				update_option('_dir_search_redius',sanitize_text_field($form_data['dir_search_redius']));
				update_option('_dir_claim_show',sanitize_text_field($form_data['dir_claim_show']));
				update_option('_search_button_show',sanitize_text_field($form_data['search_button_show']));
				update_option('_dir_searchbar_show',sanitize_text_field($form_data['dir_searchbar_show']));
				update_option('_dir_map_show',sanitize_text_field($form_data['dir_map_show']));
				update_option('_dir_social_show',sanitize_text_field($form_data['dir_social_show']));	
				update_option('_dir_tag_show',sanitize_text_field($form_data['dir_tag_show']));
				update_option('_dir_contact_show',sanitize_text_field($form_data['dir_contact_show']));
				update_option('_iv_new_badge_day',sanitize_text_field($form_data['iv_new_badge_day']));	
				update_option('_dir_map_api',sanitize_text_field($form_data['dir_map_api']));
				update_option('active_filter',sanitize_text_field($form_data['active_filter']));	
				update_option('_dir_search_keyword',sanitize_text_field($form_data['dir_search_keyword']));
				update_option('eprecaptcha_api',sanitize_text_field($form_data['eprecaptcha_api']));
	
				
			
				update_option('_dir_map_zoom',sanitize_text_field($form_data['dir_map_zoom']));
				update_option('directories_dir_map',sanitize_text_field($form_data['dir_single_map_show']));
				update_option('_dir_single_review_show',sanitize_text_field($form_data['dir_single_review_show']));						
				update_option('dir_contact_form',sanitize_text_field($form_data['dir_contact_form']));
				update_option('dir_form_shortcode',sanitize_text_field($form_data['dir_form_shortcode']));
				update_option('directories_top_slider',sanitize_text_field($form_data['directories_top_slider']));
				update_option('directories_top_4_icons',sanitize_text_field($form_data['property_top_4_icons']));
				update_option('_dir_share_show',sanitize_text_field($form_data['dir_share_show']));
				update_option('_dir_tag_show',sanitize_text_field($form_data['dir_tag_show']));
				update_option('_similar_directories',sanitize_text_field($form_data['similar_directories']));						
				update_option('dir_opening_time',sanitize_text_field($form_data['dir_opening_time']));
				update_option('_dir_features',sanitize_text_field($form_data['dir_features']));
				update_option('directories_dir_video',sanitize_text_field($form_data['dirpro_videos']));
				update_option('directories_details',sanitize_text_field($form_data['directories_details']));
				update_option('_contact_form_modal',sanitize_text_field($form_data['contact_form_modal']));
				update_option('dir_style_4top_filter',sanitize_text_field($form_data['dir_style_4top_filter']));	
				update_option('_dir_tags',sanitize_text_field($form_data['dir_tags']));						
				
				update_option('_dir_popup',sanitize_text_field($form_data['dir_popup']));						
				update_option('dir_style5_perpage',sanitize_text_field($form_data['dir_style5_perpage']));						
				update_option('dir5_background_color',sanitize_text_field($form_data['dir5_background_color']));
				update_option('dir5_content_color',sanitize_text_field($form_data['dir5_content_color']));						
				update_option('dir_style5_call',sanitize_text_field($form_data['dir_style5_call']));
				update_option('dir_style5_email',sanitize_text_field($form_data['dir_style5_email']));
				update_option('dir_top_img',sanitize_text_field($form_data['dir_top_img']));
				update_option('dir_style5_sms',sanitize_text_field($form_data['dir_style5_sms']));
				update_option('dir5_review_show',sanitize_text_field($form_data['dir5_review_show']));						
												
				update_option( 'dir_facet_cat_title' ,sanitize_text_field($form_data['dir_facet_cat_title']));				
				update_option( 'dircontact_form_message' ,sanitize_text_field($form_data['dircontact_form_message']));
				update_option( 'user_can_publish' ,sanitize_text_field($form_data['user_can_publish']));
				
				
				if(isset($form_data['dir_facet_cat_show'])){
					update_option( 'dir_facet_cat_show' ,sanitize_text_field($form_data['dir_facet_cat_show']));
					}else{
					update_option( 'dir_facet_cat_show' ,'no') ; 						
				}
				update_option( 'dir_facet_location_title' ,sanitize_text_field($form_data['dir_facet_location_title']));
				if(isset($form_data['dir_facet_location_show'])){
					update_option( 'dir_facet_location_show' ,sanitize_text_field($form_data['dir_facet_location_show']));
					}else{
					update_option( 'dir_facet_location_show' ,'no') ; 						
				}
				update_option( 'dir_facet_area_title' ,sanitize_text_field($form_data['dir_facet_area_title']));
				if(isset($form_data['dir_facet_area_show'])){
					update_option( 'dir_facet_area_show' ,sanitize_text_field($form_data['dir_facet_area_show']));
					}else{
					update_option( 'dir_facet_area_show' ,'no') ; 						
				}
				update_option( 'dir_facet_features_title' ,sanitize_text_field($form_data['dir_facet_features_title']));
				if(isset($form_data['dir_facet_features_show'])){
					update_option( 'dir_facet_features_show' ,sanitize_text_field($form_data['dir_facet_features_show']));
					}else{
					update_option( 'dir_facet_features_show' ,'no') ; 						
				}
				update_option( 'dir_facet_review_title' ,sanitize_text_field($form_data['dir_facet_review_title']));
				if(isset($form_data['dir_facet_review_show'])){
					update_option( 'dir_facet_review_show' ,sanitize_text_field($form_data['dir_facet_review_show']));
					}else{
					update_option( 'dir_facet_review_show' ,'no') ; 						
				}
				update_option( 'dir_facet_zipcode_title' ,sanitize_text_field($form_data['dir_facet_zipcode_title']));
				if(isset($form_data['dir_facet_zipcode_show'])){
					update_option( 'dir_facet_zipcode_show' ,sanitize_text_field($form_data['dir_facet_zipcode_show']));
					}else{
					update_option( 'dir_facet_zipcode_show' ,'no') ; 						
				}
				update_option( 'dir_facet_state_title' ,sanitize_text_field($form_data['dir_facet_state_title']));
				if(isset($form_data['dir_facet_state_show'])){
					update_option( 'dir_facet_state_show' ,sanitize_text_field($form_data['dir_facet_state_show']));
					}else{
					update_option( 'dir_facet_state_show' ,'no') ; 						
				}
				update_option( 'dir_facet_country_title' ,sanitize_text_field($form_data['dir_facet_country_title']));
				if(isset($form_data['dir_facet_country_show'])){
					update_option( 'dir_facet_country_show' ,sanitize_text_field($form_data['dir_facet_country_show']));
					}else{
					update_option( 'dir_facet_country_show' ,'no') ; 						
				}
				update_option( 'grid_col1500' ,sanitize_text_field($form_data['grid_col1500'])) ; 
				update_option( 'grid_col1100' ,sanitize_text_field($form_data['grid_col1100'])) ; 
				update_option( 'grid_col768' ,sanitize_text_field($form_data['grid_col768'])) ; 
				update_option( 'grid_col480' ,sanitize_text_field($form_data['grid_col480'])) ; 
				update_option( 'grid_col375' ,sanitize_text_field($form_data['grid_col375'])) ; 
				update_option( '_archive_template' ,sanitize_text_field($form_data['option_archive'])) ;
				update_option( 'directoryprosinglepage' ,sanitize_text_field($form_data['directoryprosinglepage'])) ;
				
				update_option( 'listing_single_custompage' ,sanitize_text_field($form_data['listing_single_custompage'])) ;
				
				
				update_option( 'directories_slider_autorun' ,sanitize_text_field($form_data['directories_slider_autorun'])) ;
				update_option( '_contact_info' ,sanitize_text_field($form_data['contact_info'])) ;
				update_option( 'directories_layout_single' ,sanitize_text_field($form_data['directories_layout_single'])) ;
				update_option( 'directory_top_1_title' ,sanitize_text_field($form_data['directory_top_1_title'])) ;
				update_option( 'directory_top_1_icon' ,sanitize_text_field($form_data['directory_top_1_icon'])) ;
				update_option( 'directory_top_2_title' ,sanitize_text_field($form_data['directory_top_2_title'])) ;
				update_option( 'directory_top_2_icon' ,sanitize_text_field($form_data['directory_top_2_icon'])) ;
				update_option( 'directory_top_3_title' ,sanitize_text_field($form_data['directory_top_3_title'])) ;
				update_option( 'directory_top_3_icon' ,sanitize_text_field($form_data['directory_top_3_icon'])) ;						
				update_option( 'directory_top_4_title' ,sanitize_text_field($form_data['directory_top_4_title'])) ;
				update_option( 'directory_top_4_icon' ,sanitize_text_field($form_data['directory_top_4_icon'])) ;
				update_option( '_dir_listing_sort' ,sanitize_text_field($form_data['dir_listing_sort'])) ;
				
				
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_property_update_city_image(){
				if(isset($_REQUEST['city_id'])){					
					if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'city-image' ) ) {
						wp_die( 'Are you cheating: wpnonce?' );
					}
					if ( !current_user_can( 'manage_options' ) ) {
						wp_die( 'Are you cheating: user permission?' );
					}
					$city_id=strtolower(sanitize_text_field($_REQUEST['city_id']));	
					$attachment_id=sanitize_text_field($_REQUEST['attachment_id']);	 	
					update_option('city_main_image_'.$city_id,$attachment_id);
				}
				echo json_encode('success');
				exit(0);
			}
			public function iv_directories_update_profile_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'dir-profile' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				update_option('iv_directories_profile_menu', '' );
				$opt_array2= array();
				if(isset($form_data['menu_title'])){
					$max = sizeof($form_data['menu_title']);
					for($i = 0; $i < $max;$i++)
					{	
						if($form_data['menu_title'][$i]!="" AND $form_data['menu_link'][$i]!=""){
							$opt_array2[$form_data['menu_title'][$i]]=$form_data['menu_link'][$i];
							$form_data['menu_title'][$i];
						}
					}	
					
					update_option('iv_directories_profile_menu', $opt_array2 );
				}
				// remove menu******
				if(isset($form_data['listinghome'])){
					update_option( '_iv_directories_menu_listinghome' ,$form_data['listinghome']); 
					}else{
					update_option( '_iv_directories_menu_listinghome' ,'no') ; 
				}
				if(isset($form_data['mylevel'])){
					update_option( '_iv_directories_mylevel' ,$form_data['mylevel']); 
					}else{
					update_option( '_iv_directories_mylevel' ,'no') ; 
				}
				if(isset($form_data['menusetting'])){
					update_option( '_iv_directories_menusetting' ,$form_data['menusetting']); 
					}else{
					update_option( '_iv_directories_menusetting' ,'no') ; 
				}
				if(isset($form_data['menuallpost'])){
					update_option( '_iv_directories_menuallpost' ,$form_data['menuallpost']); 
					}else{
					update_option( '_iv_directories_menuallpost' ,'no') ; 
				}
				if(isset($form_data['menunewlisting'])){
					update_option( '_iv_directories_menunewlisting' ,$form_data['menunewlisting']); 
					}else{
					update_option( '_iv_directories_menunewlisting' ,'no') ; 
				}
				if(isset($form_data['menufavorites'])){
					update_option( '_iv_directories_menufavorites' ,$form_data['menufavorites']); 
					}else{
					update_option( '_iv_directories_menufavorites' ,'no') ; 
				}
				if(isset($form_data['menuinterested'])){
					update_option( '_iv_directories_menuinterested' ,$form_data['menuinterested']); 
					}else{
					update_option( '_iv_directories_menuinterested' ,'no') ; 
				}
				echo json_encode(array('code' => 'Update Successfully'));
				exit(0);
			}
			public function iv_directories_import_data(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'demo-import' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				include ('pages/import-demo.php');
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_directories_update_dir_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'admin' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();				
				$opt_type_array= array();
				$opt_type_value_array= array();
				$opt_type_roles_array= array();			
								
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						$opt_array[sanitize_text_field($form_data['meta_name'][$i])]=sanitize_text_field($form_data['meta_label'][$i]);	
						
						if(isset($form_data['field_type'][$i])){
							$opt_type_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type'][$i]);
						}else{
							$opt_type_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_type_value'][$i])){
							$opt_type_value_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type_value'][$i]);
						}else{
							$opt_type_value_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_user_role'.$i])){							
							$opt_type_roles_array[$form_data['meta_name'][$i]]=$form_data['field_user_role'.$i];
						}else{
							$opt_type_roles_array[$form_data['meta_name'][$i]]='';
						}	
					}
				}
									
				update_option('iv_directories_fields', $opt_array );
				update_option('iv_membership_field_type', $opt_type_array );
				update_option('iv_membership_field_type_value', $opt_type_value_array );
				update_option('iv_membership_field_type_roles', $opt_type_roles_array );
				
				update_option( 'dir_addedit_awardtitle' ,sanitize_text_field($form_data['dir_addedit_awardtitle'])); 
				update_option( 'dir_addedit_award' ,sanitize_text_field($form_data['dir_addedit_award']));
				update_option( 'dir_addedit_contactinfotitle' ,sanitize_text_field($form_data['dir_addedit_contactinfotitle'])); 
				update_option( 'dir_addedit_contactinfo' ,sanitize_text_field($form_data['dir_addedit_contactinfo']));					
				update_option( 'dir_addedit_contactustitle' ,sanitize_text_field($form_data['dir_addedit_contactustitle'])); 
				update_option( 'dir_contact_form' ,sanitize_text_field($form_data['dir_contact_form'])); 					
				update_option( 'dir_form_shortcode' ,sanitize_text_field($form_data['dir_form_shortcode'])); 					
				update_option( 'dir_addedit_claimtitle' ,sanitize_text_field($form_data['dir_addedit_claimtitle'])); 
				update_option( 'dir_claim_form' ,sanitize_text_field($form_data['dir_claim_form'])); 
				update_option( 'dir_claimform_shortcode' ,sanitize_text_field($form_data['dir_claimform_shortcode']));					
				update_option( 'dir_addedit_videostitle' ,sanitize_text_field($form_data['dir_addedit_videostitle'])); 
				update_option( 'dir_addedit_videos' ,sanitize_text_field($form_data['dir_addedit_videos'])); 					
				update_option( 'dir_addedit_socialprofilestitle' ,sanitize_text_field($form_data['dir_addedit_socialprofilestitle'])); 
				update_option( 'dir_addedit_socialprofiles' ,sanitize_text_field($form_data['dir_addedit_socialprofiles'])); 
				update_option( 'dir_addedit_additionalinfotitle' ,sanitize_text_field($form_data['dir_addedit_additionalinfotitle'])); 
				update_option( 'dir_addedit_additionalinfo' ,sanitize_text_field($form_data['dir_addedit_additionalinfo'])); 
				update_option( 'dir_addedit_openingtimetitle' ,sanitize_text_field($form_data['dir_addedit_openingtimetitle'])); 
				update_option( 'dir_addedit_openingtime' ,sanitize_text_field($form_data['dir_addedit_openingtime'])); 
				update_option( 'dir_addedit_eventtitle' ,sanitize_text_field($form_data['dir_addedit_eventtitle'])); 
				update_option( 'dir_addedit_event' ,sanitize_text_field($form_data['dir_addedit_event'])); 
				update_option( 'dir_addedit_bookingtitle' ,sanitize_text_field($form_data['dir_addedit_bookingtitle'])); 
				update_option( 'dir_addedit_booking' ,sanitize_text_field($form_data['dir_addedit_booking'])); 
				update_option( 'dir_addedit_dealcoupontitle' ,sanitize_text_field($form_data['dir_addedit_dealcoupontitle'])); 
				update_option( 'dir_addedit_dealcoupon' ,sanitize_text_field($form_data['dir_addedit_dealcoupon'])); 
				echo json_encode(array('code' => 'Update Successfully'));
				exit(0);
			}
			public function iv_directories_update_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppackage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['package_name'])){
					if(strtolower(trim($form_data['package_name']))=='administrator'){
						wp_die( 'Are you cheating:Admin Permission?' );
					}
				}
				$post_content="";
				global $wpdb;			
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_id=sanitize_text_field($form_data['package_id']);
				$newpost_id=$post_id;
				$post_content= sanitize_textarea_field($form_data['package_feature']); 	
				$post_type = 'iv_directories_pack';	
				$my_post = array(
				'ID'           	=> $post_id,						 
				'post_title'		=> $post_title,
				'post_content'	=> $post_content,
				);
				wp_update_post( $my_post );
				update_post_meta($newpost_id, 'iv_directories_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'iv_directories_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'iv_directories_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'iv_directories_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
				}
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_directories_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_recurring', '');
				}
				
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'iv_directories_package_recurring', sanitize_text_field($form_data['package_recurring']));
					update_post_meta($newpost_id, 'iv_directories_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
					update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
					update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
					update_post_meta($newpost_id, 'iv_directories_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
					if(isset($form_data['package_enable_trial_period'])){
						update_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
						}else{
						update_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', 'no');
					}
					update_post_meta($newpost_id, 'iv_directories_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
					update_post_meta($newpost_id, 'iv_directories_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
					update_post_meta($newpost_id, 'iv_directories_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				}					
				update_post_meta($newpost_id, 'iv_directories_package_max_post_no', sanitize_text_field($form_data['max_pst_no']));				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'iv_directories_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_event'])){
					update_post_meta($newpost_id, 'iv_directories_package_event', sanitize_text_field($form_data['listing_event']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_event', 'no');
				}
				if(isset($form_data['listing_coupon'])){
					update_post_meta($newpost_id, 'iv_directories_package_coupon', sanitize_text_field($form_data['listing_coupon']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_coupon', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'iv_directories_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_video'])){
					update_post_meta($newpost_id, 'iv_directories_package_video', sanitize_text_field($form_data['listing_video']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_video', 'no');
				}
				if(isset($form_data['listing_booking'])){
					update_post_meta($newpost_id, 'iv_directories_package_booking', sanitize_text_field($form_data['listing_booking']));
					}else{
					update_post_meta($newpost_id, 'iv_directories_package_booking', 'no');
				}
				// For Stripe*****
				// For Stripe Plan Edit*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('iv_directories_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_iv_directories_DIR . '/admin/files/init.php');
						$stripe_id='';
						$post_name2='iv_directories_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = %s",$post_name2) );				
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'iv_directories_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':$form_data['package_recurring_cycle_count']);
						$stripe_currency =get_post_meta($stripe_id, 'iv_directories_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;					
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=$form_data['package_recurring_cycle_type'];									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'iv_directories_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'iv_directories_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'iv_directories_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						try {
							$p = \Stripe\Plan::retrieve($p_name);							
						} catch (Exception $e) {
								$api_error = $e->getMessage();
						}
						if(empty($api_error)){
							$p->delete();
						}
						try {
							\Stripe\Plan::create($stripe_array);
						} catch (Exception $e) {
								print_r($e);
						}	
						
					}	
				}
				// End Stripe Plan Create*****	
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_directories_update_paypal_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppaypal' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;	
				$post_name='iv_directories_paypal_setting';						
				$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name ));
				if ( !$post ){					
					$post_type 		= 'iv_payment_setting';
					$my_post_form 	= array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'Paypal Setting','post_type'=> $post_type,'post_status' => 'draft', );
					$newpost_id 	= wp_insert_post($my_post_form);
					}else{
					$newpost_id= $post;
				}
				update_post_meta($newpost_id, 'iv_directories_paypal_mode', sanitize_text_field($form_data['paypal_mode']));
				update_post_meta($newpost_id, 'iv_directories_paypal_username', sanitize_text_field($form_data['paypal_username']));
				update_post_meta($newpost_id, 'iv_directories_paypal_api_password', sanitize_text_field($form_data['paypal_api_password']));
				update_post_meta($newpost_id, 'iv_directories_paypal_api_signature', sanitize_text_field($form_data['paypal_api_signature']));
				update_post_meta($newpost_id, 'iv_directories_paypal_api_currency', sanitize_text_field($form_data['paypal_api_currency']));			
				update_option('_iv_directories_api_currency', sanitize_text_field($form_data['paypal_api_currency']) );			
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_directories_update_stripe_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppaypal' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_name='iv_directories_stripe_setting';
				$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $post_name ));
				if ( !$post ){
					$post_type = 'iv_payment_setting';
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'stripe Setting', 'post_type'=>$post_type ,'post_status' => 'draft',);
					$newpost_id = wp_insert_post($my_post_form);
					}else{
					$newpost_id= $post;
				}				
				update_post_meta($newpost_id, 'iv_directories_stripe_mode', sanitize_text_field($form_data['stripe_mode']));
				update_post_meta($newpost_id, 'iv_directories_stripe_live_secret_key', sanitize_text_field($form_data['secret_key']));						
				update_post_meta($newpost_id, 'iv_directories_stripe_live_publishable_key', sanitize_text_field($form_data['publishable_key']));			
				update_post_meta($newpost_id, 'iv_directories_stripe_secret_test', sanitize_text_field($form_data['secret_key_test']));						
				update_post_meta($newpost_id, 'iv_directories_stripe_publishable_test', sanitize_text_field($form_data['stripe_publishable_test']));						
				update_post_meta($newpost_id, 'iv_directories_stripe_api_currency', sanitize_text_field($form_data['stripe_api_currency']));
				update_option('_iv_directories_api_currency', sanitize_text_field($form_data['stripe_api_currency'] ));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_directories_create_coupon() {					
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;	
				$post_name=sanitize_text_field($form_data['coupon_name']);
				$post_type = 'iv_coupon';
				$coupon_data = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_name, 'post_status' => 'draft', 'post_author' => get_current_user_id(), 'post_type'=>$post_type);
				$newpost_id = wp_insert_post($coupon_data);
				if($form_data['coupon_count']==""){
					$coupon_limit='99999';
					}else{
					$coupon_limit=sanitize_text_field($form_data['coupon_count']);
				}
				$pac='';
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids'];}
				$pck_ids =implode(",",$pac);						
				update_post_meta($newpost_id, 'iv_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_coupon_limit',$coupon_limit);
				update_post_meta($newpost_id, 'iv_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'iv_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function iv_directories_update_coupon() {
				parse_str($_POST['form_data'], $form_data);						
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating?' );
				}
				$post_content="";
				global $wpdb;	
				$post_title=sanitize_text_field($form_data['coupon_name']);
				$post_id=sanitize_text_field($form_data['coupon_id']);
				$newpost_id=$post_id;
				$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_title='%s' WHERE id='%d' LIMIT 1",$post_title, $post_id);
				$wpdb->query($query);
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids'];}
				$pck_ids =implode(",",$pac);						
				update_post_meta($newpost_id, 'iv_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_coupon_limit', sanitize_text_field($form_data['coupon_count']));
				update_post_meta($newpost_id, 'iv_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'iv_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function	iv_directories_update_price_table_template(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppackage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$profile_style='';
				if(isset($_POST['price-tab-style'])){
					$profile_style=sanitize_text_field($_POST['price-tab-style']);
					update_option('iv_directories_price-table', $profile_style); 
				}
				echo json_encode(array('code' => 'Update successfully'));
				exit(0);
			}		
			public function  iv_directories_update_payment_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=sanitize_text_field($form_data['iv_terms']);		
				}
				$terms_detail=$form_data['terms_detail'];
				$iv_coupon='';
				if(isset($form_data['iv_coupon'])){
					$iv_coupon=sanitize_text_field($form_data['iv_coupon']);
				}
				update_option('iv_directories_payment_terms_text', $terms_detail );
				update_option('iv_directories_payment_terms', $iv_terms );	
				update_option('_iv_directories_payment_coupon', $iv_coupon );
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_import_demo_xml(){
				require (wp_iv_directories_DIR .'/admin/pages/importer/wordpress-importer.php');
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_update_protected_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['active_visibility'])){
					$active_visibility=$form_data['active_visibility'];
					}else{
					$active_visibility='no';
				}		
				update_option('_iv_directories_active_visibility', $active_visibility );
				if(isset($form_data['login_message'])){
					update_option('_iv_visibility_login_message', $form_data['login_message'] );
				}
				if(isset($form_data['visitor_message'])){
					update_option('_iv_visibility_visitor_message', $form_data['visitor_message'] );
				}		
				update_option('_iv_visibility_serialize_role', $form_data);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function  iv_directories_update_page_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=$form_data['iv_terms'];
				}
				$pricing_page=sanitize_text_field($form_data['pricing_page']);
				$signup_page=sanitize_text_field($form_data['signup_page']);
				$profile_page=sanitize_text_field($form_data['profile_page']);
				$profile_public=sanitize_text_field($form_data['profile_public']);
				$thank_you=sanitize_text_field($form_data['thank_you_page']);
				$login=sanitize_text_field($form_data['login_page']);
				update_option('_iv_directories_price_table', $pricing_page); 
				update_option('_iv_directories_registration', $signup_page); 
				update_option('_iv_directories_profile_page', $profile_page);
				update_option('_iv_directories_profile_public',$profile_public);
				update_option('_iv_directories_thank_you_page',$thank_you); 
				update_option('_iv_directories_login_page',$login); 
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_update_email_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$signup_form_id=$form_data['signup_form_id'];
				update_option( 'iv_directories_signup_email_subject',$form_data['iv_directories_signup_email_subject']);
				update_option( 'iv_directories_signup_email',$form_data['signup_email_template']);
				update_option( 'iv_directories_forget_email_subject',$form_data['forget_email_subject']);
				update_option( 'iv_directories_forget_email',$form_data['forget_email_template']);
				update_option('admin_email_iv_directories', $form_data['iv_directories_admin_email']); 
				update_option('iv_directories_order_client_email_sub', $form_data['iv_directories_order_email_subject']); 
				update_option('iv_directories_order_client_email', $form_data['order_client_email_template']); 
				update_option('iv_directories_order_admin_email_sub', $form_data['iv_directories_order_admin_email_subject']);
				update_option('iv_directories_order_admin_email', $form_data['order_admin_email_template']); 			
				update_option( 'iv_directories_reminder_email_subject',$form_data['iv_directories_reminder_email_subject']);
				update_option( 'iv_directories_reminder_email',$form_data['reminder_email_template']);		 
				update_option('iv_directories_reminder_day', $form_data['iv_directories_reminder_day']); 
				update_option( 'iv_directories_contact_email_subject',$form_data['contact_email_subject']);
				update_option( 'iv_directories_contact_email',$form_data['message_email_template']);				
				$bcc_message=(isset($form_data['bcc_message'])? $form_data['bcc_message']:'' );		
				update_option( '_iv_directories_bcc_message',$bcc_message);
				///////
				update_option( 'iv_directories_refund_email_subject',$form_data['refund_email_subject']);
				update_option( 'iv_directories_refund_email',$form_data['iv_directories_refund_email']);				
				$refund_message_link=(isset($form_data['refund_message_link'])? $form_data['refund_message_link']:'' );					
				update_option( '_iv_directories_refund_message_link',$refund_message_link);
				update_option( 'iv_directories_deal_email_subject',$form_data['deal_email_subject']);
				update_option( 'iv_directories_deal_email',$form_data['iv_directories_deal_email']);		
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_update_mailchamp_setting (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('iv_directories_mailchimp_api_key', sanitize_text_field($form_data['iv_directories_mailchimp_api_key'])); 
				update_option('iv_directories_mailchimp_confirmation', sanitize_text_field($form_data['iv_directories_mailchimp_confirmation'])); 
				if(isset($form_data['iv_directories_mailchimp_list'])){
					update_option('iv_directories_mailchimp_list', sanitize_text_field($form_data['iv_directories_mailchimp_list'])); 
				}
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_update_package_status (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppackage' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				global $wpdb;
				$package_id_update=trim($_POST['status_id']);
				$package_current_status=trim($_POST['status_current']);
				if($package_current_status=="pending"){
					$package_st='draft';
					$pac_msg='Active';
					}else{
					$package_st='pending';
					$pac_msg='Inactive';
				}
				$wpdb->query($wpdb->prepare($query));
				$my_post = array(
				'ID'           => $package_id_update,
				'post_status'   => $package_st,
				);
				wp_update_post( $my_post );
				echo json_encode(array("code" => "success","msg"=>$pac_msg,"current_st"=>$package_st));
				exit(0);
			}
			public function iv_directories_gateway_settings_update(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'eppayment' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$payment_gateway = sanitize_text_field($_POST['payment_gateway']);
				global $wpdb;
				update_option('iv_directories_payment_gateway', $payment_gateway);
				// For Stripe Plan Create*****	
				$iv_gateway = get_option('iv_directories_payment_gateway');
				if($iv_gateway=='stripe'){
					$stripe_id='';
					$post_name2='iv_directories_stripe_setting';
					$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name2 ));
					if ( $post ){
						$stripe_id=$post;
					}
					$i=0;
					include(wp_iv_directories_DIR . '/admin/files/init.php');
					$stripe_mode=get_post_meta( $stripe_id,'iv_directories_stripe_mode',true);	
					if($stripe_mode=='test'){
						$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_secret_test',true);	
						}else{
						$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_live_secret_key',true);	
					}	
					$stripe_currency =get_post_meta($stripe_id, 'iv_directories_stripe_api_currency',true);
					\Stripe\Stripe::setApiKey($stripe_api);
					$query = new WP_Query(array(
					'post_type' => 'iv_directories_pack',
					'posts_per_page' => -1,
					));							
					while ($query->have_posts()) {
						$query->the_post();
						$post_id = get_the_ID();			
						$package_recurring=get_post_meta( $post_id,'iv_directories_package_recurring',true);	
						if($package_recurring=='on'){
							$interval_count= get_post_meta( $post_id,'iv_directories_package_recurring_cycle_count',true);
							$interval_count= ($interval_count=="" ? '1':$interval_count);
							$stripe_array=array();						
							$p_name = $query->post->post_name;
							$stripe_array['id']= $p_name;
							$stripe_array['product']=array('name' => $p_name);
							$stripe_array['amount']=get_post_meta( $post_id,'iv_directories_package_recurring_cost_initial',true) * 100;
							$stripe_array['interval']=get_post_meta( $post_id,'iv_directories_package_recurring_cycle_type',true);									
							$stripe_array['interval_count']=$interval_count;
							$stripe_array['currency']=$stripe_currency;
							$trial=get_post_meta($post_id, 'iv_directories_package_enable_trial_period', true);
							if($trial=='yes'){
								$trial_type = get_post_meta( $post_id,'iv_directories_package_recurring_trial_type',true);
								$trial_cycle_count =get_post_meta($post_id, 'iv_directories_package_trial_period_interval', true);
								switch ($trial_type) {
									case 'year':
									$periodNum =  365 * 1;
									break;
									case 'month':
									$periodNum =  30 * $trial_cycle_count;
									break;
									case 'week':
									$periodNum = 7 * $trial_cycle_count;
									break;
									case 'day':
									$periodNum = 1 * $trial_cycle_count;
									break;
								}									
								$stripe_array['trial_period_days']=$periodNum;
							}																	
							try {
								\Stripe\Plan::retrieve($p_name);
								} catch (Exception $e) {
								if($stripe_array['amount']>0){
									\Stripe\Plan::create($stripe_array);
								}
								
							}
						}	
					}
				}	
				// End Stripe Plan Create*****	
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully: Your current gateway is ".$payment_gateway));
				exit(0);
			}
			public function iv_directories_update_user_settings(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'userupdate' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $wpdb;
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}	
				$user_id=sanitize_text_field($form_data['user_id']);
				$user_id=sanitize_text_field($form_data['user_id']);
				if($form_data['exp_date']!=''){
					$exp_d=date('Y-m-d', strtotime($form_data['exp_date']));	 
					update_user_meta($user_id, 'iv_directories_exprie_date',$exp_d); 
				}		
				update_user_meta($user_id, 'iv_directories_payment_status', sanitize_text_field($form_data['payment_status']));	
				update_user_meta($user_id, 'iv_directories_package_id',sanitize_text_field($form_data['package_sel'])); 
				$user = new WP_User( $user_id );
				$user->set_role(sanitize_text_field($form_data['user_role']));
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
		}
	}
$wp_iv_directories_admin = new wp_iv_directories_Admin();