<?php
	$eprecaptcha_api=get_option( 'eprecaptcha_api');
	$newpost_id='';
	$post_name='iv_directories_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);	
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_publishable_test',true);	
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'iv_directories_stripe_live_publishable_key',true);	
	}
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<div id="payment-errors"></div>
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Package Name','ivdirectories');?></label>
	<div class="col-md-8 col-xs-4 col-sm-8 "> 																				
		<?php
			if( $package_name==""){	
				if(sizeof($membership_pack)>0){
					$i=0;
					echo'<select name="package_sel" id ="package_sel" class=" form-control">';
					foreach ( $membership_pack as $row )
					{	
						echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
						if($i==0){$package_id=$row->ID;}
						$i++;
					}	
					echo '</select>';	
					$package_id= $membership_pack[0]->ID;
					$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);	
					if($recurring == 'on'){
						$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
						}else{
						$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
					}	
				?>
				<?php
				}	
				}else{
				echo '<label class="control-label"> '.$package_name.'</label>';
				$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
				if($recurring == 'on'){
					$package_amount=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
					}else{
					$package_amount=get_post_meta($package_id, 'iv_directories_package_cost',true);
				}
			}
		?>
	</div>
</div>
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Amount','ivdirectories');?></label>
	<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount"> <label class="control-label"> <?php echo esc_html($package_amount).' '.esc_html($api_currency ); ?> </label>
	</div>										
</div>
<?php
	if( get_option('_iv_directories_payment_coupon')==""){
	?>
	<div class="row form-group" id="show_hide_div">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " > 
			<button type="button" onclick="show_coupon();"  class="btn btn-default center"><?php  esc_html_e('Have a coupon?','ivdirectories');?></button>
		</div>
	</div>
	<?php
		include(wp_iv_directories_template.'signup/coupon_form_2.php');
	}
?>
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Card Number','ivdirectories');?></label> 
	<div class="col-md-8 col-xs-8 col-sm-8 " >  
		<input type="text" name="card_number" id="card_number"  data-validation="creditcard required"  class="form-control ctrl-textbox" placeholder="<?php  esc_html_e('Enter card number','ivdirectories');?>"  data-validation-error-msg="<?php  esc_html_e('Card number is not correct','ivdirectories');?>" >
	</div>										
</div>
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Card CVV ','ivdirectories');?></label>
	<div class="col-md-8 col-xs-8 col-sm-8 " >  
		<input type="text" name="card_cvc" id="card_cvc" class="form-control ctrl-textbox"   data-validation="number" 
		data-validation-length="2-6" data-validation-error-msg="<?php  esc_html_e('CVV number is not correct','ivdirectories');?>"placeholder="<?php  esc_html_e('Enter card CVC','ivdirectories');?>" >
	</div>
</div>	
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Expiration (MM/YYYY)','ivdirectories');?></label>
	<div class="col-md-4 col-xs-4 col-sm4" >  
		<select name="card_month" id="card_month"  class="card-expiry-month stripe-sensitive required form-control">
			<option value="01" selected="selected"><?php  esc_html_e('01','ivdirectories');?></option>
			<option value="02"><?php  esc_html_e('02','ivdirectories');?></option>
			<option value="03"><?php  esc_html_e('03','ivdirectories');?></option>
			<option value="04"><?php  esc_html_e('04','ivdirectories');?></option>
			<option value="05"><?php  esc_html_e('05','ivdirectories');?></option>
			<option value="06"><?php  esc_html_e('06','ivdirectories');?></option>
			<option value="07"><?php  esc_html_e('07','ivdirectories');?></option>
			<option value="08"><?php  esc_html_e('08','ivdirectories');?></option>
			<option value="09"><?php  esc_html_e('09','ivdirectories');?></option>
			<option value="10"><?php  esc_html_e('10','ivdirectories');?></option>
			<option value="11"><?php  esc_html_e('11','ivdirectories');?></option>
			<option value="12" selected ><?php  esc_html_e('12','ivdirectories');?></option>
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
				data-validation-error-msg="<?php  esc_html_e('You have to agree to our terms','ivdirectories');?> "  name="check_terms" id="check_terms"> <?php echo $term_text; ?>
			</label>
			<div class="text-danger" id="error_message" > </div>
		</div>									
	</div>
	<?php
	}	 
?>	
<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">	
<input type="hidden" name="form_reg" id="form_reg" value="">
<input type="hidden" name="action" value="stripe"/>
<input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
<div class="row form-group">
	<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
	<div class="col-md-8 col-xs-8 col-sm-8 " > 
	<div id="errormessage" class="alert alert-danger mt-2 displaynone" role="alert"></div>
		<div id="loading-3" style="display: none;"><img src='<?php echo wp_iv_directories_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>											
		<button  id="submit_iv_directories_payment" name="submit_iv_directories_payment"  type="submit" class="btn btn-secondary"  >
			<?php  esc_html_e('Submit','ivdirectories');?>
		</button>		
	</div>
</div>	