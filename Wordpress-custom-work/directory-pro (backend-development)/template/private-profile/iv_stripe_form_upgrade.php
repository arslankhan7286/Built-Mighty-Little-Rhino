<?php
wp_enqueue_script('iv_directories-script-upgrade-15', wp_iv_directories_URLPATH . 'admin/files/js/jquery.form-validator.js');

$newpost_id='';
$post_name='iv_directories_stripe_setting';
$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name =%s" ,$post_name ));
			if(isset($row->ID )){
			  $newpost_id= $row->ID;
			}
$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);	
if($stripe_mode=='test'){
	$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_publishable_test',true);	
}else{
	$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_live_publishable_key',true);	
}
$currencyCode= get_option('_iv_directories_api_currency');
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
			<div id="payment-errors"></div>
	<div id="stripe_form">
			<div class="row form-group">
			<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php    esc_html_e('Package Name','ivdirectories');?> </label>
				<div class="col-md-8 col-xs-8 col-sm-8 "> 																				
					<?php
					$iv_directories_pack='iv_directories_pack';
						$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =%s  and post_status='draft' ",$iv_directories_pack );
						
						$membership_pack = $wpdb->get_results($sql);
						$total_package=count($membership_pack);
						
						if(sizeof($membership_pack)>0){
							$i=0; $current_package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
							echo'<select name="package_sel" id ="package_sel" class=" form-control">';							
							foreach ( $membership_pack as $row )
							{	
								if($current_package_id==$row->ID){
									echo '<option value="'. $row->ID.'" >'. esc_html($row->post_title).' [Your Current Package]</option>';
								}else{
									echo '<option value="'. $row->ID.'" >'. esc_html($row->post_title).'</option>';
								}
									if($i==0){
										$package_id=$row->ID;
										if(get_post_meta($row->ID, 'iv_directories_package_recurring',true)=='on'){
											$package_amount=get_post_meta($row->ID, 'iv_directories_package_recurring_cost_initial', true);	
										}else{
											$package_amount=get_post_meta($row->ID, 'iv_directories_package_cost',true);
										
										}
									}
							 $i++;		
							}	
												
							echo '</select>';
						}
					 ?>
					</div>
				
				</div>
							
			<div class="row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php    esc_html_e('Amount','ivdirectories');?> </label>
								
								<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount"> <label class="control-label"> <?php  echo esc_html($package_amount).' '.esc_html($currencyCode); ?> </label>
								</div>										
			</div>				
			<div class="row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php    esc_html_e('Card Number','ivdirectories');?></label> 
								<div class="col-md-8 col-xs-8 col-sm-8 " >  
									<input type="text" name="card_number" id="card_number"  data-validation="creditcard required"  class="form-control ctrl-textbox" placeholder="<?php    esc_html_e('Enter card number','ivdirectories');?>" data-validation-error-msg="<?php    esc_html_e('Card number is not correct','ivdirectories');?>" >
			</div>										
			</div>
		<div class="row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php    esc_html_e('Card CVV','ivdirectories');?> </label>
								<div class="col-md-8 col-xs-8 col-sm-8 " >  
									<input type="text" name="card_cvc" id="card_cvc" class="form-control ctrl-textbox"   data-validation="number" 
