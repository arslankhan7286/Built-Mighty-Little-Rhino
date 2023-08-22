<?php
get_header(); 
	$opt_style=get_option('_archive_template');
	
	if($opt_style==''){$opt_style='style-5';} 


	if($opt_style=='style-4'){
		echo do_shortcode('[listing_layout_style_4]');
	}elseif($opt_style=='style-5'){
			echo do_shortcode('[listing_layout_style_5]');
	}elseif($opt_style=='style-faceted-grid'){
			echo do_shortcode('[listing_layout_faceted_grid]');	
	}elseif($opt_style=='style-grid-left'){
			echo do_shortcode('[listing_layout_grid_left_filter]');		
	}elseif($opt_style=='style-grid-a_to_z'){
			echo do_shortcode('[listing_layout_grid_a_to_z_filter]');		
	}
	else{
		echo do_shortcode('[listing_layout_style_4]');
	
	}


			
get_footer();
 ?>
