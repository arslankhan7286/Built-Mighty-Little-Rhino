<?php
	global $wpdb;

	
			
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';	
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';	

if(isset($_REQUEST['delete_id']))  {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Are you cheating:user Permission?' );
	}	
	$post_id=sanitize_text_field($_REQUEST['delete_id']);
	
		$recurring= get_post_meta($post_id, 'iv_directories_package_recurring', true);
		
		if($recurring=='on'){
			$iv_gateway = get_option('iv_directories_payment_gateway');
			if($iv_gateway=='stripe'){
				
				include(wp_iv_directories_DIR . '/admin/files/init.php');
				// delete Plan ******
				
				 
				$stripe_id = ''; 
				$post_name2='iv_directories_stripe_setting';
				$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s ", $post_name2 ));
				if ( $post ){
					$stripe_id=$post;
				}	
				$post_package = get_post($post_id); 
				$p_name = $post_package->post_name;
				$stripe_mode=get_post_meta( $stripe_id,'iv_directories_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_secret_test',true);	
				}else{
					$stripe_api =get_post_meta($stripe_id, 'iv_directories_stripe_live_secret_key',true);	
				}
				$plan='';	
				\Stripe\Stripe::setApiKey($stripe_api);
				try {
					$plan = \Stripe\Plan::retrieve($p_name);
					$plan->delete();
					
				} catch (Exception $e) {
					print_r($e);
				}		
					
			}
		}							
	
	wp_delete_post($post_id);
	delete_post_meta($post_id,true);
	$message="Deleted Successfully";
	
}
if(isset($_REQUEST['form_submit']))  {
	$message="Update Successfully ";
}
  $api_currency= get_option('_iv_directories_api_currency' );

?>
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

</style>	

<script>
		 
jQuery(document).ready(function () {

   jQuery("input[type='radio']").click(function(){
		save_package_table();
   });

});
function save_package_table(){	
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var search_params = {
		"action": 			"iv_directories_update_price_table_template",
		"price-tab-style": jQuery("input[name=option-price-table]:checked").val(),	
		"_wpnonce": '<?php echo wp_create_nonce("eppackage"); ?>',
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {              		
			
			jQuery('#success_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
		}
	});
}
function iv_package_status_change(status_id,curr_status){


 status_id =status_id.trim();
 curr_status=curr_status.trim();
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var search_params = {
		"action": 	"iv_directories_update_package_status",
		"status_id": status_id,	
		"status_current":curr_status,
		"_wpnonce": '<?php echo wp_create_nonce("eppackage"); ?>',
	};	
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {   
			if(response.code=='success'){	
				jQuery("#status_"+status_id).html('<button class="btn btn-info btn-xs" onclick="return iv_package_status_change(\' '+status_id+' \' ,\' '+response.current_st+' \');">'+response.msg+'</button>');
			}
		}
	});
}	
</script>