data-validation-length="2-6" data-validation-error-msg="<?php    esc_html_e('CVV number is not correct','ivdirectories');?>" placeholder="<?php    esc_html_e('Enter card CVC','ivdirectories');?>" >
			</div>
		</div>	
					<div class="row form-group">
							<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php    esc_html_e('Expiration (MM/YYYY)','ivdirectories');?></label>
							<div class="col-md-4 col-xs-4 col-sm4" >  
							
								<select name="card_month" id="card_month"  class="card-expiry-month stripe-sensitive required form-control">
									<option value="01" selected="selected"><?php    esc_html_e('01','ivdirectories');?></option>
									<option value="02"><?php    esc_html_e('02','ivdirectories');?></option>
									<option value="03"><?php    esc_html_e('03','ivdirectories');?></option>
									<option value="04"><?php    esc_html_e('04','ivdirectories');?></option>
									<option value="05"><?php    esc_html_e('05','ivdirectories');?></option>
									<option value="06"><?php    esc_html_e('06','ivdirectories');?></option>
									<option value="07"><?php    esc_html_e('07','ivdirectories');?></option>
									<option value="08"><?php    esc_html_e('08','ivdirectories');?></option>
									<option value="09"><?php    esc_html_e('09','ivdirectories');?></option>
									<option value="10"><?php    esc_html_e('10','ivdirectories');?></option>
									<option value="11"><?php    esc_html_e('11','ivdirectories');?></option>
									<option value="12" selected ><?php    esc_html_e('12','ivdirectories');?></option>
								  </select>
							</div>
						<div class="col-md-4 col-xs-4 col-sm-4 " >  
								 <select name="card_year"  id="card_year"  class="card-expiry-year stripe-sensitive  form-control">
								  </select>
								  <script type="text/javascript">
									var select = jQuery(".card-expiry-year"),
									year = new Date().getFullYear();
						 
									for (var i = 0; i < 12; i++) {
										select.append(jQuery("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
									}
								</script> 
						</div>								
					</div>	
				<?php
									$iv_directories_payment_terms=get_option('iv_directories_payment_terms'); 
									$term_text='I have read & accept the Terms & Conditions';
									if( get_option( 'iv_directories_payment_terms_text' ) ) {
										$term_text= get_option('iv_directories_payment_terms_text'); 
									}
									if($iv_directories_payment_terms=='yes'){
									?>
							
								<div class="row">
									<div class="col-md-4 col-xs-4 col-sm-4 "> 
									</div>
											<div class="col-md-8 col-xs-8 col-sm-8 "> 
											<label>
											  <input type="checkbox" data-validation="required" 
			 data-validation-error-msg="<?php    esc_html_e('You have to agree to our terms','ivdirectories');?> "  name="check_terms" id="check_terms"> <?php echo esc_html($term_text); ?>
											</label>
										<div class="text-danger" id="error_message" > </div>
									  </div>									
								</div>
																				
								<?php
								}	 
										 
								?>	
						<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">	
						<input type="hidden" name="coupon_code" id="coupon_code" value="">	 		
						<input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
						<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
			
				
			
				<div class="row form-group">
					<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
					<div class="col-md-8 col-xs-8 col-sm-8 " > <div id="loading"> </div> 
						<button  id="submit_iv_directories_payment"  type="submit" class="btn btn-info ctrl-btn"  > <?php    esc_html_e('Submit','ivdirectories');?> </button>
					</div>
				</div>	
	</div>			
	 			
<script type="text/javascript">	
var loader_image = '<img src="<?php echo wp_iv_directories_URLPATH. "admin/files/images/loader.gif"; ?>" />';

(function($) {
	var active_payment_gateway='<?php echo esc_html($iv_gateway); ?>'; 
	jQuery(document).ready(function($) {
						
						jQuery.validate({
							form : '#profile_upgrade_form',
							modules : 'security',		
												
							onSuccess : function() {
							  
							  	
								jQuery("#loading").html(loader_image);
								
								if(active_payment_gateway=='stripe'){
									
									  var chargeAmount = 3000;
									  
									 Stripe.createToken({
										number: jQuery('#card_number').val(),
										cvc: jQuery('#card_cvc').val(),
										exp_month: jQuery('#card_month').val(),
										exp_year: jQuery('#card_year').val(),
										
									}, stripeResponseHandler);
									
									return false;
									
								}else{ // Else for paypal
									
									return true; // false Will stop the submission of the form
								}
								
							},
							
					  })
 
	 })
	 
		
		Stripe.setPublishableKey('<?php echo  $stripe_publishable; ?>');

		function stripeResponseHandler(status, response) {
			if (response.error) {				
				jQuery("#payment-errors").html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.error.message +'.</div> ');
			} else {
				var form$ = jQuery("#profile_upgrade_form");
				// token contains id, last4, and card type
				var token = response['id'];
				// insert the token into the form so it gets submitted to the server
				form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
				// and submit
					
				 	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';			
					var search_params={
						"action"  : 	"iv_directories_profile_stripe_upgrade",	
						"form_data":	jQuery("#profile_upgrade_form").serialize(), 
						"_wpnonce": '<?php echo wp_create_nonce("update"); ?>',
					};
					jQuery.ajax({					
						url : ajaxurl,					 
						dataType : "json",
						type : "post",
						data : search_params,
						success : function(response){
							jQuery('#payment-errors').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
							jQuery("#stripe_form").hide();
							
						}
					});
				
			}
		}
})(jQuery);		
		
</script>		
