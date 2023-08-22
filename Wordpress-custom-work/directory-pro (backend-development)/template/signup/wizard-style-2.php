<?php
	global $wpdb;
	wp_enqueue_style('iv_directories-style-110', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_script('iv_directories-script-signup-12', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min.js');
	$api_currency= 'USD';
	if( get_option('_iv_directories_api_currency' )!=FALSE ) {
		$api_currency= get_option('_iv_directories_api_currency' );
	}	
	if(isset($_REQUEST['payment_gateway'])){
		$payment_gateway=sanitize_text_field($_REQUEST['payment_gateway']);
		if($payment_gateway=='paypal'){
		}
	}
	$eprecaptcha_api=get_option( 'eprecaptcha_api');
	$iv_directories_pack='iv_directories_pack';
	$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =%s  and post_status='draft' ", $iv_directories_pack);
	$membership_pack = $wpdb->get_results($sql);
	$total_package=count($membership_pack);
	$package_id= 0;
	$iv_gateway='paypal-express';
	if( get_option( 'iv_directories_payment_gateway' )!=FALSE ) {
		$iv_gateway = get_option('iv_directories_payment_gateway');	
		if($iv_gateway=='paypal-express'){
			$post_name='iv_directories_paypal_setting';						
			$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name =%s",$post_name ));
			$paypal_id='0';						
			if(isset($row->ID)){
				$paypal_id= $row->ID;
			}							
			$api_currency=get_post_meta($paypal_id, 'iv_directories_paypal_api_currency', true);
			if($api_currency==""){
				$api_currency= 'USD';
			}	
		}				 
	}
	$package_id=''; 
	if(isset($_REQUEST['package_id'])){
		$package_id=sanitize_text_field($_REQUEST['package_id']);
		$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);	
		if($recurring == 'on'){
			$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
			}else{
			$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
		}
		if($package_amount=='' || $package_amount=='0' ){$iv_gateway='paypal-express';}
	}
	$form_meta_data= get_post_meta( $package_id,'iv_directories_content',true);			
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE id =%d",$package_id ) );
	$package_name='';
	$package_amount='';
	if(isset($row->post_title)){
		$package_name=$row->post_title;
		$count =get_post_meta($package_id, 'iv_directories_package_recurring_cycle_count', true);
		$package_name=$package_name;
		$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
	}
	$newpost_id='';
	$post_name='iv_directories_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name =%s" ,$post_name));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);	
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_publishable_test',true);	
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_live_publishable_key',true);	
	}
	if($total_package<1){$iv_gateway='paypal-express';}
