<?php
	global $wpdb;
	$current_user = wp_get_current_user();
	// Check Express Checkout Here
	// IF IF*********
	$userId=$current_user->ID;
?>
<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"><?php  esc_html_e('Membership Level','ivdirectories')	;?>	 </span>
			</div>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_current" data-toggle="tab"><?php  esc_html_e('Current','ivdirectories')	;?></a>
				</li>
				<li class="">
					<a href="#tab_upgrade" data-toggle="tab"><?php  esc_html_e('Upgrade','ivdirectories')	;?></a>
				</li>
				<?php
					$package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
					$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
					if($recurring == 'on'){ ?>
					<li>
						<a href="#tab_cancel" data-toggle="tab"><?php  esc_html_e('Cancel','ivdirectories')	;?></a>
					</li>
					<?php
					}
				?>
			</ul>
		</div>
		<div class="portlet-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_current">
					<?php
						global $wpdb, $post;
						$iv_gateway = get_option('iv_directories_payment_gateway');
						$sql="SELECT * FROM $wpdb->posts WHERE post_type = 'iv_directories_pack'  and post_status='draft' ";
						$membership_pack = $wpdb->get_results($sql);
						$total_package=count($membership_pack);
						 $package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
						$iv_pac=$package_id;
						$user = new WP_User( $current_user->ID );
						$current_user_role='';
						if(isset($user->roles[0])){
							$current_user_role=strtolower($user->roles[0]);
						}
					?>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td  style="font-size:14px;width:60%">
									<?php  esc_html_e('Current Package','ivdirectories');
										
										?>
								</td>
								<td  style="font-size:14px;width:40%">
									<?php
										if($package_id!=""){
											$post_p = get_post($package_id);
											if(!empty($post_p)){
												if($current_user_role!='basic'){
													echo ($post_p->post_title!="" ? $post_p->post_title: 'None');
												}
												}else{
												esc_html_e('None','ivdirectories');
											}
											}else{
											esc_html_e('None','ivdirectories');
										}
									?>
								</td>
							</tr>
							<tr>
								<td width="60%" style="font-size:14px">
									<?php  esc_html_e('Package Amount','ivdirectories')	;?>
								</td>
								<td width="40%" style="font-size:14px">
									<?php	$currencyCode= get_option('_iv_directories_api_currency');
										$iv_gateway = get_option('iv_directories_payment_gateway');
										if($iv_gateway=='woocommerce'){
											if ( class_exists( 'WooCommerce' ) ) {
												$api_currency= get_option( 'woocommerce_currency' );
												$currencyCode= get_woocommerce_currency_symbol( $api_currency );
											}
										}
										$recurring_text='  '; $amount= '';
										if($current_user_role!='basic'){
											if(get_post_meta($package_id, 'iv_directories_package_cost', true)=='0' or get_post_meta($package_id, 'iv_directories_package_cost', true)==""){
												$amount= esc_html__('Free','ivdirectories');
												}else{
												$amount= $currencyCode.' '. get_post_meta($package_id, 'iv_directories_package_cost', true);
											}
										}
										$recurring= get_post_meta($package_id, 'iv_directories_package_recurring', true);
										if($recurring == 'on'){
											$amount= $currencyCode.' '. get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);
											$count_arb=get_post_meta($package_id, 'iv_directories_package_recurring_cycle_count', true);
											if($count_arb=="" or $count_arb=="1"){
												$recurring_text=" per ".' '.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_type', true);
												}else{
												$recurring_text=' per '.$count_arb.' '.get_post_meta($package_id, 'iv_directories_package_recurring_cycle_type', true).'s';
											}
											}else{
												$recurring_text=' &nbsp; ';
										}
										echo esc_html($amount);
									?>
								</td>
							</tr>
							<tr>
								<td width="60%" style="font-size:14px">
									<?php  esc_html_e('Package Type','ivdirectories')	;?>
								</td>
								<td width="40%" style="font-size:14px">
									<?php
										if($current_user_role!='basic'){
											echo esc_html($amount).' '.esc_html($recurring_text);
										}
									?>
								</td>
							</tr>
							<tr>
								<td width="60%" style="font-size:14px">
									<?php  esc_html_e('Payment Status','ivdirectories')	;?>
								</td>
								<td width="40%" style="font-size:14px">
									<?php
										$status_result=0;
										$payment_status= get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
										$payment_gateway = get_option('iv_directories_payment_gateway');
										$package_product_id= get_post_meta( $package_id,'iv_directories_package_woocommerce_product',true);
										if($payment_gateway=='woocommerce'){
											if ( class_exists( 'WC_Subscriptions' ) ) {
												//for WC_Subscriptions::get_my_subscriptions_template();
												$subscriptions = wcs_get_users_subscriptions();
												$user_id       = get_current_user_id();
												foreach ( $subscriptions as $subscription_id => $subscription ) {
													$payment_status=  esc_attr( wcs_get_subscription_status_name( $subscription->get_status() ) );
													$status_result=1;
												}
											}
											if($status_result==0){
												$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');
												$user_id=$current_user->ID;
												$customer_orders = get_posts( array(
												'meta_key'    => '_customer_user',
												'meta_value'  => $user_id,
												'post_type'   => 'shop_order',
												'post_status' => $order_statuses,
												'numberposts' => -1
												));
												$got_status='';
												foreach($customer_orders as $customer_order){
													$order = wc_get_order($customer_order->ID);
													$order_stat = new WC_Order( $customer_order->ID );
													foreach($order->get_items() as $item_id => $item_values){
														$product_id = $item_values['product_id'];
														if($product_id==$package_product_id){
															if($order_stat->has_status( 'completed' )){
																$payment_status= esc_html__('Completed','ivdirectories')	;
															}
															else{
																$payment_status=esc_html__('Processing','ivdirectories')	;
															}
															$got_status='1';
															break;
														}
													}
													if($got_status=='1'){
														break;
													}
												}
											}
											}else{
											$payment_status= get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
										}
										echo ucfirst(esc_html__($payment_status,'ivdirectories'));
									?>
								</td>
							</tr>
							<tr>
								<td style="font-size:14px;width:60%" >
									<?php  esc_html_e('User Role','ivdirectories')	;?>
								</td>
								<td style="font-size:14px;width:40%">
									<?php
										$user = new WP_User( $current_user->ID );
										if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
											foreach ( $user->roles as $role )
											echo ucfirst(esc_html__($role,'ivdirectories' ));
										}
									?>
								</td>
							</tr>
							<?php
								if(get_user_meta($current_user->ID, 'iv_directories_payment_status', true)=='cancel'){
								?>
								<tr>
									<td width="60%" style="font-size:14px">
										<?php  esc_html_e('Exprie Date','ivdirectories');?>
									</td>
									<td width="40%" style="font-size:14px">
										<?php
											if($recurring == 'on'){
												$exp_date= get_user_meta($current_user->ID, 'iv_directories_exprie_date', true);
												echo date('d-M-Y',strtotime($exp_date));
												}else{
												$exp_date= get_user_meta($current_user->ID, 'iv_directories_exprie_date', true);
												echo date('d-M-Y',strtotime($exp_date));
											}
										?>
									</td>
								</tr>
								<?php
									}else{
								?>
								<tr>
									<td width="60%" style="font-size:14px">
										<?php  esc_html_e('Next Payment Date','ivdirectories')	;?>
									</td>
									<td width="40%" style="font-size:14px">
										<?php
											if($current_user_role!='basic'){
												if($recurring == 'on'){
													$exp_date= get_user_meta($current_user->ID, 'iv_directories_exprie_date', true);
													echo ($exp_date!=""? date('d-M-Y',strtotime($exp_date)):'');
													}else{
													$exp_date= get_user_meta($current_user->ID, 'iv_directories_exprie_date', true);
													echo ($exp_date!=""? date('d-M-Y',strtotime($exp_date)):'');
												}
											}
										?>
									</td>
								</tr>
								<?php
								}
							?>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab_upgrade">
					<?php
						if($iv_gateway=='woocommerce'){
						?>
						<form class="form-group"  name="profile_upgrade_form" id="profile_upgrade_form" action="<?php  the_permalink() ?>?&payment_gateway=woocommerce&iv-submit-upgrade=upgrade" method="post">
							<div class=" row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Package Name','ivdirectories')	;
									
									
									?></label>
								<div class="col-md-8 col-xs-8 col-sm-8 ">
									<?php
										$iv_directories_pack='iv_directories_pack';
										$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft'",$iv_directories_pack);
										$membership_pack = $wpdb->get_results($sql);
										$total_package=count($membership_pack);
										if(sizeof($membership_pack)>0){
											$i=0; $current_package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
											echo'<select name="package_sel" id ="package_sel" class=" form-control">';
											foreach ( $membership_pack as $row )
											{
												if($current_package_id==$row->ID){
													echo '<option value="'. $row->ID.'" >'. $row->post_title.' [Your Current Package]</option>';
													}else{
													echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
												}
												if($i==0){
													$package_id=$row->ID;
													if(get_post_meta($row->ID, 'iv_directories_package_recurring',true)=='on'){
														$amount=get_post_meta($row->ID, 'iv_directories_package_recurring_cost_initial', true);
														}else{
														$amount=get_post_meta($row->ID, 'iv_directories_package_cost',true);
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
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Amount','ivdirectories')	;?></label>
								<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount">
									<?php  echo esc_html($amount).' '.esc_html($recurring_text); ?>
								</div>
							</div>
							<div class="row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
								<div class="col-md-8 col-xs-8 col-sm-8 " > 	<div id="loading"> </div>
									<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">
									<input type="hidden" name="coupon_code" id="coupon_code" value="">
									<button class="btn green-haze" type="submit"> <?php  esc_html_e('Upgrade','ivdirectories')	;?></button>
									<input type="hidden" name="return_page" id="return_page" value="<?php  the_permalink() ?>">
								</div>
							</div>
						</form>
						<?php
						}
						if($iv_gateway=='paypal-express'){
						?>
						<form class="form-group"  name="profile_upgrade_form" id="profile_upgrade_form" action="<?php  the_permalink() ?>?&payment_gateway=paypal&iv-submit-upgrade=upgrade" method="post">
							<div class=" row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Package Name','ivdirectories')	;?></label>
								<div class="col-md-8 col-xs-8 col-sm-8 ">
									<?php
										$sql="SELECT * FROM $wpdb->posts WHERE post_type = 'iv_directories_pack'  and post_status='draft'";
										$membership_pack = $wpdb->get_results($sql);
										$total_package=count($membership_pack);
										if(sizeof($membership_pack)>0){
											$i=0; $current_package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
											echo'<select name="package_sel" id ="package_sel" class=" form-control">';
											foreach ( $membership_pack as $row )
											{
												if($current_package_id==$row->ID){
													echo '<option value="'. $row->ID.'" >'. $row->post_title.' [Your Current Package]</option>';
													}else{
													echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
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
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php  esc_html_e('Amount','ivdirectories')	;?></label>
								<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount">
									<?php  echo esc_html($package_amount).' '.esc_html($recurring_text); ?>
								</div>
							</div>
							<div class="row form-group">
								<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
								<div class="col-md-8 col-xs-8 col-sm-8 " > 	<div id="loading"> </div>
									<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">
									<input type="hidden" name="coupon_code" id="coupon_code" value="">
									<button class="btn green-haze" type="submit"> <?php  esc_html_e('Upgrade','ivdirectories')	;?></button>
									<input type="hidden" name="return_page" id="return_page" value="<?php  the_permalink() ?>">
								</div>
							</div>
						</form>
						<?php
						}
						if($iv_gateway=='stripe'){ ?>
						<form class="form"  name="profile_upgrade_form" id="profile_upgrade_form" action="" method="post">
							<?php
								include(wp_iv_directories_template.'private-profile/iv_stripe_form_upgrade.php');
								$arb_status =	get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
								$cust_id = get_user_meta($current_user->ID,'iv_directories_stripe_cust_id',true);
								$sub_id = get_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id',true);
							?>
							<input type="hidden" name="cust_id" value="<?php echo esc_html($cust_id); ?>">
							<input type="hidden" name="sub_id" value="<?php echo esc_html($sub_id); ?>">
						</form>
						<?php
						}
					?>
					<div class=" row bs-callout bs-callout-info">
						<?php  esc_html_e('Note: User Role will change after update.','ivdirectories')	;?>
					</div>
				</div>
				<div class="tab-pane" id="tab_cancel">
					<?php
						$payment_gateway=get_user_meta($current_user->ID, 'iv_directories_payment_gateway', true);
						if($payment_gateway=='paypal-express'){
							$arb_status =	get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
							$profile_id = get_user_meta($current_user->ID,'iv_paypal_recurring_profile_id',true);
							if($arb_status!='cancel'  && $profile_id!='' ){											?>
							<div class="" id="update_message_paypal"></div>
							<div id="paypal_cancel_div" name="paypal_cancel_div">
								<form class="form" role="form"  name="paypal_cancel_form" id="paypal_cancel_form" action="" method="post">
									<input type="hidden" name="profile_id" value="<?php echo esc_html($profile_id); ?>">
									<div class="form-group">
										<label class="control-label"><?php  esc_html_e('Cancel Reason','ivdirectories')	;?></label>
										<textarea class="form-control" name="cancel_text" id="cancel_text" rows="3" placeholder="<?php  esc_html_e('Canceling Reason','ivdirectories')	;?>"  ></textarea>
									</div>
									<div class="margiv-top-10">
										<div class="" id="update_message"></div>
										<button type="button"   class="btn green-haze" onclick="return iv_cancel_membership_paypal();"><?php  esc_html_e('Cancel Membership','ivdirectories')	;?></button>
									</div>
								</form>
							</div>
							<?php
							}else{ ?>
							<div class="form-group">
								<label class="control-label"><?php  esc_html_e('Nothing to Cancel','ivdirectories')	;?></label>
							</div>
							<?php
							}
						}
						if($payment_gateway=='stripe'){
							$arb_status =	get_user_meta($current_user->ID, 'iv_directories_payment_status', true);
							$cust_id = get_user_meta($current_user->ID,'iv_directories_stripe_cust_id',true);
							$sub_id = get_user_meta($current_user->ID,'iv_directories_stripe_subscrip_id',true);
							if($arb_status!='cancel'  && $sub_id!='' ){										?>
							<div class="" id="update_message_stripe"></div>
							<div id="stripe_cancel_div" name="stripe_cancel_div">
								<form class="form" role="form"  name="profile_cancel_form" id="profile_cancel_form" action="<?php  the_permalink() ?>" method="post">
									<input type="hidden" name="cust_id" value="<?php echo esc_html($cust_id); ?>">
									<input type="hidden" name="sub_id" value="<?php echo esc_html($sub_id); ?>">
									<div class="form-group">

										<textarea class="form-control" name="cancel_text" id="cancel_text" rows="3" placeholder="<?php  esc_html_e('Canceling Reason','ivdirectories')	;?>"  ></textarea>
									</div>
									<div class="margiv-top-10">
										<button type="button"   class="btn green-haze" onclick="return iv_cancel_membership_stripe();"><?php  esc_html_e('Cancel Membership','ivdirectories')	;?></button>
									</div>
								</form>
							</div>
							<?php
							}else{ ?>
							<div class="form-group">
								<label class="control-label"><?php  esc_html_e('Nothing to Cancel','ivdirectories')	;?>.</label>
							</div>
							<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PROFILE CONTENT -->
