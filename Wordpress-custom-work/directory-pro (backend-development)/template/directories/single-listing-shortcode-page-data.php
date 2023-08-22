<?php
get_header();
$post_ID=(int)get_option('listing_single_custompage'); 
if (class_exists("\\Elementor\\Plugin")) {  
	$contentElementor = "";	
    $pluginElementor = \Elementor\Plugin::instance();
    $contentElementor = $pluginElementor->frontend->get_builder_content($post_ID);
	echo $contentElementor;
}else{
	$post_data = get_post($post_ID);
	$page_content = $post_data->post_content;
	$page_content = apply_filters('the_content', $page_content);
	$page_content = str_replace(']]>', ']]&gt;', $page_content);
	echo do_shortcode($page_content);
}

get_footer();
	
?>