?>
<style>
.displaynone{
	display: none;
}
</style>
<div class="bootstrap-wrapper">
  <div id="iv-form3" class="sign-up-wizard">
		<h3 class="header-profile">
			<div>
				<?php  esc_html_e('User Info','ivdirectories');?>
			</div>
		</h3>
    <?php
			if($iv_gateway=='paypal-express'){	
			?>
			<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=paypal&iv-submit-listing=register" method="post" role="form">
				<?php	
				}
				if($iv_gateway=='woocommerce'){
				?>
				<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=woocommerce&iv-submit-listing=register" method="post" role="form">
					<?php
					}
					if($iv_gateway=='stripe'){?>
					<form id="iv_directories_registration" name="iv_directories_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&package_id=<?php echo esc_html($package_id); ?>&payment_gateway=stripe&iv-submit-stripe=register" method="post" role="form">
						<input type="hidden" name="payment_gateway" id="payment_gateway" value="stripe">
						<input type="hidden" name="iv-submit-stripe" id="iv-submit-stripe" value="register">
						<?php	
						}
					?>
					<div class="row">
						<div class="col-md-12 ">
							<?php
								if(isset($_REQUEST['message-error'])){?>
								<div class="row alert alert-info alert-dismissable" id='loading-2'><a class="panel-close close" data-dismiss="alert">x</a>
									<?php  echo sanitize_text_field($_REQUEST['message-error']); ?>
								</div>
								<?php
								}
							?>
							<div>
								<div id="selected-column-1" class=" ">
									<div class="text-center" id="loading"> </div>
									<div class="form-group row"  >
										<label for="text" class="col-md-4 control-label">
											<?php  esc_html_e('User Name','ivdirectories');?>
										<span class="chili"></span></label>
										<div class="col-md-8">
											<input type="text"  name="iv_member_user_name"  id="iv_member_user_name"  data-validation="length alphanumeric" 
											data-validation-length="4-12" data-validation-error-msg="<?php  esc_html_e(' The user name has to be an alphanumeric value between 4-12 characters','ivdirectories');?>" class="form-control ctrl-textbox" placeholder="<?php  esc_html_e('Enter User Name','ivdirectories');?>"  alt="required">
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-md-4 control-label" >
											<?php  esc_html_e('Email Address','ivdirectories');?>
										<span class="chili"></span></label>
										<div class="col-md-8">
											<input type="email" name="iv_member_email" id="iv_member_email" data-validation="email"  class="form-control ctrl-textbox" placeholder="<?php  esc_html_e('Enter email address','ivdirectories');?>" data-validation-error-msg="<?php  esc_html_e('Please enter a valid email address','ivdirectories');?> " >
										</div>
									</div>
									<div class="form-group row ">
										<label for="text" class="col-md-4 control-label">
											<?php  esc_html_e('Password','ivdirectories');?>
										<span class="chili"></span></label>
										<div class="col-md-8">
											<input type="password" name="iv_member_password"  id="iv_member_password" class="form-control ctrl-textbox" placeholder="" data-validation="strength" 
											data-validation-strength="2" data-validation-error-msg="<?php  esc_html_e('The password is not strong enough','ivdirectories');?>">
										</div>
									</div>
								</div>
							</div>
							<?php wp_nonce_field( 'signup1' ); ?>
							<?php							
								$total_package = count($membership_pack);
								if(sizeof($membership_pack)<1){ ?>
								<input type="hidden" name="reg_error" id="reg_error" value="yes">
								<input type="hidden" name="package_id" id="package_id" value="0">
								<input type="hidden" name="return_page" id="return_page" value="<?php  the_permalink() ?>">
								<div class="row form-group">
									<div class="col-md-4"> </div>
									<div class="col-md-8">
									<div id="errormessage" class="alert alert-danger mt-2 displaynone" role="alert"></div>
										<div id="paypal-button">
											<div id="loading-3" style="display: none;"><img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>
											<?php
											if($eprecaptcha_api==''){
											?>											
											<button  id="submit_iv_directories_payment" name="submit_iv_directories_payment"  type="submit" class="btn btn-secondary"  >
												<?php  esc_html_e('Submit','ivdirectories');?>
											</button>
											<?php
											}else{
											?>
												<button  id="submit_iv_directories_payment" name="submit_iv_directories_payment"  class="btn btn-secondary g-recaptcha" data-sitekey="<?php echo esc_html($eprecaptcha_api); ?>"  data-callback='epluginrecaptchaSubmit' data-action='submit' >
												<?php  esc_html_e('Submit','ivdirectories');?>
												</button>
											<?php
											}
											?>
										</div>
									</div>
								</div>
								<?php
								}
							?>
							<input type="hidden" name="hidden_form_name" id="hidden_form_name" value="iv_directories_registration">
						</div>
					</div>
					<br/>
					<?php
						if($total_package>0){
						?>
						<h3 class="header-profile">
							<div>
								<?php  esc_html_e('Payment Info','ivdirectories');?>
							</div>
						</h3>
						<div class="row">
							<div class="col-md-12">
								<?php 														
									if($iv_gateway=='paypal-express'){
										include(wp_iv_directories_template.'signup/paypal_form_2.php');
									}
									if($iv_gateway=='stripe'){
										include(wp_iv_directories_template.'signup/iv_stripe_form_2.php');					
									}	
									if($iv_gateway=='woocommerce'){
										include(wp_iv_directories_template.'signup/woocommerce.php');
									}										
								?>
							</div>
						</div>
						<?php
						}
					?>
				</form>
				<div style="display: none;"> <img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' /> </div>
			</div>
		</div>
		<?php
			wp_enqueue_script("jquery");
			wp_enqueue_script('iv_directories-script-signup-2-15', wp_iv_directories_URLPATH . 'admin/files/js/jquery.form-validator.js');
			wp_enqueue_script('iv_directory-script-30', wp_iv_directories_URLPATH . 'admin/files/js/signup.js');
			wp_localize_script('iv_directory-script-30', 'dirpro_data', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loader_image'=>'<img src="'.wp_iv_directories_URLPATH. 'admin/files/images/loader.gif" />',
			'loader_image2'=>'<img src="'.wp_iv_directories_URLPATH. 'admin/files/images/old-loader.gif" />',
			'right_icon'=>'<img src="'.wp_iv_directories_URLPATH. 'admin/files/images/right_icon.png" />',
			'wrong_16x16'=>'<img src="'.wp_iv_directories_URLPATH. 'admin/files/images/wrong_16x16.png" />',
			'stripe_publishable'=>$stripe_publishable,
			'package_amount'=>$package_amount,
			'errormessage'=>esc_html__("Please complete the form",'ivdirectories'),
			'api_currency'=>$api_currency,
			'iv_gateway'=>$iv_gateway,
			'HideCoupon'=>esc_html__("Hide Coupon",'ivdirectories'),
			'Havecoupon'=>esc_html__("Have a coupon?",'ivdirectories'),
			'dirwpnonce'=> wp_create_nonce("signup2"),
			) );
			
	if($eprecaptcha_api!=''){	
		wp_register_script( 'rechaptcha', 'https://www.google.com/recaptcha/api.js?render='.$eprecaptcha_api, null, null, true );
		wp_enqueue_script('rechaptcha');
	}		