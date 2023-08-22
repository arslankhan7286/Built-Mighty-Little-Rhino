<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'woothemes_get_our_office' ) ) {
/**
 * Wrapper function to get the office members from the Woothemes_Our_Office class.
 * @param  string/array $args  Arguments.
 * @since  1.0.0
 * @return array/boolean       Array if true, boolean if false.
 */
function woothemes_get_our_office ( $args = '' ) {
	global $woothemes_our_office;
	return $woothemes_our_office->get_our_office( $args );
} // End woothemes_get_our_office()
}

/**
 * Enable the usage of do_action( 'woothemes_our_office' ) to display office members within a theme/plugin.
 *
 * @since  1.0.0
 */
add_action( 'woothemes_our_office', 'woothemes_our_office' );




if ( ! function_exists( 'woothemes_our_office' ) ) {
/**
 * Display or return HTML-formatted office members.
 * @param  string/array $args  Arguments.
 * @since  1.0.0
 * @return string
 */
function woothemes_our_office ( $args = '' ) {
	global $post;

	$defaults = apply_filters( 'woothemes_our_office_default_args', array(
		'limit' 					=> 12,
		'per_row' 					=> null,
		'orderby' 					=> 'menu_order',
		'order' 					=> 'DESC',
		'id' 						=> 0,
		'slug'						=> null,
		'display_author' 			=> true,
		'display_additional' 		=> true,
		'display_avatar' 			=> true,
		'display_url' 				=> true,
		'display_twitter' 			=> true,
		'display_author_archive'	=> true,
		'display_role'	 			=> true,
		'effect' 					=> 'fade', // Options: 'fade', 'none'
		'pagination' 				=> false,
		'echo' 						=> true,
		'size' 						=> 250,
		'title' 					=> '',
		'before' 					=> '<div class="widget widget_woothemes_our_office">',
		'after' 					=> '</div>',
		'before_title' 				=> '<h2>',
		'after_title' 				=> '</h2>',
		'category' 					=> 0
	) );

	$args = wp_parse_args( $args, $defaults );

	// Allow child themes/plugins to filter here.
	$args = apply_filters( 'woothemes_our_office_args', $args ); ?>
    
    
   <script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "72af30ed-8290-4178-b5d1-3fdb0b5c43a3", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script type="text/javascript">
jQuery(window).load(function() {
  // The slider being synced must be initialized first
  jQuery('#carousel').flexslider({
    animation: "slide",
    controlNav: true,
    animationLoop: true,
    slideshow: false,
    itemWidth: 155,
    itemMargin: 5,
    asNavFor: '#slider'
  });
   
  jQuery('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
});
</script> 
    
    
    <?php
	
	require_once('library/property-images-metabox.php');  
   
$post_slug = $post->post_name;
 
 if($post_slug == "offices"){
	 
	 
	 $query = woothemes_get_our_office( $args );
			foreach ( $query as $post ) { 
			$post_title = get_the_title( $post );
			 ?>
     
            <h2><a href="<?php echo home_url()."/".$post_title ?>"  class="post_ttl">
            <?php
				echo $post_title;

        	} ?>
      </a></h2>	

	 
<?php	 }else{
 
query_posts(array(post_type => 'office-member' , name=> $post_slug  ));


 if ( have_posts() ) : while ( have_posts() ) : the_post(); 
 $Id = $post->ID;
/* $query = woothemes_get_our_office( $args );
			foreach ( $query as $post ) {
				echo $Id = get_the_id( $post );
			}
    */
 ?>
<h1><?php the_title(); ?></h1>
<div id="PropertyMainDiv" <?php if ($p_detail_sidebar == 1) { ?> style="width:612px;" <?php } ?>>
<div class="SpacerDiv"></div>

<div class="SpacerDiv"></div>
<h3 class="address"></h3>

<div class="SpacerDiv"></div>


         
                
<?php


$offices_imgs = get_offices_images_ids($Id);
if ($offices_imgs == true) { ?>
<div class="ProPhotos">
<!-- Place somewhere in the <body> of your page -->
<div id="slider" class="flexslider">
  <ul class="slides">
    <?php foreach ($offices_imgs as $img_id) { ?>
    <li>
    <?php

$thumb_url = wp_get_attachment_image_src($img_id,'full', true);
 $thumb_url[0];
?>
<img src="<?php  echo $thumb_url[0]; ?>" style="height:500px;"/>
      <?php //echo wp_get_attachment_image($img_id, 'full'); 
	  // echo wp_get_attachment_image($img_id, array('300', '300'));
	  ?>
    </li>
    <?php } ?>
    
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>
<?php $offices_arr_size = count($offices_imgs);
	if ($offices_arr_size > 1) { ?>
	    <div id="carousel" class="flexslider">
  <ul class="slides">
    <?php
	foreach ($offices_imgs as $img_id) { ?>
    <li>
      <?php echo wp_get_attachment_image($img_id); ?>
    </li>
    <?php } ?>
    
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>
<?php } ?>
<?php $map_address =  get_post_meta($Id, '_map_address', true); 
if($map_address != ""){

?>
<div class='googlemap waiting'><div id="map_canvas" style="width: 100%; height: 300px;"></div></div>
		
		<script>jQuery(function(){loadGMap('<?php echo $map_address; ?>', 'map_canvas', 16)});</script>
        
        <?php  }?>

<div class="SpacerDiv"></div>
	<div id="ProDescription">
		<div class="heading">Details</div>
				<div class="SpecLabel">Office Address:</div>
						<div class="SpecInfo"><?php echo the_content($Id); ?></div>
				<div class="SpecLabel">Phone No:</div>
						<div class="SpecInfo"> <?php echo get_post_meta($Id, '_office_phone', true); ?></div> 
	</div>
</div>

<?php } 


endwhile; ?>
            <?php wp_reset_query(); ?>
            <?php endif;

if (get_option('p_share_buttons') == 1) {?>
<span class='st_fblike_hcount' displayText='Facebook Like'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_sharethis_hcount' displayText='ShareThis'></span>





<?php } 


/*	$html = '';

	do_action( 'woothemes_our_office_before', $args );

		// The Query.
		$query = woothemes_get_our_office( $args );

		// The Display.
		if ( ! is_wp_error( $query ) && is_array( $query ) && count( $query ) > 0 ) {

			$class = '';

			if ( is_numeric( $args['per_row'] ) ) {
				$class .= ' columns-' . intval( $args['per_row'] );
			}

			if ( 'none' != $args['effect'] ) {
				$class .= ' effect-' . $args['effect'];
			}

			$html .= $args['before'] . "\n";
			if ( '' != $args['title'] ) {
				$html .= html_entity_decode( $args['before_title'] ) . esc_html( $args['title'] ) . html_entity_decode( $args['after_title'] ) . "\n";			}
			$html .= '<div class="office-members component' . esc_attr( $class ) . '">' . "\n";

			// Begin templating logic.
			$tpl = '<div itemscope itemtype="http://schema.org/Person" class="%%CLASS%%">%%AVATAR%% %%TITLE%% <div id="office-member-%%ID%%"  class="office-member-text" itemprop="description">%%TEXT%% %%AUTHOR%%</div></div>';
			$tpl = apply_filters( 'woothemes_our_office_item_template', $tpl, $args );

			$count = 0;
			foreach ( $query as $post ) {
				$count++;
				$template = $tpl;

				$css_class = apply_filters( 'woothemes_our_office_member_class', $css_class = 'office-member' );
				if ( ( is_numeric( $args['per_row'] ) && ( 0 == ( $count - 1 ) % $args['per_row'] ) ) || 1 == $count ) { $css_class .= ' first'; }
				if ( ( is_numeric( $args['per_row'] ) && ( 0 == $count % $args['per_row'] ) ) ) { $css_class .= ' last'; }

				// Add a CSS class if no image is available.
				if ( isset( $post->image ) && ( '' == $post->image ) ) {
					$css_class .= ' no-image';
				}

				setup_postdata( $post );

				$title 		= '';
				$title_name = '';

				// If we need to display the title, get the data
				if ( ( get_the_title( $post ) != '' ) && true == $args['display_author'] ) {
					$title .= '<h3 itemprop="name" class="member">';

					if ( true == $args['display_url'] && '' != $post->url && apply_filters( 'woothemes_our_office_member_url', true ) ) {
						$title .= '<a href="' . esc_url( $post->url ) . '">' . "\n";
					}

					$title_name = get_the_title( $post );

					$title .= $title_name;

					if ( true == $args['display_url'] && '' != $post->url && apply_filters( 'woothemes_our_office_member_url', true ) ) {
						$title .= '</a>' . "\n";
					}

					$title .= '</h3><!--/.member-->' . "\n";

					$member_role = '';

					if ( true == $args['display_role'] && isset( $post->byline ) && '' != $post->byline && apply_filters( 'woothemes_our_office_member_role', true ) ) {
						$member_role .= ' <p class="role" itemprop="jobTitle">' . $post->byline . '</p><!--/.excerpt-->' . "\n";
					}

					$title .= apply_filters( 'woothemes_our_office_member_fields_display', $member_role );
					

				}

				// Templating engine replacement.
				$template 		= str_replace( '%%TITLE%%', $title, $template );

				$author 		= '';
				$author_text 	= '';

				// If we need to display the author, get the data.
				if ( true == $args['display_additional'] ) {

					$author .= '<ul class="author-details">';

					$member_fields = '';

					if ( true == $args['display_author_archive'] && apply_filters( 'woothemes_our_office_member_user_id', true ) ) {

						$user = $post->user_id;

						// User didn't select an item from the autocomplete list
						// Let's try to get the user from the search query
						if ( 0 == $post->user_id && '' != $post->user_search ) {
							$user = get_user_by( 'slug', $post->user_search );
							if ( $user ) {
								$user = $user->ID;
							}
						}

						if ( 0 != $user ) {
							$member_fields .= '<li class="our-office-author-archive" itemprop="url"><a href="' . get_author_posts_url( $post->user_id ) . '">' . sprintf( __( 'Read posts by %1$s', 'woothemes' ), get_the_title() ) . '</a></li>' . "\n";
						}

					}

					if ( true == $args['display_twitter'] && '' != $post->twitter && apply_filters( 'woothemes_our_office_member_twitter', true ) ) {
						$member_fields .= '<li class="our-office-twitter" itemprop="contactPoint"><a href="//twitter.com/' . esc_html( $post->twitter ) . '" class="twitter-follow-button" data-show-count="false">Follow @' . esc_html( $post->twitter ) . '</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></li>'  . "\n";
					}

$member_fields .=esc_html( $post->email );

					$author .= apply_filters( 'woothemes_our_member_fields_display', $member_fields );

					$author .= '</ul>';

					// Templating engine replacement.
					$template = str_replace( '%%AUTHOR%%', $author, $template );
				} else {
					$template = str_replace( '%%AUTHOR%%', '', $template );
				}

				// Templating logic replacement.
				$template = str_replace( '%%ID%%', get_the_ID(), $template );
				$template = str_replace( '%%CLASS%%', esc_attr( $css_class ), $template );

				if ( isset( $post->image ) && ( '' != $post->image ) && true == $args['display_avatar'] ) {
					//$template = str_replace( '%%AVATAR%%', '<figure itemprop="image">' . $post->image . '</figure>', $template );
				} else {
					//$template = str_replace( '%%AVATAR%%', '', $template );
				}

				// Remove any remaining %%AVATAR%% template tags.
				$template 	= str_replace( '%%AVATAR%%', '', $template );
				$content 	= apply_filters( 'woothemes_our_office_content', wpautop( get_the_content() ), $post );

				// Display bio if Office Member is mapped to a user on this site.
				if ( apply_filters( 'woothemes_our_office_display_bio', true ) && 0 != $user ) {
					if ( '' != get_the_author_meta( 'description', $user ) ) {
						$content = wpautop( get_the_author_meta( 'description', $user ) );
					}
				}

				$template = str_replace( '%%TEXT%%', $content, $template );

				// filter the individual office member html
				$template = apply_filters( 'woothemes_our_office_member_html', $template, $post );

				// Assign for output.
				$html .= $template;
				
			}

			wp_reset_postdata();

			if ( $args['pagination'] == true && count( $query ) > 1 && $args['effect'] != 'none' ) {
				$html .= '<div class="pagination">' . "\n";
				$html .= '<a href="#" class="btn-prev">' . apply_filters( 'woothemes_our_office_prev_btn', '&larr; ' . __( 'Previous', 'our-office-by-woothemes' ) ) . '</a>' . "\n";
		        $html .= '<a href="#" class="btn-next">' . apply_filters( 'woothemes_our_office_next_btn', __( 'Next', 'our-office-by-woothemes' ) . ' &rarr;' ) . '</a>' . "\n";
		        $html .= '</div><!--/.pagination-->' . "\n";
			}
			$html .= '</div><!--/.office-members-->' . "\n";
			$html .= $args['after'] . "\n";
		}


		// Allow child themes/plugins to filter here.
		$html = apply_filters( 'woothemes_our_office_html', $html, $query, $args );

		if ( $args['echo'] != true ) {
			return $html;
		}

		// Should only run is "echo" is set to true.
		echo $html;  */
		?>
        
        </div>
        

        
        <?php
}


		do_action( 'woothemes_our_office_after', $args ); // Only if "echo" is set to true.
} // End woothemes_our_office()
}

if ( ! function_exists( 'woothemes_our_office_shortcode' ) ) {
/**
 * The shortcode function.
 * @since  1.0.0
 * @param  array  $atts    Shortcode attributes.
 * @param  string $content If the shortcode is a wrapper, this is the content being wrapped.
 * @return string          Output using the template tag.
 */
function woothemes_our_office_shortcode ( $atts, $content = null ) {
	$args = (array)$atts;

	$defaults = array(
		'limit' 					=> 12,
		'per_row' 					=> null,
		'orderby' 					=> 'menu_order',
		'order' 					=> 'DESC',
		'id' 						=> 0,
		'slug'						=> null,
		'display_author' 			=> true,
		'display_additional' 		=> true,
		'display_avatar' 			=> true,
		'display_url' 				=> true,
		'display_author_archive'	=> true,
		'display_twitter' 			=> true,
		'display_role'	 			=> true,
		'effect' 					=> 'fade', // Options: 'fade', 'none'
		'pagination' 				=> false,
		'echo' 						=> true,
		'size' 						=> 250,
		'category' 					=> 0,
		'title'						=> '',
		'before_title' 				=> '<h2>',
		'after_title' 				=> '</h2>'
	);

	$args = shortcode_atts( $defaults, $atts );

	// Make sure we return and don't echo.
	$args['echo'] = false;

	// Fix integers.
	if ( isset( $args['limit'] ) ) {
		$args['limit'] = intval( $args['limit'] );
	}

	if ( isset( $args['size'] ) &&  ( 0 < intval( $args['size'] ) ) ) {
		$args['size'] = intval( $args['size'] );
	}

	if ( isset( $args['category'] ) && is_numeric( $args['category'] ) ) {
		$args['category'] = intval( $args['category'] );
	}

	// Fix booleans.
	foreach ( array( 'display_author', 'display_additional', 'display_url', 'display_author_archive', 'display_twitter', 'display_role', 'pagination', 'display_avatar' ) as $k => $v ) {
		if ( isset( $args[$v] ) && ( 'true' == $args[$v] ) ) {
			$args[$v] = true;
		} else {
			$args[$v] = false;
		}
	}

	return woothemes_our_office( $args );

} // End woothemes_our_office_shortcode()
}

add_shortcode( 'woothemes_our_office', 'woothemes_our_office_shortcode' );

if ( ! function_exists( 'woothemes_our_office_content_default_filters' ) ) {
/**
 * Adds default filters to the "woothemes_our_office_content" filter point.
 * @since  1.0.0
 * @return void
 */
function woothemes_our_office_content_default_filters () {
	add_filter( 'woothemes_our_office_content', 'do_shortcode' );
} // End woothemes_our_office_content_default_filters()

add_action( 'woothemes_our_office_before', 'woothemes_our_office_content_default_filters' );
}