<?php	
	global $wpdb;
	if( ! class_exists('Paypal' ) ) {
		include(wp_iv_directories_DIR . '/inc/class-paypal.php');
	}
	$post_name='iv_directories_paypal_setting';						
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = %s",$post_name) );
	$paypal_id='0';
	if($row==''){$row=array();}
	if(isset($row->ID)){
		$paypal_id= $row->ID;
	}							
	$paypal_api_currency=get_post_meta($paypal_id, 'iv_directories_paypal_api_currency', true);
	$paypal_username=get_post_meta($paypal_id, 'iv_directories_paypal_username',true);
	$paypal_api_password=get_post_meta($paypal_id, 'iv_directories_paypal_api_password', true);
	$paypal_api_signature=get_post_meta($paypal_id, 'iv_directories_paypal_api_signature', true);
	$credentials = array();
	$credentials['USER'] = (isset($paypal_username)) ? $paypal_username : '';
	$credentials['PWD'] = (isset($paypal_api_password)) ? $paypal_api_password : '';
	$credentials['SIGNATURE'] = (isset($paypal_api_signature)) ? $paypal_api_signature : '';
	$paypal_mode=get_post_meta($paypal_id, 'iv_directories_paypal_mode', true);
	$currencyCode = $paypal_api_currency;
	$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
	$sandboxBool = (!empty($sandbox)) ? true : false;
	$paypal = new Paypal($credentials,$sandboxBool);
	if( isset($_REQUEST['iv-submit-listing']) && isset($_REQUEST['payment_gateway']) && $_REQUEST['iv-submit-listing']=='register' && $_REQUEST['payment_gateway']=='paypal' ){	
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup1' ) ) {
			wp_die( 'Are you cheating:wpnonce1?' );
		}
		$package_id='';
		$package_id=sanitize_text_field($_POST['package_id']);
		//create user here******	
		$return_page_url= $_POST['return_page'];
		$userdata = array();
		$user_name='';
		if(isset($_POST['iv_member_user_name'])){
			$userdata['user_login']=sanitize_text_field($_POST['iv_member_user_name']);
		}					
		if(isset($_POST['iv_member_email'])){
			$userdata['user_email']=sanitize_email($_POST['iv_member_email']);
		}					
		if(isset($_POST['iv_member_password'])){
			$userdata['user_pass']=sanitize_text_field($_POST['iv_member_password']);
		}
		if($userdata['user_login']!='' and $userdata['user_email']!='' and $userdata['user_pass']!='' ){
			$user_id = username_exists( $userdata['user_login'] );
			if ( !$user_id and email_exists($userdata['user_email']) == false ) {							
				$user_id = wp_insert_user( $userdata ) ;
				$user = new WP_User( $user_id );
				$user->set_role('basic');
				$userId=$user_id;
				$expire_interval = get_post_meta($package_id, 'iv_directories_package_initial_expire_interval', true);						
				$initial_expire_type = get_post_meta($package_id, 'iv_directories_package_initial_expire_type', true);
				if($expire_interval!='' AND $initial_expire_type!=''){
					$exp_periodNum = (60 * 60 * 24 * 90);
					switch ($initial_expire_type) {
						case 'year':
						$exp_periodNum = (60 * 60 * 24 * 365) * $expire_interval;
						break;
						case 'month':
						$exp_periodNum = (60 * 60 * 24 * 30) * $expire_interval;
						break;
						case 'week':
						$exp_periodNum = (60 * 60 * 24 * 7) * $expire_interval;
						break;
						case 'day':
						$exp_periodNum = (60 * 60 * 24) * $expire_interval;
						break;
					}
					$exp_time = time() + $exp_periodNum;
					$exp_d = date('Y-m-d',$exp_time).'T'.'00:00:00Z';
					}else{
					$exp_d=date('Y-m-d', strtotime('+10 year'));
				} 							  
				update_user_meta($user_id, 'iv_directories_exprie_date',$exp_d); 
				update_user_meta($user_id, 'iv_directories_package_id',$package_id);
				include( wp_iv_directories_ABSPATH. 'inc/signup-mail.php');
				} else {
				$iv_redirect = get_option( '_iv_directories_registration');
				if(trim($iv_redirect)!=''){
					$reg_page= get_permalink( $iv_redirect).'?&package_id='.$package_id.'&message-error=User_or_Email_Exists'; 
					wp_redirect( $reg_page );
					exit;
				}	
			}
		}		
		if($userdata['user_login']=='' or $userdata['user_email']=='' or $userdata['user_pass']=='' ){
			$iv_redirect = get_option( '_iv_directories_registration');
			if(trim($iv_redirect)!=''){
				$reg_page= get_permalink( $iv_redirect).'?&package_id='.$package_id.'&message-error=exists'; 
				wp_redirect( $reg_page );
				exit;
			}	
		}	
		//create user End******
		$row2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE id =%s",$package_id ));
		$package_name='';
		if(isset($row2->post_title)){
			$package_name= $row2->post_title;
		}
		$iv_directories_package_cost= get_post_meta( $package_id,'iv_directories_package_cost',true);
		$iv_directories_package_recurring= get_post_meta( $package_id,'iv_directories_package_recurring',true);
		$package_cost=$iv_directories_package_cost;
		// Cheek here Coupon ************
		$trial_enable= get_post_meta( $package_id,'iv_directories_package_enable_trial_period',true);
		if( $iv_directories_package_recurring=='on'  ){
			$package_cost=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);			
		}
		if($package_cost >0){
			$currencyCode = (isset($paypal_api_currency)) ? $paypal_api_currency : 'USD';
			$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
			$paymentName = $package_name;
			$paymentDescription = $iv_directories_package_cost.' '.$currencyCode.' for '.$package_name .' at '. get_bloginfo();
			$page_name_registration=get_option('_iv_directories_registration' ); 
			$returnUrl = $return_page_url."?&paypal-thanks=success&payment_gateway=paypal&package_id=".$package_id.'&user_id='.$user_id;
			$cancelUrl = $return_page_url."?&paypal-cancel=cancel&payment_gateway=paypal&package_id=".$package_id.'&user_id='.$user_id;
			$urlParams = array(
			'RETURNURL' => $returnUrl,
			'CANCELURL' => $cancelUrl
			);
			$recurringDescriptionFull='';
			if($iv_directories_package_recurring=='on'){
				$period= get_post_meta( $package_id,'iv_directories_package_recurring_cycle_type',true);
				$recurringDescriptionFull= $package_cost.' '.$currencyCode.' for '.$package_name .' at '. get_bloginfo();
				$recurring = array(
				'L_BILLINGTYPE0' => 'RecurringPayments',
				'L_BILLINGAGREEMENTDESCRIPTION0' => $recurringDescriptionFull
				);
				$params = $urlParams + $recurring;
				}else{ // Not recurring Start									
				// CouponStart ******************************										
				$coupon_code=sanitize_text_field($_POST['coupon_name']);
				$dis_amount=0;
				$package_amount=$iv_directories_package_cost;
				$post_count = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = %s and  post_type='iv_coupon'",$coupon_code ));	
				if(isset($post_count->post_title)){
					$coupon_name = $post_count->post_title;							 
					$current_date=$today = date("m/d/Y");							 
					$start_date=get_post_meta($post_count->ID, 'iv_coupon_start_date', true);
					$end_date=get_post_meta($post_count->ID, 'iv_coupon_end_date', true);
					$coupon_used=get_post_meta($post_count->ID, 'iv_coupon_used', true);
					$coupon_limit=get_post_meta($post_count->ID, 'iv_coupon_limit', true);
					$dis_amount=get_post_meta($post_count->ID, 'iv_coupon_amount', true);							 
					$package_ids =get_post_meta($post_count->ID, 'iv_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);							 
					if(in_array('0', $all_pac_arr)){
						$pac_found=1;
						}else{
						if(in_array($package_id, $all_pac_arr)){
							$pac_found=1;
							}else{
							$pac_found=0;
						}
					}
					$trial_enable = get_post_meta( $package_id,'iv_directories_package_enable_trial_period',true); 
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found == '1' ){	
						$coupon_type= get_post_meta($post_count->ID, 'iv_coupon_type', true);
						update_post_meta($post_count->ID, 'iv_coupon_used', $coupon_used+1);
						if($coupon_type=='percentage'){
							$dis_amount= $dis_amount * $package_amount/100;										
						}
						}else{
						$dis_amount=0;
					}
					}else{
					$dis_amount=0;
				}
				update_user_meta($userId, 'iv_directories_discount',$dis_amount);
				// Coupon End *****************************
				$iv_directories_package_cost = $iv_directories_package_cost- $dis_amount;
				$orderParams = array(
				'PAYMENTREQUEST_0_AMT' => $iv_directories_package_cost,
				'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
				'PAYMENTREQUEST_0_CURRENCYCODE' => $currencyCode,
				'PAYMENTREQUEST_0_ITEMAMT' => $iv_directories_package_cost
				);
				$itemParams = array(
				'L_PAYMENTREQUEST_0_NAME0' => $paymentName,
				'L_PAYMENTREQUEST_0_DESC0' => $paymentDescription,
				'L_PAYMENTREQUEST_0_AMT0' =>  $iv_directories_package_cost,
				'L_PAYMENTREQUEST_0_QTY0' => '1'
				);
				$params = $urlParams + $orderParams + $itemParams;
			} // Not recurring  End // One time payment
			$response = $paypal -> request('SetExpressCheckout',$params);
			$errors = new WP_Error();
			if(!$response){
				$errorMessage = 'ERROR: Check paypal API settings!';
				$errors->add( 'bad_paypal_api', $errorMessage . ' ' . $paypal->getErrors() );
				$register_error_string = $errors;
			}
			$token="";
			if(is_array($response) && $response['ACK'] == 'Success') {
				$token = $response['TOKEN'];					
				$userId=$user_id;
				update_user_meta($userId, 'iv_paypal_token', $token);
				$peried=get_post_meta( $package_id,'iv_directories_package_recurring_cycle_type',true);
				$cycle_count=get_post_meta( $package_id,'iv_directories_package_recurring_cycle_count',true);
				update_user_meta($userId, 'iv_paypal_recurring_profile_amt', get_post_meta( $package_id,'iv_directories_package_recurring_cost_initial',true));
				update_user_meta($userId, 'iv_directories_payment_gateway','paypal-express'); 
				update_user_meta($userId, 'iv_paypal_recurring_profile_init_amt',get_post_meta( $package_id,'iv_directories_package_cost',true));
				update_user_meta($userId, 'iv_paypal_recurring_profile_period',$peried);	
				update_user_meta($userId, 'iv_paypal_recurring_cycle_count',$cycle_count);
				update_user_meta($userId, 'iv_directories_discount',$dis_amount);
				update_user_meta($userId, 'iv_directories_package_id',$package_id);							
				update_user_meta($userId, 'iv_paypal_recurring_profile_desc',$recurringDescriptionFull);
				}else{
				die('User has created. But '.$response['L_LONGMESSAGE0']);
			}	
			wp_redirect( 'https://www.'.$sandbox.'paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) ); 
			exit; 
			}else{ 
			// for $package_cost ==0 
			//set Role Forr Free Package*******
			if(isset($userId)){
				$user = new WP_User( $userId );
				$role_package= get_post_meta( $package_id,'iv_directories_package_user_role',true); 
				if($role_package==""){
					$role_package='basic';
				}
				if(strtolower(trim($role_package))!='administrator'){
					$user->set_role($role_package);
				}
				update_user_meta($userId, 'iv_directories_package_id',$package_id);
				// success Page
				$iv_redirect = get_option( '_iv_directories_profile_page');
				if(trim($iv_redirect)!=''){
					$reg_page= get_permalink( $iv_redirect); 
					wp_clear_auth_cookie();
					wp_set_current_user ( $user->ID );
					wp_set_auth_cookie  ( $user->ID );
					wp_safe_redirect( $reg_page );					
					exit;
				}
			}			
		}
	}
	if(isset($_GET['paypal-thanks']) && ($_GET['paypal-thanks'] == 'success') && !empty($_GET['token'])) {	
		global $wpdb, $registerErrors, $registerMessages;
		$token = sanitize_text_field($_REQUEST['token']);
		$tokenRow = $wpdb->get_row($wpdb->prepare( "SELECT * FROM $wpdb->usermeta WHERE meta_value =%s", $token));
		if($tokenRow){
			$userId = $tokenRow->user_id;			
			$checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => sanitize_text_field($_GET['token'])));
			if( is_array($checkoutDetails) && ($checkoutDetails['ACK'] == 'Success') ) {
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				$iv_directories_package_recurring= get_post_meta( $package_id,'iv_directories_package_recurring',true);
				// The payment is recurring
				if($iv_directories_package_recurring=='on'){
					// Cancel old profile
					$fee_wiil_add=0;
					$oldProfile = get_user_meta($userId,'iv_paypal_recurring_profile_id',true);
					if (!empty($oldProfile)) {
						$cancelParams = array(
						'PROFILEID' => $oldProfile,
						'ACTION' => 'Cancel'
						);
						$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
						$fee_wiil_add=1;
					}
					$package_id=sanitize_text_field($_REQUEST['package_id']);
					$package_info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE id =%s",$package_id ));
					$package_name='';
					if(isset($package_info->post_title)){
						$package_name= $package_info->post_title;
					}
					$iv_directories_package_cost= get_post_meta( $package_id,'iv_directories_package_cost',true);
					$iv_directories_package_recurring= get_post_meta( $package_id,'iv_directories_package_recurring',true);
					$currencyCode = (isset($paypal_api_currency)) ? $paypal_api_currency : 'USD';
					$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
					$paymentName = $package_name;
					$paymentDescription ='Description:'.$package_name;
					$initAmt = get_user_meta($userId,'iv_paypal_recurring_profile_init_amt',true);
					$amt = get_user_meta($userId,'iv_paypal_recurring_profile_amt',true);				
					$description = get_user_meta($userId,'iv_paypal_recurring_profile_desc',true);				
					$period = get_user_meta($userId,'iv_paypal_recurring_profile_period',true);	
					$subscription_type= get_user_meta($userId, 'iv_subscription_type',true); 
					$recurring_cycle_count=	get_post_meta($package_id,'iv_directories_package_recurring_cycle_count',true);
					if($recurring_cycle_count=="" || $recurring_cycle_count=="0"){
						$recurring_cycle_count='1';
					}
					$trial_enable= get_post_meta( $package_id,'iv_directories_package_enable_trial_period',true);
					if( $trial_enable=='yes'  ){
						$initAmt='0';
						$period = get_post_meta( $package_id,'iv_directories_package_recurring_trial_type',true);						
						$recurring_cycle_count=	get_post_meta( $package_id,'iv_directories_package_trial_period_interval',true);	
					}	
					$one_time_activeation_fee=0;
					$fee=0;	
					$periodNum = (60 * 60 * 24 * 365);
					switch ($period) {
						case 'year':
						$periodNum = (60 * 60 * 24 * 365) * $recurring_cycle_count;
						break;
						case 'month':
						$periodNum = (60 * 60 * 24 * 30) * $recurring_cycle_count;
						break;
						case 'week':
						$periodNum = (60 * 60 * 24 * 7) * $recurring_cycle_count;
						break;
						case 'day':
						$periodNum = (60 * 60 * 24) * $recurring_cycle_count;
						break;
					}
					$timeToBegin = time() + $periodNum;
					$begins = date('Y-m-d',$timeToBegin).'T'.'00:00:00Z';
					$discount='0';
					// For Trial again $period
					$period = get_user_meta($userId,'iv_paypal_recurring_profile_period',true);	
					$recurring_cycle_count=	get_post_meta($package_id,'iv_directories_package_recurring_cycle_count',true);
					if($recurring_cycle_count=="" || $recurring_cycle_count=="0"){
						$recurring_cycle_count='1';
					}
					// Recurring payment
					$recurringParams = array(
					'TOKEN' => 		$checkoutDetails['TOKEN'],
					'PAYERID' => 	$checkoutDetails['PAYERID'],
					'INITAMT' => 	floatval($initAmt),
					'AMT' => 		floatval($amt),
					'CURRENCYCODE' => $currencyCode,
					'DESC' => $description,
					'BILLINGPERIOD' => ucfirst ($period ),
					'BILLINGFREQUENCY' => $recurring_cycle_count,
					'PROFILESTARTDATE' => $begins,
					'FAILEDINITAMTACTION' => 'CancelOnFailure',
					'AUTOBILLOUTAMT' => 'NoAutoBill',
					'MAXFAILEDPAYMENTS' => '0'
					);
					$arb_limit	= get_post_meta( $package_id,'iv_directories_package_recurring_cycle_limit',true); 
					if($arb_limit!=''){
						$recurringParams['TOTALBILLINGCYCLES']=$arb_limit;
					}
					$trial_enable= get_post_meta( $package_id,'iv_directories_package_enable_trial_period',true); 
					if( $trial_enable=='yes' ){					
						$trial_amount= get_post_meta( $package_id,'iv_directories_package_trial_amount',true); 
						$trial_period_interval= get_post_meta( $package_id,'iv_directories_package_trial_period_interval',true); 
						$trial_type = get_post_meta( $package_id,'iv_directories_package_recurring_trial_type',true);
						if(trim($trial_amount)=='0' or trim($trial_amount)=='' ){
							$trial_amount='0';
						}
						$recurringParams['TRIALBILLINGFREQUENCY']=$trial_period_interval;
						$recurringParams['TRIALAMT']=$trial_amount;						
						$recurringParams['TRIALTOTALBILLINGCYCLES']='1';
						$recurringParams['TRIALBILLINGPERIOD']=ucfirst ($trial_type);				
					}
					$recurringPayment = $paypal -> request('CreateRecurringPaymentsProfile', $recurringParams);
					// recurring profile created
					if( is_array($recurringPayment) && $recurringPayment['ACK'] == 'Success' ) {
						update_user_meta( $userId, 'iv_paypal_recurring_profile_id', $recurringPayment['PROFILEID'] );
						update_user_meta($userId, 'iv_directories_exprie_date',$begins); 
						update_user_meta($userId, 'iv_directories_package_id',$package_id);
						// Check here for success status*****	
						if($recurringPayment['PROFILESTATUS']=='PendingProfile'){
							update_user_meta($userId, 'iv_directories_payment_status', 'pending');
							}else{
							$role_package= get_post_meta( $package_id,'iv_directories_package_user_role',true); 
							update_user_meta($userId, 'iv_directories_payment_status', 'success');
							$user = new WP_User( $userId );
							if(strtolower(trim($role_package))!='administrator'){
								$user->set_role($role_package);
							}												
						}
						//Start aktar mail module  
						$dis_amount=$discount;	
						include( wp_iv_directories_ABSPATH.'inc/order-mail.php');
						//End aktar mail module  	
					}
					} else {
					//  If single payment
					$params = array(
					'TOKEN' => $checkoutDetails['TOKEN'],
					'PAYERID' => $checkoutDetails['PAYERID'],
					'PAYMENTACTION' => 'Sale',
					'PAYMENTREQUEST_0_AMT' => $checkoutDetails['PAYMENTREQUEST_0_AMT'], // Same amount as in the original request
					'PAYMENTREQUEST_0_CURRENCYCODE' => $checkoutDetails['CURRENCYCODE'] // Same currency as the original request
					);			
					$singlePayment = $paypal -> request('DoExpressCheckoutPayment',$params);
					// IF PAYMENT OK
					if( is_array($singlePayment) && $singlePayment['ACK'] == 'Success') {
						// set role
						$role_package= get_post_meta( $package_id,'iv_directories_package_user_role',true); 	
						$user = new WP_User( $userId );
						if(strtolower(trim($role_package))!='administrator'){
							$user->set_role($role_package);
						}	
						update_user_meta($userId, 'iv_directories_package_id',$package_id);
						update_user_meta($userId, 'iv_directories_payment_status', 'success');
						//New code for expire date
						$expire_interval = get_post_meta($package_id, 'iv_directories_package_initial_expire_interval', true);						
						$initial_expire_type = get_post_meta($package_id, 'iv_directories_package_initial_expire_type', true);
						if($expire_interval!='' AND $initial_expire_type!=''){
							$exp_periodNum = (60 * 60 * 24 * 90);
							switch ($initial_expire_type) {
								case 'year':
								$exp_periodNum = (60 * 60 * 24 * 365) * $expire_interval;
								break;
								case 'month':
								$exp_periodNum = (60 * 60 * 24 * 30) * $expire_interval;
								break;
								case 'week':
								$exp_periodNum = (60 * 60 * 24 * 7) * $expire_interval;
								break;
								case 'day':
								$exp_periodNum = (60 * 60 * 24) * $expire_interval;
								break;
							}
							$exp_time = time() + $exp_periodNum;
							$exp_d = date('Y-m-d',$exp_time).'T'.'00:00:00Z';
							}else{
							$exp_d=date('Y-m-d', strtotime('+10 year'));
						} 							  
						update_user_meta($userId, 'iv_directories_exprie_date',$exp_d); 
						update_user_meta($userId, 'iv_directories_package_id',$package_id);
						// End expire date
						$transactionId = $singlePayment['PAYMENTINFO_0_TRANSACTIONID'];
						update_user_meta( $userId, 'iv_paypal_transaction_id', $transactionId );					 
						include( wp_iv_directories_ABSPATH.'inc/order-mail.php');
					}
				}
				$iv_redirect = get_option( '_iv_directories_profile_page');
				if(trim($iv_redirect)!=''){
					$reg_page= get_permalink( $iv_redirect); 
					wp_clear_auth_cookie();
					wp_set_current_user ( $user->ID );
					wp_set_auth_cookie  ( $user->ID );
					wp_safe_redirect( $reg_page );		
					exit;
				}	
			}
		}
	}	
	//Upgrade 1st Link
	// for payment_gateway=paypal&iv-submit-upgrade=upgrade
	if( isset($_REQUEST['iv-submit-upgrade']) &&  $_REQUEST['iv-submit-upgrade']=='upgrade' && $_REQUEST['payment_gateway']=='paypal'  ){	
		global $current_user;
		$userId=$user_id=$current_user->ID;
		$package_id='';
		if(isset($_REQUEST['package_id'])){
			$package_id=sanitize_text_field($_REQUEST['package_id']);
		}
		$return_page_url= sanitize_text_field($_POST['return_page']);
		$oldProfile = get_user_meta($userId,'iv_paypal_recurring_profile_id',true);
		if (!empty($oldProfile)) {
			$cancelParams = array(
			'PROFILEID' => $oldProfile,
			'ACTION' => 'Cancel'
			);
			$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);					
		}
		// Copy From Sign UP 1st Step**************
		$row2 =$wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE id =%s",$package_id ));
		$package_name='';
		if(isset($row2->post_title)){
			$package_name= $row2->post_title;
		}
		$iv_directories_package_cost= get_post_meta( $package_id,'iv_directories_package_cost',true);
		$iv_directories_package_recurring= get_post_meta( $package_id,'iv_directories_package_recurring',true);
		$package_cost=$iv_directories_package_cost;
		// Cheek here Coupon ************
		$trial_enable= 'no';
		if( $iv_directories_package_recurring=='on'  ){
			$package_cost=get_post_meta($package_id, 'iv_directories_package_recurring_cost_initial', true);			
		}		
		if($package_cost >0){
			$currencyCode = (isset($paypal_api_currency)) ? $paypal_api_currency : 'USD';
			$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
			$paymentName = $package_name;
			$paymentDescription = $iv_directories_package_cost.' '.$currencyCode.' for '.$package_name .' at '. get_bloginfo();
			$page_name_registration=get_option('_iv_directories_registration' ); 
			$returnUrl = $return_page_url."?&paypal-thanks=success&payment_gateway=paypal&package_id=".$package_id.'&user_id='.$user_id;
			$cancelUrl = $return_page_url."?&paypal-cancel=cancel&payment_gateway=paypal&package_id=".$package_id.'&user_id='.$user_id;
			$urlParams = array(
			'RETURNURL' => $returnUrl,
			'CANCELURL' => $cancelUrl
			);
			$recurringDescriptionFull='';
			if($iv_directories_package_recurring=='on'){
				$period= get_post_meta( $package_id,'iv_directories_package_recurring_cycle_type',true);
				$recurringDescriptionFull= $package_cost.' '.$currencyCode.' for '.$package_name .' at '. get_bloginfo();
				$recurring = array(
				'L_BILLINGTYPE0' => 'RecurringPayments',
				'L_BILLINGAGREEMENTDESCRIPTION0' => $recurringDescriptionFull
				);
				$params = $urlParams + $recurring;
				}else{ // Not recurring Start	
				$orderParams = array(
				'PAYMENTREQUEST_0_AMT' => $iv_directories_package_cost,
				'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
				'PAYMENTREQUEST_0_CURRENCYCODE' => $currencyCode,
				'PAYMENTREQUEST_0_ITEMAMT' => $iv_directories_package_cost
				);
				$itemParams = array(
				'L_PAYMENTREQUEST_0_NAME0' => $paymentName,
				'L_PAYMENTREQUEST_0_DESC0' => $paymentDescription,
				'L_PAYMENTREQUEST_0_AMT0' =>  $iv_directories_package_cost,
				'L_PAYMENTREQUEST_0_QTY0' => '1'
				);
				$params = $urlParams + $orderParams + $itemParams;
			} // Not recurring  End // One time payment
			$response = $paypal -> request('SetExpressCheckout',$params);
			$errors = new WP_Error();
			if(!$response){
				$errorMessage = 'ERROR: Check paypal API settings!';							
				$errors->add( 'bad_paypal_api', $errorMessage . ' ' . $paypal->getErrors() );
				$register_error_string = $errors;
			}
			$token="";
			if(is_array($response) && $response['ACK'] == 'Success') {
				$token = $response['TOKEN'];					
				$userId=$user_id;
				update_user_meta($userId, 'iv_paypal_token', $token);
				$peried=get_post_meta( $package_id,'iv_directories_package_recurring_cycle_type',true);
				$cycle_count=get_post_meta( $package_id,'iv_directories_package_recurring_cycle_count',true);
				update_user_meta($userId, 'iv_paypal_recurring_profile_amt', get_post_meta( $package_id,'iv_directories_package_recurring_cost_initial',true));
				update_user_meta($userId, 'iv_directories_payment_gateway','paypal-express'); 
				update_user_meta($userId, 'iv_paypal_recurring_profile_init_amt',get_post_meta( $package_id,'iv_directories_package_cost',true));
				update_user_meta($userId, 'iv_paypal_recurring_profile_period',$peried);	
				update_user_meta($userId, 'iv_paypal_recurring_cycle_count',$cycle_count);
				update_user_meta($userId, 'iv_directories_discount','');
				update_user_meta($userId, 'iv_paypal_recurring_profile_desc',$recurringDescriptionFull);
			}	
			wp_redirect( 'https://www.'.$sandbox.'paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) ); 
			exit; 
			}else{
			// For Expire date
			$expire_interval = get_post_meta($package_id, 'iv_directories_package_initial_expire_interval', true);						
			$initial_expire_type = get_post_meta($package_id, 'iv_directories_package_initial_expire_type', true);
			if($expire_interval!='' AND $initial_expire_type!=''){
				$exp_periodNum = (60 * 60 * 24 * 90);
				switch ($initial_expire_type) {
					case 'year':
					$exp_periodNum = (60 * 60 * 24 * 365) * $expire_interval;
					break;
					case 'month':
					$exp_periodNum = (60 * 60 * 24 * 30) * $expire_interval;
					break;
					case 'week':
					$exp_periodNum = (60 * 60 * 24 * 7) * $expire_interval;
					break;
					case 'day':
					$exp_periodNum = (60 * 60 * 24) * $expire_interval;
					break;
				}
				$exp_time = time() + $exp_periodNum;
				$exp_d = date('Y-m-d',$exp_time).'T'.'00:00:00Z';
				}else{
				$exp_d=date('Y-m-d', strtotime('+10 year'));
			} 					  
			update_user_meta($user_id, 'iv_directories_exprie_date',$exp_d); 
			update_user_meta($user_id, 'iv_directories_package_id',$package_id);
			// Expire date
		}
	}		