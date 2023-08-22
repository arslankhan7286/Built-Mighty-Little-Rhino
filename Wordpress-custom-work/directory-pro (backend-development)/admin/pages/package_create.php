<script>
function save_the_form() {
	var loader_image = "<img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' />";
	jQuery("#loading").html(loader_image);

			// New Block For Ajax*****
			var search_params={
				"action"  : 	"iv_directories_save_package",	
				"form_data":	jQuery("#package_form_iv").serialize(),
				"_wpnonce": '<?php echo wp_create_nonce("eppackage"); ?>',	
			};
			jQuery.ajax({					
				url : ajaxurl,					 
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){
					var url = "<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-package-all&form_submit=success";    						
					jQuery(location).attr('href',url);	
				}
			});
			
}

			
	jQuery(document).ready(function(){
		jQuery('#package_recurring').click(function(){
			if(this.checked){				
				jQuery('#recurring_block').show();
			}else{				
				jQuery('#recurring_block').hide();
			}
		});
	});	
	jQuery(document).ready(function(){
		jQuery('#package_enable_trial_period').click(function(){
			if(this.checked){				
				jQuery('#trial_block').show();
			}else{				
				jQuery('#trial_block').hide();
			}
		});
	});		
</script>	
			<?php			
			global $wpdb;	
		
					
			?>
			<div class="bootstrap-wrapper">
				<div class="dashboard-eplugin container-fluid">
					<div class="row">					
						<div class="col-xs-12" id="submit-button-holder">					
							<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return save_the_form();"><?php esc_html_e('Save Package','ivdirectories'); ?></button></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Create Package / Membership Level','ivdirectories'); ?> <br /><small> &nbsp;</small> </h3>
						</div>							
							
					</div> 					
						<form id="package_form_iv" name="package_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
							  
							  <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Name','ivdirectories'); ?></label>
								<div class="col-md-6">
								  <input type="text" class="form-control" name="package_name" id="package_name" placeholder="Enter Package Name">
								</div>
							  </div>
							    <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Feature List','ivdirectories'); ?></label>
								<div class="col-md-6">
									<textarea class="form-control" name="package_feature" id="package_feature" rows="5" placeholder="Enter Feature List "></textarea>
								    <?php esc_html_e('It will display on price list table','ivdirectories'); ?> 
								</div>
							  </div>
							  <h3 class="page-header"> <?php esc_html_e('Billing Details','ivdirectories'); ?></h3>
							 
							  <div class="form-group">
								<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e('Initial Payment','ivdirectories'); ?></label>
								<div class="col-md-6">
								  <input type="text" class="form-control" id="package_cost" name="package_cost" placeholder="Enter Initial Payment">
								  <?php esc_html_e('The initial amount collected at user registration.','ivdirectories'); ?>
								</div>
							  </div>
							  
							   <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Expire After','ivdirectories'); ?></label>
								<div class="col-md-2">
								  <select id="package_initial_expire_interval" name="package_initial_expire_interval" class="ctrl-combobox form-control">
									  
										<?php 
											$package_id='0';
											
											 $package_initial_period_interval= get_post_meta($package_id, 'iv_directories_package_initial_expire_interval', true); 
											  echo '<option value="">None</option>';
											for($ii=1;$ii<31;$ii++){
												echo '<option value="'.$ii.'" '.($package_initial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
											
											}
											
											?>
                                           
                                    </select>	
                                     			
								</div>	
											
								
									<div class="col-md-4">
										<?php
											 $package_initial_expire_type= get_post_meta($package_id, 'iv_directories_package_initial_expire_type', true); 
											 ?>
											<select name="package_initial_expire_type" id ="package_initial_expire_type" class=" form-control">		
													<option value="">None </option>								
													<option value="day" <?php echo ($package_initial_expire_type == 'day' ? 'selected' : '') ?>>Day(s)</option>
													<option value="week" <?php echo ($package_initial_expire_type == 'week' ? 'selected' : '') ?>>Week(s)</option>
													<option value="month" <?php echo ($package_initial_expire_type == 'month' ? 'selected' : '') ?>>Month(s)</option>
													<option value="year" <?php echo ($package_initial_expire_type == 'year' ? 'selected' : '') ?>>Year(s)</option>
											</select>		
									 
									</div>
									<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
									<?php esc_html_e('If select none then user package will expire after 19 years. Package Expire Option will not work on Recurring Subscription. "Billing Cycle Limit" will Work For Recurring Subscription.','ivdirectories'); ?>
										
									</div>
								
							  </div>
								
								   <div class="form-group">
									<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Recurring Subscription','ivdirectories'); ?></label>
									
									<div class="col-md-6 ">
										<label>
										  <input type="checkbox" name="package_recurring" id="package_recurring" value="on" > <?php esc_html_e('Enable Recurring Payment','ivdirectories'); ?>
										</label>
									</div>								
								  </div>
								  
								  
				<div id="recurring_block" style="display:none" >

									
								   <div class="form-group">
									<label for="text" class="col-md-2 control-label"><?php esc_html_e('Billing Amount','ivdirectories'); ?></label>
									<div class="col-md-2">
									  <input type="text" class="form-control" name ="package_recurring_cost_initial" id="package_recurring_cost_initial" placeholder="Amount">
									</div>
									<label for="text" class="col-md-1 control-label"><?php esc_html_e('Per','ivdirectories'); ?></label>
									<div class="col-md-1">									
									   <input type="text" class="form-control" id="package_recurring_cycle_count" name="package_recurring_cycle_count" placeholder="Cycle #">
									</div>
										<div class="col-md-2">
												<select name="package_recurring_cycle_type" id ="package_recurring_cycle_type" class="ctrl-combobox form-control">											
														<option value="day">Day(s)</option>
														<option value="week">Week(s)</option>
														<option value="month">Month(s)</option>
														<option value="year">Year(s)</option>
												</select>		
										 
										</div>
										<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
											<?php esc_html_e('The "Billing Amount" will Collect at User Registration.','ivdirectories'); ?>
										</div>
									  </div>
							   <?php
							  if(get_option('iv_directories_payment_gateway')!='woocommerce'){
							  ?>
							   <div class="form-group">
									<label for="text" class="col-md-2 control-label"><?php esc_html_e('Billing Cycle Limit','ivdirectories'); ?></label>
															
									<div class="col-md-2">
											<select name="package_recurring_cycle_limit" id ="package_recurring_cycle_limit" class="ctrl-combobox form-control">											
													<option value="">Never</option>										
												<?php
												 $package_recurring_cycle_limit= ""; 
												for($ii=1;$ii<35;$ii++){
													echo '<option value="'.$ii.'" '.($package_recurring_cycle_limit == $ii ? 'selected' : '').'>'.$ii.'</option>';												
												}												
												?>
											</select>	
									</div>									
							  </div>							
								<div class="form-group">
									<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Trial','ivdirectories'); ?></label>
									<div class="col-md-6 ">
										<label>
										  <input type="checkbox" name="package_enable_trial_period" id="package_enable_trial_period"  value='yes'> <?php esc_html_e('Enable Trial Period','ivdirectories'); ?>
										</label>
										<br/>
										<?php esc_html_e('"Billing Amount" will Collect After Trial Period. ','ivdirectories'); ?> 
										
									</div>																
								</div>
						
								<div id="trial_block" style="display:none" >
								  
									   <div class="form-group">
										<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e('Trial Amount','ivdirectories'); ?></label>
										<div class="col-md-6">
										  <input type="text" class="form-control" id="package_trial_amount" name="package_trial_amount" placeholder="Enter Amount to Bill for The Trial Period">
											<?php esc_html_e('Amount to Bill for The Trial Period. Free is 0.[Stripe will not support this option ]','ivdirectories'); ?>
										</div>
									  </div>
									  
									  <div class="form-group">
										<label for="text" class="col-md-2 control-label"><?php esc_html_e('Trial Period','ivdirectories'); ?></label>
										<div class="col-md-2">
										  <select id="package_trial_period_interval" name="package_trial_period_interval" class="ctrl-combobox form-control">
												   
												<?php
												
													 $package_trial_period_interval= '1'	; 
													for($ii=1;$ii<31;$ii++){
														echo '<option value="'.$ii.'" '.($package_trial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
													
													}
													
													?>
											</select>
												
											
										</div>	
										
													
										
											<div class="col-md-4">
													<select name="package_recurring_trial_type" id ="package_recurring_trial_type" class="ctrl-combobox form-control">											
															<option value="day">Day(s)</option>
															<option value="week">Week(s)</option>
															<option value="month">Month(s)</option>
															<option value="year">Year(s)</option>
													</select>		
											 
											</div>
											<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
												<?php esc_html_e('After The Trial Period "Billing Amount"	Will Be Billed.','ivdirectories'); ?>	
											</div>
										
									  </div>
							</div> <!-- Trial Block -->		  
								<?php
								}
								?>
								  
						</div> <!-- Recurring Block -->
							<?php
							if(get_option('iv_directories_payment_gateway')=='woocommerce'){
							if ( class_exists( 'WooCommerce' ) ) {
							
							?>  
							  <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e('Woocommerce Product','ivdirectories'); ?></label>
								<div class="col-md-3">							
										<select  class="form-control" id="Woocommerce_product" name="Woocommerce_product">
											<?php 					
											$publish='publish';	
											$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts where post_type='product'  and post_status=%s",$publish);		
											$product_rows = $wpdb->get_results($sql);	
											if(sizeof($product_rows)>0){									
												foreach ( $product_rows as $row ) 
												{	$selected='';													
													echo '<option value="'.esc_html($row->ID).'"'.$selected.' >'.esc_html($row->post_title).' </option>';
												}
											}	
											?>											
										</select>                                     			
								</div>		
							</div>						
						<?php
							}
						}	
						?>				
							  
						<h3 class="page-header"> <?php esc_html_e('Access Control/Options','ivdirectories'); ?> </h3>
						 <div class="form-group">
							<label for="text" class="col-md-2  control-label"><?php esc_html_e('Maximum Post/Directory','ivdirectories'); ?> </label>
							<div class="col-md-6">
							  <input type="text" class="form-control" name="max_pst_no" id="max_pst_no" placeholder="Enter Max Number">
							  <?php esc_html_e('Maximum # of post by this package. Blank is none.','ivdirectories'); ?>
							</div>
						  </div>
						 <div class="form-group">
							<label for="text" class="col-md-2 control-label"><?php esc_html_e('Directory Visibility','ivdirectories'); ?>  </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_hide" id="listing_hide"  value='yes'> <?php esc_html_e('Directory will hide after user subscription expire.','ivdirectories'); ?>
								</label>																	
							</div>																
						</div> 
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Directory Event','ivdirectories'); ?> </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_event" id="listing_event"  value='yes'> <?php esc_html_e('Can Add Event.','ivdirectories'); ?>
								</label>
																		
							</div>																
						</div> 						
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Deals/Coupon','ivdirectories'); ?> </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_coupon" id="listing_coupon"  value='yes'> <?php esc_html_e('Can Add Directory Deals/Coupon.','ivdirectories'); ?>
								</label>								 										
							</div>																
						</div> 
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Directory Videos','ivdirectories'); ?> </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_video" id="listing_video"  value='yes'> <?php esc_html_e('Can Add Videos.','ivdirectories'); ?>
								</label>								 										
							</div>																
						</div> 
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Directory VIP Badge','ivdirectories'); ?> </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_badge_vip" id="listing_badge_vip"  value='yes'> <?php esc_html_e('Will Add VIP Badge','ivdirectories'); ?> <img width="30px" src="<?php echo  wp_iv_directories_URLPATH."/assets/images/vipicon.png";?>">	
								</label>								 										
							</div>																
						</div> 
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Directory Booking','ivdirectories'); ?> </label>
							<div class="col-md-6 ">
								<label>
								  <input type="checkbox" name="listing_booking" id="listing_booking"  value='yes'  > <?php esc_html_e('Can Add Booking Shortcode','ivdirectories'); ?> 
								</label>								 										
							</div>													
						</div>				
						
						</form>
					
						<div class="row">					
							<div class="col-xs-12">					
								<div align="center">
									<div id="loading"></div>
									<button class="btn btn-info btn-lg" onclick="return save_the_form();"><?php esc_html_e('Save Package','ivdirectories'); ?></button></div>
									<p>&nbsp;</p>
								</div>
							</div>
						</div>
				</div>		 

