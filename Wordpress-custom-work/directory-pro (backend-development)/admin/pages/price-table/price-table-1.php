<?php
wp_enqueue_style('wp-iv_directories-piblic-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
	global $wpdb, $post;
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
	$currencies['INR'] ='INR';
	$currencyCode= get_option('_iv_directories_api_currency');
	$currencyCode=(isset($currencies[$currencyCode]) ? $currencies[$currencyCode] :$currencyCode );


	$post_name='iv_directories_pack';
	$membership_pack = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = %s and post_status='draft'", $post_name ));


	$total_package=count($membership_pack);
	if($total_package>0){
		if($total_package==1 || $total_package==2){
			$window_ratio='33';
		}else{
			$window_ratio= 96/$total_package;
		}
	}
?>

<div class="bootstrap-wrapper pricing-sec">
  <div class="row text-center">
    <?php
$iv_gateway = get_option('iv_directories_payment_gateway');
if($iv_gateway=='woocommerce'){
	if ( class_exists( 'WooCommerce' ) ) {
		$api_currency= get_option( 'woocommerce_currency' );
		$currencyCode= get_woocommerce_currency_symbol( $api_currency );
	}
}
if(sizeof($membership_pack)>0){
	 $page_name_reg=get_option('_iv_directories_registration' );
	$feature_max=0;
	foreach ( $membership_pack as $row5 )
	{
		$feature_arr = array_filter(explode("\n", $row5->post_content));
		$last_li_no=sizeof($feature_arr);
		if($last_li_no > $feature_max){
			$feature_max=$last_li_no;
		}
	}
	$i=0;
	foreach ( $membership_pack as $row )
	{
		$recurring_text='  ';
		if(get_post_meta($row->ID, 'iv_directories_package_cost', true)=='0' or get_post_meta($row->ID, 'iv_directories_package_cost', true)==""){
		  $amount= esc_html__( 'Free', 'ivdirectories' );
		}else{
		  $amount= $currencyCode.' '. get_post_meta($row->ID, 'iv_directories_package_cost', true);
		}
		$recurring= get_post_meta($row->ID, 'iv_directories_package_recurring', true);
		if($recurring == 'on'){
			$amount= $currencyCode.' '. get_post_meta($row->ID, 'iv_directories_package_recurring_cost_initial', true);
			$count_arb=get_post_meta($row->ID, 'iv_directories_package_recurring_cycle_count', true);
			if($count_arb=="" or $count_arb=="1"){
			$recurring_text=" per ".' '.get_post_meta($row->ID, 'iv_directories_package_recurring_cycle_type', true);
			}else{
			$recurring_text=' per '.$count_arb.' '.get_post_meta($row->ID, 'iv_directories_package_recurring_cycle_type', true).'s';
			}

		}else{
			$recurring_text=' &nbsp; ';
		}
?>
<div class="col-lg-4">
   <ul id="p1" class="<?php echo ($i%2 == 0 ? 'even' : '') ; ?>">
     <li>
       <h2><?php echo strtoupper($row->post_title); ?></h2>
       <h3><?php echo esc_html($amount); ?><span><?php echo esc_html($recurring_text); ?></span></h3>
       <ul>
         <?php
			$row->post_content;
			$ii=0;
			$feature_all = explode("\n", $row->post_content);

			$last_li_no=sizeof($feature_all);
			foreach($feature_all as $feature){
				if(trim($feature)!=""){
					echo '<li class=" '.($ii == 0 ? 'first' : ''). ($ii == $last_li_no ? 'last' : ''). ($ii %2== 0 ? ' even' : ' odd').'">'.$feature.'</li>';
				$ii++;
				}
			}
			if($feature_max > $ii){
				while ($ii < $feature_max) {
					echo '<li class=" '.($ii == 0 ? 'first' : ''). ($ii == $feature_max ? 'last' : ''). ($ii %2== 0 ? ' even' : ' odd').'">&nbsp; </li>';
				 $ii++;
				}
			}
			?>
        </ul>
        <div class="submit-btn"> <a href="<?php echo get_page_link($page_name_reg).'?&package_id=	'.$row->ID ; ?>"><?php esc_html_e( 'Sign up', 'ivdirectories' );?></a> </div>
      </li>
    </ul>
</div>
<?php
		$i++;
		}
	}
?>
  </div>
</div>
