<?php

global $wpdb;
	$newpost_id='';
	$post_name='iv_directories_paypal_setting';		
	$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name ));
	if ( $post ){
		$newpost_id=$post;
	}
			  
	$paypal_mode=get_post_meta( $newpost_id,'iv_directories_paypal_mode',true);
	
	$newpost_id='';	
	$post_name='iv_directories_stripe_setting';	
	$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name ));
	if ( $post ){
		$newpost_id=$post;
	}					
				
	$stripe_mode=get_post_meta( $newpost_id,'iv_directories_stripe_mode',true);				
				
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		
		<div class="row">
			<div class="col-md-12">				
				<h3 class="page-header" ><?php esc_html_e( 'Payment Gateways', 'ivdirectories' );?> </h3>				
				<div class="col-md-12" id="update_message">
				</div>				
			</div>
		</div>
		
		
			<div class="row">
			<div class="col-md-12">
						<div id="update_message"> </div>
					<table class="table">
					  <thead>
						<tr>
						  <th>#</th>
						  <th><?php esc_html_e( 'Gateways Name', 'ivdirectories' );?></th>
						  <th><?php esc_html_e( 'Mode', 'ivdirectories' );?></th>
						  <th><?php esc_html_e( 'Status', 'ivdirectories' );?></th>
						  <th><?php esc_html_e( 'Action', 'ivdirectories' );?></th>
						</tr>
					  </thead>
					  <tbody>
						<tr>
						  <td>1</td>
						  <td> <label>
							<input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('iv_directories_payment_gateway')=='paypal-express')? 'checked':'' ?> value="paypal-express">
									<?php esc_html_e( 'Paypal', 'ivdirectories' );?>
						  </label>
						  </td>
						  <td><?php echo strtoupper($paypal_mode); ?></td>
						  <td><?php echo (get_option('iv_directories_payment_gateway')=='paypal-express')? 'Active':'Inactive' ?> </td>
						   <td><a class="btn btn-primary btn-xs" href="?page=wp-iv_directories-payment-paypal"><?php esc_html_e( 'Edit Setting', 'ivdirectories' );?> </a></td>
						</tr>
						<tr>
						  <td>2</td>
						  <td>
						   <label>
						  <input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('iv_directories_payment_gateway')=='stripe')? 'checked':'' ?>  value="stripe">
									<?php esc_html_e( 'Stripe', 'ivdirectories' );?>
						  </label> </td>
						  <td><?php  echo strtoupper(get_post_meta( $newpost_id,'iv_directories_stripe_mode',true)); ?></td>
						  <td><?php echo (get_option('iv_directories_payment_gateway')=='stripe')? 'Active':'Inactive' ?></td>
						  <td> <a class="btn btn-primary btn-xs" href="?page=wp-iv_directories-payment-stripe"> <?php esc_html_e( 'Edit Setting', 'ivdirectories' );?></a> </td>
						</tr>
						<?php
						if ( class_exists( 'WooCommerce' ) ) {
						?>
						<tr>
						  <td>3</td>
						  <td><input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('iv_directories_payment_gateway')=='woocommerce')? 'checked':'' ?>  value="woocommerce">
								<?php esc_html_e( 'WooCommerce[You need to select the payment gateway from woocommerce settings]', 'ivdirectories' );?>	
						  </label> </td>
						  <td></td>
						  <td><?php echo (get_option('iv_directories_payment_gateway')=='woocommerce')? 'Active':'Inactive' ?></td>
						  <td>  </td>
						</tr>
						<?php
							}
						?>
					  </tbody>
					</table>
			
		</div>
				
			
		</div>
		<?php
				include('footer.php');
			?>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function () {

		   jQuery("input[type='radio']").click(function(){
				iv_update_email_settings();
		   });

		});
	
function  iv_update_email_settings (){
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		
		var search_params = {
			"action": "iv_directories_gateway_settings_update",
			"payment_gateway": jQuery("input[name=payment_gateway]:checked").val(),	
			"_wpnonce": '<?php echo wp_create_nonce("eppayment"); ?>',
			
		};
		jQuery.ajax({
			url: ajaxurl,
			dataType: "json",
			type: "post",
			data: search_params,
			success: function(response) { 
				jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						             		
			
			}
		});
}
</script>
