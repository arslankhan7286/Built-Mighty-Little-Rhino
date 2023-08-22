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

?>
<h3  class=""><?php esc_html_e('Cities Images','ivdirectories'); ?>  <small><?php esc_html_e('[Cities will get from your listings]','ivdirectories'); ?> </small>	
</h3>

<br/>
<div id="update_message-city"> </div>	
	<form class="form-horizontal" role="form"  name='map_marker' id='map_marker'>
		<div class="row ">
			<div class="col-md-12 ">
			<table class="table table-bordered table-hover table-responsive">												  
			  <thead>
				<tr>
				  <th><?php esc_html_e('City Name','ivdirectories'); ?>  </th>			
				
				   <th><?php esc_html_e('City Image','ivdirectories'); ?> </th>
				</tr>
			  </thead>
			  <tbody>			 
				<?php		
						
						// City
						$args_citys = array(
							'post_type'  => $directory_url,
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key'     => 'city',
									'orderby' => 'meta_value',
									'order' => 'ASC',
								),

							),
						);
						$citys = new WP_Query( $args_citys );
						$citys_all = $citys->posts;
						$get_cityies =array();
						foreach ( $citys_all as $term ) {
							$new_city="";
							$new_city=get_post_meta($term->ID,'city',true);
							if (!in_array($new_city, $get_cityies)) {
								$get_cityies[]=$new_city;

							}
						}

					// City
					if(count($get_cityies)) {
						asort($get_cityies);
						foreach($get_cityies as $row1){
							if($row1!=''){ ?>
								<tr>							  
									<th>						
									
											<?php echo ucfirst($row1);  ?>									
											<input type="hidden" name="<?php echo str_replace(' ','-',$row1);?>" value="<?php echo str_replace(' ','-',$row1);?>">
									</th>					
									
									<th> 
												<div id="city_<?php echo str_replace(' ','-',strtolower($row1));?>" class="">
												<?php
													$marker = get_option('city_main_image_'.str_replace(' ','-',strtolower($row1)));
													if($marker!=''){
														echo wp_get_attachment_image($marker);																
													} 
												?>
												</div>	
												<br/>
											 
											<button type="button" onclick="change_city_image('<?php echo str_replace(' ','-',strtolower($row1));?>');"  class="btn btn-success btn-xs">
											<?php  esc_html_e('Set Image','ivdirectories');?> </button>
									</th>
								</tr>
							
							<?php
							}
						}	
					}
					
					?>	
			  </tbody>
			</table>  
			 </div> 
		</div>	 
		<?php wp_nonce_field( 'city-image' ); ?>
	</form>
<script>
	function change_city_image(city_image_id){	
				var image_gallery_frame;


                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php esc_html_e( 'City Image', 'ivdirectories' ); ?>',
                    button: {
                        text: '<?php esc_html_e( 'City Image', 'ivdirectories' ); ?>',
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
								"action": 	"iv_property_update_city_image",
								"attachment_id": attachment.id,
								"city_id": city_image_id,
								"_wpnonce": '<?php echo wp_create_nonce("city-image"); ?>', 
							};
                             jQuery.ajax({
										url: ajaxurl,
										dataType: "json",
										type: "post",
										data: search_params,
										success: function(response) {   
											if(response=='success'){ 				
												
												jQuery('#city_'+city_image_id).html('<img width="100px" src="'+attachment.url+'">');                              
						

											}
											
										}
							});									
                              
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}
</script>	

