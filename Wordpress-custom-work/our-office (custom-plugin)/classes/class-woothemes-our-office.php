<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * WooThemes Offices Class
 *
 * All functionality pertaining to the Offices feature.
 *
 * @package WordPress
 * @subpackage WooThemes_Our_Office
 * @category Plugin
 * @author Matty
 * @since 1.0.0
 */
class Woothemes_Our_Office {
	
	private $dir;
	private $assets_dir;
	private $assets_url;
	private $token;
	public $version;
	private $file;

	/**
	 * Constructor function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( $file ) {
		require_once('property-images-metabox.php');
		$this->dir = dirname( $file );
		$this->file = $file;
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $file ) ) );
		$this->token = 'office-member';

		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		if ( is_admin() ) {
			global $pagenow;
			add_action('admin_init',array( $this, 'add_office_images_metabox'));
			add_action('save_post',array( $this, 'save_office_images_metabox')); 
			add_action( 'admin_menu', array( $this, 'meta_box_setup' ), 20 );
			add_action( 'save_post', array( $this, 'meta_box_save' ) );
			add_filter( 'enter_title_here', array( $this, 'enter_title_here' ) );
			add_action( 'admin_print_styles', array( $this, 'enqueue_admin_styles' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && esc_attr( $_GET['post_type'] ) == $this->token ) {
				add_filter( 'manage_edit-' . $this->token . '_columns', array( $this, 'register_custom_column_headings' ), 10, 1 );
				add_action( 'manage_posts_custom_column', array( $this, 'register_custom_columns' ), 10, 2 );
			}

			// Get users ajax callback
			add_action( 'wp_ajax_get_users', array( $this, 'get_users_callback' ) );
			add_action( 'admin_footer',  array( $this, 'get_users_javascript' ) );

		}

		add_action( 'after_setup_theme', array( $this, 'ensure_post_thumbnails_support' ) );
	} // End __construct()

	/**
	 * Register the post type.
	 *
	 * @access public
	 * @param string $token
	 * @param string 'Offices'
	 * @param string 'Offices'
	 * @param array $supports
	 * @return void
	 */
	public	function add_office_images_metabox(){

		//add_meta_box('office_images_html', __('Add Photos'), "office_images_html", 'office', 'side', 'core');
		add_meta_box( 'office_images_html', __( 'Add Photos', 'office_images_html' ), array( $this, 'office_images_html' ), $this->token, 'side', 'core' );

}
	 
	public function save_office_images_metabox($post_ID){ 

	// on retourne rien du tout s'il s'agit d'une sauvegarde automatique

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )

        return $post_id;

    

