<?php	
wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-datepicker');

						
?>	
<script type="text/javascript"> jQuery(function() {
							jQuery( "#start_date" ).datepicker();
							jQuery( "#end_date" ).datepicker();
						});</script>					
<script>

	function iv_update_coupon() {

	
				// New Block For Ajax*****
				var search_params={
					"action"  : 	"iv_directories_update_coupon",	
					"form_data":	jQuery("#coupon_form_iv").serialize(), 
					"form_pac_ids": jQuery("#package_id").val(),
					"_wpnonce": '<?php echo wp_create_nonce("coupon"); ?>',
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						var url = "<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-coupons-form&form_submit=success";    						
						jQuery(location).attr('href',url);
						
					}
				});
				
	}

			
</script>	
<?php
global $wpdb;

$id='';	$title='';
if(isset($_REQUEST['id'])){
	$id=sanitize_text_field($_REQUEST['id']);				
}
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
			<div class="bootstrap-wrapper">
				<div class="dashboard-eplugin container-fluid">

							
					<!-- Start Form 101 -->
					<div class="row">					
						<div class="col-md-12" id="submit-button-holder">					
							<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return iv_update_coupon();"><?php esc_html_e( 'Update Coupon', 'ivdirectories' );?></button></div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-md-12"><h3 class="page-header"><?php esc_html_e( 'Update Coupon', 'ivdirectories' );?> </h3>
						
						</div>	
											
						
					</div> 
					
						
						<form id="coupon_form_iv" name="coupon_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
							
							 
							 
										
							<div class="form-group">
								<label for="text" class="col-md-2 control-label"></label>
								<div id="iv-loading"></div>
							 </div>	
							<div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Coupon Name', 'ivdirectories' );?></label>
								<div class="col-md-5">
								  <input type="text" class="form-control" name="coupon_name" id="coupon_name" value="<?php echo get_the_title($id); ?>" placeholder="Enter Coupon Name Or Coupon Code">
								</div>
							  </div>	
							   <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Discount Type', 'ivdirectories' );?></label>
								<div class="col-md-5">
									<?php
										$dis_type= get_post_meta($id, 'iv_coupon_type', true); 
									?>
									<select  name="coupon_type" id ="coupon_type" class="form-control">
										<option value="amount" 		<?php echo ($dis_type=='amount' ? 'selected' : '' ); ?> ><?php esc_html_e( 'Fixed Amount', 'ivdirectories' );?></option>
										<option value="percentage"  <?php echo ($dis_type=='percentage' ? 'selected' : '' ); ?> ><?php esc_html_e( 'Percentage', 'ivdirectories' );?></option>
									
									</select>
								
								</div>
							 </div> 
							  	
							 <div class="form-group">
								<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Package Only', 'ivdirectories' );?></label>
								<div class="col-md-5">
								
									<?php
									$query = new WP_Query(array(
										'post_type' => 'iv_directories_pack',
										'posts_per_page' => -1,
									));
									 $current_pac=get_post_meta($id, 'iv_coupon_pac_id', true);							
									$current_pac_arr=explode(",",$current_pac);
							
									echo'<select multiple name="package_id" id ="package_id" class="form-control">';
									while ($query->have_posts()) {
											$query->the_post();
											 $post_id = get_the_ID();
											$recurring= get_post_meta( $post_id,'iv_directories_package_recurring',true);
											$pac_cost= get_post_meta( $post_id,'iv_directories_package_cost',true);
											if($recurring!='on' and $pac_cost!="" ){										
												echo '<option value="'. $post_id.'"'. (in_array( $post_id, $current_pac_arr) ? 'selected' : '').' >'. get_the_title().'</option>';
											}							
									}
									echo '</select>';
								?>
								</div>
							  </div> 
							 
							  <div class="form-group">
								<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Usage Limit', 'ivdirectories' );?></label>
								<div class="col-md-5">
								  <input type="text" class="form-control" id="coupon_count" name="coupon_count" value="<?php echo get_post_meta($id, 'iv_coupon_limit', true); ?>"  placeholder="Enter Usage Limit Number">
								</div>
							  </div>
							
							 
							<div class="form-group" >									
										<label for="text" class="col-md-2 control-label"><?php esc_html_e( 'Start Date', 'ivdirectories' );?></label>
										<div class="col-md-5">
											<input type="text"  readonly name="start_date"   id="start_date" class="form-control ctrl-textbox"  placeholder="Select Date" value="<?php echo get_post_meta($id, 'iv_coupon_start_date', true); ?>">

										</div>
									</div>							  
							    <div class="form-group">
								<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Expire Date', 'ivdirectories' );?></label>
								<div class="col-md-5">
								  <input type="text" class="form-control" readonly id="end_date" name="end_date" value="<?php echo get_post_meta($id, 'iv_coupon_end_date', true); ?>"  placeholder="Select Datee">
								</div>
							  </div>
							  <div class="form-group">
								<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e( 'Amount', 'ivdirectories' );?></label>
								<div class="col-md-5">
								  <input type="text" class="form-control" id="coupon_amount" name="coupon_amount" value="<?php echo get_post_meta($id, 'iv_coupon_amount', true); ?>"  placeholder=" Coupon Amount [ Only Amount no Currency ]">
								</div>
							  </div>
							
							<input type="hidden"  id="coupon_id" name="coupon_id" value="<?php echo esc_html($id); ?>"  >
							
						</form>
						<div class=" col-md-7  bs-callout bs-callout-info">		
					<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and 100% discount will not support.', 'ivdirectories' );?>
													
						</div>
						<div class="row">					
							<div class="col-xs-12">					
								<div align="center">
									<button class="btn btn-info btn-lg" onclick="return iv_update_coupon();"><?php esc_html_e( 'Update Coupon', 'ivdirectories' );?></button></div>
									<p>&nbsp;</p>
								</div>
							</div>
						</div>						
				</div>