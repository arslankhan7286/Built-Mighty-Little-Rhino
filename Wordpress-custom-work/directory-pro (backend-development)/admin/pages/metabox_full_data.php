<?php	
		global $wpdb, $post;
		global $current_user;
		$main_class = new wp_iv_directories;
		wp_enqueue_script("jquery");
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('wp-iv_directories-myaccount-style-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
		wp_enqueue_script('iv_directories-myaccount-style-12', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min.js');
		wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
		wp_enqueue_style('datetimepicker', wp_iv_directories_URLPATH . 'admin/files/css/jquery.datetimepicker.css');
		

		// Save action   iv_directories_meta_save  
		//*************************	plugin file *********
			
 		 $iv_directories_approve= get_post_meta( $post->ID,'iv_directories_approve', true );
		 $iv_directories_current_author= $post->post_author;
		 $curr_post_id=$post->ID;
		 
 		?>
 
 <div class="bootstrap-wrapper">
 	<div class="dashboard-eplugin container-fluid">                 
						<div class="row">
							<div class="col-md-12">							
								<div class=" row form-group ">
									<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Image Gallery','ivdirectories'); ?> 
										<button type="button" onclick="edit_gallery_image('gallery_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add Images','ivdirectories'); ?></button>
									 </label>						
								</div>
								<div class=" row form-group ">	
										
											<?php
											$gallery_ids=get_post_meta($curr_post_id ,'image_gallery_ids',true);
											$gallery_ids_array = array_filter(explode(",", $gallery_ids));
											?>
										<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="<?php echo esc_html($gallery_ids); ?>">
										
										<div class="col-md-12" id="gallery_image_div">
											<?php
												if(sizeof($gallery_ids_array)>0){ 
													foreach($gallery_ids_array as $slide){	
														
												?>
												<div id="gallery_image_div<?php echo esc_html($slide);?>" class="col-md-2"><img  class="img-responsive"  src="<?php echo wp_get_attachment_url( $slide ); ?>"><button type="button" onclick="remove_gallery_image('gallery_image_div<?php echo esc_html($slide);?>', <?php echo esc_html($slide);?>);"  class="btn btn-xs btn-danger">Remove</button> </div>
												<?php
													}
												 }
												?>
												
										</div>									
								</div>
							
<div class=" form-group row">
							<div class="col-md-6 "> 
								<label for="text" class=" control-label col-md-4 "><?php esc_html_e('Address','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control col-md-8 " name="address" value="<?php echo get_post_meta($post->ID,'address',true); ?>" placeholder="<?php esc_html_e('Enter address Here','ivdirectories'); ?>">
							
							</div>							
							<div class=" col-md-6"> 
							<label for="text" class=" control-label col-md-4"><?php esc_html_e('Area','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control col-md-8" name="area" id="area" value="<?php echo get_post_meta($post->ID,'area',true); ?>" placeholder="<?php esc_html_e('Enter Area Here','ivdirectories'); ?>">
							</div>														
						</div>
						<div class=" form-group row">
							<div class="col-md-6 "> 
								<label for="text" class=" control-label col-md-4"><?php esc_html_e('City','ivdirectories'); ?></label>
								<input type="text" class="form-control col-md-8" name="city" id="city" value="<?php echo get_post_meta($post->ID,'city',true); ?>" placeholder="<?php esc_html_e('Enter city ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
								<label for="text" class=" control-label col-md-4"><?php esc_html_e('Zipcode','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control col-md-8" name="postcode" id="postcode" value="<?php echo get_post_meta($post->ID,'postcode',true); ?>" placeholder="<?php esc_html_e('Enter Zipcode ','ivdirectories'); ?>">
							</div>
						</div>
						

						<div class=" form-group">
							<div class=" col-md-6">
								<label for="text" class=" control-label col-md-4"><?php esc_html_e('State','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control col-md-8" name="state" id="state" value="<?php echo get_post_meta($post->ID,'state',true); ?>" placeholder="<?php esc_html_e('Enter State ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
							<label for="text" class=" control-label col-md-4"><?php esc_html_e('Country','ivdirectories'); ?></label>							
							
								<input type="text" class="form-control col-md-8" name="country" id="country" value="<?php echo get_post_meta($post->ID,'country',true); ?>" placeholder="<?php esc_html_e('Enter Country ','ivdirectories'); ?>">
							</div>
						</div>	
						<div class=" form-group">
							<div class=" col-md-6">
								<label for="text" class=" control-label col-md-4"><?php esc_html_e('Latitude','ivdirectories'); ?></label>
								<input type="text" class="form-control col-md-8" name="latitude" id="latitude" value="<?php echo get_post_meta($post->ID,'latitude',true); ?>" placeholder="<?php esc_html_e('Enter latitude ','ivdirectories'); ?>">
							</div>
							<div class=" col-md-6">
							<label for="text" class=" control-label col-md-4"><?php esc_html_e('Longitude','ivdirectories'); ?></label>	
								<input type="text" class="form-control col-md-8" name="longitude" id="longitude" value="<?php echo get_post_meta($post->ID,'longitude',true); ?>" placeholder="<?php esc_html_e('Enter longitude ','ivdirectories'); ?>">
							</div>
						</div>
							<div class="clearfix">&nbsp;</div>
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
											foreach ( $default_fields as $field_key => $field_value ) { 
													echo  $main_class->ep_directory_check_field_input_access($field_key, $field_value, 'myaccount', $post->ID );
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
									 $dirpro_call_button=get_post_meta($post->ID,'dirpro_call_button',true);
									 if($dirpro_call_button==""){$dirpro_call_button='yes';}
									?>	
								<div class="form-group ">
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
							 $dirpro_email_button=get_post_meta($post->ID,'dirpro_email_button',true);
							 if($dirpro_email_button==""){$dirpro_email_button='yes';}
							?>	
								<div class="form-group ">
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
									 $dirpro_sms_button=get_post_meta($post->ID,'dirpro_sms_button',true);
									 if($dirpro_sms_button==""){$dirpro_sms_button='yes';}
											?>	
								<div class="form-group ">
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
								
								<div class="clearfix"></div>
								  
								  <div class=" form-group">
										<?php
											$listing_contact_source=get_post_meta($post->ID,'listing_contact_source',true);
											if($listing_contact_source==''){$listing_contact_source='user_info';}
										?>
									
											<div class="radio">											
											  <label><input type="radio" name="contact_source" value="user_info"  <?php echo ($listing_contact_source=='user_info'?'checked':''); ?> ><?php esc_html_e('Contact info collect from user->','ivdirectories'); ?><?php echo ucfirst($current_user->display_name); ?><?php esc_html_e(' : Email, Phone, Website','ivdirectories'); ?> </label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="contact_source" value="new_value" <?php echo ($listing_contact_source=='new_value'?'checked':''); ?>><?php esc_html_e('Contact info come from: New Info Input','ivdirectories'); ?>  </label>
											</div>
									</div>
									
									<div id="new_contact_div" <?php echo ($listing_contact_source=='user_info'?'style="display:none"':''); ?> >
									<div class=" form-group row">
										<div class="col-md-6 "> 
											<label for="text" class=" control-label"><?php esc_html_e('Phone','ivdirectories'); ?></label>	
												<input type="text" class=" form-control" name="phone" id="phone" value="<?php echo get_post_meta($post->ID,'phone',true); ?>" placeholder="<?php esc_html_e('Enter Phone Number','ivdirectories'); ?>">
																											
										</div>
										<div class="col-md-6 "> 
											<label for="text" class=" control-label"><?php esc_html_e('Fax','ivdirectories'); ?></label>
												<input type="text" class="  form-control" name="fax" id="fax" value="<?php echo get_post_meta($post->ID,'fax',true); ?>" placeholder="<?php esc_html_e('Enter Fax Number','ivdirectories'); ?>">
										</div>
											
									</div>	
									<div class=" form-group row">
										<div class="col-md-6 "> 
											<label for="text" class=" control-label"><?php esc_html_e('Email Address','ivdirectories'); ?></label>
											<input type="text" class="form-control" name="contact-email" id="contact-email" value="<?php echo get_post_meta($post->ID,'contact-email',true); ?>" placeholder="<?php esc_html_e('Enter Email Address','ivdirectories'); ?>">
										</div>																
										<div class="col-md-6 "> 
											<label for="text" class=" control-label"><?php esc_html_e('Web Site','ivdirectories'); ?></label>
												<input type="text" class="form-control" name="contact_web" id="contact_web" value="<?php echo get_post_meta($post->ID,'contact_web',true); ?>" placeholder="<?php esc_html_e('Enter Web Site','ivdirectories'); ?>">
										</div>																
									</div>
									</div>
									
								  </div>
								</div>
					  </div>
					
					<?php
						}
					?>
					
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
													<input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo get_post_meta($post->ID,'youtube',true); ?>" placeholder="<?php esc_html_e('Enter Youtube video ID, e.g : bU1QPtOZQZU ','ivdirectories'); ?>">
												</div>																
												<div class="col-md-6 "> 
												<label for="text" class=" control-label"><?php esc_html_e('Vimeo','ivdirectories'); ?></label>
												
												
													<input type="text" class="form-control" name="vimeo" id="vimeo" value="<?php echo get_post_meta($post->ID,'vimeo',true); ?>" placeholder="<?php esc_html_e('Enter vimeo ID, e.g : 134173961','ivdirectories'); ?>">
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
											<input type="text" name="facebook" id="facebook" value="<?php echo get_post_meta($post->ID,'facebook',true); ?>" class="form-control"/>
										</div>
										<div class="col-md-6 "> 
										<label class="control-label">Linkedin</label>
										<input type="text" name="linkedin" id="linkedin" value="<?php echo get_post_meta($post->ID,'linkedin',true); ?>" class="form-control"/>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6 "> 
											<label class="control-label">Twitter</label>
											<input type="text" name="twitter" id="twitter" value="<?php echo get_post_meta($post->ID,'twitter',true); ?>" class="form-control"/>
										</div>
										<div class="col-md-6 "> 
										<label class="control-label">Google+ </label>
										<input type="text" name="gplus" id="gplus" value="<?php echo get_post_meta($post->ID,'gplus',true); ?>"  class="form-control"/>
										</div>
									</div>
									   <div class="form-group row">
											<div class="col-md-6 "> 
												<label class="control-label">Instagram </label>
												<input type="text" name="instagram" id="instagram" value="<?php echo get_post_meta($post->ID,'instagram',true); ?>"  class="form-control"/>
											</div>
											<div class="col-md-6 "> 
											<label class="control-label">Youtube </label>
											<input type="text" name="youtube_social" id="youtube_social" value="<?php echo get_post_meta($post->ID,'youtube_social',true); ?>"  class="form-control"/>
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
								  <div class="panel-body">	
								  <?php					
										$opeing_days = get_post_meta($post->ID ,'_opening_time',true);
										if($opeing_days!=''){?>						
											
											<?php	
												$i=1;
												if(sizeof($opeing_days)>0){
													foreach($opeing_days as $key => $item){
														$day_time = explode("|", $item);	
														echo '<div id="old_days'. $i .'">
															<div class="col-md-4"><h5>'.$key.'</h5></div> <div class="col-md-7"> <h5>: '.$day_time[0].' - '.$day_time[1].'</h5></div><div class="col-md-1"> <button type="button" onclick="remove_old_day('.$i.');"  class="btn btn-xs btn-danger">X</button> 												
															 </div>
															<input type="hidden" name="day_name[]" id="day_name[]" value="'.$key.'">
															<input type="hidden" name="day_value1[]" id="day_value1[]" value="'.$day_time[0].'">
															<input type="hidden" name="day_value2[]" id="day_value2[]" value="'.$day_time[1].'">
															</div>
															';
														$i++;
													}	
												}										
										}
									 ?>		
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
						<div class="clearfix"></div>
							<?php
							$dir_addedit_awardtitle=get_option('dir_addedit_awardtitle');	
							if($dir_addedit_awardtitle==""){$dir_addedit_awardtitle=esc_html__('Awards','ivdirectories');}	
							
							$dir_addedit_award=get_option('dir_addedit_award');	
							if($dir_addedit_award==""){$dir_addedit_award='no';}	
							if($dir_addedit_award=="yes"){
							?>						
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
												
												<?php	$aw=0;	 
													   for($i=0;$i<20;$i++){
														 		  
														   if(get_post_meta($post->ID,'_award_title_'.$i,true)!='' || get_post_meta($post->ID,'_award_description_'.$i,true) || get_post_meta($post->ID,'_award_year_'.$i,true)|| get_post_meta($post->ID,'_award_image_id_'.$i,true) ){?>
															   
															   
															   <div id="award">
																   <div id="award_delete_<?php echo esc_html($i); ?>">
																   
																	<div class=" form-group">
																		<span class="pull-right"  > 
																		<button type="button" onclick="award_delete(<?php echo esc_html($i); ?>);"  class="btn btn-xs btn-danger">X</button>
																		</span>
																		<label for="text" class=" control-label"><?php esc_html_e('Title','ivdirectories'); ?>
																			
																		</label>
																		
																		<div class="  "> 
																			<input type="text" class="form-control" name="award_title[]" id="award_title[]" value="<?php echo get_post_meta($post->ID,'_award_title_'.$i,true); ?>" placeholder="<?php esc_html_e('Enter title','ivdirectories'); ?>">
																		</div>																
																	</div>		
																	<div class=" form-group">
																		<label for="text" class=" control-label"><?php esc_html_e('Description','ivdirectories'); ?></label>
																		
																		<div class="  "> 
																			<input type="text" class="form-control" name="award_description[]" id="award_description[]" value="<?php echo get_post_meta($post->ID,'_award_description_'.$i,true); ?>" placeholder="<?php esc_html_e('Enter Description','ivdirectories'); ?>">
																		</div>																
																	</div>
																	<div class=" form-group">
																		<label for="text" class=" control-label"><?php esc_html_e('Receive Year(s)','ivdirectories'); ?></label>
																		
																		<div class="  "> 
																			<input type="text" class="form-control" name="award_year[]" id="award_year[]" value="<?php echo get_post_meta($post->ID,'_award_year_'.$i,true); ?>" placeholder="<?php esc_html_e('Enter Year','ivdirectories'); ?>">
																		</div>																
																	</div>	
																	<div class=" form-group " style="margin-top:10px">
																		<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Image','ivdirectories'); ?>  </label>
																		<div class="col-md-4" id="award_image_div">
																			<?php 
																				if(get_post_meta($post->ID,'_award_image_id_'.$i,true)!=''){?>
																					<a  href="javascript:void(0);" onclick="award_post_image(this);"  >		
																					<img src="<?php echo wp_get_attachment_url( get_post_meta($post->ID,'_award_image_id_'.$i,true) ); ?> "  class="img-responsive">
																					<input type="hidden" name="award_image_id[]" id="award_image_id[]" value="<?php echo get_post_meta($post->ID,'_award_image_id_'.$i,true); ?>">
																					</a>
																				<?php
																				}else{?>
																						<a  href="javascript:void(0);" onclick="award_post_image(this);"  >									
																						<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>			
																						</a>																					
																			<?php		
																				}																		
																			?>
																							
																		</div>						
																	</div>
																</div>		
															</div>	
															 <div class="clearfix"></div>	 
															  <hr>
															 		
																	
															<?php
															$aw++;	
															}				 
														
														}
													?>
															<div id="awardmain">
															<div class=" form-group">
																<label for="text" class=" control-label"><?php esc_html_e('Title','ivdirectories'); ?></label>
																
																<div class="  "> 
																	<input type="text" class="form-control" name="award_title[]" id="award_title[]" value="" placeholder="<?php esc_html_e('Enter title','ivdirectories'); ?>">
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
												<button type="button" onclick="add_award_field();"  class="btn btn-xs green-haze"><?php esc_html_e('Add More','ivdirectories'); ?></button>
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
												<input type="text" class="form-control" name="event-title" id="event-title" value="<?php echo get_post_meta($post->ID,'event_title',true); ?>" placeholder="<?php esc_html_e('Enter Title Here','ivdirectories'); ?>">							
										</div>	
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Event Detail','ivdirectories'); ?></label>
												<?php
													$settings_a = array(															
														'textarea_rows' =>10,	
														'editor_class' => 'form-control'															 
														);
													$content_client = get_post_meta($post->ID,'event_detail',true);
													$editor_id = 'event-detail';
												
																						
													?>
													<textarea id="event-detail" name="event-detail"  rows="4" class="form-control" > <?php echo esc_html($content_client); ?> </textarea>
											
												
												
										</div>
										<div class=" row form-group " style="margin-top:10px">
											<label for="text" class=" col-md-5 control-label"><?php esc_html_e('Event Image','ivdirectories'); ?>  </label>
										
											<div class="col-md-4" id="event_image_div">										
												
											
													<?php
													
													if(get_post_meta($post->ID,'_event_image_id',true)!=''){
															$event_image_src= wp_get_attachment_url( get_post_meta($post->ID,'_event_image_id',true) );
															?>
															<img  class="img-responsive"  src="<?php echo esc_url($event_image_src); ?>">
																														
													
													<?php		
													}else{ ?>
															<a  href="javascript:void(0);" onclick="event_post_image('event_image_div');"  >									
															<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>	
															</a>
															
																
															
													<?php
													}
													?>			
											</div>
										
											<div class="col-md-3" id="event_image_edit">	
													<?php
													
													if(get_post_meta($post->ID,'_event_image_id',true)!=''){
															
															?>															
															<button type="button" onclick="event_post_image('event_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e( 'Edit', 'ivdirectories' );?></button> &nbsp;<button type="button" onclick="remove_event_image('event_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e( 'Remove', 'ivdirectories' );?></button>
															
													
													<?php		
													}else{ ?>
															<button type="button" onclick="event_post_image('event_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add','ivdirectories'); ?></button>
													<?php
													}
													?>		
											</div>	
											
											<input type="hidden" name="event_image_id" id="event_image_id" value="<?php echo esc_html( get_post_meta($post->ID,'_event_image_id',true)); ?>" >
											
																				
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
													$content_client = get_post_meta($post->ID,'booking_detail',true);
													$editor_id = 'booking_detail';
												
													
													$booking_shortcode = get_post_meta($post->ID,'booking',true);									
													?>
												<textarea id="booking_detail" name="booking_detail"  rows="4" class="form-control" > <?php echo esc_html($content_client); ?> </textarea>
										  </div>
										  <div class="form-group">
												<label class="control-label"><?php esc_html_e('Or, Booking Shortcode','ivdirectories'); ?>  </label>
												<input type="text" name="booking" id="booking"  placeholder="e.g : [events_calendar long_events=1]" class="form-control" value="<?php echo esc_html($booking_shortcode); ?>" />
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
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven1">
									  <?php echo esc_html($dir_addedit_dealcoupontitle); ?>
									</a>
								  </h4>
									<h4 class="panel-title" style="text-align:right;color:blue;font-size:12px;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven1">
									   <?php esc_html_e('[ Edit ]','ivdirectories'); ?> 
									</a>
								  </h4>
								</div>
								<div id="collapseSeven1" class="panel-collapse collapse">
								  <div class="panel-body">											
										
										<div class=" form-group">
											
											<label for="text" class="control-label"><?php esc_html_e('Title','ivdirectories'); ?></label>
												<input type="text" class="form-control" name="deal-title" id="deal-title" value="<?php  echo get_post_meta($post->ID,'deal_title',true);?>" placeholder="<?php esc_html_e('Enter Title Here','ivdirectories'); ?>">							
										</div>	
												<?php
												$currencyCode= get_option('_iv_directories_api_currency');
												?>
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Deals/Coupon Amount '.$currencyCode,'ivdirectories'); ?></label>
												
												<input type="text" class="form-control" name="deal-amount" id="deal-amount" value="<?php  echo get_post_meta($post->ID,'deal_amount',true);?>" placeholder="<?php esc_html_e('Enter Deals or Coupon Amount on '.$currencyCode.' [ No currency, Only Number]','ivdirectories'); ?>">							
										</div>
									
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Paypal Email Address [Amount will deposit here]','ivdirectories'); ?></label>
												<input type="text" class="form-control" name="deal-paypal" id="deal-paypal" value="<?php  echo get_post_meta($post->ID,'deal_paypal',true);?>" placeholder="<?php esc_html_e('Enter Your Paypal Email Address','ivdirectories'); ?>">							
										</div>
										
										<div class=" form-group">
											<label for="text" class=" control-label"><?php esc_html_e('Detail','ivdirectories'); ?></label>
													<?php
														$settings_a = array(															
															'textarea_rows' =>10,	
															'editor_class' => 'form-control'															 
															);
														$content_client =get_post_meta($post->ID,'deal_detail',true);
														$editor_id = 'deal-detail';
														wp_editor( $content_client, $editor_id,$settings_a );	
																							
														?>
													
										</div>
									
										<div class="row form-group " >
											<label for="text" class=" col-md-5 control-label" ><?php esc_html_e('Deal/Coupon Image','ivdirectories'); ?></label>
										
											<div class="col-md-4" id="deal_image_div" >
												
												<?php													
													if(get_post_meta($post->ID,'_deal_image_id',true)!=''){
															$deal_image_src= wp_get_attachment_url( get_post_meta($post->ID,'_deal_image_id',true) );
															?>
															<img  class="img-responsive"  src="<?php echo esc_url($deal_image_src); ?>">
																														
													
													<?php		
													}else{ ?>
															<a  href="javascript:void(0);" onclick="deal_post_image('deal_image_div');"  >									
															<?php  echo '<img width="100px" src="'. wp_iv_directories_URLPATH.'assets/images/image-add-icon.png">'; ?>	
															</a>
															
																
															
													<?php
													}
													?>							
											</div>
											
											<input type="hidden" name="deal_image_id" id="deal_image_id" value="<?php echo get_post_meta($post->ID,'_deal_image_id',true);  ?>">
											
											<div class="col-md-3" id="deal_image_edit">													
												<?php
													
													if(get_post_meta($post->ID,'_deal_image_id',true)!=''){
															
															?>															
															<button type="button" onclick="deal_post_image('deal_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e( 'Edit', 'ivdirectories' );?></button> &nbsp;<button type="button" onclick="remove_deal_image('deal_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e( 'Remove', 'ivdirectories' );?></button>
															
													
													<?php		
													}else{ ?>
															<button type="button" onclick="deal_post_image('deal_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add','ivdirectories'); ?></button>
													<?php
													}
													?>	
												
											</div>									
										</div>	
										
						
								
						 </div>
								
								
								</div>
					  </div>
						
						<?php
							}
						?>	
						
						  </div>
						</div>
			                     
                 <input type="hidden" name="listing_data_submit" id="listing_data_submit" value="yes">
                 
          <!-- END PROFILE CONTENT -->

   
	</div>
 </div>         
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
?>		