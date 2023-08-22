<?php
	global $post,$wpdb,$tag;
	$main_class = new wp_iv_directories;
	wp_enqueue_script("jquery");
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	wp_enqueue_style('iv_directories-style-110', wp_iv_directories_URLPATH . 'admin/files/css/listing_style_7.css');
	wp_enqueue_style('iv_directories-style-111', wp_iv_directories_URLPATH . 'admin/files/css/bootstrap-tagsinput.css');
	wp_enqueue_script('typehead', wp_iv_directories_URLPATH . 'admin/files/js/typehead.bundle.js');
	wp_enqueue_style('colorbox', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	
	$dir_top_img=get_option('dir_top_img');
	if($dir_top_img==""){$dir_top_img='yes';}
	$dir_style_font=get_option('dir_style_font');
	if($dir_style_font==""){$dir_style_font='no';}
	if($dir_style_font=='yes'){
		wp_enqueue_style('epdirpro-font-110', wp_iv_directories_URLPATH . 'admin/files/css/quicksand-font.css');
	}
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$current_post_type=$directory_url;
	$form_action='';
	if ( is_front_page() ) {
		$form_action='action="'.get_post_type_archive_link($current_post_type).'"';
	}
	$locations='';
	$pos='';
	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($_REQUEST['dirsearchtype']) AND $_REQUEST['dirsearchtype']!=''){  	
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
		$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);		
	}elseif(isset($_REQUEST['dirsearch']) AND $_REQUEST['dirsearch']!=''){
		$dirsearchtype='Title';  
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
	}
	if(isset($_REQUEST['locationtype']) AND $_REQUEST['locationtype']!=""){ 
		$locationtype=sanitize_text_field($_REQUEST['locationtype']);
		$location=sanitize_text_field($_REQUEST['location']);
	}elseif(isset($_REQUEST['location']) AND $_REQUEST['location']!=''){
		$locationtype='City'; 
		$location=sanitize_text_field($_REQUEST['location']);
	}
	
	$dir5_background_color=get_option('dir5_background_color');
	if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}
	$dir5_content_color=get_option('dir5_content_color');
	if($dir5_content_color==""){$dir5_content_color='#fff';}
	if(isset($atts['main_background_color'])){
		$dir5_background_color=$atts['main_background_color'];
		if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}
	}
	if(isset($atts['text_background_color'])){
		$dir5_content_color=$atts['text_background_color'];
		if($dir5_content_color==""){$dir5_content_color='#fff';}
	}

?>
<style>
	.fa{
    font: normal normal normal 14px/1 FontAwesome !important;
	}
	.item{
	background:<?php echo esc_html($dir5_content_color);?>!important;
	}
	.facet-parent {
	background:<?php echo esc_html($dir5_content_color);?>!important;
	}
	
</style>
<?php
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>
<div class="bootstrap-wrapper">
	<div class="container px-0">
		<section class="whole-container">
			<div class="row bottomline-parent">
				<div class="col-lg-4 facet-parent h-50 mh-auto item">
				<?php
					$dir_searchbar_show=get_option('_dir_searchbar_show');	
					if($dir_searchbar_show==""){$dir_searchbar_show='yes';}
					if($dir_searchbar_show=="yes"){					
						include(wp_iv_directories_template.'directories/archive-top-search-5.php');				
						}
					?>
					<div class="filter">
						<?php   esc_html_e('Filter Search','ivdirectories');?> <i class="fas fa-align-left"></i>
					</div>
					<div id=facets></div>
				</div>
				<div class="col-lg-8 result-parent">
					<div id="results" class="row"></div>
				</div>
			</div>
			</section>
	</div>
		
</div>

