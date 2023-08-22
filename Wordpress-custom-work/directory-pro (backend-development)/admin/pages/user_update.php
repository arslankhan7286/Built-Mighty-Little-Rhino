<?php
wp_enqueue_script('jquery-ui-datepicker');
?>
<script>
	function update_user_setting() {
	
				// New Block For Ajax*****
				var search_params={
					"action"  : 	"iv_directories_update_user_settings",	
					"form_data":	jQuery("#user_form_iv").serialize(), 
					"_wpnonce": '<?php echo wp_create_nonce("userupdate"); ?>',	
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						var url = "<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_user-directory-admin&message=success";    						
						jQuery(location).attr('href',url);
						
					}
				});
				
	}
		jQuery(function() {
			jQuery( "#exp_date" ).datepicker({ dateFormat: 'yy-m-d',changeMonth: true, changeYear: true, yearRange: '-99:+50' });
						
		});			


			
</script>	
			<?php
			global $wpdb,$wp_roles;
			$user_id='';
			if(isset($_GET['id'])){ $user_id=sanitize_text_field($_GET['id']);}
			
			$user = new WP_User( $user_id );
			
			?>
			<div class="bootstrap-wrapper">
				<div class="dashboard-eplugin container-fluid">	
					<div class="row">
						<div class="col-md-12"><h3 class=""><?php esc_html_e( 'User Settings: Edit', 'ivdirectories' );?> </h3>
						
						</div>	
					</div> 
					<div class="col-md-7 panel panel-info">
						<div class="panel-body">
								
						
						<form id="user_form_iv" name="user_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
													 
							<div class="form-group">
								<label for="text" class="col-md-3 control-label"></label>
								<div id="iv-loading"></div>
							 </div>	
							  <div class="form-group">
								<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'User Name', 'ivdirectories' );?></label>
								<div class="col-md-8">
									
									<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_login); ?></label>
								</div>
							  </div>
							   <div class="form-group">
								<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Email Address', 'ivdirectories' );?></label>
								<div class="col-md-8">									
									<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_email); ?></label>
									
								</div>
							  </div>	
							 
							 <div class="form-group">
								<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Role', 'ivdirectories' );?></label>
								<div class="col-md-8">
									<?php
											$user_role= $user->roles[0];
										?>
									<select name="user_role" id ="user_role" class="form-control">
										<?php											
													foreach ( $wp_roles->roles as $key=>$value ){														
															echo'<option value="'.$key.'"  '.($user_role==$key? " selected" : " ") .' >'.$key.'</option>';	
														
													}

											  ?>	
									</select>	
								</div>
							  </div> 
							 <div class="form-group">
								<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Package', 'ivdirectories' );?></label>
								<div class="col-md-8">									
										<?php
								
								
								$post_type='iv_directories_pack';
								$membership_pack = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = %s ", $post_type ));								
							
								$total_package=count($membership_pack);
								
								if($membership_pack>0){
									$i=0; $current_package_id=get_user_meta($user_id,'iv_directories_package_id',true);
									echo'<select name="package_sel" id ="package_sel" class=" form-control">';
									foreach ( $membership_pack as $row )
									{
										if($current_package_id==$row->ID){
											echo '<option value="'. $row->ID.'" selected>'. $row->post_title.' [User Current Package]</option>';
										}else{
											echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
										}
											
									 $i++;
									}

									echo '</select>';
								}
							 ?>
								</div>
							  </div> 
							  <div class="form-group">
								<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'Payment Status', 'ivdirectories' );?></label>
								<div class="col-md-8">
									<?php
									 $payment_status= get_user_meta($user_id, 'iv_directories_payment_status', true);
									?>
									<select name="payment_status" id ="payment_status" class="form-control">
													<option value="success" <?php echo ($payment_status == 'success' ? 'selected' : '') ?>><?php esc_html_e( 'Success', 'ivdirectories' );?></option>
													<option value="pending" <?php echo ($payment_status == 'pending' ? 'selected' : '') ?>><?php esc_html_e( 'Pending', 'ivdirectories' );?></option>
													
									</select>	
									
								</div>
							  </div>
							  <div class="form-group">
								<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Expiry Date', 'ivdirectories' );?></label>
								<div class="col-md-8">
									<?php
									 $exp_date= get_user_meta($user_id, 'iv_directories_exprie_date', true);
									?>
								 <input type="text"  name="exp_date"  readonly   id="exp_date" class="form-control ctrl-textbox"  value="<?php echo esc_html($exp_date); ?>" placeholder="">

								</div>
							  </div>						
							 <input type="hidden"  name="user_id"     id="user_id"   value="<?php echo esc_html($user_id); ?>" >
										
							<div class="row">					
								<div class="col-md-12">	
									<label for="" class="col-md-4 control-label"></label>
									<div class="col-md-8">
										<button class="btn btn-info " onclick="return update_user_setting();"><?php esc_html_e( 'Update User', 'ivdirectories' );?></button></div>
										<p>&nbsp;</p>
									</div>
								</div>
							</div>	
							
							</form>
						</div>			
					</div>
				</div>		 



			
