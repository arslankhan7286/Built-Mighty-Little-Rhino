<style>
.bs-callout {
    margin: 20px 0;
    padding: 15px 30px 15px 15px;
    border-left: 5px solid #eee;
}
.bs-callout-info {
    background-color: #E4F1FE;
    border-color: #22A7F0;
}
.html-active .switch-html, .tmce-active .switch-tmce {
	height: 28px!important;
	}
	.wp-switch-editor {
		height: 28px!important;
	}
</style>	
<?php
wp_enqueue_media(); 
$directory_url=get_option('_iv_directory_url');
if($directory_url==""){$directory_url='directories';}
$cpt_category_link=get_admin_url().'edit-tags.php?taxonomy='.$directory_url.'-category&post_type='.$directory_url;

?>

<h3  class=""><?php esc_html_e('Category Image / Map Marker','ivdirectories'); ?>  <small><a href="<?php echo esc_url($cpt_category_link);?>" class="btn btn-info btn-xs"><?php esc_html_e('Create New Caterory','ivdirectories'); ?></a></small>	

</h3>
<br/>
<div id="update_message"> </div>	
	<form class="form-horizontal" role="form"  name='map_marker' id='map_marker'>
		<div class="row ">
			<div class="col-md-12 ">
			<table class="table table-bordered table-hover table-responsive">												  
			  <thead>
				<tr>
				  <th><?php esc_html_e('Category Main','ivdirectories'); ?>  </th>
				  <th><?php esc_html_e('Sub Category','ivdirectories'); ?>  </th>
				  <th><?php esc_html_e('Map Marker','ivdirectories'); ?> </th>
				   <th><?php esc_html_e('Category Image','ivdirectories'); ?> </th>
				</tr>
			  </thead>
			  <tbody>
			  <?php	
			  $directory_url=get_option('_iv_directory_url');					
			 if($directory_url==""){$directory_url='directories';}			
					//directories
					$taxonomy = $directory_url.'-category';
					$args = array(
						'orderby'           => 'name', 
						'order'             => 'ASC',
						'hide_empty'        => false, 
						'exclude'           => array(), 
						'exclude_tree'      => array(), 
						'include'           => array(),
						'number'            => '', 
						'fields'            => 'all', 
						'slug'              => '',
						'parent'            => '0',
						'hierarchical'      => true, 
						'child_of'          => 0,
						'childless'         => false,
						'get'               => '', 
						
					);
					$terms = get_terms($taxonomy,$args); // Get all terms of a taxonomy
					if ( $terms && !is_wp_error( $terms ) ) :
					
						foreach ( $terms as $term ) {  ?>
							<tr>							  
							  <th>							
									
									<?php echo strtoupper($term->name);  ?>									
									<input type="hidden" name="<?php echo esc_html($term->slug);?>" id="<?php echo esc_html($term->slug);?>" value="<?php echo esc_html($term->term_id);?>">
							</th>
							<th>
									
							</th>
							<th> 
							
								<div id="marker_<?php echo esc_html($term->term_id);?>" class="col-md-2">
								<?php
									$marker = get_option('_cat_map_marker_'.$term->term_id);
									if($marker!=''){
										echo wp_get_attachment_image($marker);																	
									}else{ ?>
										<img  width="20px" src="<?php echo  wp_iv_directories_URLPATH."/assets/images/map-marker/map-marker.png";?>">	
								<?php									
									}
								?>
								</div>
							
							<button type="button" onclick="change_marker_image('<?php echo esc_html($term->term_id);?>');"  class="btn btn-success btn-xs"><?php esc_html_e( 'Change Image', 'ivdirectories' );?></button>
							</th>	
							<th> 
									<div id="cate_<?php echo esc_html($term->term_id);?>" class="">
										<?php
											$marker = get_option('_cate_main_image_'.$term->term_id);
											if($marker!=''){
												echo wp_get_attachment_image($marker);																	
											}else{ ?>
												
										<?php									
											}
										?>
										</div>	
										<br/>
									 
									<button type="button" onclick="change_cate_image('<?php echo esc_html($term->term_id);?>');"  class="btn btn-success btn-xs"><?php esc_html_e( 'Set Image', 'ivdirectories' );?></button>
									</th>
						</tr>
						<?php
								$category_id=$term->term_id;
										 											
										$args2 = array(
												'type'                     => $directory_url,
												'child_of'                 => $category_id,
												'parent'                   => '',
												'orderby'                  => 'name',
												'order'                    => 'ASC',
												'hide_empty'               => 0,
												'hierarchical'             => 1,
												'exclude'                  => '',
												'include'                  => '',
												'number'                   => '',
												'taxonomy'                 => $directory_url.'-category',
												'pad_counts'               => false 

											); 											
											$categories = get_categories( $args2 );
										
							
								if ( $categories && !is_wp_error( $categories ) ) :										
									foreach ( $categories as $term_sub ) { ?>
										<tr>							  
											<th>	
											</th>
											<th>
												<?php echo esc_html($term_sub->name);  ?>		
											</th>
											<th> 
											<div id="marker_<?php echo esc_html($term_sub->term_id);?>" class="col-md-2">
												<?php
													$marker = get_option('_cat_map_marker_'.$term_sub->term_id);
													if($marker!=''){
														echo wp_get_attachment_image($marker);																	
													}else{ ?>
														<img  width="20px" src="<?php echo  wp_iv_directories_URLPATH."/assets/images/map-marker/map-marker.png";?>">	
												<?php									
													}
												?>
												</div>	
											<button type="button" onclick="change_marker_image('<?php echo esc_html($term_sub->term_id);?>');"  class="btn btn-success btn-xs"><?php esc_html_e( 'Change Image', 'ivdirectories' );?></button>
											</th>	
												<th> 
													<div id="cate_<?php echo esc_html($term_sub->term_id);?>" class="">
													<?php
														$marker = get_option('_cate_main_image_'.$term_sub->term_id);
														if($marker!=''){
															echo wp_get_attachment_image($marker);																	
														}else{ ?>
																
													<?php									
														}
													?>
													</div>
												<br/>	
													
													 	<br/>	
												<button type="button" onclick="change_cate_image('<?php echo esc_html($term_sub->term_id);?>');"  class="btn btn-success btn-xs"><?php esc_html_e( 'Set Image', 'ivdirectories' );?></button>
												</th>
										</tr>
									<?php
									} 	
																
								endif;			
					
						
						} 								
					endif;	
					?>
				
			  </tbody>
			</table>  
			 </div> 
		</div>	 
		
	</form>