<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">		
			<?php
				include('footer.php');
			?>
		<div class="row ">					
			<div class="col-md-12" id="submit-button-holder">					
				<div class="pull-right ">								
					
					<a class="btn btn-info "  href="<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-package-create"><?php esc_html_e( 'Create A New Package', 'ivdirectories' );?></a>
				</div>
			</div>
		</div>
		
		<div class="row">			
				<div class="col-md-12 table-responsive">
					
					<h3  class=""><?php esc_html_e( 'All Package / Membership Level', 'ivdirectories' );?>  <small></small>
						<small >
							<?php
							
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
							
							}
							if (isset($message) AND $message <> "") {
								echo  '<span style="color: #0000FF;"> [ '.$message.' ]</span>';
							}
							?>
						</small>
					</h3>
				<div class="panel panel-info">
					<div class="panel-body">
					<table class="table table-striped col-md-12">
						<thead >
							<tr>
								<th ><?php esc_html_e( 'Package Name', 'ivdirectories' );?></th>
								<th ><?php esc_html_e( 'Amount', 'ivdirectories' );?></th>
								<th><?php esc_html_e( 'Link', 'ivdirectories' );?></th>
								<th><?php esc_html_e( 'User Role', 'ivdirectories' );?></th>
								<th><?php esc_html_e( 'Status', 'ivdirectories' );?></th>
								<th ><?php esc_html_e( 'Action', 'ivdirectories' );?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$currency=$api_currency ;
							$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
									
							
							global $wpdb, $post; $i=0;
							$query = new WP_Query(array(
								'post_type' => 'iv_directories_pack',
								'posts_per_page' => -1,
							));							
							while ($query->have_posts()) {
								$query->the_post();
								$post_id = get_the_ID();
								echo'<tr>';
									echo '<td>'.esc_html( get_the_title($post_id)).'</td>';
									$amount='';
									if(get_post_meta($post_id, 'iv_directories_package_cost', true)!="" AND get_post_meta($post_id, 'iv_directories_package_cost', true)!="0"){
										$amount= get_post_meta($post_id, 'iv_directories_package_cost', true).' '.$currency;
									}else{
										$amount= '0 '.$currency;
									}
									$recurring= get_post_meta($post_id, 'iv_directories_package_recurring', true);	
									if($recurring == 'on'){
										$count_arb=get_post_meta($post_id, 'iv_directories_package_recurring_cycle_count', true); 	
										if($count_arb=="" or $count_arb=="1"){
										$recurring_text=" per ".' '.get_post_meta($post_id, 'iv_directories_package_recurring_cycle_type', true);
										}else{
										$recurring_text=' per '.$count_arb.' '.get_post_meta($post_id, 'iv_directories_package_recurring_cycle_type', true).'s';
										}
										
									}else{
										$recurring_text=' &nbsp; ';
									}
									
									$recurring= get_post_meta($post_id, 'iv_directories_package_recurring', true);	
									if($recurring == 'on'){
										$amount= get_post_meta($post_id, 'iv_directories_package_recurring_cost_initial', true).' '.$currency;
										$amount=$amount. ' / '.$recurring_text;
									}
												
												
									echo '<td>'. esc_html($amount).'</td>';	
									 $page_name_reg=get_option('_iv_directories_registration' ); 		
									echo '<td><a target="blank" href="'.get_page_link($page_name_reg).'?&package_id='.$post_id.'">'.get_page_link($page_name_reg).'?&package_id='.$post_id.' </a>			
									
									</td>';
									
									echo '<td>'. esc_html(get_the_title($post_id)).'</td>';
									
									
									?>
									<td>
									<div id="status_<?php echo esc_html($post_id); ?>">
									<?php
									
									if(get_post_status($post_id)=="draft"){										
										$pac_msg='Active';
									 }else{										
										$pac_msg='Inactive';
									 }
									?>
									<button class="btn btn-info btn-xs" onclick="return iv_package_status_change('<?php echo esc_html($post_id); ?>','<?php echo get_post_status($post_id); ?>');"><?php echo esc_html($pac_msg); ?></button>
									</div>	
										
										<?php
										echo" </td> ";
										echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-iv_directories-package-update&id='.$post_id.'"> Edit</a> <a href="?page=wp-iv_directories-package-all&delete_id='.$post_id.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this package?\');">Delete</a></td>';
										
										
										
										echo'</tr>';
										
								
							}	
							
								?>
								
							</tbody>
						</table>
						
					</div>					
					
					</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-12">					
						<div class="">								
							
							<a class="btn btn-info "  href="<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-package-create"><?php esc_html_e( 'Create A New Package', 'ivdirectories' );?></a>
														
								
						</div>
					</div>
				</div>
				<br/>
		<div class="panel panel-info">
			<div class="panel-body">
				
						<div class=" col-md-12  bs-callout bs-callout-info">		
					<?php esc_html_e( 'User role "Basic" is created on the plugin activation. Paid exprired or unsuccessful payment user will set on the "Basic" user role.', 'ivdirectories' );?>
						
					
						</div>
											
						<div class="clearfix"></div>
						<ul class=" list-group col-md-6">
								<li class="list-group-item">Short Code : <code>[iv_directories_price_table]  </code></li>
								<li class="list-group-item">PHP Code :<code>
											&lt;?php
											echo do_shortcode('[iv_directories_price_table ]');
											?&gt;</code>  
										</li>
								<li class="list-group-item">
									 
									 <?php esc_html_e( 'Package Page : ', 'ivdirectories' );?>
									<?php 
											$iv_directories_price_table=get_option('_iv_directories_price_table');
											  ?>
											<a class="btn btn-info btn-xs " href="<?php echo get_permalink( $iv_directories_price_table ); ?>" target="blank"><?php esc_html_e( 'View Page', 'ivdirectories' );?></a>
						

								</li>		
					  </ul>	
						  			
					<div class="clearfix"></div>
					<div class="  bs-callout bs-callout-info">	
						<?php esc_html_e( 'Note: You can use other available pricing table. The package link URL will go on "Sign UP " button.', 'ivdirectories' );?> 
					</div>
				
			
			</div>
		</div>			

					
			
			</div>
		
		</div>
