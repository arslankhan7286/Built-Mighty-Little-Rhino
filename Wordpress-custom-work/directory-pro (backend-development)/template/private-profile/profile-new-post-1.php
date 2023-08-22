<?php
$map_api_have='no';
$dir_map_api=get_option('_dir_map_api');	
if($dir_map_api!=""){$map_api_have='yes';}	


?>          <div class="profile-content">
            
              <div class="portlet light">
                <div class="portlet-title tabbable-line clearfix">
                    <div class="caption caption-md">
                      <span class="caption-subject"> <?php esc_html_e('New Listing','ivdirectories'); ?></span>
                    </div>					
                  </div>               
                  <div class="portlet-body">
                    <div class="tab-content">
                    
                      <div class="tab-pane active" id="tab_1_1">
					  <?php					
						global $wpdb;
						$directory_url=get_option('_iv_directory_url');					
						if($directory_url==""){$directory_url='directories';}
						// Check Max\
						$iv_directories_pack='iv_directories_pack';
						$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$iv_directories_pack );
						$membership_pack = $wpdb->get_results($sql);
						$total_package = count($membership_pack);
						$max=999999;
						$package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);							
										
						if($package_id!=""){ 	
							if(get_user_meta($current_user->ID, 'iv_directories_payment_status', true)=='success'){
								$max=get_post_meta($package_id, 'iv_directories_package_max_post_no', true);
							}else{
								if(get_post_meta($package_id, 'iv_directories_package_cost', true)=='0' or get_post_meta($package_id, 'iv_directories_package_cost', true)==""){
									$max=get_post_meta($package_id, 'iv_directories_package_max_post_no', true);								
								}else{
									$max=0;
								}
								
							}
						}											
						if($package_id=="" OR $package_id=="0"){   
							$iv_directories_pack='iv_directories_pack';
							global $wpdb; $user_role= $current_user->roles[0];
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s' and post_status='draft'", $iv_directories_pack);
							$membership_pack = $wpdb->get_results($sql);
							$total_package=count($membership_pack);								
							if($total_package >0){							
								$max=get_post_meta($package_id, 'iv_directories_package_max_post_no', true);								
							}else{
								$max=999999;
							}	
						}		
						$user_role= $current_user->roles[0];
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							$max=999999;
						}		
								
						
						$sql=$wpdb->prepare("SELECT count(*) as total FROM $wpdb->posts WHERE post_type ='%s'  and post_author='%s' ",$directory_url,$current_user->ID);									
						$all_post = $wpdb->get_row($sql);
						$my_post_count=$all_post->total;
						
						if ( $my_post_count>=$max)  {
								$iv_redirect = get_option( '_iv_directories_profile_page');							
								$reg_page= get_permalink( $iv_redirect); 							
							?>
							<?php esc_html_e('Please Upgrade Your Account','ivdirectories'); ?>
							 <a href="<?php echo esc_url($reg_page).'?&profile=level'; ?>" title="Upgarde"><b><?php esc_html_e('Here','ivdirectories'); ?> </b></a> 
							<?php esc_html_e('To Add More Post.','ivdirectories'); ?>	
							
							
						<?php
						}else{
					
					?>					
					
						<div class="row">
							<div class="col-md-12">	 
							
							 
							<form action="" id="new_post" name="new_post"  method="POST" role="form">
								<div class=" form-group">
									<label for="text" class=" control-label"><?php esc_html_e('Title','ivdirectories'); ?></label>
									<div class="  "> 
										<input type="text" class="form-control" name="title" id="title" value="" placeholder="<?php esc_html_e('Enter Title Here','ivdirectories'); ?>">
									</div>																		
								</div>
								
								<div class="form-group">
										
										<div class=" ">
												<?php
													$settings_a = array(															
														'textarea_rows' =>8,
														'editor_class' => 'form-control'															 
														);
													
													$editor_id = 'new_post_content';
													wp_editor( '', $editor_id,$settings_a );										
													?>
									
										</div>
									
								</div>
								<div class=" row form-group ">
									<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Feature Image','ivdirectories'); ?>  </label>
									
										<div class="col-md-4" id="post_image_div">
											<a  href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >									
											<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
											</a>					
										</div>
										
										<input type="hidden" name="feature_image_id" id="feature_image_id" value="">
										
										<div class="col-md-3" id="post_image_edit">	
											<button type="button" onclick="edit_post_image('post_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add','ivdirectories'); ?> </button>
											
										</div>									
								</div>
								<div class=" row form-group ">
									<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Image Gallery','ivdirectories'); ?> 
										<button type="button" onclick="edit_gallery_image('gallery_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add Images','ivdirectories'); ?></button>
									 </label>						
								</div>
								<div class=" row form-group ">	
										
										<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="">
										
										<div class="col-md-12" id="gallery_image_div">
										</div>									
								</div>
								
																
								
								<div class="clearfix"></div>
								<div class=" row form-group ">
									<label for="text" class=" col-md-12 control-label"><?php esc_html_e('Post Status','ivdirectories'); ?>  </label>
									
										<div class="col-md-12" id="">										
										<select name="post_status" id="post_status"  class="form-control">
											<?php
											$user_can_publish=get_option('user_can_publish');	
											if($user_can_publish==""){$user_can_publish='yes';}	
											
												if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){?>
														<option value="publish"><?php esc_html_e('Publish','ivdirectories'); ?></option>													
												<?php
												}
												if(isset($current_user->roles[0]) and $current_user->roles[0]!='administrator'){
													if($user_can_publish=="yes"){
														?>
														<option value="publish"><?php esc_html_e('Publish','ivdirectories'); ?></option>
													<?php
													}
												}
											?>	
											<option value="pending"><?php esc_html_e('Pending Review','ivdirectories'); ?></option>
											<option value="draft"><?php esc_html_e('Draft','ivdirectories'); ?></option>
											
										</select>										
											
											
										</div>				
																		
								</div>
								
								
								<div class="clearfix"></div>
								<div class=" row form-group">
									<label for="text" class=" col-md-12 control-label"><?php esc_html_e('Category','ivdirectories'); ?></label>									
									<div class=" col-md-12 "> 
								
								<?php
									echo '<select name="postcats[]" class="form-control " multiple="multiple">';
								
								
										$selected='';
										if( isset($_POST['submit'])){
											$selected = $_POST['postcats'];
										}
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
									$i=0;
									foreach ( $terms as $term_parent ) {  ?>												
										
										
											<?php 
											
											echo '<option  value="'.$term_parent->slug.'" '.($selected==$term_parent->slug?'selected':'' ).'><strong>'.$term_parent->name.'<strong></option>';
											?>	
												<?php
												
												$args2 = array(
													'type'                     => $directory_url,						
													'parent'                   => $term_parent->term_id,
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
														
														
													foreach ( $categories as $term ) { 
														echo '<option  value="'.$term->slug.'" '.($selected==$term->slug?'selected':'' ).'>--'.$term->name.'</option>';
													} 	
																				
												endif;		
												
												?>
																			
	  
									<?php
										$i++;
									} 								
								endif;	
									echo '</select>';	
								?>		
									</div>
																		
								</div>
								
								
								


						<div class=" form-group row">
							<div class="col-md-6 "> 
								<label for="text" class=" control-label  "><?php esc_html_e('Address','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control  " name="address" id="address"  value="" placeholder="<?php esc_html_e('Enter address Here','ivdirectories'); ?>">
							
							</div>							
							<div class=" col-md-6"> 
							<label for="text" class=" control-label"><?php esc_html_e('Area','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control" name="area" id="area" value="" placeholder="<?php esc_html_e('Enter Area Here','ivdirectories'); ?>">
							</div>														
						</div>
						<div class=" form-group row">
							<div class="col-md-6 "> 
								<label for="text" class=" control-label"><?php esc_html_e('City','ivdirectories'); ?></label>
								<input type="text" class="form-control " name="city" id="city" value="" placeholder="<?php esc_html_e('Enter city ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
								<label for="text" class=" control-label "><?php esc_html_e('Zipcode','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control" name="postcode" id="postcode" value="" placeholder="<?php esc_html_e('Enter Zipcode ','ivdirectories'); ?>">
							</div>
						</div>
						

						<div class=" form-group">
							<div class=" col-md-6">
								<label for="text" class=" control-label "><?php esc_html_e('State','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control" name="state" id="state" value="" placeholder="<?php esc_html_e('Enter State ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
							<label for="text" class=" control-label "><?php esc_html_e('Country','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control " name="country" id="country" value="" placeholder="<?php esc_html_e('Enter Country ','ivdirectories'); ?>">
							</div>
						</div>	
						<div class=" form-group">
							<div class=" col-md-6">
								<label for="text" class=" control-label "><?php esc_html_e('Latitude','ivdirectories'); ?></label>
								<input type="text" class="form-control " name="latitude" id="latitude" value="" placeholder="<?php esc_html_e('Enter latitude ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
							<label for="text" class=" control-label "><?php esc_html_e('Longitude','ivdirectories'); ?></label>	
								<input type="text" class="form-control " name="longitude" id="longitude" value="" placeholder="<?php esc_html_e('Enter longitude ','ivdirectories'); ?>">
							</div>
						</div>
						
						<div class="clearfix">&nbsp;</div>
						
						
						<?php
						if($map_api_have=='yes'){
						?>						
						<div class=" form-group">
							<label for="text" class=" control-label"><?php esc_html_e('Address Map','ivdirectories'); ?></label>							
							<div class=" "> 
							<div  id="map-canvas"  style="width:100%;height:300px;"></div>
																		
							</div>																
						</div>
						
						<?php
						}
					?>
						<?php
					$dir_addedit_additionalinfotitle=get_option('dir_addedit_additionalinfotitle');	
					if($dir_addedit_additionalinfotitle==""){$dir_addedit_additionalinfotitle='Additional Info';}
					$dir_addedit_additionalinfo=get_option('dir_addedit_additionalinfo');	
					if($dir_addedit_additionalinfo==""){$dir_addedit_additionalinfo='yes';}	
					if($dir_addedit_additionalinfo=="yes"){					
					?>
					<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									  <?php echo esc_html($dir_addedit_additionalinfotitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									 <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
								  <div class="panel-body">											
											<?php
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
										$i=1;
										$field_type_roles=  get_option( 'iv_membership_field_type_roles' );																			
										$user = new WP_User( $current_user->ID );
										
										$i=1;
										foreach ( $default_fields as $field_key => $field_value ) { 		
											if(isset($myaccount_fields_array[$field_key])){
												
													$role_access='no';
													if(in_array('all',$field_type_roles[$field_key] )){
														$role_access='yes';
													}																	
													if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
														foreach ( $user->roles as $role ){
															if(in_array($role,$field_type_roles[$field_key] )){
																$role_access='yes';
															}
															if('administrator'==$role){
																$role_access='yes';
															}
														}	
													}	
													if($role_access=='yes'){
														echo  $main_class->ep_directory_check_field_input_access($field_key, $field_value, 'myaccount', '0' );
													}
												
											}else{
												echo  $main_class->ep_directory_check_field_input_access($field_key, $field_value, 'myaccount', '0' );
											}
										}
									?>	
										
								  </div>
								</div>
					  </div>
					<?php
					}
					?>
					<?php
					$dir_addedit_contactinfotitle=get_option('dir_addedit_contactinfotitle');	
					if($dir_addedit_contactinfotitle==""){$dir_addedit_contactinfotitle='Contact Info';}	
					$dir_addedit_contactinfo=get_option('dir_addedit_contactinfo');	
					if($dir_addedit_contactinfo==""){$dir_addedit_contactinfo='yes';}	
					if($dir_addedit_contactinfo=="yes"){
					?>	
					<div class="clearfix"></div>	
					
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									  <?php echo esc_html($dir_addedit_contactinfotitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									  <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseFour" class="panel-collapse collapse">
								  <div class="panel-body">											
									<?php											
									$dir_style5_call=get_option('dir_style5_call');	
									if($dir_style5_call==""){$dir_style5_call='yes';}
									if($dir_style5_call=="yes"){
									 $dirpro_call_button='';
									 if($dirpro_call_button==""){$dirpro_call_button='yes';}
									?>	
								<div class="form-group row">
									<label  class="col-md-4 control-label"> <?php esc_html_e('Call Button','ivdirectories');  ?></label>
								
									<div class="col-md-3">
										<label>												
										<input type="radio" name="dirpro_call_button" id="dirpro_call_button" value='yes' <?php echo ($dirpro_call_button=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Call Button','ivdirectories');  ?>
										</label>	
									</div>
									<div class="col-md-5">	
										<label>											
										<input type="radio"  name="dirpro_call_button" id="dirpro_call_button" value='no' <?php echo ($dirpro_call_button=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Call Button','ivdirectories');  ?>
										</label>
									</div>	
								</div>
					
							<?php
									}
												
							$dir_style5_email=get_option('dir_style5_email');	
							if($dir_style5_email==""){$dir_style5_email='yes';}
							if($dir_style5_email=="yes"){
							 $dirpro_email_button='';
							 if($dirpro_email_button==""){$dirpro_email_button='yes';}
							?>	
								<div class="form-group row">
									<label  class="col-md-4 control-label"> <?php esc_html_e('Email Button','ivdirectories');  ?></label>
								
									<div class="col-md-3">
										<label>												
										<input type="radio" name="dirpro_email_button" id="dirpro_email_button" value='yes' <?php echo ($dirpro_email_button=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Email Button','ivdirectories');  ?>
										</label>	
									</div>
									<div class="col-md-5">	
										<label>											
										<input type="radio"  name="dirpro_email_button" id="dirpro_email_button" value='no' <?php echo ($dirpro_email_button=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Email Button','ivdirectories');  ?>
										</label>
									</div>	
								</div>		
								
								<?php
							}	
														
									$dir_style5_sms=get_option('dir_style5_sms');	
									if($dir_style5_sms==""){$dir_style5_sms='yes';}
									if($dir_style5_email=="yes"){
									 $dirpro_sms_button='';
									 if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
											?>	
								<div class="form-group row">
									<label  class="col-md-4 control-label"> <?php esc_html_e('SMS Button','ivdirectories');  ?></label>
								
									<div class="col-md-3">
										<label>												
										<input type="radio" name="dirpro_sms_button" id="dirpro_sms_button" value='yes' <?php echo ($dirpro_sms_button=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show SMS Button','ivdirectories');  ?>
										</label>	
									</div>
									<div class="col-md-5">	
										<label>											
										<input type="radio"  name="dirpro_sms_button" id="dirpro_sms_button" value='no' <?php echo ($dirpro_sms_button=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide SMS Button','ivdirectories');  ?>
										</label>
									</div>	
								</div>
								
							<?php
									}
							?>	
								<hr/>
									
									
									<?php
											$listing_contact_source='';
											if($listing_contact_source==''){$listing_contact_source='user_info';}
										?>
									<div class=" form-group">	
											<div class="radio">											
											  <label><input type="radio" name="contact_source" value="user_info"  <?php echo ($listing_contact_source=='user_info'?'checked':''); ?> ><?php esc_html_e('Contact info collect from user->','ivdirectories'); ?> <?php echo ucfirst($current_user->display_name); ?><?php esc_html_e(' : Email, Phone, Website','ivdirectories'); ?> </label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="contact_source" value="new_value" <?php echo ($listing_contact_source=='new_value'?'checked':''); ?>><?php esc_html_e('Contact info come from: New Info Input','ivdirectories'); ?>  </label>
											</div>
									</div>
									<div id="new_contact_div" <?php echo ($listing_contact_source=='user_info'?'style="display:none"':''); ?> >
											<div class=" form-group row">
												<div class="col-md-6 "> 
													<label for="text" class=" control-label"><?php esc_html_e('Phone','ivdirectories'); ?></label>
														<input type="text" class="form-control" name="phone" id="phone" value="" placeholder="<?php esc_html_e('Enter Phone Number','ivdirectories'); ?>">
												</div>																
												<div class="col-md-6 "> 
													<label for="text" class=" control-label"><?php esc_html_e('Fax','ivdirectories'); ?></label>
														<input type="text" class="form-control" name="fax" id="fax" value="" placeholder="<?php esc_html_e('Enter Fax Number','ivdirectories'); ?>">
													</div>																
											</div>	
											<div class=" form-group row">
												<div class="col-md-6 "> 
													<label for="text" class=" control-label"><?php esc_html_e('Email Address','ivdirectories'); ?></label>
														<input type="text" class="form-control" name="contact-email" id="contact-email" value="" placeholder="<?php esc_html_e('Enter Email Address','ivdirectories'); ?>">
													</div>																
												<div class="col-md-6 "> 
													<label for="text" class=" control-label"><?php esc_html_e('Web Site','ivdirectories'); ?></label>
														<input type="text" class="form-control" name="contact_web" id="contact_web" value="" placeholder="<?php esc_html_e('Enter Web Site','ivdirectories'); ?>">
													</div>																
											</div>
											
									</div>
									
								  </div>
								</div>
					  </div>
					
					<?php
						}
					?>					
						<div class="clearfix"></div>	
					
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
									  <?php esc_html_e('Amenities/Tags','ivdirectories'); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
									  <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseEight" class="panel-collapse collapse">
								  <div class="panel-body">
									<div class=" form-group">
											
											<div class=" "> 
													<?php
													$args =array();
													$directory_url=get_option('_iv_directory_url');					
													if($directory_url==""){$directory_url='directories';}
													$dir_tags=get_option('_dir_tags');
													if($dir_tags==""){$dir_tags='yes';}	
													if($dir_tags=='yes'){
															$args2 = array(
																'type'                     => $directory_url,
																//'parent'                   => $term_parent->term_id,
																'orderby'                  => 'name',
																'order'                    => 'ASC',
																'hide_empty'               => 0,
																'hierarchical'             => 1,
																'exclude'                  => '',
																'include'                  => '',
																'number'                   => '',
																'taxonomy'                 => $directory_url.'_tag',
																'pad_counts'               => false

															);
															$main_tag = get_categories( $args2 );																													
																								
															if ( $main_tag && !is_wp_error( $main_tag ) ) :
																foreach ( $main_tag as $term_m ) {		
																	$checked='';																	
																	?>
																<div class="col-md-4">
																	 <label class="form-group"> <input type="checkbox" name="tag_arr[]" id="tag_arr[]" <?php echo esc_html($checked);?> value="<?php echo esc_html($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>  
																	</div>
															<?php	
															}
															endif;	
														
													
													}else{
														$args['hide_empty']=false;
														$tags = get_tags($args );	
														$checked='';
														
														foreach ( $tags as $tag ) { 															
															?>
															<div class="col-md-4">
															 <label class="form-group"> 
																 
																 <input type="checkbox" name="tag_arr[]" id="tag_arr[]" value="<?php echo esc_html($tag->name); ?>" <?php echo esc_html($checked);?> > <?php echo esc_html($tag->name); ?> </label>  
															</div>
															<?php
														}
													
													}
													
													
												?>
											</div>																
									</div>
									<div class="clearfix"></div>
									<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Add New Amenities/Tags','ivdirectories'); ?></label>						
											<div class="  "> 
												<input type="text" class="form-control" name="new_tag" id="new_tag" value="" placeholder="<?php esc_html_e('Enter New Tags: Separate tags with commas','ivdirectories'); ?>">
											</div>																
									</div>	
									
									
																		
								  </div>
								</div>
					  </div>
					
					
					<?php
					$dir_addedit_videostitle=get_option('dir_addedit_videostitle');	
					if($dir_addedit_videostitle==""){$dir_addedit_videostitle='Videos';}	
					$dir_addedit_videos=get_option('dir_addedit_videos');	
					if($dir_addedit_videos==""){$dir_addedit_videos='yes';}	
					if($dir_addedit_videos=="yes"){
					?>
					<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									  <?php echo esc_html($dir_addedit_videostitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									   <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseThree" class="panel-collapse collapse">
								  <div class="panel-body">	
									  <?php
											// video, event , coupon , vip_badge
										 if($this->check_write_access('video')){
											
										?>										
										<div class=" form-group row">
											<div class="col-md-6 "> 
												<label for="text" class=" control-label"><?php esc_html_e('Youtube','ivdirectories'); ?></label>
													<input type="text" class="form-control" name="youtube" id="youtube" value="" placeholder="<?php esc_html_e('Enter Youtube video ID, e.g : bU1QPtOZQZU ','ivdirectories'); ?>">
											</div>																
											<div class="col-md-6 "> 
												<label for="text" class=" control-label"><?php esc_html_e('vimeo','ivdirectories'); ?></label>
													<input type="text" class="form-control" name="vimeo" id="vimeo" value="" placeholder="<?php esc_html_e('Enter vimeo ID, e.g : 134173961','ivdirectories'); ?>">
											</div>																
										</div>
										<?php
										}else{
												esc_html_e('Please upgrade your account to add video ','ivdirectories');
										}
										?>
									
								  </div>
								</div>
					  </div>
					<?php
					}
					?>
					<?php
					$dir_addedit_socialprofilestitle=get_option('dir_addedit_socialprofilestitle');	
					if($dir_addedit_socialprofilestitle==""){$dir_addedit_socialprofilestitle='Social Profiles';}
					$dir_addedit_socialprofiles=get_option('dir_addedit_socialprofiles');	
					if($dir_addedit_socialprofiles==""){$dir_addedit_socialprofiles='yes';}			
					if($dir_addedit_socialprofiles=="yes"){
					?>
					<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									  <?php echo esc_html($dir_addedit_socialprofilestitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									   <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseFive" class="panel-collapse collapse">
								  <div class="panel-body">											
										
									<div class="form-group row">
										<div class="col-md-6 "> 
											<label class="control-label">FaceBook</label>
											<input type="text" name="facebook" id="facebook" value="" class="form-control"/>
										</div>
										<div class="col-md-6 "> 
											<label class="control-label">Linkedin</label>
											<input type="text" name="linkedin" id="linkedin" value="" class="form-control"/>
										</div>
									</div>	
									 <div class="form-group row">
									  <div class="col-md-6 "> 
										<label class="control-label">Twitter</label>
										<input type="text" name="twitter" id="twitter" value="" class="form-control"/>
									  </div>
									 
									</div>  
									   <div class="form-group row">
									   <div class="col-md-6 "> 
										<label class="control-label">Instagram </label>
										<input type="text" name="instagram" id="instagram" value=""  class="form-control"/>
									  </div>
									  <div class="col-md-6 "> 
										<label class="control-label">Youtube </label>
										<input type="text" name="youtube_social" id="youtube_social" value=""  class="form-control"/>
									  </div>
									</div>  
									  
									  
						  									
										
								  </div>
								</div>
					  </div>
					<?php
					}
					?>
				
					<?php
							$dir_addedit_openingtimetitle=get_option('dir_addedit_openingtimetitle');	
							if($dir_addedit_openingtimetitle==""){$dir_addedit_openingtimetitle='Opening Time';}
							$dir_addedit_openingtime=get_option('dir_addedit_openingtime');	
							if($dir_addedit_openingtime==""){$dir_addedit_openingtime='yes';}	
							if($dir_addedit_openingtime=="yes"){	
							?>
							<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									  <?php echo esc_html($dir_addedit_openingtimetitle); ?> 
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									  <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse">
								  <div class="panel-body" style="min-height:400px">	
									<div id="day_field_div">
										<div class=" row form-group " id="day-row1" >									
											<div class=" col-md-4"> 
											<select name="day_name[]" id="day_name[]" class="form-control">	
											<option value=""></option> 
											<option value="<?php esc_html_e('Monday','ivdirectories'); ?> "> <?php esc_html_e('Monday','ivdirectories'); ?>  </option> 
											<option value="<?php esc_html_e('Tuesday','ivdirectories'); ?>"><?php esc_html_e('Tuesday','ivdirectories'); ?></option> 
											<option value="<?php esc_html_e('Wednesday','ivdirectories'); ?>"><?php esc_html_e('Wednesday','ivdirectories'); ?></option> 
											<option value="<?php esc_html_e('Thursday','ivdirectories'); ?>"><?php esc_html_e('Thursday','ivdirectories'); ?></option> 
											<option value="<?php esc_html_e('Friday','ivdirectories'); ?>"><?php esc_html_e('Friday','ivdirectories'); ?></option> 
											<option value="<?php esc_html_e('Saturday','ivdirectories'); ?>"><?php esc_html_e('Saturday','ivdirectories'); ?></option> 
											<option value="<?php esc_html_e('Sunday','ivdirectories'); ?>"><?php esc_html_e('Sunday','ivdirectories'); ?></option> 
											</select>
											</div>		
											<div  class=" col-md-4">
												<input type="text" placeholder="<?php esc_html_e('12:00 AM','ivdirectories'); ?> " name="day_value1[]" id="day_value1[]"  class="form-control" />
											
												
											</div>
											<div  class="col-md-4">
											<input type="text" placeholder="<?php esc_html_e('12:00 PM','ivdirectories'); ?> " name="day_value2[]" id="day_value2[]"  class="form-control" />
											
											</div>
											
										</div>
									</div>	
											
									<div class=" row  form-group ">
										<div class="col-md-12" >	
										<button type="button" onclick="add_day_field();"  class="btn btn-xs green-haze"><?php esc_html_e('Add More','ivdirectories'); ?></button>
										</div>
									</div>	
								  </div>
								</div>
					  </div>
					<?php
							}
					?>
					<?php	
					$dir_addedit_awardtitle=get_option('dir_addedit_awardtitle');	
					if($dir_addedit_awardtitle==""){$dir_addedit_awardtitle=esc_html__('Awards','ivdirectories');}	
					
					$dir_addedit_award=get_option('dir_addedit_award');	
					if($dir_addedit_award==""){$dir_addedit_award='yes';}	
					if($dir_addedit_award=="yes"){
					?>	
						<div class="clearfix"></div>	
						<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapsethirty2">
									  <?php echo esc_html($dir_addedit_awardtitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapsethirty2">
									   <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapsethirty2" class="panel-collapse collapse">
								  <div class="panel-body">	
									  <div id="awards">
										 <div id="award">	
																								
													<div class=" form-group">
														<label for="text" class=" control-label"><?php esc_html_e('Title','ivdirectories'); ?></label>
														
														<div class="  "> 
															<input type="text" class="form-control" name="award_title[]" id="award_title[]" value="" placeholder="<?php esc_html_e('Enter  title','ivdirectories'); ?>">
														</div>																
													</div>		
													<div class=" form-group">
														<label for="text" class=" control-label"><?php esc_html_e('Description','ivdirectories'); ?></label>
														
														<div class="  "> 
															<input type="text" class="form-control" name="award_description[]" id="award_description[]" value="" placeholder="<?php esc_html_e('Enter Description','ivdirectories'); ?>">
														</div>																
													</div>
													<div class=" form-group">
														<label for="text" class=" control-label"><?php esc_html_e('Receive Year(s)','ivdirectories'); ?></label>
														
														<div class="  "> 
															<input type="text" class="form-control" name="award_year[]" id="award_year[]" value="" placeholder="<?php esc_html_e('Enter Year','ivdirectories'); ?>">
														</div>																
													</div>	
													<div class=" form-group " style="margin-top:10px">
													<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Image','ivdirectories'); ?>  </label>
												
													<div class="col-md-4" id="award_image_div">
														<a  href="javascript:void(0);" onclick="award_post_image(this);"  >									
														<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
														</a>
															
															
																			
													</div>						
											</div>	
										</div>
																				
									</div>
									<div class=" row  form-group ">
										<div class="col-md-12" >	
										<button type="button" onclick="newadd_award_field();"  class="btn btn-xs green-haze"><?php esc_html_e('Add More','ivdirectories'); ?></button>
										</div>
									</div>							
									
									
										
									
								  </div>
								</div>
					  </div>
						
						<?php
							}
						?>
					<?php
							$dir_addedit_eventtitle=get_option('dir_addedit_eventtitle');	
							if($dir_addedit_eventtitle==""){$dir_addedit_eventtitle='Event';}
							$dir_addedit_event=get_option('dir_addedit_event');	
							if($dir_addedit_event==""){$dir_addedit_event='no';}
							if($dir_addedit_event=="yes"){							
							?>
					<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
									  <?php echo esc_html($dir_addedit_eventtitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
									  <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseSix" class="panel-collapse collapse">
								  <div class="panel-body">											
										<?php
											// video, event , coupon , vip_badge , booking
										 if($this->check_write_access('event')){
											
										?>		
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Event Title','ivdirectories'); ?></label>
												<input type="text" class="form-control" name="event-title" id="event-title" value="" placeholder="<?php esc_html_e('Enter Title Here','ivdirectories'); ?>">							
										</div>	
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Event Detail','ivdirectories'); ?></label>
												<?php
													$settings_a = array(															
														'textarea_rows' =>10,	
														'editor_class' => 'form-control'															 
														);
													$content_client ='';
													$editor_id = 'event-detail';
												
																						
													?>
													
												<textarea id="event-detail" name="event-detail"  rows="4" class="form-control" >  </textarea>
												
												
										</div>
										<div class=" row form-group " style="margin-top:10px">
											<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Event Image','ivdirectories'); ?>  </label>
										
											<div class="col-md-4" id="event_image_div">
												<a  href="javascript:void(0);" onclick="event_post_image('event_image_div');"  >									
												<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
												</a>					
											</div>
											
											<input type="hidden" name="event_image_id" id="event_image_id" value="">
											
											<div class="col-md-3" id="event_image_edit">	
												<button type="button" onclick="event_post_image('event_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add','ivdirectories'); ?></button>
												
											</div>									
										</div>	
										<?php
										}else{
												esc_html_e('Please upgrade your account to add event ','ivdirectories');
										}
										?>
								  </div>
								
								</div>
					  </div>
					<?php
						}
					?>
					<?php
							$dir_addedit_bookingtitle=get_option('dir_addedit_bookingtitle');	
							if($dir_addedit_bookingtitle==""){$dir_addedit_bookingtitle='Booking';}
							
							$dir_addedit_booking=get_option('dir_addedit_booking');	
							if($dir_addedit_booking==""){$dir_addedit_booking='no';}
							if($dir_addedit_booking=="yes"){	
							?>
					<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapsenine">
									  <?php echo esc_html($dir_addedit_bookingtitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapsenine">
									  <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapsenine" class="panel-collapse collapse">
								  <div class="panel-body">	
									  <?php
											// video, event , coupon , vip_badge , booking
										 if($this->check_write_access('booking')){
											
										?>												
										   <div class="form-group">
												<label class="control-label"><?php esc_html_e('Booking Detail','ivdirectories'); ?>  </label>
												
												<?php
													$settings_booking = array(															
														'textarea_rows' =>2,	
														'editor_class' => 'form-control'															 
														);
													//$content_client = get_post_meta($post_edit->ID,'booking_detail',true);
													$editor_id = 'booking_detail';
													//wp_editor( $content_client, $editor_id, $settings_booking );	
																						
													?>
												<textarea id="booking_detail" name="booking_detail"  rows="4" class="form-control" > </textarea>
										  </div>
										  <div class="form-group">
												<label class="control-label"><?php esc_html_e('Or, Booking Shortcode','ivdirectories'); ?>  </label>
												<input type="text" name="booking" id="booking" value="" placeholder="e.g : [events_calendar long_events=1 ]" class="form-control"/>
										  </div>
										  
										  <?php
										}else{
												esc_html_e('Please upgrade your account to add booking detail ','ivdirectories');
										}
										?>
								  </div>
								</div>
					  </div>
					<?php
							}
					?>
					<?php
							$dir_addedit_dealcoupontitle=get_option('dir_addedit_dealcoupontitle');	
							if($dir_addedit_dealcoupontitle==""){$dir_addedit_dealcoupontitle='Deal/Coupon';}	
							
							$dir_addedit_dealcoupon=get_option('dir_addedit_dealcoupon');	
							if($dir_addedit_dealcoupon==""){$dir_addedit_dealcoupon='no';}	
							if($dir_addedit_dealcoupon=="yes"){	
							?>
						<div class="clearfix"></div>	
					<div class="panel panel-default">
								<div class="panel-heading">
								  <h4 class="panel-title col-lg-10">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
									  <?php echo esc_html($dir_addedit_dealcoupontitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
									   <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseSeven" class="panel-collapse collapse">
								  <div class="panel-body">											
										  <?php
											// video, event , coupon , vip_badge , booking
										 if($this->check_write_access('coupon')){
											
										?>	
									<div class=" form-group">
										<label for="text" class=" control-label"><?php esc_html_e('Title','ivdirectories'); ?></label>
											<input type="text" class="form-control" name="deal-title" id="deal-title" value="" placeholder="<?php esc_html_e('Enter Title Here','ivdirectories'); ?>">							
									</div>	
									<?php
												$currencyCode= get_option('_iv_directories_api_currency');
											?>
									<div class=" form-group">
										<label for="text" class=" control-label"><?php esc_html_e('Deals/Coupon Amount '.$currencyCode,'ivdirectories'); ?></label>
											
											<input type="text" class="form-control" name="deal-amount" id="deal-amount" value="" placeholder="<?php esc_html_e('Enter Deals or Coupon Amount on '.$currencyCode.' [ No currency, Only Number]','ivdirectories'); ?>">							
									</div>
									
									<div class=" form-group">
										<label for="text" class=" control-label"><?php esc_html_e('Paypal Email Address [Amount will deposit here]','ivdirectories'); ?></label>
											<input type="text" class="form-control" name="deal-paypal" id="deal-paypal" value="" placeholder="<?php esc_html_e('Enter Your Paypal Email Address','ivdirectories'); ?>">							
									</div>
									
									<div class=" form-group">
										<label for="text" class=" control-label"><?php esc_html_e('Detail','ivdirectories'); ?></label>
												<?php
													$settings_a = array(															
														'textarea_rows' =>10,	
														'editor_class' => 'form-control'															 
														);
													$content_client ='';
													$editor_id = 'deal-detail';
													wp_editor( $content_client, $editor_id,$settings_a );	
																						
													?>
												
									</div>
									
									<div class="row form-group " >
										<label for="text" class=" col-md-5 control-label" ><?php esc_html_e('Deal/Coupon Image','ivdirectories'); ?></label>
									
										<div class="col-md-4" id="deal_image_div" >
											<a  href="javascript:void(0);" onclick="deal_post_image('deal_image_div');"  >									
											<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
											</a>					
										</div>
										
										<input type="hidden" name="deal_image_id" id="deal_image_id" value="">
										
										<div class="col-md-3" id="deal_image_edit">	
											<button type="button" onclick="deal_post_image('deal_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add','ivdirectories'); ?></button>
											
										</div>									
								</div>	
										
						
								  <?php
										}else{
												esc_html_e('Please upgrade your account to add coupon/deal ','ivdirectories');
										}
										?>
						 </div>
								
								
								</div>
					  </div>
						<?php
							}
						?>
						
						
								<div class="margiv-top-10">
								    <div class="" id="update_message"></div>
									<input type="hidden" name="user_post_id" id="user_post_id" value="">
								    <button type="button" onclick="iv_save_post();"  class="btn green-haze"><?php esc_html_e('Save Post','ivdirectories'); ?></button>
		                          
		                        </div>	
									 
							</form>
						  </div>
						</div>
			<?php
			
				} // for Role
			
		
				
			?>
					
			

                      
					 </div>
                     
                  </div>
                </div>
              </div>
            </div>
          <!-- END PROFILE CONTENT -->

<?php
	wp_enqueue_script('iv_directory-ar-script-e4', wp_iv_directories_URLPATH . 'admin/files/js/add-edit-listing.js');
	wp_localize_script('iv_directory-ar-script-e4', 'dirpro4', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
		'wp_iv_directories_URLPATH'		=> wp_iv_directories_URLPATH,
		'current_user_id'	=>get_current_user_id(),	
		'SetImage'		=>esc_html__('Set Image','ivdirectories'),
		'GalleryImages'=>esc_html__('Gallery Images','ivdirectories'),
		'email'=>esc_html__('Email','ivdirectories'),		
		'dirwpnonce'=> wp_create_nonce("myaccount"),
		'permalink'=> get_permalink(),			
		) );
if($map_api_have=='yes'){
	?>
	<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo $dir_map_api;?>'></script>
	<?php
	wp_enqueue_script('iv_directory-ar-script-121', wp_iv_directories_URLPATH . 'admin/files/js/google_map.js');
	wp_localize_script('iv_directory-ar-script-121', 'dirpro3', array(		
		'lat'=> '37.0902',		
		'lng'=> '95.7129',		
		) );
}		
		
$my_theme = wp_get_theme();
$theme_name= $my_theme->get( 'Name' );
if(strtolower($theme_name)=='divi' || strtolower($theme_name)=='divi child'){ 
?>
<script>
jQuery( document ).ready(function() {
   jQuery('.collapse').collapse()
});	
</script>	
<?php	
	}	
 ?> 