<?php
wp_enqueue_style('wp-iv_directories-bidding-style-101', wp_iv_directories_URLPATH . 'admin/files/css/bidding.css');
wp_enqueue_style('wp-iv_directories-bidding-style-102', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
wp_enqueue_script('wp-iv_directories-bidding-script-103', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	$directory_url=get_option('_iv_directory_url');					
	if($directory_url==""){$directory_url='directories';}
	
	$profile_url=get_permalink(); 
	global $current_user;
	 $current_user = wp_get_current_user();
	$user = $current_user->ID;
	$message='';
if(isset($_GET['delete_id']))  {
	$post_id=sanitize_text_field($_GET['delete_id']);
	$post_edit = get_post($post_id); 
	
	if($post_edit->post_author==$current_user->ID){
		wp_delete_post($post_id);
		delete_post_meta($post_id,true);
		$message="Deleted Successfully";
	}

	
	
}
?>  
<style>
.boxo{ border:1px solid #ccc; border-radius:0 0 6px 6px; padding:15px 0}
.picwrapper{ padding:0}

.addnote{ background:#f5f5f5; padding:10px 0; margin:20px; clear:both}
.addnote textarea{ width:100%}
</style>
   
     <div class="profile-content">
            
              <div class="portlet light">
                  <div class="portlet-title tabbable-line clearfix">
                    <div class="caption caption-md">
                      <span class="caption-subject"> 
					  <?php
											
								esc_html_e('My Favorites','ivdirectories');		
						?></span>
                    </div>
					
                  </div>
                  
                  <div class="portlet-body">
                   <div class="row boxo"> 
							<div class="col-lg-12 col-sm-12">	
									<div class="srchresultwrapper">	
								 <?php 
									$favorites=get_user_meta(get_current_user_id(),'_dir_favorites', true);	
									$favorites_a = array();
									$favorites_a = explode(",", $favorites);									
									$ids = array_filter($favorites_a);
									
									$my_favorites = query_posts(array('post__in' => $ids,'post_type'=> $directory_url));
																	
									if(sizeof($ids)>0){
									foreach ($my_favorites as $post) {								 
								
										?> 
									 
										<div class="srchresult" id="main_<?php echo esc_html($post->ID);?>">
										  <div class="col-lg-3 col-sm-3 col-xs-3">
										  
										<div class="picwrapper">
												<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'medium' ); 
													if($feature_image[0]!=""){ ?>												
														<a href="<?php echo get_permalink($post->ID); ?>" > <img title="dir image"   src="<?php  echo esc_url($feature_image[0]); ?>"></a>
													<?php												
													}
												?>	
										</div>
										
									  </div>
									  <div class="col-lg-9 col-sm-9 col-xs-9">
										<div class="rightflaot">
											<button type="button" class="btn btn-default btn-xs" onclick="close_his(<?php echo esc_html($post->ID);?>);return false;">X</button>
										</div>
										<h5 class="listing-info" ><a href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a></h5>
									
										<p class="desc">   </p>
										<?php esc_html_e('Address :','ivdirectories');  echo get_post_meta($post->ID,'address',true); ?>   <br />
										
										<div class="rightflaot">
											<div id="update_message"></div>
											<input type="button"  onclick="load_note_dir(<?php echo esc_html($post->ID); ?>,'<?php echo get_post_meta($post->ID,'_note_'.get_current_user_id(),true); ?>');" value="<?php esc_html_e('Add note','ivdirectories'); ?>"  class="btn btn-default btn-sm"/>
										<!--<input type="button" value="Contact Property" class="btn btn-primary btn-sm"/>  -->
										<a class='btn btn-primary btn-sm popup-contact' href="<?php echo admin_url('admin-ajax.php').'?action=iv_directories_contact_popup&dir-id='.$post->ID; ?>">
										 <?php esc_html_e('Contact','ivdirectories'); ?>
										 </a>
										</div>
										
									  </div>
										  <div class="col-lg-12 col-sm-12 col-xs-12">
											<div class="col-lg-12 col-sm- col-xs-12" id="dir_<?php echo esc_html($post->ID); ?>">
													<p>
													<?php 
													if(get_post_meta($post->ID,'_note_'.get_current_user_id(),true)!=''){
													 ?>
														<div class=" row">
															<strong><?php esc_html_e('Note:','ivdirectories'); ?> </strong> <?php echo get_post_meta($post->ID,'_note_'.get_current_user_id(),true); ?>	
														</div>
													<?php
													}
													?>	
															
													</p>		
											</div>
										</div>	
										
									  <div class="clear">&nbsp;</div>
									</div>
									
									<?php
										}
									}else{
										esc_html_e('No data available','ivdirectories');	 
										
									}	
										wp_reset_query();
									?>
										   
									
								  </div>
										 
									 </div>	
								</div>

              
                </div>
              </div>
 </div>
<script>
jQuery(document).ready(function($) {		
		jQuery(".popup-contact").colorbox({transition:"None", width:"650px", height:"415px" ,opacity:"0.70"});
		
})	
</script>
        

 
