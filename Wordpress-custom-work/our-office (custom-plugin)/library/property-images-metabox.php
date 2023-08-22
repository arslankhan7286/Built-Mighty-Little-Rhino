<?php

function list_offices_images( $ptyimg = false ){
$p_num_slider_pics = get_option('p_num_slider_pics');
for ($i = 1; $i <= $p_num_slider_pics; $i++) {
	$arrayval['office_image'.$i] = '_office_image'.$i;
}

	$list_images = apply_filters('list_images',$arrayval, $ptyimg );
	return $list_images;

}


function get_offices_images_ids($thumbnail = false, $id = false){

	global $post;

	$the_id = ($id) ? $id : $post->ID;



	$list_images = list_offices_images( get_post_type( $id ) );



	$a = array();
if ($list_images) {
	foreach ($list_images as $key => $img) {

		if($i = get_post_meta($the_id,$img,true))

			$a[$key] = $i;
	}
	}

	if($thumbnail){

		$thumb_id = get_post_thumbnail_id($the_id);

		if(!empty($thumb_id)) array_unshift($a, get_post_thumbnail_id($the_id));

	} 

	return $a;

}



function get_offices_images_src($size = 'medium',$thumbnail = false, $id = false){

	if($id)

		$images = $thumbnail ? get_offices_images_ids(true,$id) : get_offices_images_ids(false,$id);

	else 

		$images = $thumbnail ? get_offices_images_ids(true) : get_offices_images_ids();

	$o = array();

	foreach($images as $k => $i)

		$o[$k] = wp_get_attachment_image_src($i, $size);

	return $o;

}



function get_multi_offices_images_src($small = 'thumbnail',$large = 'full',$thumbnail = false, $id = false){

	if($id)

		$images = $thumbnail ? get_offices_images_ids(true,$id) : get_offices_images_ids(false,$id);

	else 

		$images = $thumbnail ? get_offices_images_ids(true) : get_offices_images_ids();

	$o = array();

	foreach($images as $k => $i)

		$o[$k] = array(wp_get_attachment_image_src($i, $small),wp_get_attachment_image_src($i, $large));

	return $o;

}