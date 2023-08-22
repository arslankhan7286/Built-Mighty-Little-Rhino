<?php

  if (!defined('ABSPATH')) {
  	exit;
	}
  if (!class_exists('wp_iv_directories')) {
		final class wp_iv_directories {
			private static $instance;
			/**
				* The Plug-in version.
				*
				* @var stringiv_property_update_wp_post
			*/
			public $version = "2.3.3";
			/**
				* The minimal required version of WordPress for this plug-in to function correctly.
				*
				* @var string
			*/
			public $wp_version = "3.5";
			public static function instance() {
				if (!isset(self::$instance) && !(self::$instance instanceof wp_iv_directories)) {
					self::$instance = new wp_iv_directories;
				}
				return self::$instance;
			}
			/**
				* Construct and start the other plug-in functionality
			*/
			public function __construct() {
				//
				// 1. Plug-in requirements
				//
				if (!$this->check_requirements()) {
					return;
				}
				//
				// 2. Declare constants and load dependencies
				//
				$this->define_constants();
				$this->load_dependencies();
				//
				// 3. Activation Hooks
				//
				register_activation_hook(__FILE__, array(&$this, 'activate'));
				register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
				register_uninstall_hook(__FILE__, 'wp_iv_directories::uninstall');
				//
				// 4. Load Widget
				//
				add_action('widgets_init', array(&$this, 'register_widget'));
				// Script
				add_action('wp_enqueue_scripts', array($this, 'load_scripts_eplugins'));
				//
				// 5. i18n
				//
				add_action('init', array(&$this, 'i18n'));
				//
				// 6. Actions
				//
				add_action('wp_ajax_iv_directories_check_coupon', array(&$this, 'iv_directories_check_coupon'));
				add_action('wp_ajax_nopriv_iv_directories_check_coupon', array(&$this, 'iv_directories_check_coupon'));
				add_action('wp_ajax_iv_directories_check_package_amount', array(&$this, 'iv_directories_check_package_amount'));
				add_action('wp_ajax_nopriv_iv_directories_check_package_amount', array(&$this, 'iv_directories_check_package_amount'));
				add_action('wp_ajax_iv_directories_update_profile_pic', array(&$this, 'iv_directories_update_profile_pic'));add_action('wp_ajax_iv_directories_update_profile_setting', array(&$this, 'iv_directories_update_profile_setting'));
				add_action('wp_ajax_iv_directories_update_wp_post', array(&$this, 'iv_directories_update_wp_post'));
				add_action('wp_ajax_iv_directories_save_wp_post', array(&$this, 'iv_directories_save_wp_post'));
				add_action('wp_ajax_iv_directories_update_setting_fb', array(&$this, 'iv_directories_update_setting_fb'));
				add_action('wp_ajax_iv_directories_update_setting_hide', array(&$this, 'iv_directories_update_setting_hide'));
				add_action('wp_ajax_iv_directories_update_setting_password', array(&$this, 'iv_directories_update_setting_password'));
				add_action('wp_ajax_iv_directories_check_login', array(&$this, 'iv_directories_check_login'));
				add_action('wp_ajax_nopriv_iv_directories_check_login', array(&$this, 'iv_directories_check_login'));
				add_action('wp_ajax_iv_directories_forget_password', array(&$this, 'iv_directories_forget_password'));
				add_action('wp_ajax_nopriv_iv_directories_forget_password', array(&$this, 'iv_directories_forget_password'));
				add_action('wp_ajax_iv_directories_cancel_stripe', array(&$this, 'iv_directories_cancel_stripe'));
				add_action('wp_ajax_iv_directories_cancel_paypal', array(&$this, 'iv_directories_cancel_paypal'));
				add_action('wp_ajax_iv_directories_profile_stripe_upgrade', array(&$this, 'iv_directories_profile_stripe_upgrade'));
				add_action('wp_ajax_iv_directories_save_favorite', array(&$this, 'iv_directories_save_favorite'));
				add_action('wp_ajax_iv_directories_save_un_favorite', array(&$this, 'iv_directories_save_un_favorite'));
				add_action('wp_ajax_iv_directories_save_note', array(&$this, 'iv_directories_save_note'));
				add_action('wp_ajax_iv_directories_delete_favorite', array(&$this, 'iv_directories_delete_favorite'));
				add_action('wp_ajax_iv_directories_contact_popup', array(&$this, 'iv_directories_contact_popup'));
				add_action('wp_ajax_nopriv_iv_directories_contact_popup', array(&$this, 'iv_directories_contact_popup'));				
				add_action('wp_ajax_iv_directories_contact_popup_listing', array(&$this, 'iv_directories_contact_popup_listing'));
				add_action('wp_ajax_nopriv_iv_directories_contact_popup_listing', array(&$this, 'iv_directories_contact_popup_listing'));
				add_action('wp_ajax_iv_directories_message_delete', array($this, 'iv_directories_message_delete'));

				add_action('wp_ajax_iv_directories_claim_popup', array(&$this, 'iv_directories_claim_popup'));
				add_action('wp_ajax_nopriv_iv_directories_claim_popup', array(&$this, 'iv_directories_claim_popup'));
				add_action('wp_ajax_iv_directories_message_send', array(&$this, 'iv_directories_message_send'));
				add_action('wp_ajax_nopriv_iv_directories_message_send', array(&$this, 'iv_directories_message_send'));
				add_action('wp_ajax_iv_directories_claim_send', array(&$this, 'iv_directories_claim_send'));
				add_action('wp_ajax_nopriv_iv_directories_claim_send', array(&$this, 'iv_directories_claim_send'));
				add_action('wp_ajax_iv_directories_cron_job', array(&$this, 'iv_directories_cron_job'));
				add_action('wp_ajax_nopriv_iv_directories_cron_job', array(&$this, 'iv_directories_cron_job'));
				add_action('wp_ajax_iv_directories_save_user_review', array(&$this, 'iv_directories_save_user_review'));
				add_action('wp_ajax_iv_directories_loadmore', array(&$this, 'iv_directories_loadmore'));
				add_action('wp_ajax_nopriv_iv_directories_loadmore', array(&$this, 'iv_directories_loadmore'));
				add_action('plugins_loaded', array(&$this, 'start'));
				add_action('add_meta_boxes', array(&$this, 'prfx_custom_meta_iv_directories'));
				add_action('wp_ajax_get_unique_dirslider_search_field1', array(&$this, 'get_unique_dirslider_search_field1'));
				add_action('wp_ajax_nopriv_get_unique_dirslider_search_field1', array(&$this, 'get_unique_dirslider_search_field1'));
				add_action('wp_ajax_get_unique_dirslider_search_field2', array(&$this, 'get_unique_dirslider_search_field2'));
				add_action('wp_ajax_nopriv_get_unique_dirslider_search_field2', array(&$this, 'get_unique_dirslider_search_field2'));
				add_action('wp_ajax_finalerp_csv_product_upload', array(&$this, 'finalerp_csv_product_upload'));
				add_action('wp_ajax_save_csv_file_to_database', array(&$this, 'save_csv_file_to_database'));
				add_action('wp_ajax_eppro_get_import_status', array(&$this, 'eppro_get_import_status'));
				add_action( 'save_post', array(&$this, 'iv_directories_meta_save'));
				add_action( 'wp_login', array(&$this, 'check_expiry_date'));
				add_action( 'pre_get_posts',array(&$this, 'iv_restrict_media_library') );
				add_action( 'wp_loaded', array(&$this, 'iv_directories_woocommerce_form_submit') );
				// 7. Shortcode
				add_shortcode('listing_filter', array(&$this, 'listing_filter_func'));
				add_shortcode('iv_directories_display', array(&$this, 'iv_directories_display_func'));
				add_shortcode('iv_directories_price_table', array(&$this, 'iv_directories_price_table_func'));
				add_shortcode('iv_directories_form_wizard', array(&$this, 'iv_directories_form_wizard_func'));
				add_shortcode('iv_directories_profile_template', array(&$this, 'iv_directories_profile_template_func'));
				add_shortcode('iv_directories_profile_public', array(&$this, 'iv_directories_profile_public_func'));
				add_shortcode('iv_directories_login', array(&$this, 'iv_directories_login_func'));
				add_shortcode('iv_directories_user_directory', array(&$this, 'iv_directories_user_directory_func'));
				add_shortcode('listing_carousel', array(&$this, 'listing_carousel_func'));
				add_shortcode('directorypro_cities', array(&$this, 'directorypro_cities_func'));
				add_shortcode('directorypro_categories', array(&$this, 'directorypro_categories_func'));
				add_shortcode('directorypro_category_tree', array(&$this, 'directorypro_cat_with_sub_func'));
				add_shortcode('directorypro_featured', array(&$this, 'directorypro_featured_func'));
				add_shortcode('directorypro_map', array(&$this, 'directorypro_map_func'));
				add_shortcode('directorypro_search', array(&$this, 'directorypro_search_func'));
				add_shortcode('listing_layout_style_4', array(&$this, 'listing_layout_style_4_func'));
				add_shortcode('listing_layout_style_5', array(&$this, 'listing_layout_style_5_func'));
				
				add_shortcode('listing_layout_faceted_grid', array(&$this, 'listing_layout_faceted_grid_func'));
				add_shortcode('listing_layout_grid_left_filter', array(&$this, 'listing_layout_grid_left_filter_func'));
				add_shortcode('listing_layout_grid_a_to_z_filter', array(&$this, 'listing_layout_grid_a_to_z_filter_func'));
				
				add_shortcode('listing_detail', array($this, 'listing_detail_func'));
				
				add_shortcode('slider_search', array(&$this, 'slider_search_func'));
				add_shortcode('iv_directories_reminder_email_cron', array(&$this, 'iv_directories_reminder_email_cron_func'));
				// 8. Filter
				add_filter('comments_template', array(&$this,'no_comments_on_page'),10);
				add_action( 'init', array(&$this, 'iv_dir_post_type') );
				add_action( 'init', array(&$this, 'tr_create_my_taxonomy'));
				add_action( 'init', array(&$this, 'ep_create_my_taxonomy_tags'));
				add_action( 'init', array(&$this, 'iv_directories_paypal_form_submit') );
				add_action( 'init', array(&$this, 'iv_directories_stripe_form_submit') );
				add_action( 'init', array(&$this, 'remove_admin_bar') );
				// For elementor
				add_action( 'init', array($this, 'iv_directories_elementor_file') );
				add_action( 'elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories' ));
				// *** End elementor
				add_filter( 'template_include', array(&$this, 'include_template_function') );
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'epdirpro_plugin_action_links' ) );


			}
			public function load_scripts_eplugins() {
				wp_enqueue_script("jquery");
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-autocomplete');
			}
			public function add_elementor_widget_categories() {

					\Elementor\Plugin::$instance->elements_manager->add_category(
						'directory-pro',
						[
							'title' => __( 'Directory Pro', 'ivdirectories' ),
							'icon'  => 'fa fa-plug',
						]
					);

				}

			/**
				* Define constants needed across the plug-in.
			*/
			private function define_constants() {
				if (!defined('wp_iv_directories_BASENAME')) define('wp_iv_directories_BASENAME', plugin_basename(__FILE__));
				if (!defined('wp_iv_directories_DIR')) define('wp_iv_directories_DIR', dirname(__FILE__));
				if (!defined('wp_iv_directories_FOLDER'))define('wp_iv_directories_FOLDER', plugin_basename(dirname(__FILE__)));
				if (!defined('wp_iv_directories_ABSPATH'))define('wp_iv_directories_ABSPATH', trailingslashit(str_replace("\\", "/", WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)))));
				if (!defined('wp_iv_directories_URLPATH'))define('wp_iv_directories_URLPATH', trailingslashit(plugins_url() . '/' . plugin_basename(dirname(__FILE__))));
				if (!defined('wp_iv_directories_ADMINPATH'))define('wp_iv_directories_ADMINPATH', get_admin_url());
				//for get_stylesheet_directory()
				$filename = get_stylesheet_directory()."/directorypro/";
				if (!file_exists($filename)) {
					if (!defined('wp_iv_directories_template'))define( 'wp_iv_directories_template', wp_iv_directories_ABSPATH.'template/' );
					}else{
					if (!defined('wp_iv_directories_template'))define( 'wp_iv_directories_template', $filename);
				}
			}
			/**
				* Loads PHP files that required by the plug-in
			*/
			public function remove_admin_bar() {
				$iv_hide = get_option( '_iv_directories_hide_admin_bar');
				if (!current_user_can('administrator') && !is_admin()) {
					if($iv_hide=='yes'){
						show_admin_bar(false);
					}
				}
			}
			public function include_template_function( $template_path ) {
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				if ( get_post_type() == $directory_url) {
					if ( is_single() ) {
						$directoryprosinglepage=get_option('directoryprosinglepage');
						if($directoryprosinglepage==''){$directoryprosinglepage='plugintemplate';}
						if($directoryprosinglepage=='elementorpro'){
							if ( !in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {	
									$template_path =  wp_iv_directories_template. 'directories/single-directories.php';
								if ( !in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
									$template_path =  wp_iv_directories_template. 'directories/single-directories.php';
								}
							}
						}elseif($directoryprosinglepage=='custompage'){							
							$template_path =  wp_iv_directories_template. 'directories/single-listing-shortcode-page-data.php'; 
						}else{				
							$template_path =  wp_iv_directories_template. 'directories/single-directories.php';
						}
												
					}
					if( is_tag() || is_category() || is_archive() ){
						$template_path =  wp_iv_directories_template. 'directories/listing-layout.php';
					}
				}
				
				return $template_path;
			}
			public function tr_create_my_taxonomy() {
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				register_taxonomy(
				$directory_url.'-category',
				$directory_url,
				array(
				'label' => esc_html__( 'Categories' ),
				'rewrite' => array( 'slug' => $directory_url.'-category' ),
				'hierarchical' => true,
				'show_in_rest' =>	true,
				)
				);
			}
			public function iv_dir_post_type() {
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				$directory_url_name=ucfirst($directory_url);
				$labels = array(
				'name'                => _x( $directory_url_name, 'Post Type General Name', 'ivdirectories' ),
				'singular_name'       => _x( $directory_url_name, 'Post Type Singular Name', 'ivdirectories' ),
				'menu_name'           => esc_html__( $directory_url_name, 'ivdirectories' ),
				'name_admin_bar'      => esc_html__( $directory_url_name, 'ivdirectories' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'ivdirectories' ),
				'all_items'           => esc_html__( 'All Items', 'ivdirectories' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'ivdirectories' ),
				'add_new'             => esc_html__( 'Add New', 'ivdirectories' ),
				'new_item'            => esc_html__( 'New Item', 'ivdirectories' ),
				'edit_item'           => esc_html__( 'Edit Item', 'ivdirectories' ),
				'update_item'         => esc_html__( 'Update Item', 'ivdirectories' ),
				'view_item'           => esc_html__( 'View Item', 'ivdirectories' ),
				'search_items'        => esc_html__( 'Search Item', 'ivdirectories' ),
				'not_found'           => esc_html__( 'Not found', 'ivdirectories' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ivdirectories' ),
				);
				$args = array(
				'label'               => esc_html__( $directory_url_name, 'ivdirectories' ),
				'description'         => esc_html__( $directory_url_name, 'ivdirectories' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}
				if($dir_tags=='no'){$args['taxonomies']=array(  'post_tag' );}
				register_post_type( $directory_url, $args );
				///******Review**********
				$labels2 = array(
				'name'                => _x( 'Reviews', 'Post Type General Name', 'ivdirectories' ),
				'singular_name'       => _x( 'Reviews', 'Post Type Singular Name', 'ivdirectories' ),
				'menu_name'           => esc_html__( 'Reviews', 'ivdirectories' ),
				'name_admin_bar'      =>esc_html__( 'Reviews', 'ivdirectories' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'ivdirectories' ),
				'all_items'           => esc_html__( 'All Items', 'ivdirectories' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'ivdirectories' ),
				'add_new'             => esc_html__( 'Add New', 'ivdirectories' ),
				'new_item'            => esc_html__( 'New Item', 'ivdirectories' ),
				'edit_item'           => esc_html__( 'Edit Item', 'ivdirectories' ),
				'update_item'         => esc_html__( 'Update Item', 'ivdirectories' ),
				'view_item'           => esc_html__( 'View Item', 'ivdirectories' ),
				'search_items'        => esc_html__( 'Search Item', 'ivdirectories' ),
				'not_found'           => esc_html__( 'Not found', 'ivdirectories' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ivdirectories' ),
				);
				$args2 = array(
				'label'               => esc_html__( 'Reviews', 'ivdirectories' ),
				'description'         => esc_html__( 'Reviews: Directory Pro', 'ivdirectories' ),
				'labels'              => $labels2,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'dirpro_review', $args2 );
				
				$labels4 = array(
				'name'                => _x( 'Message', 'Post Type General Name', 'ivdirectories' ),
				'singular_name'       => _x( 'Message', 'Post Type Singular Name', 'ivdirectories' ),
				'menu_name'           => esc_html__( 'Message', 'ivdirectories' ),
				'name_admin_bar'      => esc_html__( 'Message', 'ivdirectories' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'ivdirectories' ),
				'all_items'           => esc_html__( 'All Items', 'ivdirectories' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'ivdirectories' ),
				'add_new'             => esc_html__( 'Add New', 'ivdirectories' ),
				'new_item'            => esc_html__( 'New Item', 'ivdirectories' ),
				'edit_item'           => esc_html__( 'Edit Item', 'ivdirectories' ),
				'update_item'         => esc_html__( 'Update Item', 'ivdirectories' ),
				'view_item'           => esc_html__( 'View Item', 'ivdirectories' ),
				'search_items'        => esc_html__( 'Search Item', 'ivdirectories' ),
				'not_found'           => esc_html__( 'Not found', 'ivdirectories' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ivdirectories' ),
				);
				$args4 = array(
				'label'               => esc_html__( 'Message', 'ivdirectories' ),
				'description'         => esc_html__( 'Message', 'ivdirectories' ),
				'labels'              => $labels4,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),					
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'directorypro_message', $args4 );
				
			}
			public function ep_create_my_taxonomy_tags(){
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}
				if($dir_tags=='yes'){
					register_taxonomy(
					$directory_url.'_tag',
					$directory_url,
					array(
					'label' => esc_html__( 'Tags', 'ivdirectories'),
					'rewrite' => array( 'slug' => $directory_url.'_tag' ),
					'description'         => esc_html__( 'Tags', 'ivdirectories' ),
					'hierarchical' => true,
					'show_in_rest' =>	true,
					)
					);
				}
			}
			public function post_type_tags_fix($request) {
				if ( isset($request['tag']) && !isset($request['post_type']) ){
					$request['post_type'] = 'directories';
				}
				return $request;
			}
			public function epdirpro_plugin_action_links( $links ) {
				$plugin_links = array(
				'<a href="admin.php?page=wp-iv_directories-settings">' . esc_html__( 'Settings', 'ivdirectories' ) . '</a>',
				'<a href="http://help.eplug-ins.com/dirprodoc/">' . esc_html__( 'Docs', 'ivdirectories' ) . '</a>',
				'<a href="https://codecanyon.net/item/directory-pro/12488012/comments">' . esc_html__( 'Support', 'ivdirectories' ) . '</a>',
				);
				return array_merge( $plugin_links, $links );
			}
			public function iv_directories_loadmore(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				parse_str($_POST['form_data'], $form_data);
				include( wp_iv_directories_template. 'directories/load_more_4.php');
				echo json_encode(array("code" => "success","data"=>$post_data,"loadmore"=>$loadmorebutton,"dirs_json"=>$dirs_data));
				exit(0);
			}
			public function iv_directories_elementor_file(  ) {
				if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				
					include(wp_iv_directories_template . 'elementor/elementor-single-meta.php');
					include(wp_iv_directories_template . 'elementor/listing-maps.php');
					include(wp_iv_directories_template . 'elementor/image-gallery.php');
					include(wp_iv_directories_template . 'elementor/featured-image.php');
					
				}
			}
			public function iv_directories_save_user_review(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				$post_type = 'dirpro_review';
				$args = array(
				'post_type' => $post_type, // enter your custom post type
				'author' => sanitize_text_field($form_data['listingid']),
				);
				$the_query_review = new WP_Query( $args );
				$deleteid ='';
				if ( $the_query_review->have_posts() ) :
				while ( $the_query_review->have_posts() ) : $the_query_review->the_post();
				$deleteid = get_the_ID();
				if(get_post_meta($deleteid,'review_submitter',true)==$current_user->ID){
					wp_delete_post($deleteid );
				}
				endwhile;
				endif;
				$my_post= array();
				$my_post['post_author'] = sanitize_text_field($form_data['listingid']);
				$my_post['post_title'] = sanitize_text_field($form_data['review_subject']);
				$my_post['post_content'] = sanitize_textarea_field($form_data['review_comment']);
				$my_post['post_status'] = 'publish';
				$my_post['post_type'] = 'dirpro_review';
				$newpost_id= wp_insert_post( $my_post );
				$review_value=1;
				if(isset($form_data['star']) ){$review_value=sanitize_text_field($form_data['star']);}
				update_post_meta($newpost_id, 'review_submitter', $current_user->ID);
				update_post_meta($newpost_id, 'review_value', $review_value);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function finalerp_csv_product_upload(){
				//parse_str($_POST['form_data'], $form_data);
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$csv_file_id=0;
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= $_POST['csv_file_id'];
				}
				require (wp_iv_directories_DIR .'/admin/pages/importer/upload_main_big_csv.php');
				$total_files = get_option( 'finalerp-number-of-files');
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully", "maping"=>$maping));
				exit(0);
			}
			public function save_csv_file_to_database(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$csv_file_id=0;
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= $_POST['csv_file_id'];
				}
				$row_start=0;
				if(isset($_POST['row_start'])){
					$row_start= $_POST['row_start'];
				}
				require (wp_iv_directories_DIR .'/admin/pages/importer/csv_save_database.php');
				echo json_encode(array("code" => $done_status,"msg"=>"Updated Successfully", "row_done"=>$row_done ));
				exit(0);
			}
			public function listing_filter_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/listing_filter.php');
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_login_func($atts = ''){
				ob_start();
				global $current_user;
				if($current_user->ID==0){	
					include(wp_iv_directories_template. 'private-profile/profile-login.php');
				}else{
					include( wp_iv_directories_template. 'private-profile/profile-template-1.php');
				}	
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_forget_password(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'login' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $data_a);
				if( ! email_exists($data_a['forget_email']) ) {
					echo json_encode(array("code" => "not-success","msg"=>"There is no user registered with that email address."));
					exit(0);
					} else {
					include( wp_iv_directories_ABSPATH. 'inc/forget-mail.php');
					echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
					exit(0);
				}
			}
			public function iv_directories_check_login(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'login' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $user;
				$creds = array();
				$creds['user_login'] =sanitize_text_field($form_data['username']);
				$creds['user_password'] =  sanitize_text_field($form_data['password']);
				$creds['remember'] =  (isset($form_data['remember']) ?'true' : 'false');
				$secure_cookie = is_ssl() ? true : false;
				$user = wp_signon( $creds, $secure_cookie );
				if ( is_wp_error($user) ) {
					echo json_encode(array("code" => "not-success","msg"=>$user->get_error_message()));
					exit(0);
				}
				if ( !is_wp_error($user) ) {
					$iv_redirect = get_option( '_iv_directories_profile_page');
					if($iv_redirect!='defult'){
						if ( function_exists('icl_object_id') ) {
							$iv_redirect = icl_object_id($iv_redirect, 'page', true);
						}
						$reg_page= get_permalink( $iv_redirect);
						echo json_encode(array("code" => "success","msg"=>$reg_page));
						exit(0);
					}
				}
			}
			public function iv_directories_update_wp_post(){
				global $current_user;global $wpdb;
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce-edit?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					//  for more checking echo json_encode(array("code" => "success","msg"=>"The user does not have permission to edit post"));
					//exit(0);
				}
				parse_str($_POST['form_data'], $form_data);
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				$my_post = array();
				$user_can_publish=get_option('user_can_publish');	
				if($user_can_publish==""){$user_can_publish='yes';}	
				
				if($form_data['post_status']=='publish'){					
						$form_data['post_status']='pending';
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							$form_data['post_status']='publish';
							}else{
							if($user_can_publish=="yes"){
								$form_data['post_status']='publish';
							}else{
								$form_data['post_status']='pending';
							}	
						}
						
				}
				$allowed_html = wp_kses_allowed_html( 'post' );	
				
				$my_post['ID'] = $newpost_id= sanitize_text_field($form_data['user_post_id']);
				$my_post['post_title'] = sanitize_text_field($form_data['title']);				
				$my_post['post_content'] = wp_kses( $form_data['edit_post_content'], $allowed_html);				
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);
				$my_post['post_type'] = $directory_url;
				wp_update_post( $my_post );
				if(isset($form_data['feature_image_id'] ) AND $form_data['feature_image_id']!='' ){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( sanitize_text_field($form_data['user_post_id']), $attach_id );
					}else{
					$attach_id='0';
					delete_post_thumbnail( $form_data['user_post_id'] );
				}
				if(isset($form_data['postcats'] )){
					$category_ids = array($form_data['postcats']);
					$post_cats= array();
					foreach($category_ids AS $cid) {
						$post_cats=$cid;
					}
					wp_set_object_terms( $newpost_id, $post_cats, $directory_url.'-category');
				}
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
				if(get_option( 'iv_membership_field_type')!=''){
					$field_type_opt= get_option( 'iv_membership_field_type');	
				}else{
					$field_type_opt= array();
				}							
				if(sizeof($default_fields )){
					foreach( $default_fields as $field_key => $field_value ) {
						if(isset($field_type_opt[$field_key])){
							if($field_type_opt[$field_key]=='url'){							
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_url($form_data[$field_key])); 
							}elseif($field_type_opt[$field_key]=='textarea'){ 
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_textarea_field($form_data[$field_key]));  
							}elseif($field_type_opt[$field_key]=='checkbox'){ 
								if(isset($form_data[$field_key]) AND $form_data[$field_key]!=''){
								$save_checkbox_value= implode(',', $form_data[$field_key]);
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($save_checkbox_value));
								}
							}else{
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($form_data[$field_key])); 
							}
						}else{
							update_post_meta($newpost_id, $field_key, sanitize_text_field($form_data[$field_key]) );
						}
					}
				}
				$opening_day=array();
				if(isset($form_data['day_name'] )){
					$day_name= $form_data['day_name'] ;
					$day_value1 = $form_data['day_value1'];
					$day_value2 = $form_data['day_value2'] ;
					$i=0;
					foreach($day_name  as $one_meta){
						if(isset($day_name[$i]) and isset($day_value1[$i]) ){
							if($day_name[$i] !=''){
								$opening_day[sanitize_text_field($day_name[$i])]=sanitize_text_field($day_value1[$i]).'|'.sanitize_text_field($day_value2[$i]);
							}
						}
						$i++;
					}
					update_post_meta($newpost_id, '_opening_time', $opening_day);
				}
				// For Awards Save
				// Delete 1st
				$i=0;
				for($i=0;$i<20;$i++){
					delete_post_meta($newpost_id, '_award_title_'.$i);
					delete_post_meta($newpost_id, '_award_description_'.$i);
					delete_post_meta($newpost_id, '_award_year_'.$i);
					delete_post_meta($newpost_id, '_award_image_id_'.$i);
				}
				// Delete End
				if(isset($form_data['award_title'] )){
					$award_title= $form_data['award_title'];
					$award_description= $form_data['award_description'];
					$award_year= $form_data['award_year'];
					$award_image_id= (isset($form_data['award_image_id']) ? $form_data['award_image_id']:'');
					$i=0;
					for($i=0;$i<20;$i++){
						if(isset($award_title[$i]) AND $award_title[$i]!=''){
							update_post_meta($newpost_id, '_award_title_'.$i, sanitize_text_field($award_title[$i]));
							update_post_meta($newpost_id, '_award_description_'.$i, sanitize_text_field($award_description[$i]));
							update_post_meta($newpost_id, '_award_year_'.$i, sanitize_text_field($award_year[$i]));
							update_post_meta($newpost_id, '_award_image_id_'.$i,sanitize_text_field( $award_image_id[$i]));
						}
					}
				}
				// For Tag Save tag_arr
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}
				if($dir_tags=='yes'){
					$tag_all='';
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;
						$i=0;$tag_all='';
						wp_set_object_terms( $newpost_id, $tag_name, $directory_url.'_tag');
					}
					$tag_all='';
					if(isset($form_data['new_tag'] )){
						$tag_new= explode(",", $form_data['new_tag']);
						foreach($tag_new  as $one_tag){
							wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $directory_url.'_tag');
							$i++;
						}
					}
					}else{
					$tag_all='';
					$tag_array= wp_get_post_tags( $newpost_id );
					foreach($tag_array as $one_tag){
						wp_remove_object_terms( $newpost_id, $one_tag->name, 'post_tag' );
					}
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;
						$i=0;$tag_all='';
						foreach($tag_name  as $one_tag){
							$tag_all= $tag_all.",".sanitize_text_field($one_tag);
							$i++;
						}
						wp_set_post_tags($newpost_id, $tag_all, true);
					}
					if(isset($form_data['new_tag'] )){
						$tag_all=$tag_all.','.sanitize_text_field($form_data['new_tag']);
						wp_set_post_tags($newpost_id, $tag_all, true);
					}
				}
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address']));
				update_post_meta($newpost_id, 'area', sanitize_text_field($form_data['area']));
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude']));
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city']));
				update_post_meta($newpost_id, 'state', sanitize_text_field($form_data['state']));
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode']));
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country']));
				if(isset($form_data['contact_source'] )){
					update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));
				}
				if(isset($form_data['dirpro_call_button'] )){
					update_post_meta($newpost_id, 'dirpro_call_button', sanitize_text_field($form_data['dirpro_call_button']));
				}
				if(isset($form_data['dirpro_email_button'] )){
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button']));
				}
				if(isset($form_data['dirpro_sms_button'] )){
					update_post_meta($newpost_id, 'dirpro_sms_button', sanitize_text_field($form_data['dirpro_sms_button']));
				}
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids']));
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone']));
				update_post_meta($newpost_id, 'fax', sanitize_text_field($form_data['fax']));
				update_post_meta($newpost_id, 'contact-email', sanitize_email($form_data['contact-email']));
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));
				if(isset($form_data['vimeo'] )){
					update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo']));
					update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube']));
				}
				update_post_meta($newpost_id, 'facebook', sanitize_text_field($form_data['facebook']));
				update_post_meta($newpost_id, 'linkedin', sanitize_text_field($form_data['linkedin']));
				update_post_meta($newpost_id, 'twitter', sanitize_text_field($form_data['twitter']));
				
				update_post_meta($newpost_id, 'instagram', sanitize_text_field($form_data['instagram']));
				update_post_meta($newpost_id, 'youtube_social', sanitize_text_field($form_data['youtube_social']));
				if(isset($form_data['event-title'])){
					update_post_meta($newpost_id, '_event_image_id', sanitize_text_field($form_data['event_image_id']));
					update_post_meta($newpost_id, 'event_title', sanitize_text_field($form_data['event-title']));
					update_post_meta($newpost_id, 'event_detail', sanitize_textarea_field($form_data['event-detail']));
				}
				if(isset($form_data['deal-title'])){
					update_post_meta($newpost_id, '_deal_image_id', sanitize_text_field($form_data['deal_image_id']));
					update_post_meta($newpost_id, 'deal_title', sanitize_text_field($form_data['deal-title']));
					update_post_meta($newpost_id, 'deal_detail',sanitize_textarea_field($form_data['deal-detail']));
					update_post_meta($newpost_id, 'deal_paypal', sanitize_text_field($form_data['deal-paypal']));
					update_post_meta($newpost_id, 'deal_amount', sanitize_text_field($form_data['deal-amount']));
				}
				if(isset($form_data['booking'])){
					update_post_meta($newpost_id, 'booking', sanitize_text_field($form_data['booking']));
				}
				if(isset($form_data['booking_detail'])){
					update_post_meta($newpost_id, 'booking_detail', sanitize_text_field($form_data['booking_detail']));
				}
				delete_post_meta($newpost_id, 'eplisting-category');
				delete_post_meta($newpost_id, 'eplisting-tag');
				
				
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_save_wp_post(){
				global $current_user; global $wpdb;
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce-add?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					// for more checking  wp_die( 'The user role does not access to create any post:user Permission [edit_posts] ?' );
				}
				$allowed_html = wp_kses_allowed_html( 'post' );	
				$i=0;
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				parse_str($_POST['form_data'], $form_data);
				$my_post = array();
				$my_post['post_title']= sanitize_text_field($form_data['title']);				
				$my_post['post_content'] = wp_kses( $form_data['new_post_content'], $allowed_html); 
				$my_post['post_type']= $directory_url;
				$user_can_publish=get_option('user_can_publish');	
				if($user_can_publish==""){$user_can_publish='yes';}	
		
				if($form_data['post_status']=='publish'){					
					$form_data['post_status']='pending';
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$form_data['post_status']='publish';
						}else{
							if($user_can_publish=="yes"){
								$form_data['post_status']='publish';
							}else{
								$form_data['post_status']='pending';
							}								
					}						
				}
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);				
				
				$newpost_id= wp_insert_post( $my_post );
				// WPML Start******
				/*
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1",$directory_url,$newpost_id );
					$wpdb->query($query);
					wpml_update_translatable_content( 'post_'.$directory_url, $newpost_id , $language_code );
				}
				*/
				// End WPML**********
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );
				}
				if(isset($form_data['postcats'] )){
					$category_ids = array($form_data['postcats']);
					$post_cats= array();
					foreach($category_ids AS $cid) {
						$post_cats=$cid;
					}
					wp_set_object_terms( $newpost_id, $post_cats, $directory_url.'-category');
				}
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
				if(get_option( 'iv_membership_field_type')!=''){
					$field_type_opt= get_option( 'iv_membership_field_type');	
				}else{
					$field_type_opt= array();
				}							
				if(sizeof($default_fields )){
					foreach( $default_fields as $field_key => $field_value ) {
						if(isset($field_type_opt[$field_key])){
							if($field_type_opt[$field_key]=='url'){							
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_url($form_data[$field_key])); 
							}elseif($field_type_opt[$field_key]=='textarea'){ 
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_textarea_field($form_data[$field_key]));  
							}elseif($field_type_opt[$field_key]=='checkbox'){ 
								if(isset($form_data[$field_key]) AND $form_data[$field_key]!=''){
								$save_checkbox_value= implode(',', $form_data[$field_key]);
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($save_checkbox_value));
								}
							}else{
								update_post_meta($newpost_id, sanitize_text_field($field_key), sanitize_text_field($form_data[$field_key])); 
							}
						}else{
							update_post_meta($newpost_id, $field_key, sanitize_text_field($form_data[$field_key]) );
						}
					}
				}
				$opening_day=array();
				if(isset($form_data['day_name'] )){
					$day_name= $form_data['day_name'] ;
					$day_value1 = $form_data['day_value1'] ;
					$day_value2 = $form_data['day_value2'] ;
					$i=0;
					foreach($day_name  as $one_meta){
						if(isset($day_name[$i]) and isset($day_value1[$i]) ){
							if($day_name[$i] !=''){
								$opening_day[sanitize_text_field($day_name[$i])]=sanitize_text_field($day_value1[$i]).'|'.sanitize_text_field($day_value2[$i]);
							}
						}
						$i++;
					}
					update_post_meta($newpost_id, '_opening_time', $opening_day);
				}
				// For Awards Save
				if(isset($form_data['award_title'] )){
					$award_title= $form_data['award_title'];
					$award_description= $form_data['award_description'];
					$award_year= $form_data['award_year'];
					$award_image_id= (isset($form_data['award_image_id']) ? $form_data['award_image_id']:'');
					$i=0;
					//foreach($award_title  as $one_award_title){
					for($i=0;$i<20;$i++){
						if(isset($award_title[$i])){
							update_post_meta($newpost_id, '_award_title_'.$i, sanitize_text_field($award_title[$i]));
						}
						if(isset($award_description[$i])){
							update_post_meta($newpost_id, '_award_description_'.$i, sanitize_text_field($award_description[$i]));
						}
						if(isset($award_year[$i])){
							update_post_meta($newpost_id, '_award_year_'.$i, sanitize_text_field($award_year[$i]));
						}
						if(isset($award_image_id[$i])){
							update_post_meta($newpost_id, '_award_image_id_'.$i, sanitize_text_field($award_image_id[$i]));
						}
					}
				}
				// For Tag Save tag_arr
				$dir_tags=get_option('_dir_tags');
				if($dir_tags==""){$dir_tags='yes';}
				if($dir_tags=='yes'){
					$tag_all='';
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;
						$i=0;$tag_all='';
						wp_set_object_terms( $newpost_id, $tag_name, $directory_url.'_tag');
					}
					$tag_all='';
					if(isset($form_data['new_tag'] )){
						$tag_new= explode(",", $form_data['new_tag']);
						foreach($tag_new  as $one_tag){
							wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $directory_url.'_tag');
							$i++;
						}
					}
					}else{
					$tag_all='';
					$tag_array= wp_get_post_tags( $newpost_id );
					foreach($tag_array as $one_tag){
						wp_remove_object_terms( $newpost_id, $one_tag->name, 'post_tag' );
					}
					if(isset($form_data['tag_arr'] )){
						$tag_name= $form_data['tag_arr'] ;
						$i=0;$tag_all='';
						foreach($tag_name  as $one_tag){
							$tag_all= $tag_all.",".sanitize_text_field($one_tag);
							$i++;
						}
						wp_set_post_tags($newpost_id, $tag_all, true);
					}
					if(isset($form_data['new_tag'] )){
						$tag_all=$tag_all.','.sanitize_text_field($form_data['new_tag']);
						wp_set_post_tags($newpost_id, $tag_all, true);
					}
				}
				if(isset($form_data['dirpro_call_button'] )){
					update_post_meta($newpost_id, 'dirpro_call_button', sanitize_text_field($form_data['dirpro_call_button']));
				}
				if(isset($form_data['dirpro_email_button'] )){
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button']));
				}
				if(isset($form_data['dirpro_sms_button'] )){
					update_post_meta($newpost_id, 'dirpro_sms_button', sanitize_text_field($form_data['dirpro_sms_button']));
				}
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address']));
				update_post_meta($newpost_id, 'area', sanitize_text_field($form_data['area']));
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude']));
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city']));
				update_post_meta($newpost_id, 'state', sanitize_text_field($form_data['state']));
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode']));
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country']));
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids']));
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone']));
				update_post_meta($newpost_id, 'fax', sanitize_text_field($form_data['fax']));
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email']));
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));
				if(isset($form_data['contact_source'] )){
					update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));
				}
				if(isset($form_data['vimeo'] )){
					update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo']));
					update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube']));
				}
				update_post_meta($newpost_id, 'facebook', sanitize_text_field($form_data['facebook']));
				update_post_meta($newpost_id, 'linkedin', sanitize_text_field($form_data['linkedin']));
				update_post_meta($newpost_id, 'twitter', sanitize_text_field($form_data['twitter']));				
				update_post_meta($newpost_id, 'instagram', sanitize_text_field($form_data['instagram']));
				update_post_meta($newpost_id, 'youtube_social', sanitize_text_field($form_data['youtube_social']));
				if(isset($form_data['event-title'])){
					update_post_meta($newpost_id, '_event_image_id', sanitize_text_field($form_data['event_image_id']));
					update_post_meta($newpost_id, 'event_title', sanitize_text_field($form_data['event-title']));
					update_post_meta($newpost_id, 'event_detail', sanitize_textarea_field($form_data['event-detail']));
				}
				if(isset($form_data['booking'])){
					update_post_meta($newpost_id, 'booking', sanitize_text_field($form_data['booking']));
				}
				if(isset($form_data['booking_detail'])){
					update_post_meta($newpost_id, 'booking_detail', sanitize_textarea_field($form_data['booking_detail']));
				}
				include( wp_iv_directories_ABSPATH. 'inc/notification.php');
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function get_unique_location_values( $key = 'keyword', $post_type='' ){
				global $wpdb;
				$all_data=array();
				// Area**
				$dir_facet_title=get_option('dir_facet_area_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivdirectories');}
				$res=array();
				$key = 'area';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'
				", $key) );
				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// City ***
				$dir_facet_title=get_option('dir_facet_location_title');
				if($dir_facet_title==""){$dir_facet_title=esc_html__('City','ivdirectories');}
				$res=array();
				$key = 'city';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'
				", $key) );
				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// Zipcode ***
				$dir_facet_title=get_option('dir_facet_zipcode_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivdirectories');}
				$res=array();
				$key = 'postcode';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'
				", $key) );
				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				$all_data_json= json_encode($all_data);
				return $all_data_json;
			}
			public function get_unique_keyword_values(){
				global $wpdb;
				$post_type=get_option('_iv_directory_url');
				if($post_type==""){$post_type='directories';}
				$res=array();
				$all_data=array();
				$partners = array();
				$partners_obj =  get_terms( $post_type.'-category', array('hide_empty' => false) );
				$dir_facet_title=get_option('dir_facet_cat_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivdirectories');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					if(isset($partner->name)){
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']= $dir_facet_title;
					array_push( $all_data, $row_data );
					}
				}
				$partners = array();
				$partners_obj =  get_terms( $post_type.'_tag', array('hide_empty' => false) );
				$dir_facet_title=get_option('dir_facet_features_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					if(isset($partner->name)){
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']=$dir_facet_title;					
					array_push( $all_data, $row_data );
					}
				}
				$args3 = array(
				'post_type' => $post_type, // enter your custom post type
				'post_status' => 'publish',
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				'orderby' => 'title',
				'order' => 'ASC',
				);
				$all_data_json=array();
				$query_auto = new WP_Query( $args3 );
				$posts_auto = $query_auto->posts;
				foreach($posts_auto as $post_a) {
					$row_data=array();
					$row_data['label']=$post_a->post_title;
					$row_data['value']=$post_a->post_title;
					$row_data['category']= esc_html__('Title','ivdirectories');
					array_push( $all_data, $row_data );
				}
				$all_data_json= json_encode($all_data);
				return $all_data_json;
			}
			public function ep_directory_check_field_input_access($field_key_pass, $field_value, $template='myaccount', $listid){ 
				 $listid=$listid;		
				
				$field_type=  		get_option( 'iv_membership_field_type' );
				$field_type_value=  get_option( 'iv_membership_field_type_value' );
				$field_type_roles=  get_option( 'iv_membership_field_type_roles' );
				
				$return_value='';			
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='dropdown'){	 								
						$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8"><select name="'. esc_html($field_key_pass).'" id="'.esc_attr($field_key_pass).'" class="form-control "  >';				
						foreach($dropdown_value as $one_value){	 
							if(trim($one_value)!=''){
								$return_value=$return_value.'<option '.(trim(get_post_meta($listid,$field_key_pass,true))==trim($one_value)?' selected':'').' value="'. esc_attr($one_value).'">'. esc_html($one_value).'</option>';
							}
						}	
						$return_value=$return_value.'</select></div></div>';					
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='checkbox'){	 								
						 $dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8">
						<div class="row" >
						';
						$saved_checkbox_value =	explode(',',get_post_meta($listid,$field_key_pass,true));
						
						foreach($dropdown_value as $one_value){
							if(trim($one_value)!=''){
								$return_value=$return_value.'
								<div class="form-check form-check-inline col-md-12 margin-top10">
								<label class="form-check-label" for="'. esc_attr($one_value).'">
								<input '.( in_array($one_value,$saved_checkbox_value)?' checked':'').' class=" form-check-input" type="checkbox" name="'. esc_attr($field_key_pass).'[]"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
								'. esc_attr($one_value).' </label>
								</div>';
							}
						}	
						$return_value=$return_value.'</div></div></div>';						
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='radio'){	 								
						$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row ">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8">
						<div class="row" >
						';						
						foreach($dropdown_value as $one_value){	 
							if(trim($one_value)!=''){
								$return_value=$return_value.'
								<div class="form-check form-check-inline col-md-12 margin-top10">
								<label class="form-check-label " for="'. esc_attr($one_value).'">
								<input '.(get_post_meta($listid,$field_key_pass,true)==$one_value?' checked':'').' class="form-check-input" type="radio" name="'. esc_attr($field_key_pass).'"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
								'. esc_attr($one_value).'</label>
								</div>														
								';
							}
						}	
						$return_value=$return_value.'</div></div></div>';					
					}					 
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='textarea'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><textarea  placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control "  rows="4"/>'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'</textarea></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='datepicker'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Select ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control epinputdate " value="'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='text'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='url'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_url(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
					}
				
				return $return_value;
			}
			public function get_unique_dirslider_search_field1(){
				global $wpdb;
				$term='';
				if(isset($_REQUEST['term'])){
					$term=sanitize_text_field($_REQUEST['term']);
				}
				$post_type=get_option('_iv_directory_url');
				if($post_type==""){$post_type='directories';}
				$res=array();
				$all_data=array();
				$partners = array();
				$partners_obj =  get_terms( $post_type.'-category', array('hide_empty' => true, 'name__like'    => $term) );
				$dir_facet_title=get_option('dir_facet_cat_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivdirectories');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']= $dir_facet_title;
					array_push( $all_data, $row_data );
				}
				$partners = array();
				$partners_obj =  get_terms( $post_type.'_tag', array('hide_empty' => true,'name__like'    => $term) );
				$dir_facet_title=get_option('dir_facet_features_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']=$dir_facet_title;
					array_push( $all_data, $row_data );
				}
				$args3 = array(
				'post_type' 		=> $post_type, // enter your custom post type
				'post_status' 	=> 'publish',
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				'orderby' 			=> 'title',
				'order' 				=> 'ASC',
				's'							=>  $term,
				);
				$all_data_json=array();
				$query_auto = new WP_Query( $args3 );
				$posts_auto = $query_auto->posts;
				foreach($posts_auto as $post_a) {
					$row_data=array();
					$row_data['label']=$post_a->post_title;
					$row_data['value']=$post_a->post_title;
					$row_data['category']= esc_html__('Title','ivdirectories');
					array_push( $all_data, $row_data );
				}
				wp_send_json( $all_data );
			}
			public function get_unique_dirslider_search_field2( ){
				global $wpdb;
				$term='';
				if(isset($_REQUEST['term'])){
					$term=sanitize_text_field($_REQUEST['term']);
				}

				$post_type=get_option('_iv_directory_url');
				if($post_type==""){$post_type='directories';}
				$all_data=array();
				// Area**
				$dir_facet_title=get_option('dir_facet_area_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivdirectories');}
				$res=array();
				$key = 'area';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'
				 AND pm.meta_value LIKE '%s'", $key, '%'.$term.'%') );

				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// City ***
				$dir_facet_title=get_option('dir_facet_location_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivdirectories');}
				$res=array();
				$key = 'city';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'  AND pm.meta_value LIKE '%s'
				", $key,'%'.$term.'%') );
				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// Zipcode ***
				$dir_facet_title=get_option('dir_facet_zipcode_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivdirectories');}
				$res=array();
				$key = 'postcode';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'  AND pm.meta_value LIKE '%s'
				", $key,'%'.$term.'%') );
				foreach($res as $row1){
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				wp_send_json( $all_data );
			}
			public function directorypro_cities_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/listing-cities.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listing_carousel_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/listing-carousel.php');
				$content = ob_get_clean();
				return $content;
			}
			public function get_unique_post_meta_values( $key = 'postcode', $post_type ){
				global $wpdb;
				if( empty( $key ) ){
					return;
				}
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'
				", $key) );
				return $res;
			}
			public function iv_directories_message_delete(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				global $current_user;
				$message_id=sanitize_text_field($form_data['id']);
				$user_to=get_post_meta($message_id,'user_to',true);	
				if($user_to==$current_user->ID){				
					wp_delete_post($message_id);
					delete_post_meta($message_id,true);	
					echo json_encode(array("msg" => 'success'));
					}else{
					echo json_encode(array("msg" => 'Not success'));
				}
				exit(0);		
			}
			public function iv_directories_cancel_paypal(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if( ! class_exists('Paypal' ) ) {
					include(wp_iv_directories_DIR . '/inc/class-paypal.php');
				}
				$post_name='iv_directories_paypal_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name =%s' ",$post_name ));
				$paypal_id='0';
				if(isset($row->ID )){
					$paypal_id= $row->ID;
				}
				$paypal_api_currency=get_post_meta($paypal_id, 'iv_directories_paypal_api_currency', true);
				$paypal_username=get_post_meta($paypal_id, 'iv_directories_paypal_username',true);
				$paypal_api_password=get_post_meta($paypal_id, 'iv_directories_paypal_api_password', true);
				$paypal_api_signature=get_post_meta($paypal_id, 'iv_directories_paypal_api_signature', true);
				$credentials = array();
				$credentials['USER'] = (isset($paypal_username)) ? $paypal_username : '';
				$credentials['PWD'] = (isset($paypal_api_password)) ? $paypal_api_password : '';
				$credentials['SIGNATURE'] = (isset($paypal_api_signature)) ? $paypal_api_signature : '';
				$paypal_mode=get_post_meta($paypal_id, 'iv_directories_paypal_mode', true);
				$currencyCode = $paypal_api_currency;
				$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
				$sandboxBool = (!empty($sandbox)) ? true : false;
				$paypal = new Paypal($credentials,$sandboxBool);
				$oldProfile = get_user_meta($current_user->ID,'iv_paypal_recurring_profile_id',true);
				if (!empty($oldProfile)) {
					$cancelParams = array(
					'PROFILEID' => $oldProfile,
					'ACTION' => 'Cancel'
					);
					$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
					update_user_meta($current_user->ID,'iv_paypal_recurring_profile_id','');
					update_user_meta($current_user->ID,'iv_cancel_reason', $form_data['cancel_text']);
					update_user_meta($current_user->ID,'iv_directories_payment_status', 'cancel');
					echo json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
					exit(0);
					}else{
					echo json_encode(array("code" => "not","msg"=>"Unable to Cancel "));
					exit(0);
				}
			}
			public function  iv_directories_profile_stripe_upgrade(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'update' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				include(wp_iv_directories_DIR . '/admin/files/init.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				$newpost_id='';
				$post_name='iv_directories_stripe_setting';
				$row = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '".$post_name."' ");
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'iv_directories_stripe_secret_test',true);
					}else{
					$stripe_api =get_post_meta($newpost_id, 'iv_directories_stripe_live_secret_key',true);
				}
				\Stripe\Stripe::setApiKey($stripe_api);
				// For  cancel ----
				$arb_status =	get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
				$cust_id = get_user_meta($current_user->ID,'iv_directories_stripe_cust_id',true);
				$sub_id = get_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id',true);
				if($sub_id!=''){
					try{
						$iv_cancel_stripe = \Stripe\Subscription::retrieve($sub_id);
						$iv_cancel_stripe->cancel();
						} catch (Exception $e) {
					}
					update_user_meta($current_user->ID,'iv_directories_payment_status', 'cancel');
					update_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id','');
				}
				// Start  New
				$response='';
				parse_str($_POST['form_data'], $form_data);
				include(wp_iv_directories_DIR . '/admin/pages/payment-inc/stripe-upgrade.php');
				echo json_encode(array("code" => "success","msg"=>$response));
				exit(0);
			}
		
			public function iv_directories_cancel_stripe(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				include(wp_iv_directories_DIR . '/admin/files/init.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				$newpost_id='';
				$post_name='iv_directories_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name =%s",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'iv_directories_stripe_secret_test',true);
					}else{
					$stripe_api =get_post_meta($newpost_id, 'iv_directories_stripe_live_secret_key',true);
				}
				$sub_id = get_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id',true);
				\Stripe\Stripe::setApiKey($stripe_api);
				try{
				
					$iv_cancel_stripe = \Stripe\Subscription::retrieve($sub_id);
					$iv_cancel_stripe->cancel();
					} catch (Exception $e) {
				}
				update_user_meta($current_user->ID,'iv_cancel_reason', $form_data['cancel_text']);
				update_user_meta($current_user->ID,'iv_directories_payment_status', 'cancel');
				update_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id','');
				echo json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
				exit(0);
			}
			public function iv_directories_woocommerce_form_submit(  ) {
				include(wp_iv_directories_ABSPATH . '/admin/pages/payment-inc/woo-submit.php');
			}
			public function iv_directories_update_setting_hide(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				$mobile_hide=(isset($form_data['mobile_hide'])? $form_data['mobile_hide']:'');
				$email_hide=(isset($form_data['email_hide'])? $form_data['email_hide']:'');
				$phone_hide=(isset($form_data['phone_hide'])? $form_data['phone_hide']:'');
				update_user_meta($current_user->ID,'hide_email', $email_hide);
				update_user_meta($current_user->ID,'hide_phone', $phone_hide);
				update_user_meta($current_user->ID,'hide_mobile',$mobile_hide);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function directorypro_search_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/directories-search-widget.php');
				$content = ob_get_clean();
				return $content;
			}
			public function slider_search_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/slider-search.php');
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_update_setting_fb(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				update_user_meta($current_user->ID,'twitter', sanitize_text_field($form_data['twitter']));
				update_user_meta($current_user->ID,'facebook', sanitize_text_field($form_data['facebook']));
			
				update_user_meta($current_user->ID,'linkedin', sanitize_text_field($form_data['linkedin']));
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function iv_directories_update_setting_password(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				if ( wp_check_password( $form_data['c_pass'], $current_user->user_pass, $current_user->ID) ){
					if($form_data['r_pass']!=$form_data['n_pass']){
						echo json_encode(array("code" => "not", "msg"=>esc_html__("New Password & Re Password are not same.", 'ivdirectories' ) ));
						exit(0);
						}else{
						wp_set_password( $form_data['n_pass'], $current_user->ID);
						echo json_encode(array("code" => "success","msg"=>esc_html__("Updated Successfully", 'ivdirectories' )));
						exit(0);
					}
					}else{
					echo json_encode(array("code" => "not", "msg"=>esc_html__("Current password is wrong. ", 'ivdirectories' )));
					exit(0);
				}
			}
			public function iv_directories_update_profile_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $current_user;
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}
				update_user_meta($current_user->ID,'first_name', sanitize_text_field($form_data['first_name']));
				update_user_meta($current_user->ID,'last_name', sanitize_text_field($form_data['last_name']));
				update_user_meta($current_user->ID,'phone', sanitize_text_field($form_data['phone']));
				update_user_meta($current_user->ID,'mobile', sanitize_text_field($form_data['mobile']));
				update_user_meta($current_user->ID,'address', sanitize_text_field($form_data['address']));
				update_user_meta($current_user->ID,'occupation', sanitize_text_field($form_data['occupation']));
				update_user_meta($current_user->ID,'description', sanitize_text_field($form_data['description']));
				update_user_meta($current_user->ID,'web_site', sanitize_text_field($form_data['web_site']));
				echo json_encode(array("code" => "success","msg"=>esc_html__("Updated Successfully",'ivdirectories') ));
				exit(0);
			}
			public function iv_restrict_media_library( $wp_query ) {
				if(!function_exists('wp_get_current_user')) { include(ABSPATH . "wp-includes/pluggable.php"); }
				global $current_user, $pagenow;
				if( is_admin() && !current_user_can('edit_others_posts') ) {
					$wp_query->set( 'author', $current_user->ID );
					add_filter('views_edit-post', 'fix_post_counts');
					add_filter('views_upload', 'fix_media_counts');
				}
			}
			public function check_expiry_date($user) {
				include(wp_iv_directories_DIR . '/inc/check_expire_date.php');
			}
			public function iv_directories_update_profile_pic(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				if(isset($_REQUEST['profile_pic_url_1'])){
					$iv_profile_pic_url=sanitize_text_field($_REQUEST['profile_pic_url_1']);
					$attachment_thum=sanitize_text_field($_REQUEST['attachment_thum']);
					}else{
					$iv_profile_pic_url='';
					$attachment_thum='';
				}
				update_user_meta($current_user->ID, 'iv_profile_pic_thum', $attachment_thum);
				update_user_meta($current_user->ID, 'iv_profile_pic_url', $iv_profile_pic_url);
				echo json_encode('success');
				exit(0);
			}
			public function iv_directories_paypal_form_submit() {
				include(wp_iv_directories_DIR . '/admin/pages/payment-inc/paypal-submit.php');
			}
			public function iv_directories_stripe_form_submit(  ) {
				include(wp_iv_directories_DIR . '/admin/pages/payment-inc/stripe-submit.php');
			}
			public function plugin_mce_css_iv_directories( $mce_css ) {
				if ( ! empty( $mce_css ) )
				$mce_css .= ',';
				$mce_css .= plugins_url( 'admin/files/css/iv-bootstrap.css', __FILE__ );
				return $mce_css;
			}
			/***********************************
				* Adds a meta box to the post editing screen
			*/
			public function prfx_custom_meta_iv_directories() {
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				add_meta_box('prfx_meta', esc_html__('Claim & Featured', 'ivdirectories'), array(&$this, 'iv_directories_meta_callback'),$directory_url,'side');
				add_meta_box('prfx_meta2', esc_html__('Listing Data ', 'ivdirectories'), array(&$this, 'iv_directories_meta_callback_full_data'),$directory_url,'advanced','high');
			}
			public function iv_directories_check_coupon(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup2' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				$coupon_code=sanitize_text_field($_REQUEST['coupon_code']);
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
				$api_currency =sanitize_text_field($_REQUEST['api_currency']);
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s and  post_type='iv_coupon'", $coupon_code ));
				if(isset($post_cont->ID) && $package_amount>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_coupon_amount', true);
					$package_ids =get_post_meta($post_cont->ID, 'iv_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					if(in_array('0', $all_pac_arr)){
						$pac_found=1;
						}else{
						if(in_array($package_id, $all_pac_arr)){
							$pac_found=1;
							}else{
							$pac_found=0;
						}
					}
					$recurring = get_post_meta( $package_id,'iv_directories_package_recurring',true);
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found == '1' && $recurring!='on' ){
						$total = $package_amount -$dis_amount;
						$coupon_type= get_post_meta($post_cont->ID, 'iv_coupon_type', true);
						if($coupon_type=='percentage'){
							$dis_amount= $dis_amount * $package_amount/100;
							$total = $package_amount -$dis_amount ;
						}
						echo json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success-2',
						'dis_amount' => '',
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					if($package_amount=="" or $package_amount=="0"){$package_amount='0';}
					$dis_amount='';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success-1',
					'dis_amount' => '',
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			public function iv_directories_check_package_amount(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup2' ) ) {
					wp_die( 'Are you cheating:wpnonce2?' );
				}
				global $wpdb;
				$coupon_code=sanitize_text_field($_REQUEST['coupon_code']);
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				if( get_post_meta( $package_id,'iv_directories_package_recurring',true) =='on'  ){
					$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
					}else{
					$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
				}
				$api_currency= get_option('_iv_directories_api_currency');
				$iv_gateway = get_option('iv_directories_payment_gateway');
				if($iv_gateway=='woocommerce'){
					if ( class_exists( 'WooCommerce' ) ) {
						$api_currency= get_option( 'woocommerce_currency' );
						$api_currency= get_woocommerce_currency_symbol( $api_currency );
					}
				}
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s and  post_type='iv_coupon'", $coupon_code ));
				if(sizeof($post_cont)>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_coupon_amount', true);
					$package_ids =get_post_meta($post_cont->ID, 'iv_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					$pac_found= in_array($package_id, $all_pac_arr);
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found=="1"){
						$total = $package_amount -$dis_amount;
						echo json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => 	$total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='--';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success-1',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					$dis_amount='--';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success-2',
					'dis_amount' => $dis_amount.' '.$api_currency,
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			/**
				* Outputs the content of the meta box
			*/
			public function iv_directories_meta_callback($post) {
				wp_nonce_field(basename(__FILE__), 'prfx_nonce');
				include ('admin/pages/metabox.php');
			}
			public function iv_directories_meta_callback_full_data($post) {
				wp_nonce_field(basename(__FILE__), 'prfx_nonce');
				include ('admin/pages/metabox_full_data.php');
			}
			public function iv_directories_meta_save($post_id) {
				global $wpdb;
				$is_autosave = wp_is_post_autosave($post_id);
				if (isset($_REQUEST['iv_directories_approve'])) {
					if($_REQUEST['iv_directories_approve']=='yes'){
						update_post_meta($post_id, 'iv_directories_approve', sanitize_text_field($_REQUEST['iv_directories_approve']));
						// Set new user for post
						$iv_directories_author_id= sanitize_text_field($_REQUEST['iv_directories_author_id']);
						$sql=$wpdb->prepare("UPDATE  $wpdb->posts SET post_author=%d  WHERE ID=%d",$iv_directories_author_id,$post_id );
						$wpdb->query($sql);
					}
				}else{
					update_post_meta($post_id, 'iv_directories_approve', 'no');
				}
				if (isset($_REQUEST['dirpro_featured'])) {
					update_post_meta($post_id, 'dirpro_featured', sanitize_text_field($_REQUEST['dirpro_featured']));
					}else{
					update_post_meta($post_id, 'dirpro_featured','');
				}
				if (isset($_REQUEST['listing_data_submit'])) {
					
					
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
					if(get_option( 'iv_membership_field_type')!=''){
						$field_type_opt= get_option( 'iv_membership_field_type');	
					}else{
						$field_type_opt= array();
					}							
					if(sizeof($default_fields )){
						foreach( $default_fields as $field_key => $field_value ) {
							if(isset($field_type_opt[$field_key])){
								if($field_type_opt[$field_key]=='url'){							
									update_post_meta($post_id, sanitize_text_field($field_key), sanitize_url($_REQUEST[$field_key])); 
								}elseif($field_type_opt[$field_key]=='textarea'){ 
									update_post_meta($post_id, sanitize_text_field($field_key), sanitize_textarea_field($_REQUEST[$field_key]));  
								}elseif($field_type_opt[$field_key]=='checkbox'){ 
									$save_checkbox_value= implode(',', $_REQUEST[$field_key]);
									update_post_meta($post_id, sanitize_text_field($field_key), sanitize_text_field($save_checkbox_value));
								}else{
									update_post_meta($post_id, sanitize_text_field($field_key), sanitize_text_field($_REQUEST[$field_key])); 
								}
							}else{
								update_post_meta($post_id, $field_key, sanitize_text_field($_REQUEST[$field_key]) );
							}
						}
					}
					
					
					
					
					$opening_day=array();
					if(isset($_REQUEST['day_name'] )){
						$day_name= $_REQUEST['day_name'] ; 			//this is array data we sanitize later, when it save
						$day_value1 = $_REQUEST['day_value1'] ; //this is array data we sanitize later, when it save
						$day_value2 = $_REQUEST['day_value2'] ; //this is array data we sanitize later, when it save
						$i=0;
						foreach($day_name  as $one_meta){
							if(isset($day_name[$i]) and isset($day_value1[$i]) ){
								if($day_name[$i] !=''){
									$opening_day[sanitize_text_field($day_name[$i])]=sanitize_text_field($day_value1[$i]).'|'.sanitize_text_field($day_value2[$i]);
								}
							}
							$i++;
						}
						update_post_meta($post_id, '_opening_time', $opening_day);
					}
					// For Awards Save
					// Delete 1st
					$i=0;
					for($i=0;$i<20;$i++){
						delete_post_meta($post_id, '_award_title_'.$i);
						delete_post_meta($post_id, '_award_description_'.$i);
						delete_post_meta($post_id, '_award_year_'.$i);
						delete_post_meta($post_id, '_award_image_id_'.$i);
					}
					// Delete End
					if(isset($_REQUEST['award_title'] )){
						$award_title= $_REQUEST['award_title']; //this is array data we sanitize later, when it save
						$award_description= $_REQUEST['award_description']; //this is array data we sanitize later, when it save
						$award_year= $_REQUEST['award_year']; //this is array data we sanitize later, when it save
						$award_image_id= (isset($_REQUEST['award_image_id']) ? $_REQUEST['award_image_id']:'');
						$i=0;
						for($i=0;$i<20;$i++){
							if(isset($award_title[$i]) AND $award_title[$i]!=''){
								update_post_meta($post_id, '_award_title_'.$i, sanitize_text_field($award_title[$i]));
								update_post_meta($post_id, '_award_description_'.$i, sanitize_text_field($award_description[$i]));
								update_post_meta($post_id, '_award_year_'.$i, sanitize_text_field($award_year[$i]));
								update_post_meta($post_id, '_award_image_id_'.$i, sanitize_text_field($award_image_id[$i]));
							}
						}
					}
					if(isset($_REQUEST['dirpro_call_button'] )){
						update_post_meta($post_id, 'dirpro_call_button', sanitize_text_field($_REQUEST['dirpro_call_button']));
					}
					if(isset($_REQUEST['dirpro_email_button'] )){
						update_post_meta($post_id, 'dirpro_email_button', sanitize_text_field($_REQUEST['dirpro_email_button']));
					}
					if(isset($_REQUEST['dirpro_sms_button'] )){
						update_post_meta($post_id, 'dirpro_sms_button', sanitize_text_field($_REQUEST['dirpro_sms_button']));
					}
					update_post_meta($post_id, 'address', sanitize_text_field($_REQUEST['address']));
					update_post_meta($post_id, 'area', sanitize_text_field($_REQUEST['area']));
					update_post_meta($post_id, 'latitude', sanitize_text_field($_REQUEST['latitude']));
					update_post_meta($post_id, 'longitude', sanitize_text_field($_REQUEST['longitude']));
					update_post_meta($post_id, 'city', sanitize_text_field($_REQUEST['city']));
					update_post_meta($post_id, 'state', sanitize_text_field($_REQUEST['state']));
					update_post_meta($post_id, 'postcode', sanitize_text_field($_REQUEST['postcode']));
					update_post_meta($post_id, 'country', sanitize_text_field($_REQUEST['country']));
					update_post_meta($post_id, 'image_gallery_ids', sanitize_text_field($_REQUEST['gallery_image_ids']));
					update_post_meta($post_id, 'phone', sanitize_text_field($_REQUEST['phone']));
					update_post_meta($post_id, 'fax', sanitize_text_field($_REQUEST['fax']));
					update_post_meta($post_id, 'contact-email', sanitize_text_field($_REQUEST['contact-email']));
					update_post_meta($post_id, 'contact_web', sanitize_text_field($_REQUEST['contact_web']));
					update_post_meta($post_id, 'vimeo', sanitize_text_field($_REQUEST['vimeo']));
					update_post_meta($post_id, 'youtube', sanitize_text_field($_REQUEST['youtube']));
					update_post_meta($post_id, 'facebook', sanitize_text_field($_REQUEST['facebook']));
					update_post_meta($post_id, 'linkedin', sanitize_text_field($_REQUEST['linkedin']));
					update_post_meta($post_id, 'twitter', sanitize_text_field($_REQUEST['twitter']));
					
					update_post_meta($post_id, 'instagram', sanitize_text_field($_REQUEST['instagram']));
					update_post_meta($post_id, 'youtube_social', sanitize_text_field($_REQUEST['youtube_social']));
					if(isset($_REQUEST['contact_source'])){
						update_post_meta($post_id, 'listing_contact_source', sanitize_text_field($_REQUEST['contact_source']));
					}
					if(isset($_REQUEST['event-title'])){
						update_post_meta($post_id, '_event_image_id', sanitize_text_field($_REQUEST['event_image_id']));
						update_post_meta($post_id, 'event_title', sanitize_text_field($_REQUEST['event-title']));
						update_post_meta($post_id, 'event_detail', sanitize_text_field($_REQUEST['event-detail']));
					}
					if(isset($_REQUEST['booking'])){
						update_post_meta($post_id, 'booking', sanitize_text_field($_REQUEST['booking']));
					}
					if(isset($_REQUEST['booking_detail'])){
						update_post_meta($post_id, 'booking_detail', sanitize_textarea_field($_REQUEST['booking_detail']));
					}
					delete_post_meta($post_id, 'eplisting-category');
					delete_post_meta($post_id, 'eplisting-tag');
				}
			}
			public function eppro_get_import_status(){
				$eppro_total_row = floatval( get_option( 'eppro_total_row' ));
				$eppro_current_row = floatval( get_option( 'eppro_current_row' ));
				$progress =  ((int)$eppro_current_row / (int)$eppro_total_row)*100;
				if($eppro_total_row<=$eppro_current_row){$progress='100';}
				if($progress=='100'){
					echo json_encode(array("code" => "-1","progress"=>(int)$progress, "total_files"=>$total_files));
					}else{
					echo json_encode(array("code" => "0","progress"=>(int)$progress, "total_files"=>$total_files));
				}
				exit(0);
			}
			public function get_dirpro_listing_default_image() {
				if(get_option('default_image_attachment_id')!=''){
					$default_image_url= wp_get_attachment_image_src(get_option('default_image_attachment_id'),'full');		
					if(isset($default_image_url[0])){									
						$default_image_url=$default_image_url[0] ;
					}
					}else{
						$default_image_url=wp_iv_directories_URLPATH."/assets/images/default-directory.jpg";
				}
				return $default_image_url;
			}
			public function eppro_upload_images_field($value, $post_id ) {
				include(ABSPATH . 'wp-admin/includes/file.php');
				include(ABSPATH . 'wp-admin/includes/media.php');
				include(ABSPATH . 'wp-admin/includes/image.php');
				$image_array = explode(',', $value);
				// Download file to temp location
				$i=0;$image_gallery='';
				foreach($image_array as $thumb_url){
					if(!empty($thumb_url)){
						if($i<1){
							$return='id';
							$thumbid= media_sideload_image($thumb_url, $return );
							$image_gallery=$image_gallery.','.$thumbid;
						}
					}
					$i++;
				}
				return $image_gallery;
			}
			public function eppro_upload_featured_image($thumb_url, $post_id ) {
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				// Download file to temp location
				$i=0;$product_image_gallery='';
				$tmp = download_url( $thumb_url );
				// Set variables for storage
				// fix file name for query strings
				preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
				$file_array['name'] = basename($matches[0]);
				$file_array['tmp_name'] = $tmp;
				// If error storing temporarily, unlink
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
				}
				//use media_handle_sideload to upload img:
				$thumbid = media_handle_sideload( $file_array, $post_id, 'gallery desc' );
				// If error storing permanently, unlink
				if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
				}
				set_post_thumbnail($post_id, $thumbid);
			}
			public function no_comments_on_page( $file )
			{
				$current_user = wp_get_current_user(); $user_role= '';
				global $post ;
				$active_module=get_option('_iv_directories_active_visibility_page');
				if($active_module=='yes'){
					if(isset($current_user->ID) AND $current_user->ID!=''){
						$user_role= $current_user->roles[0];
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							return $file;
						}
						}else{
						$user_role= 'visitor';
					}
					$have_access=0;
					$store_array=get_option('_iv_visibility_serialize_role');
					if(isset($store_array[$user_role]))	{
						$post_category='';
						if(get_the_category($post->ID)){
							$post_category = get_the_category($post->ID);  // the value is recieved properly
							if(isset($post_category[0]->category_nicename)){
								$post_category=$post_category[0]->category_nicename;
							}
						}
						if(in_array($post_category, $store_array[$user_role])){
							$have_access=1;
							}else{
							$have_access=0;
						}
					}
					$have_access_page=0;
					$store_array_page=get_option('_iv_visibility_serialize_page_role');
					if(isset($store_array_page[$user_role])){
						if(in_array($post->post_name, $store_array_page[$user_role])){
							$have_access_page=1;
							}else{
							$have_access_page=0;
						}
					}
					if($have_access == 0 AND $have_access_page == 0){
						$file =wp_iv_directories_DIR . '/admin/pages/empty-comment-file.php';
					}
				}
				return $file;
			}
			/**
				* Checks that the WordPress setup meets the plugin requirements
				* @global string $wp_version
				* @return boolean
			*/
			private function check_requirements() {
				global $wp_version;
				if (!version_compare($wp_version, $this->wp_version, '>=')) {
					add_action('admin_notices', 'wp_iv_directories::display_req_notice');
					return false;
				}
				return true;
			}
			/**
				* Display the requirement notice
				* @static
			*/
			static function display_req_notice() {
				global $wp_iv_directories;
				echo '<div id="message" class="error"><p><strong>';
				echo esc_html__('Sorry, BootstrapPress re requires WordPress ' . $wp_iv_directories->wp_version . ' or higher.
				Please upgrade your WordPress setup', 'wp-pb');
				echo '</strong></p></div>';
			}
			private function load_dependencies() {
				// Admin Panel
				if (is_admin()) {
					include ('admin/notifications.php');
					include ('admin/admin.php');
				}
				// Front-End Site
				if (!is_admin()) {
				}
				// Global
				include ('inc/widget.php');
			}
			/**
				* Called every time the plug-in is activated.
			*/
			public function activate() {
				include ('install/install.php');
			}
			/**
				* Called when the plug-in is deactivated.
			*/
			public function deactivate() {
				global $wpdb;
				$page_name='price-table';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='registration';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='my-account';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='profile-public';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='thank-you';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='login';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='user-directory';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='iv-reminder-email-cron-job';
				$query =$wpdb->prepare( "delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
			}
			/**
				* Called when the plug-in is uninstalled
			*/
			static function uninstall() {
			}
			/**
				* Register the widgets
			*/
			public function register_widget() {
				register_widget("wp_iv_directories_widget");
			}
			/**
				* Internationalization
			*/
			public function i18n() {
				load_plugin_textdomain('ivdirectories', false, basename(dirname(__FILE__)) . '/languages/' );
			}
			/**
				* Starts the plug-in main functionality
			*/
			public function start() {
			}
			public function iv_directories_display_func($atts = '', $content = '') {
				global $wpdb;
				if (isset($atts['form'])) {
					$form_name = $atts['form'];
					$post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $form_name . "'");
					$content_post = get_post($post_id);
					$content = $content_post->post_content;
				}
				return $content;
			}
			public function iv_directories_price_table_func($atts = '', $content = '') {
				ob_start();
				include( wp_iv_directories_ABSPATH. 'admin/pages/price-table/price-table-1.php');
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_form_wizard_func($atts = '') {
				global $current_user;
				$template_path=wp_iv_directories_template.'signup/';
				ob_start();	  //include the specified file
				if($current_user->ID==0){
					$signup_access= get_option('users_can_register');
					if($signup_access=='0'){
						esc_html_e( 'Sorry! You are not allowed for signup.', 'ivdirectories' );
						}else{
						include( $template_path. 'wizard-style-2.php');
					}
				}else{
					include( wp_iv_directories_template. 'private-profile/profile-template-1.php');
				}	
					$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_profile_template_func($atts = '') {
				global $current_user;
				ob_start();
				if($current_user->ID==0){
					include(wp_iv_directories_template. 'private-profile/profile-login.php');
					}else{
					$tempale=get_option('iv_directories_profile-template');
					//include the specified file
					if($tempale=='style-1'){
						include( wp_iv_directories_template. 'private-profile/profile-template-1.php');
					}
					if($tempale=='style-2'){
						include( wp_iv_directories_template. 'private-profile/profile-template-1.php');
					}
				}
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_reminder_email_cron_func ($atts = ''){
				include( wp_iv_directories_ABSPATH. 'inc/reminder-email-cron.php');
			}
			public function iv_directories_cron_job(){
				include( wp_iv_directories_ABSPATH. 'inc/all_cron_job.php');
				exit(0);
			}
			public function directorypro_categories_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/directorypro_categories.php');
				$content = ob_get_clean();
				return $content;
			}

			public function directorypro_cat_with_sub_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/directorypro_cat_with_subcat.php');
				$content = ob_get_clean();
				return $content;
			}


			public function directorypro_map_func($atts = ''){
				ob_start();
				include( wp_iv_directories_template. 'directories/directories-map.php');
				$content = ob_get_clean();
				return $content;
			}
			public function directorypro_featured_func($atts = ''){
				ob_start();
				if(isset($atts['style']) and $atts['style']!="" ){
					$tempale=$atts['style'];
					}else{
					$tempale=get_option('directorypro_featured');
				}
				if($tempale==''){
					$tempale='style-1';
				}
				//include the specified file
				if($tempale=='style-1'){
					include( wp_iv_directories_template. 'directories/directorypro_featured.php');
				}
				$content = ob_get_clean();
				return $content;
			}
			public function listing_layout_style_4_func($atts=''){
				ob_start();
				include( wp_iv_directories_template. 'directories/archive-directories-style-4.php');
				$content = ob_get_clean();
				return $content;
			}		
			
			public function listing_layout_faceted_grid_func($atts=''){
				ob_start();
				include( wp_iv_directories_template. 'directories/archive-directories-faceted-grid.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listing_layout_grid_left_filter_func($atts = ''){
				global $current_user;
				ob_start();						  //include the specified file
				include( wp_iv_directories_template. 'directories/archive-directories-grid_left_filter.php');
				$content = ob_get_clean();
				return $content;
			}	
			public function listing_detail_func(){
				global $current_user;
				ob_start();						  //include the specified file
				include( wp_iv_directories_template. 'directories/single-listing-shortcode.php');
				$content = ob_get_clean();
				return $content;
			
			}
			public function listing_layout_grid_a_to_z_filter_func($atts = ''){
				global $current_user;
				ob_start();						  //include the specified file
				include( wp_iv_directories_template. 'directories/archive-directories-grid_a_to_z_filter.php');
				$content = ob_get_clean();
				return $content;
			}
				
				
			public function listing_layout_style_5_func($atts=''){
				ob_start();
				include( wp_iv_directories_template. 'directories/archive-directories-style-5.php');
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_user_directory_func($atts = ''){
				global $current_user;
				ob_start();						  //include the specified file
				include( wp_iv_directories_template. 'user-directory/directory-template-2.php');
				$content = ob_get_clean();
				return $content;
			}
			public function iv_directories_profile_public_func($atts = '') {
				ob_start();						  //include the specified file
				include( wp_iv_directories_template. 'profile-public/profile-template-2.php');
				$content = ob_get_clean();
				return $content;
			}
			public function get_search_listing($lat=0,$lng=0,$radius=3,$postcats){
				global $wpdb;
				if($radius==""){$radius='50';}
				if($lat==""){$lat='0';}
				if($lng==""){$lng='0';}
				$results = $wpdb->get_results("SELECT p.ID,
				ACOS(SIN(RADIANS($lat))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS($lat  ))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS($lng))) * 6387.7 AS distance
				FROM $wpdb->posts p
				LEFT JOIN wp_postmeta AS pm1 ON ( p.ID = pm1.post_id AND pm1.meta_key = 'latitude' )
				LEFT JOIN wp_postmeta AS pm2 ON ( p.ID = pm2.post_id AND pm2.meta_key = 'longitude' )
				WHERE post_type = '".$directory_url."' AND post_status = 'publish'
				HAVING distance <= $radius
				ORDER BY distance ASC;");
				$ids='';
				foreach($results as $row){
					$ids=$row->ID.',';
				}
				return $ids;
			}
			public function get_nearest_listing($lat=0,$lng=0,$radius=3){
				global $wpdb;
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				if($radius==""){$radius='50';}
				if($lat==""){$lat='0';}
				if($lng==""){$lng='0';}
				$dir_search_redius=get_option('_dir_search_redius');
				$for_option_redius='6387.7';
				if($dir_search_redius=="Miles"){$for_option_redius='3959';}else{$for_option_redius='6387.7'; }
				$results = $wpdb->get_results("SELECT p.*, pm1.meta_value as lat, pm2.meta_value as lon,
				ACOS(SIN(RADIANS($lat))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS($lat  ))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS($lng))) * ".$for_option_redius." AS distance
				FROM $wpdb->posts p
				LEFT JOIN wp_postmeta AS pm1 ON ( p.ID = pm1.post_id AND pm1.meta_key = 'latitude' )
				LEFT JOIN wp_postmeta AS pm2 ON ( p.ID = pm2.post_id AND pm2.meta_key = 'longitude' )
				WHERE post_type = '".$directory_url."' AND post_status = 'publish'
				HAVING distance <= $radius
				ORDER BY distance ASC;");
				return $results;
			}
			public function iv_directories_contact_popup_listing(){
				include( wp_iv_directories_template. 'directories/contact_popup.php');
				exit(0);
			}
			public function iv_directories_contact_popup(){
				include( wp_iv_directories_template. 'private-profile/contact_popup.php');
				exit(0);
			}
			public function iv_directories_claim_popup(){
				include( wp_iv_directories_template. 'directories/claim.php');
				exit(0);
			}
			public function eplisting_get_categories_caching($id, $post_type){				
				if(metadata_exists('post', $id, 'eplisting-category')) {
					$items = get_post_meta($id,'eplisting-category',true );										
					}else{									
					$items=wp_get_object_terms( $id, $post_type.'-category');
					update_post_meta($id, 'eplisting-category' , $items);
					
				}					
				return $items;
			}
			public function eplisting_get_tag_caching($id, $post_type){				
				if(metadata_exists('post', $id, 'eplisting-tag')) {
					$items = get_post_meta($id,'eplisting-tag',true );										
					}else{									
					$items=wp_get_object_terms( $id, $post_type.'_tag');
					update_post_meta($id, 'eplisting-tag' , $items);
				}					
				return $items;
			}
			
			public function iv_directories_save_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites.', '.get_current_user_id();
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2.', '.$dir_id;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function iv_directories_save_un_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function iv_directories_save_note(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				$dir_id=sanitize_text_field($form_data['id']);
				$note=sanitize_textarea_field($form_data['note']);
				update_post_meta($dir_id,'_note_'.get_current_user_id(),$note);
				echo json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function iv_directories_delete_favorite(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function iv_directories_message_send(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
					parse_str($_POST['form_data'], $form_data);					
				// Create new message post
				$allowed_html = wp_kses_allowed_html( 'post' );					
				if(isset($form_data['dir_id'])){
					if($form_data['dir_id']>0){
						$dir_id=sanitize_text_field($form_data['dir_id']);
						$dir_detail= get_post($dir_id); 
						$dir_title= '<a href="'.get_permalink($dir_id).'">'.$dir_detail->post_title.'</a>';
						$user_id=$dir_detail->post_author;
						$user_info = get_userdata( $user_id);
						$client_email_address =$user_info->user_email;
						$userid_to=$user_id;
						
					}
				}
				if(isset($form_data['user_id'])){
					if($form_data['user_id']!=''){
						$dir_title= '';
						$user_info = get_userdata(sanitize_text_field($form_data['user_id']));
						$client_email_address =$user_info->user_email;
						$userid_to=sanitize_text_field($form_data['user_id']);
					}
					echo'222222';
				}
				$new_nessage= esc_html__( 'New Message', 'jobboard' );
				$my_post=array();
				$subject=$new_nessage;
				if(isset($form_data['subject'])){
					$subject=sanitize_text_field($form_data['subject']);
				} 
				$my_post['post_title'] =$subject;
				$my_post['post_content'] = wp_kses( $form_data['message-content'], $allowed_html); 
				$my_post['post_type'] = 'directorypro_message';
				$my_post['post_status']='private';												
				$newpost_id= wp_insert_post( $my_post );
				Update_post_meta($newpost_id,'user_to', $userid_to );
				Update_post_meta($newpost_id,'dir_url', $dir_title );				
				Update_post_meta($newpost_id,'from_email',sanitize_email($form_data['email_address']) );
				if(isset($form_data['name'])){
					Update_post_meta($newpost_id,'from_name', sanitize_text_field($form_data['name']) );
				}
				Update_post_meta($newpost_id,'from_phone', sanitize_text_field($form_data['visitorphone']) );
				
				include( wp_iv_directories_ABSPATH. 'inc/message-mail.php');
				echo json_encode(array("msg" => esc_html__('Message Sent','ivdirectories')));
				exit(0);
			}
			public function iv_directories_claim_send(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				include( wp_iv_directories_ABSPATH. 'inc/claim-mail.php');
				echo json_encode(array("msg" => esc_html__('Message Sent','ivdirectories')));
				exit(0);
			}
			public function check_write_access($arg=''){
				$current_user = wp_get_current_user();
				$userId=$current_user->ID;
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					return true;
				}
				$package_id=get_user_meta($userId,'iv_directories_package_id',true);
				if($package_id==""){
					global $wpdb; $user_role= $current_user->roles[0];
					$sql="SELECT * FROM $wpdb->posts WHERE post_type = 'iv_directories_pack'";
					$membership_pack = $wpdb->get_results($sql);
					$total_package=count($membership_pack);
					if(sizeof($membership_pack)>0){
						$i=0;
						foreach ( $membership_pack as $row )
						{
							if(get_post_meta($row->ID, 'iv_directories_package_user_role', true)==$user_role ){
								$package_id=$row->ID ;
							}
						}
					}
				}
				$access=get_post_meta($package_id, 'iv_directories_package_'.$arg, true);
				if($access=='yes'){
					return true;
					}else{
					return false;
				}
			}
			public function check_reading_access($arg='',$id=0){
				global $post;
				$current_user = wp_get_current_user();
				$userId=$current_user->ID;
				if($id>0){
					$post = get_post($id);
				}
				if($post->post_author==$userId){
					return true;
				}
				$package_id=get_user_meta($userId,'iv_directories_package_id',true);
				$access=get_post_meta($package_id, 'iv_directories_package_'.$arg, true);
				$active_module=get_option('_iv_directories_active_visibility');
				if($active_module=='yes' ){
					if(isset($current_user->ID) AND $current_user->ID!=''){
						$user_role= $current_user->roles[0];
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							return true;
						}
						}else{
						$user_role= 'visitor';
					}
					$store_array=get_option('_iv_visibility_serialize_role');
					if(isset($store_array[$user_role]))
					{
						if(in_array($arg, $store_array[$user_role])){
							return true;
							}else{
							return false;
						}
						}else{
						return false;
					}
					}else{
					return true;
				}
			}
		}
	}
	if(!class_exists('WP_GeoQuery'))
	{
		/**
			* Extends WP_Query to do geographic searches
		*/
		class WP_GeoQuery extends WP_Query
		{
			private $_search_latitude = NULL;
			private $_search_longitude = NULL;
			private $_search_distance = NULL;
			private $_search_postcats = NULL;
			/**
				* Constructor - adds necessary filters to extend Query hooks
			*/
			public function __construct($args = array())
			{
				$directory_url=get_option('_iv_directory_url');
				if($directory_url==""){$directory_url='directories';}
				// Extract Latitude
				if(!empty($args['lat']))
				{
					$this->_search_latitude = $args['lat'];
				}
				// Extract Longitude
				if(!empty($args['lng']))
				{
					$this->_search_longitude = $args['lng'];
				}
				if(!empty($args['distance']))
				{
					$this->_search_distance = $args['distance'];
				}
				if(!empty($args['directories-category']))
				{
					$this->_search_postcats= $args[$directory_url.'-category'];
				}
				// unset lat/lng
				unset($args['lat'], $args['lng'],$args['distance']);
				add_filter('posts_fields', array(&$this, 'posts_fields'), 10, 2);
				add_filter('posts_join', array(&$this, 'posts_join'), 10, 2);
				add_filter('posts_where', array(&$this, 'posts_where'), 10, 2);
				add_filter('posts_groupby', array($this, 'posts_groupby'), 10, 2);
				add_filter('posts_orderby', array(&$this, 'posts_orderby'), 10, 2);
				parent::query($args);
				remove_filter('posts_fields', array($this, 'posts_fields'));
				remove_filter('posts_join', array($this, 'posts_join'));
				remove_filter('posts_where', array($this, 'posts_where'));
				remove_filter('posts_groupby', array($this, 'posts_groupby'));
				remove_filter('posts_orderby', array($this, 'posts_orderby'));
			} // END public function __construct($args = array())
			/**
				* Selects the distance from a haversine formula
			*/
			public function posts_groupby($where) {
				global $wpdb;
				if($this->_search_longitude!=""){
					if($this->_search_postcats!=""){
						$where .= $wpdb->prepare(" HAVING distance < %d ", $this->_search_distance);
						}else{
						$where = $wpdb->prepare("{$wpdb->posts}.ID  HAVING distance < %d ", $this->_search_distance);
					}
				}
				if($this->_search_postcats!=""){
				}
				return $where;
			}
			public function posts_fields($fields)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude))
				{
					$dir_search_redius=get_option('_dir_search_redius');
					$for_option_redius='6387.7';
					if($dir_search_redius=="Miles"){$for_option_redius='3959';}else{$for_option_redius='6387.7'; }
					$fields .= sprintf(", ( ".$for_option_redius."* acos(
					cos( radians(%s) ) *
					cos( radians( latitude.meta_value ) ) *
					cos( radians( longitude.meta_value ) - radians(%s) ) +
					sin( radians(%s) ) *
					sin( radians( latitude.meta_value ) )
					) ) AS distance ", $this->_search_latitude, $this->_search_longitude, $this->_search_latitude);
					$fields .= ", latitude.meta_value AS latitude ";
					$fields .= ", longitude.meta_value AS longitude ";
				}
				return $fields;
			} // END public function posts_join($join, $query)
			/**
				* Makes joins as necessary in order to select lat/long metadata
			*/
			public function posts_join($join, $query)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$join .= " INNER JOIN {$wpdb->postmeta} AS latitude ON {$wpdb->posts}.ID = latitude.post_id ";
					$join .= " INNER JOIN {$wpdb->postmeta} AS longitude ON {$wpdb->posts}.ID = longitude.post_id ";

				}
				return $join;
			} // END public function posts_join($join, $query)
			/**
				* Adds where clauses to compliment joins
			*/
			public function posts_where($where)
			{
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$where .= ' AND latitude.meta_key="latitude" ';
					$where .= ' AND longitude.meta_key="longitude" ';
				}
				return $where;
			} // END public function posts_where($where)
			/**
				* Adds where clauses to compliment joins
			*/
			public function posts_orderby($orderby)
			{
				if(!empty($this->_search_latitude) && !empty($this->_search_distance))
				{
					$orderby = " distance ASC, " . $orderby;
				}
				return $orderby;
			} // END public function posts_orderby($orderby)
		}
	}
	/*
		* Creates a new instance of the BoilerPlate Class
	*/
	function iv_directoriesBootstrap() {
		return wp_iv_directories::instance();
	}
iv_directoriesBootstrap(); ?>