<?php
	$dirs_data=array();
	$tag_arr= array();
	$args = array(
	'post_type' => $directory_url, // enter your custom post type
	'post_status' => 'publish',
	'posts_per_page'=> '-1',
	);
	$dir_listing_sort=get_option('_dir_listing_sort');
	if($dir_listing_sort==""){$dir_listing_sort='date';}
	if($dir_listing_sort=='ASC'){
		$args['orderby']='title';
		$args['order']='ASC';
	}
	if($dir_listing_sort=='DESC'){
		$args['orderby']='title';
		$args['order']='DESC';
	}
	// Date
	if($dir_listing_sort=='date'){
		$args['orderby']='date';
		$args['order']='DESC';
	}
	if($dir_listing_sort=='old-date'){
		$args['orderby']='date';
		$args['order']='ASC';
	}
	if($dir_listing_sort=='rand'){
		$args['orderby']='rand';
		$args['order']='ASC';
	}

	$dirsearch='';
	$dirsearchtype='';
	$locationtype='';
	$location='';
	if(isset($_REQUEST['dirsearch'])){
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
	}
	if(isset($_REQUEST['dirsearchtype']) AND $_REQUEST['dirsearchtype']!=''){  	
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
		$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);		
	}elseif(isset($_REQUEST['dirsearch']) AND $_REQUEST['dirsearch']!=''){
		$dirsearchtype='Title';  
		$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
	}
	if(isset($_REQUEST['locationtype']) AND $_REQUEST['locationtype']!=""){ 
		$locationtype=sanitize_text_field($_REQUEST['locationtype']);
		$location=sanitize_text_field($_REQUEST['location']);
	}elseif(isset($_REQUEST['location']) AND $_REQUEST['location']!=''){
		$locationtype='City'; 
		$location=sanitize_text_field($_REQUEST['location']);
	}
	$dir_facet_title=get_option('dir_facet_cat_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		
		$dirsearch= get_term_by('name',$dirsearch, $directory_url.'-category');
		if( isset($dirsearch->slug)){
			$args[$directory_url.'-category']=$dirsearch->slug;
		}
	}
	$dir_facet_title=get_option('dir_facet_features_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args[$directory_url.'_tag']=$dirsearch;
	}
	$dir_facet_title= esc_html__('Title','ivdirectories');
	if(strtolower($dir_facet_title)==strtolower($dirsearchtype)){
		$args['s']= $dirsearch;
	}
	if($dirsearchtype=="" AND $dirsearch!=''){
		$args['s']= $dirsearch;
	}
	$dir_facet_title=get_option('dir_facet_location_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivdirectories');}
	$city_mq ='';
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$area_mq='';
	$dir_facet_title=get_option('dir_facet_area_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$area_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'area',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq='';
	$zip_mq='';
	$dir_facet_title=get_option('dir_facet_zipcode_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivdirectories');}
	if(strtolower($dir_facet_title)==strtolower($locationtype)){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => $location,
		'compare' => 'LIKE'
		),
		);
	}
	if(isset($atts['category']) and $atts['category']!="" ){
		$postcats = $atts['category'];
		$args[$directory_url.'-category']=$postcats;
	}
	if(get_query_var($directory_url.'-category')!=''){
		$postcats = get_query_var($directory_url.'-category');
		$args[$directory_url.'-category']=$postcats;
		$selected=$postcats;
		$search_show=1;
	}
	if( isset($_POST[$directory_url.'-category'])){
		if($_POST[$directory_url.'-category']!=''){
			$postcats = sanitize_text_field($_POST[$directory_url.'-category']);
			$args[$directory_url.'-category']=$postcats;
			$selected=$postcats;
		}
	}
	if( isset($_REQUEST['keyword'])){
		if($_REQUEST['keyword']!=""){
			$args['s']= sanitize_text_field($_REQUEST['keyword']);
			$keyword_post=sanitize_text_field($_REQUEST['keyword']);
			$search_show=1;
		}
	}
	if(get_query_var($directory_url.'_tag')!=''){
		$postcats = get_query_var($directory_url.'_tag');
		$args[$directory_url.'_tag']=$postcats;
		$search_show=1;
	}
	// Meta Query***********************
	$city_mq2 ='';
	if(isset($_REQUEST['dir_city']) AND $_REQUEST['dir_city']!=''){
		$city_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'city',
		'value'   => sanitize_text_field($_REQUEST['dir_city']),
		'compare' => 'LIKE'
		),
		);
	}
	$country_mq2='';
	if(isset($_REQUEST['dir_country']) AND $_REQUEST['dir_country']!=''){
		$country_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'country',
		'value'   => sanitize_text_field($_REQUEST['dir_country']),
		'compare' => 'LIKE'
		),
		);
	}
	$zip_mq2='';
	if(isset($_REQUEST['zipcode']) AND $_REQUEST['zipcode']!=''){
		$zip_mq = array(
		'relation' => 'AND',
		array(
		'key'     => 'postcode',
		'value'   => sanitize_text_field($_REQUEST['zipcode']),
		'compare' => 'LIKE'
		),
		);
	}
	// For featrue listing***********
	$feature_listing_all =array();
	$feature_listing_all =$args;
	$args['meta_query'] = array(
	$city_mq, $country_mq, $zip_mq,$area_mq,$city_mq2, $country_mq2, $zip_mq2,
	);
	$dir_top_img=get_option('dir_top_img');
	if($dir_top_img==""){$dir_top_img='yes';}
	$dir5_review_show=get_option('dir5_review_show');
	if($dir5_review_show==""){$dir5_review_show='no';}
	$dir_tags=get_option('_dir_tags');
	if($dir_tags==""){$dir_tags='yes';}
	$dir_style5_call=get_option('dir_style5_call');
	if($dir_style5_call==""){$dir_style5_call='yes';}
	$dir_style5_sms=get_option('dir_style5_sms');
	if($dir_style5_sms==""){$dir_style5_sms='yes';}
	$dir_style5_email=get_option('dir_style5_email');	
	if($dir_style5_email==""){$dir_style5_email='yes';}
	
	include( wp_iv_directories_template. 'directories/archive_feature_listing5.php');
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$dir_data=array();
	$id = get_the_ID();
	if(get_post_meta($id, 'dirpro_featured', true)!='featured'){
		$dir_data['id']=$id;
		$dir_data['link']=get_permalink($id);
		$dir_data['title']=$post->post_title;
		$dir_data['dir_top_img']=$dir_top_img;
		$feature_img='';
		if(has_post_thumbnail()){
			$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
			if($feature_image[0]!=""){
				$feature_img =$feature_image[0];
			}
			}else{
			$feature_img= $this->get_dirpro_listing_default_image();
		}
		$dir_data['imageURL']=  $feature_img;
		$cat_arr=array();
		$currentCategory = $main_class->eplisting_get_categories_caching($id,$directory_url);
		$cat_name2='';	
		if(isset($currentCategory[0]->slug)){
			$cat_name2 = $currentCategory[0]->name;
			$cc=0;
			foreach($currentCategory as $c){
				$cat_arr[]=ucfirst($c->name);
			}
		}
		$dir_data['category']=$cat_arr;
		
		if($dir5_review_show=='yes'){
			$dir_data['review_show']='yes';
			$total_reviews_point = $wpdb->get_col( $wpdb->prepare( "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = 'review_value'
			AND p.post_status = 'publish'
			AND p.post_type = 'dirpro_review' AND p.post_author = %s", $id ));
			$argsreviw = array( 'post_type' => 'dirpro_review','author'=>$id,'post_status'=>'publish' );
			$ratings = new WP_Query( $argsreviw );
			$total_review_post = $ratings->post_count;
			$avg_review=0;
			if(isset($total_reviews_point[0])){
				$avg_review= (float)$total_reviews_point[0]/(float)$total_review_post;
			}
			$dir_data['avg_review']=$avg_review;
			if($avg_review>=1){
				if($avg_review==1){
					$dir_data['review']=(int)$avg_review.esc_html__(' Star','ivdirectories');
				}
				if($avg_review>1){
					$dir_data['review']=(int)$avg_review.esc_html__(' Stars','ivdirectories');
				}
				}else{
			}
			}else{
			$dir_data['review_show']='no';
		}
		$phone='';
		$dir_data['phone']='';
		$listing_contact_source=get_post_meta($id,'listing_contact_source',true);
		if($listing_contact_source==''){$listing_contact_source='new_value';}
		if($listing_contact_source=='new_value'){
			$dir_data['phone']=	get_post_meta($id,'phone',true);
			$phone=get_post_meta($id,'phone',true);
			$dir_data['email']=get_post_meta($id,'email',true);
			$contact_web=get_post_meta($id,'contact_web',true);
			$contact_web=str_replace('https://','',$contact_web);
			$contact_web=str_replace('http://','',$contact_web);
			$dir_data['web']=	$contact_web;
			}else{
			$post_author_id= $the_query->post->post_author;
			$agent_info = get_userdata($post_author_id);
			if(get_user_meta($post_author_id,'phone',true)!=""){
				$dir_data['phone']=	get_user_meta($post_author_id,'phone',true);
				$phone=get_user_meta($post_author_id,'phone',true);
			}
			$contact_web=get_user_meta($post_author_id,'web_site',true);
			$contact_web=str_replace('https://','',$contact_web);
			$contact_web=str_replace('http://','',$contact_web);
			$dir_data['web']=	$contact_web;
			$dir_data['email']=$agent_info->user_email;
		}
		
		$dirpro_call_button=get_post_meta($id,'dirpro_call_button',true);
		if($dirpro_call_button==""){$dirpro_call_button='yes';}
		if($dir_style5_call=="yes" AND $dirpro_call_button=='yes'){
			$dir_data['call_button']='yes';
			if($dir_data['phone']==''){$dir_data['call_button']='no';}
			}else{
			$dir_data['call_button']='no';
		}
		
		$dirpro_email_button=get_post_meta($id,'dirpro_email_button',true);
		if($dirpro_email_button==""){$dirpro_email_button='yes';}
		if($dir_style5_email=="yes" AND $dirpro_email_button=='yes'){
			$dir_data['email_button']='yes';
			}else{
			$dir_data['email_button']='no';
		}
		
		$dirpro_sms_button=get_post_meta($id,'dirpro_sms_button',true);
		if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
		if($dir_style5_sms=="yes" AND $dirpro_sms_button=='yes'){
			$dir_data['sms_button']='yes';
			if($phone==''){$dir_data['sms_button']='no';}
			}else{
			$dir_data['sms_button']='no';
		}
		$loc_arr=array();
		$dir_data['address']= get_post_meta($id,'address',true);
		$dir_data['city']=ucwords(strtolower(trim(get_post_meta($id,'city',true))));
		if(trim(get_post_meta($id,'city',true))!=""){
			array_push( $loc_arr, ucwords(trim(get_post_meta($id,'city',true))) );
		}
		if(trim(get_post_meta($id,'state',true))!=''){
			$dir_data['state']= ucwords(strtolower(trim(get_post_meta($id,'state',true))));
		}
		if(get_post_meta($id,'postcode',true)!=''){
			$dir_data['zipcode']= ucwords(get_post_meta($id,'postcode',true));
		}
		if(get_post_meta($id,'area',true)!=''){
			$dir_data['area']= ucwords(strtolower(trim(get_post_meta($id,'area',true))));
		}
		if(get_post_meta($id,'country',true)!=''){
			$dir_data['country']= ucwords(strtoupper(trim(get_post_meta($id,'country',true))));
		}
		if(trim(get_post_meta($id,'city',true))!=""){
			$city_v=strtolower(trim(get_post_meta($id,'city',true)));
			$dir_data['location']=  ucwords($city_v);
		}
		// Tag***
		if($dir_tags=='yes'){
			$tag_array=$currentCategory = $main_class->eplisting_get_tag_caching($id,$directory_url);
			}else{
			$tag_array= wp_get_post_tags( $id );
		}
		$tagg_arr=array();
		foreach($tag_array as $one_tag){
			$tagg_arr[]=ucfirst($one_tag->name);
		}
		if (!empty($tagg_arr)) {
			$dir_data['feature']=  $tagg_arr;
		}
		array_push( $dirs_data, $dir_data );
	}
	endwhile;
	endif;
	$dirs_data_json= json_encode($dirs_data);
	$facets = array();
	$dir_facet_show=get_option('dir_facet_cat_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_cat_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['category']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_location_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_location_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('City','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['location']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_area_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_area_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['area']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_features_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_features_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['feature']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_zipcode_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_zipcode_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['zipcode']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_state_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_state_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('State','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['state']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_country_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_country_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Country','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['country']=$dir_facet_title;
	}
	$dir_facet_show=get_option('dir_facet_review_show');
	if($dir_facet_show==""){$dir_facet_show='yes';}
	$dir_facet_title=get_option('dir_facet_review_title');
	if($dir_facet_title==""){$dir_facet_title= esc_html__('Reviews','ivdirectories');}
	if($dir_facet_show=="yes"){
		$facets['review']=$dir_facet_title;
	}
	$facets_json= json_encode($facets);

?>
<?php
	$dir_style5_perpage=get_option('dir_style5_perpage');
	if($dir_style5_perpage==""){$dir_style5_perpage=20;}
	wp_enqueue_script('iv_directory-ar-script-29', wp_iv_directories_URLPATH . 'admin/files/js/underscore-1.1.7.js');
	wp_enqueue_script('iv_directory-ar-script-32', wp_iv_directories_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('iv-bootstrap-4-js', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	
	wp_enqueue_script('iv_directory-ar-script-30', wp_iv_directories_URLPATH . 'admin/files/js/facetedsearch.js');
	wp_localize_script('iv_directory-ar-script-30', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loadmore'=>esc_html__('Load More','ivdirectories'),
	'nolisting'=>esc_html__("Sorry, but no items match these criteria",'ivdirectories'),
	'Sortby'=>esc_html__("Sort by",'ivdirectories'),
	'Results'=>esc_html__("Results",'ivdirectories'),
	'Deselect'=>esc_html__("Deselect all filters",'ivdirectories'),
	'perpage'=>$dir_style5_perpage,
	) );
	wp_enqueue_script('iv_directory-ar-script-27', wp_iv_directories_URLPATH . 'admin/files/js/archive-listing-faceted-grid.js');
	wp_localize_script('iv_directory-ar-script-27', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'wp_iv_directories_URLPATH'		=> wp_iv_directories_URLPATH,
	'current_user_id'	=>get_current_user_id(),
	'facets_json'		=>$facets_json,
	'dirpro_items'		=>$dirs_data_json,
	'call'		=>esc_html__('Call','ivdirectories'),
	'featured'=>esc_html__('featured','ivdirectories'),
	'email'=>esc_html__('Email','ivdirectories'),
	'SMS'=>esc_html__('SMS','ivdirectories'),
	'message'=>esc_html__('Please put your email','ivdirectories'),
	'detail'=>esc_html__('Detail','ivdirectories'),
	'web'=>esc_html__('Web','ivdirectories'),
	'title'=>esc_html__('Title','ivdirectories'),
	'category'=>esc_html__('Category','ivdirectories'),
	'random'=>esc_html__('Random','ivdirectories'),
	'perpage'=>$dir_style5_perpage,
	'dirwpnonce'=> wp_create_nonce("listing"),
	'pos'=>$pos,
	'locations'=>$locations,
	'SMSbody'=>'I would like to inquire about the listing. The listing can be found on the site :'.site_url(),
	) );
?>