<script>
  function change_marker_image(cat_image_id){	
				var image_gallery_frame;

              
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: 'Marker Image',
                    button: {
                        text: 'Marker Image',
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {							
							var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
							var search_params = {
								"action": 	"iv_directories_update_map_marker",
								"attachment_id": attachment.id,
								"category_id": cat_image_id,
								"_wpnonce": '<?php echo wp_create_nonce("map-image"); ?>',
							};
                             jQuery.ajax({
										url: ajaxurl,
										dataType: "json",
										type: "post",
										data: search_params,
										success: function(response) {   
											if(response=='success'){					
												
												jQuery('#marker_'+cat_image_id).html('<img width="20px" src="'+attachment.url+'">');                              
						

											}
											
										}
							});									
                              
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}
	  function change_cate_image(cat_image_id){	
				var image_gallery_frame;

           
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: 'Category Image',
                    button: {
                        text: 'Category Image',
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {							
							var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
							var search_params = {
								"action": 	"iv_directories_update_cate_image",
								"attachment_id": attachment.id,
								"category_id": cat_image_id,
								"_wpnonce": '<?php echo wp_create_nonce("cat-image"); ?>',
							};
                             jQuery.ajax({
										url: ajaxurl,
										dataType: "json",
										type: "post",
										data: search_params,
										success: function(response) {   
											if(response=='success'){					
												
												jQuery('#cate_'+cat_image_id).html('<img width="100px" src="'+attachment.url+'">');                              
						

											}
											
										}
							});									
                              
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}
</script>	