   	$list_images = list_office_images();
if ($list_images) {
    foreach($list_images as $k => $i){

	    if ( isset( $_POST[$k] ) ) {

			check_admin_referer('image-liee-save_'.$_POST['post_ID'], 'image-liee-nonce');

			update_post_meta($post_ID, $i, esc_html($_POST[$k])); 

		}

	}
}
}
	 
	public function register_post_type () {
		
		$labels = array(
			'name' 					=> _x( 'Offices', 'post type general name', 'our-office-by-woothemes' ),
			'singular_name' 		=> _x( 'Office', 'post type singular name', 'our-office-by-woothemes' ),
			'add_new' 				=> _x( 'Add New', 'Office', 'our-office-by-woothemes' ),
			'add_new_item' 			=> sprintf( __( 'Add New %s', 'our-office-by-woothemes' ), __( 'Office', 'our-office-by-woothemes' ) ),
			'edit_item' 			=> sprintf( __( 'Edit %s', 'our-office-by-woothemes' ), __( 'Office', 'our-office-by-woothemes' ) ),
			'new_item' 				=> sprintf( __( 'New %s', 'our-office-by-woothemes' ), __( 'Office', 'our-office-by-woothemes' ) ),
			'all_items' 			=> sprintf( __( 'All %s', 'our-office-by-woothemes' ), __( 'Officess', 'our-office-by-woothemes' ) ),
			'view_item' 			=> sprintf( __( 'View %s', 'our-office-by-woothemes' ), __( 'Offices', 'our-office-by-woothemes' ) ),
			'search_items' 			=> sprintf( __( 'Search %a', 'our-office-by-woothemes' ), __( 'Officess', 'our-office-by-woothemes' ) ),
			'not_found' 			=> sprintf( __( 'No %s Found', 'our-office-by-woothemes' ), __( 'Officess', 'our-office-by-woothemes' ) ),
			'not_found_in_trash' 	=> sprintf( __( 'No %s Found In Trash', 'our-office-by-woothemes' ), __( 'Officess', 'our-office-by-woothemes' ) ),
			'parent_item_colon' 	=> '',
			'menu_name' 			=> __( 'Officess', 'our-office-by-woothemes' )


		);
		

		$single_slug = apply_filters( 'woothemes_our_office_single_slug', _x( 'office-member', 'single post url slug', 'our-office-by-woothemes' ) );
		$archive_slug = apply_filters( 'woothemes_our_office_archive_slug', _x( 'office-members', 'post archive url slug', 'our-office-by-woothemes' ) );

		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui'			 	=> true,
			'show_in_menu' 			=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array(
										'slug' 			=> $single_slug,
										'with_front' 	=> false
										),
			'capability_type' 		=> 'post',
			'has_archive' 			=> $archive_slug,
			'hierarchical' 			=> false,
			'supports' 				=> array(
										'title',
										'author',
										'editor',
										'thumbnail',
										'page-attributes'
										),
			'menu_position' 		=> 5,
			
		);
		$args = apply_filters( 'woothemes_our_office_post_type_args', $args );
		register_post_type( $this->token, (array) $args );
	} // End register_post_type()

	/**
	 * Register the "our-office-category" taxonomy.
	 * @access public
	 * @since  1.3.0
	 * @return void
	 */
	/*public function register_taxonomy () {
		$this->taxonomy_category = new Woothemes_Our_Office_Taxonomy(); // Leave arguments empty, to use the default arguments.
		$this->taxonomy_category->register();
	} */// End register_taxonomy()

	/**
	 * Add custom columns for the "manage" screen of this post type.
	 *
	 * @access public
	 * @param string $column_name
	 * @param int $id
	 * @since  1.0.0
	 * @return void
	 */
	public function register_custom_columns ( $column_name, $id ) {
		global $wpdb, $post;

		$meta = get_post_custom( $id );

		switch ( $column_name ) {

			case 'image':
				$value = '';

				$value = $this->get_image( $id, 40 );

				echo $value;
			break;

			default:
			break;

		}
	} // End register_custom_columns()

	/**
	 * Add custom column headings for the "manage" screen of this post type.
	 *
	 * @access public
	 * @param array $defaults
	 * @since  1.0.0
	 * @return void
	 */
	 
	public function register_custom_column_headings ( $defaults ) {
		$new_columns 	= array( 'image' => __( 'Image', 'our-office-by-woothemes' ) );
		$last_item 		= '';

		if ( isset( $defaults['date'] ) ) { unset( $defaults['date'] ); }

		if ( count( $defaults ) > 2 ) {
			$last_item = array_slice( $defaults, -1 );

			array_pop( $defaults );
		}
		$defaults = array_merge( $defaults, $new_columns );

		if ( $last_item != '' ) {
			foreach ( $last_item as $k => $v ) {
				$defaults[$k] = $v;
				break;
			}
		}

		return $defaults;
	} // End register_custom_column_headings()

	/**
	 * Update messages for the post type admin.
	 * @since  1.0.0
	 * @param  array $messages Array of messages for all post types.
	 * @return array           Modified array.
	 */
	public function updated_messages ( $messages ) {
	  global $post, $post_ID;

	  $messages[$this->token] = array(
	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __( 'Offices updated. %sView Offices%s', 'our-office-by-woothemes' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    2 => __( 'Custom field updated.', 'our-office-by-woothemes' ),
	    3 => __( 'Custom field deleted.', 'our-office-by-woothemes' ),
	    4 => __( 'Offices updated.', 'our-office-by-woothemes' ),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __( 'Offices restored to revision from %s', 'our-office-by-woothemes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __( 'Offices published. %sView Offices%s', 'our-office-by-woothemes' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    7 => __('Offices saved.'),
	    8 => sprintf( __( 'Offices submitted. %sPreview Offices%s', 'our-office-by-woothemes' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	    9 => sprintf( __( 'Offices scheduled for: %1$s. %2$sPreview Offices%3$s', 'our-office-by-woothemes' ),
	      // translators: Publish box date format, see http://php.net/date
	      '<strong>' . date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) . '</strong>', '<a target="_blank" href="' . esc_url( get_permalink($post_ID) ) . '">', '</a>' ),
	    10 => sprintf( __( 'Offices draft updated. %sPreview Offices%s', 'our-office-by-woothemes' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	  );

	  return $messages;
	} // End updated_messages()

	/**
	 * Setup the meta box.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	  
	 
	public function office_images_html($post){


	$list_images = list_office_images();



	wp_enqueue_script( 'media-upload' );

	wp_enqueue_script( 'thickbox' );

	wp_enqueue_script( 'quicktags' );

	wp_enqueue_script( 'jquery-ui-resizable' );

	wp_enqueue_script( 'jquery-ui-draggable' );

	wp_enqueue_script( 'jquery-ui-button' );

	wp_enqueue_script( 'jquery-ui-position' );

	wp_enqueue_script( 'jquery-ui-dialog' );

	wp_enqueue_script( 'wpdialogs' );

	wp_enqueue_script( 'wplink' );

	wp_enqueue_script( 'wpdialogs-popup' );

	wp_enqueue_script( 'wp-fullscreen' );

	wp_enqueue_script( 'editor' );

	wp_enqueue_script( 'word-count' );

	wp_enqueue_script( 'img-mb', plugins_url('js/get-images.js',__FILE__), array( 'jquery','media-upload','thickbox','set-post-thumbnail' ) );

	wp_enqueue_style( 'thickbox' );



	wp_nonce_field( 'image-liee-save_'.$post->ID, 'image-liee-nonce');



if ($list_images) {
	echo '<div id="droppable">';

	$z =1;
	foreach($list_images as $k=>$i){

		$meta = get_post_meta($post->ID,$i,true);

		$img = (isset($meta)) ? '<img src="'.wp_get_attachment_thumb_url($meta).'" width="235" height="100" alt="" draggable="false">' : '';

		echo '<div class="image-entry" draggable="true">';

		echo '<input type="hidden" name="'.$k.'" id="'.$k.'" class="id_img" data-num="'.$z.'" value="'.$meta.'">';

		if($meta != ''){		

		echo '<div style="display:block;" class="img-preview" data-num="'.$z.'">'.$img.'</div>';

		}else{

		echo '<div class="img-preview" data-num="'.$z.'">'.$img.'</div>';

		}

		

		

		echo '<a href="javascript:void(0);" class="get-image" data-num="'.$z.'">'._x('Add New','file').'</a><a href="javascript:void(0);" class="del-image " data-num="'.$z.'">'.__('Remove').'</a>';

		

		

		echo '</div>';

		$z++;

	}
	echo '</div>';
}

	?>



	<div style="clear:left;"></div>

	<script>jQuery(document).ready(function($){

		function reorderImages(){

			//reorder images

			$('#droppable .image-entry').each(function(i){

				//rewrite attr

				var num = i+1;

				$(this).find('.get-image').attr('data-num',num);

				$(this).find('.del-image').attr('data-num',num);

				$(this).find('div.img-preview').attr('data-num',num);

				var $input = $(this).find('input');

				$input.attr('name','image'+num).attr('id','image'+num).attr('data-num',num);

			});

		}



		if('draggable' in document.createElement('span')) {

			function handleDragStart(e) {

			  this.style.opacity = '0.4';  // this / e.target is the source node.

			}



			function handleDragOver(e) {

			  if (e.preventDefault) {

			    e.preventDefault(); // Necessary. Allows us to drop.

			  }

			  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

			  return false;

			}



			function handleDragEnter(e) {

			  // this / e.target is the current hover target.

			  this.classList.add('over');

			}



			function handleDragLeave(e) {

				var rect = this.getBoundingClientRect();

	           // Check the mouseEvent coordinates are outside of the rectangle

	           if(e.x > rect.left + rect.width || e.x < rect.left

	           || e.y > rect.top + rect.height || e.y < rect.top) {

	               this.classList.remove('over');  // this / e.target is previous target element.

	           }

			}



			function handleDrop(e) {

			  // this / e.target is current target element.

			  if (e.stopPropagation) {

			    e.stopPropagation(); // stops the browser from redirecting.

			  }

			  // Don't do anything if dropping the same column we're dragging.

			  if (dragSrcEl != this) {

			    // Set the source column's HTML to the HTML of the column we dropped on.

			    dragSrcEl.innerHTML = this.innerHTML;

			    this.innerHTML = e.dataTransfer.getData('text/html');

			    reorderImages();

			  }

			  // See the section on the DataTransfer object.

			  return false;

			}



			function handleDragEnd(e) {

			  // this/e.target is the source node.

			  this.style.opacity = '1';

			  [].forEach.call(cols, function (col) {

			    col.classList.remove('over');

			  });

			}



			var dragSrcEl = null;



			function handleDragStart(e) {

			  // Target (this) element is the source node.

			  this.style.opacity = '0.4';

			  dragSrcEl = this;

			  e.dataTransfer.effectAllowed = 'move';

			  e.dataTransfer.setData('text/html', this.innerHTML);

			}



			var cols = document.querySelectorAll('#droppable .image-entry');

			[].forEach.call(cols, function(col) {

			  col.addEventListener('dragstart', handleDragStart, false);

			  col.addEventListener('dragenter', handleDragEnter, false);

			  col.addEventListener('dragover', handleDragOver, false);

			  col.addEventListener('dragleave', handleDragLeave, false);

			  col.addEventListener('drop', handleDrop, false);

	  		  col.addEventListener('dragend', handleDragEnd, false);

			});

		}else{

			  $( "#droppable" ).sortable({

			  	opacity: 0.4, 

			    cursor: 'move',

			    update: function(event, ui) {

			    	reorderImages()

			    }

			  });

		}

	});</script>

	<style type="text/css">

	[draggable] {

	  -moz-user-select: none;

	  -khtml-user-select: none;

	  -webkit-user-select: none;

	  user-select: none;

	}

	.img-preview{

		position:relative;

		display:none;

		width:235px;

		height:100px;

		/*background:#efefef;*/

		/*border:1px solid #FFF;*/

	}

	.img-preview img{

		position:absolute;

		top:0;

		left:0;

	}

	.image-entry{

		float:left;

		margin:0 10px 10px 0;

		border:1px solid #ccc;

		padding:10px;

		/*background:#FFF;*/

		min-width:235px;

	}

	.image-entry:last-child{margin-right:0;}

	.image-entry.over{

		border: 2px dashed #000;

	}

	.get-image{

		margin-top:10px !important;

		width:50%;

		float:left;

		text-align:center;

	}

	.del-image{

		margin-top:10px !important;

		width:50%;

		float:right;

		text-align:center;

	}

	</style>

	<?php

}
	 
	 
	public function meta_box_setup () {
		add_meta_box( 'office-member-data', __( 'Offices Details', 'our-office-by-woothemes' ), array( $this, 'meta_box_content' ), $this->token, 'normal', 'high' );
	} // End meta_box_setup()

	/**
	 * The contents of our meta box.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function meta_box_content () {
		global $post_id;
		$fields = get_post_custom( $post_id );
		$field_data = $this->get_custom_fields_settings();

		$html = '';

		$html .= '<input type="hidden" name="woo_' . $this->token . '_noonce" id="woo_' . $this->token . '_noonce" value="' . wp_create_nonce( plugin_basename( $this->dir ) ) . '" />';

		if ( 0 < count( $field_data ) ) {
			$html .= '<table class="form-table">' . "\n";
			$html .= '<tbody>' . "\n";

			foreach ( $field_data as $k => $v ) {
				$data = $v['default'];
				if ( isset( $fields['_' . $k] ) && isset( $fields['_' . $k][0] ) ) {
					$data = $fields['_' . $k][0];
				}

				switch ( $v['type'] ) {
					case 'hidden':
						$field = '<input name="' . esc_attr( $k ) . '" type="hidden" id="' . esc_attr( $k ) . '" value="' . esc_attr( $data ) . '" />';
						$html .= '<tr valign="top">' . $field . "\n";
						$html .= '<tr/>' . "\n";
						break;
					default:
						$field = '<input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />';
						$html .= '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label></th><td>' . $field . "\n";
						$html .= '<p class="description">' . $v['description'] . '</p>' . "\n";
						$html .= '</td><tr/>' . "\n";
						break;
				}

			}

			$html .= '</tbody>' . "\n";
			$html .= '</table>' . "\n";
			
			
		}

		echo $html;
		
	} // End meta_box_content()

	/**
	 * Save meta box fields.
	 *
	 * @access public
	 * @since  1.0.0
	 * @param int $post_id
	 * @return void
	 */
	public function meta_box_save ( $post_id ) {
		global $post, $messages;

		// Verify
		if ( ( get_post_type() != $this->token ) || ! wp_verify_nonce( $_POST['woo_' . $this->token . '_noonce'], plugin_basename( $this->dir ) ) ) {
			return $post_id;
		}

		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		$field_data = $this->get_custom_fields_settings();
		$fields = array_keys( $field_data );

		foreach ( $fields as $f ) {

			${$f} = strip_tags(trim($_POST[$f]));

			// Escape the URLs.
			if ( 'url' == $field_data[$f]['type'] ) {
				${$f} = esc_url( ${$f} );
			}

			if ( get_post_meta( $post_id, '_' . $f ) == '' ) {
				add_post_meta( $post_id, '_' . $f, ${$f}, true );
			} elseif( ${$f} != get_post_meta( $post_id, '_' . $f, true ) ) {
				update_post_meta( $post_id, '_' . $f, ${$f} );
			} elseif ( ${$f} == '' ) {
				delete_post_meta( $post_id, '_' . $f, get_post_meta( $post_id, '_' . $f, true ) );
			}
		}
	} // End meta_box_save()

	/**
	 * Customise the "Enter title here" text.
	 *
	 * @access public
	 * @since  1.0.0
	 * @param string $title
	 * @return void
	 */
	public function enter_title_here ( $title ) {
		if ( get_post_type() == $this->token ) {
			$title = __( 'Enter the Offices\'s name here', 'our-office-by-woothemes' );
		}
		return $title;
	} // End enter_title_here()

	/**
	 * Enqueue post type admin CSS.
	 *
	 * @access public
	 * @since   1.0.0
	 * @return   void
	 */
	public function enqueue_admin_styles () {
		wp_register_style( 'woothemes-our-office-admin', $this->assets_url . 'css/admin.css', array(), '1.0.1' );
		wp_enqueue_style( 'woothemes-our-office-admin' );
	} // End enqueue_admin_styles()

	/**
	 * Enqueue post type admin JavaScript.
	 *
	 * @access public
	 * @since   1.0.0
	 * @return   void
	 */
	public function enqueue_admin_scripts () {
		wp_enqueue_script('jquery-ui-autocomplete', null, array('jquery'), null, false);
	} // End enqueue_admin_styles()

	/**
	 * Get the settings for the custom fields.
	 * @since  1.0.0
	 * @return array
	 */
	public function get_custom_fields_settings () {
		$fields = array();

		$fields['office_phone'] = array(
		    'name' 				=> __( 'Phone No', 'our-office-by-woothemes' ),
		    'description' 		=> sprintf( __( 'Enter in a Phone No.', 'our-office-by-woothemes' ), '<a href="' . esc_url( 'http://gravatar.com/' ) . '" target="_blank">', '</a>' ),
		    'type' 				=> 'text',
		    'default' 			=> '',
		    'section' 			=> 'info'
		);
		
			$fields['map_address'] = array(
			    'name' 			=> __( 'Map Address', 'our-office-by-woothemes' ),
			    'description' 	=> __( 'Enter a Office Map Address.', 'our-office-by-woothemes' ),
			    'type' 			=> 'text',
			    'default' 		=> '',
			    'section' 		=> 'info'
			);
	
		

/*		

		if ( apply_filters( 'woothemes_our_office_member_url', true ) ) {
			$fields['url'] = array(
			    'name' 			=> __( 'URL', 'our-office-by-woothemes' ),
			    'description' 	=> __( 'Enter this Offices\'s URL (for example: http://woothemes.com/).', 'our-office-by-woothemes' ),
			    'type' 			=> 'url',
			    'default' 		=> '',
			    'section' 		=> 'info'
			);
		}

		if ( apply_filters( 'woothemes_our_office_member_twitter', true ) ) {
			$fields['twitter'] = array(
			    'name' 			=> __( 'Twitter Username', 'our-office-by-woothemes' ),
			    'description' 	=> __( 'Enter this Offices\'s Twitter username without the @ (for example: woothemes).', 'our-office-by-woothemes' ),
			    'type' 			=> 'text',
			    'default' 		=> '',
			    'section' 		=> 'info'
			);
		}

		if ( apply_filters( 'woothemes_our_office_member_user_search', true ) ) {
			$fields['user_search'] = array(
			    'name' 			=> __( 'WordPress Username', 'our-office-by-woothemes' ),
			    'description' 	=> __( 'Map this Offices to a user on this site.', 'our-office-by-woothemes' ),
			    'type' 			=> 'text',
			    'default' 		=> '',
			    'section' 		=> 'info'
			);
		}*/

		if ( apply_filters( 'woothemes_our_office_member_user_id', true ) ) {
			$fields['user_id'] = array(
			    'name' 			=> __( 'WordPress Username', 'our-office-by-woothemes' ),
			    'description' 	=> __( 'Holds the id of the selected user.', 'our-office-by-woothemes' ),
			    'type' 			=> 'hidden',
			    'default' 		=> 0,
			    'section' 		=> 'info'
			);
		}



		return apply_filters( 'woothemes_our_office_member_fields', $fields );
	} // End get_custom_fields_settings()

	/**
	 * Ajax callback to search for users.
	 * @param  string $query Search Query.
	 * @since  1.1.0
	 * @return json       	Search Results.
	 */
	public function get_users_callback() {

		check_ajax_referer( 'our_office_ajax_get_users', 'security' );

		$term = urldecode( stripslashes( strip_tags( $_GET['term'] ) ) );

		if ( !empty( $term ) ) {

			header( 'Content-Type: application/json; charset=utf-8' );

			$users_query = new WP_User_Query( array(
				'fields'			=> 'all',
				'orderby'			=> 'display_name',
				'search'			=> '*' . $term . '*',
				'search_columns'	=> array( 'ID', 'user_login', 'user_email', 'user_nicename' )
			) );

			$users = $users_query->get_results();
			$found_users = array();

			if ( $users ) {
				foreach ( $users as $user ) {
					$found_users[] = array( 'id' => $user->ID, 'display_name' => $user->display_name );
				}
			}

			echo json_encode( $found_users );

		}

		die();

	}

	/**
	 * Get the image for the given ID. If no featured image, check for Office e-mail.
	 * @param  int 				$id   Post ID.
	 * @param  string/array/int $size Image dimension.
	 * @since  1.0.0
	 * @return string       	<img> tag.
	 */
	protected function get_image ( $id, $size ) {
		$response = '';

		if ( has_post_thumbnail( $id ) ) {
			// If not a string or an array, and not an integer, default to 150x9999.
			if ( ( is_int( $size ) || ( 0 < intval( $size ) ) ) && ! is_array( $size ) ) {
				$size = array( intval( $size ), intval( $size ) );
			} elseif ( ! is_string( $size ) && ! is_array( $size ) ) {
				$size = array( 50, 50 );
			}
			$response = get_the_post_thumbnail( intval( $id ), $size, array( 'class' => 'avatar' ) );
		} else {
			$office_phone = get_post_meta( $id, '_office_phone', true );
			if ( '' != $office_phone && is_email( $office_phone ) ) {
				$response = get_avatar( $office_phone, $size );
			}
		}

		return $response;
	} // End get_image()

	/**
	 * Get Officess.
	 * @param  string/array $args Arguments to be passed to the query.
	 * @since  1.0.0
	 * @return array/boolean      Array if true, boolean if false.
	 */
	public function get_our_office ( $args = '' ) {
		$defaults = array(
			'query_id'		=> 'our_office',
			'limit' 		=> 12,
			'orderby' 		=> 'menu_order',
			'order' 		=> 'DESC',
			'id' 			=> 0,
			'slug'			=> null,
			//'category' 		=> 0,
			'meta_key'		=> null,
			'meta_value'	=> null
		);

		$args = wp_parse_args( $args, $defaults );

		// Allow child themes/plugins to filter here.
		$args = apply_filters( 'woothemes_get_our_office_args', $args );

		// The Query Arguments.
		$query_args 						= array();
		$query_args['query_id']				= $args['query_id'];
		$query_args['post_type'] 			= 'office-member';
		$query_args['numberposts'] 			= $args['limit'];
		$query_args['orderby'] 				= $args['orderby'];
		$query_args['order'] 				= $args['order'];
		$query_args['suppress_filters'] 	= false;

		$ids = explode( ',', $args['id'] );
		if ( 0 < intval( $args['id'] ) && 0 < count( $ids ) ) {
			$ids = array_map( 'intval', $ids );
			if ( 1 == count( $ids ) && is_numeric( $ids[0] ) && ( 0 < intval( $ids[0] ) ) ) {
				$query_args['p'] = intval( $args['id'] );
			} else {
				$query_args['ignore_sticky_posts'] = 1;
				$query_args['post__in'] = $ids;
			}
		}

		if ( $args['slug'] ) {
			$query_args['name'] = esc_html( $args['slug'] );
		}

		// Whitelist checks.
		if ( ! in_array( $query_args['orderby'], array( 'none', 'ID', 'author', 'title', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order', 'meta_value', 'meta_value_num' ) ) ) {
			$query_args['orderby'] = 'date';
		}

		if ( ! in_array( $query_args['order'], array( 'ASC', 'DESC' ) ) ) {
			$query_args['order'] = 'DESC';
		}

		if ( ! in_array( $query_args['post_type'], get_post_types() ) ) {
			$query_args['post_type'] = 'office-member';
		}

		$tax_field_type = '';

		// If the category ID is specified.
		/*if ( is_numeric( $args['category'] ) && 0 < intval( $args['category'] ) ) {
			$tax_field_type = 'id';
		}*/

		// If the category slug is specified.
		/*if ( ! is_numeric( $args['category'] ) && is_string( $args['category'] ) ) {
			$tax_field_type = 'slug';
		}*/

		// If a meta query is specified
		if ( is_string( $args['meta_key'] ) ) {
			$query_args['meta_key'] = esc_html( $args['meta_key'] );
		}

		if ( is_string( $args['meta_value'] ) ) {
			$query_args['meta_value'] = esc_html( $args['meta_value'] );
		}

		// Setup the taxonomy query.
		/*if ( '' != $tax_field_type ) {
			$term = $args['category'];
			if ( is_string( $term ) ) { $term = esc_html( $term ); } else { $term = intval( $term ); }
			$query_args['tax_query'] = array( array( 'taxonomy' => 'office-member-category', 'field' => $tax_field_type, 'terms' => array( $term ) ) );
		}*/

		// The Query.
		$query = get_posts( $query_args );

		// The Display.
		if ( ! is_wp_error( $query ) && is_array( $query ) && count( $query ) > 0 ) {
			foreach ( $query as $k => $v ) {
				$meta = get_post_custom( $v->ID );

				// Get the image.
				$query[$k]->image = $this->get_image( $v->ID, $args['size'] );

				foreach ( (array)$this->get_custom_fields_settings() as $i => $j ) {
					if ( isset( $meta['_' . $i] ) && ( '' != $meta['_' . $i][0] ) ) {
						$query[$k]->$i = $meta['_' . $i][0];
					} else {
						$query[$k]->$i = $j['default'];
					}
				}
			}
		} else {
			$query = false;
		}

		return $query;
	} // End get_our_office()

	/**
	 * Load the plugin's localisation file.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'our-office-by-woothemes', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation()

	/**
	 * Load the plugin textdomain from the main WordPress "languages" folder.
	 * @since  1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'our-office-by-woothemes';
	    // The "plugin_locale" filter is also used in load_plugin_textdomain()
	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain()

	/**
	 * Run on activation.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();
		$this->flush_rewrite_rules();
	} // End activation()

	/**
	 * Register the plugin's version.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	private function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( 'woothemes-our-office' . '-version', $this->version );
		}
	} // End register_plugin_version()

	/**
	 * Flush the rewrite rules
	 * @access public
	 * @since 1.4.0
	 * @return void
	 */
	private function flush_rewrite_rules () {
		$this->register_post_type();
		flush_rewrite_rules();
	} // End flush_rewrite_rules()

	/**
	 * Ensure that "post-thumbnails" support is available for those themes that don't register it.
	 * @since  1.0.1
	 * @return  void
	 */
	public function ensure_post_thumbnails_support () {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) { add_theme_support( 'post-thumbnails' ); }
	} // End ensure_post_thumbnails_support()

	/**
	 * Output admin javascript
	 * @since  1.1.0
	 * @return  void
	 */
	public function get_users_javascript() {

		global $pagenow, $post_type;

		if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && isset( $post_type ) && esc_attr( $post_type ) == $this->token ) {

			$ajax_nonce = wp_create_nonce( 'our_office_ajax_get_users' );

	?>
			<!--<script type="text/javascript" >
				jQuery(function() {
					jQuery( "#user_search" ).autocomplete({
						minLength: 1,
						source: function ( request, response ) {
							jQuery.ajax({
								url: ajaxurl,
								dataType: 'json',
								data: {
									action: 'get_users',
									security: '<?php //echo $ajax_nonce; ?>',
									term: request.term
								},
								success: function( data ) {
									response( jQuery.map( data, function( item ) {
										return {
											label: item.display_name,
											value: item.id
										}
									}));
								}
							});
						},
						select: function ( event, ui ) {
							event.preventDefault();
							jQuery( "#user_search" ).val( ui.item.label );
							jQuery( "#user_id" ).val( ui.item.value );
						}
					});

					// Unset #user_id if #user_search is emptied
					jQuery( '#user_search' ).blur(function() {
					    if ( jQuery(this).val().length == 0 ) {
					        jQuery( "#user_id" ).val( 0 );
					    }
					});

					// Unser #user_id if #user_search is empty on page load
					if ( jQuery( '#user_search' ).val().length == 0 ) {
				        jQuery( "#user_id" ).val( 0 );
				    }
				});
			</script>-->
	<?php
		}
	} //End get_users_javascript

} // End Class
