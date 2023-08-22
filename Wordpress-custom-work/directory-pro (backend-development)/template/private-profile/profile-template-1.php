<?php
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('wp-iv_directories-myaccount-style-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_script('iv_directories-myaccount-style-12', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_style('dataTables', wp_iv_directories_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('dataTables', wp_iv_directories_URLPATH . 'admin/files/js/jquery.dataTables.js');
	wp_enqueue_style('datetimepicker', wp_iv_directories_URLPATH . 'admin/files/css/jquery.datetimepicker.css');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_media();
	$main_class = new wp_iv_directories;
	global $current_user;
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$user = new WP_User( $current_user->ID );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ){
			$crole= ucfirst($role);
			break;
		}
	}
	if(strtoupper($crole)!=strtoupper('administrator')){
		include(wp_iv_directories_template.'/private-profile/check_status.php');
	}
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>
<?php
	global $current_user;
	$current_user = wp_get_current_user();
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
	$currency= get_option('_iv_directories_api_currency');
	$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
?>
<div id="profile-account2" class="bootstrap-wrapper around-separetor">
	<div class="row margin-top-10">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<!-- BEGIN PROFILE SIDEBAR -->
			<div class="profile-sidebar">
				<!-- PORTLET MAIN -->
				<div class="portlet portlet0 light profile-sidebar-portlet">
					<!-- SIDEBAR USERPIC -->
					<div class="profile-userpic text-center" id="profile_image_main">
						<?php
							$iv_profile_pic_url=get_user_meta($current_user->ID, 'iv_profile_pic_thum',true);
							if($iv_profile_pic_url!=''){ ?>
							<img src="<?php echo esc_url($iv_profile_pic_url); ?>">
							<?php
								}else{
								echo'	 <img src="'. wp_iv_directories_URLPATH.'assets/images/Blank-Profile.jpg">';
							}
						?>
					</div>
					<!-- END SIDEBAR USERPIC -->
					<!-- SIDEBAR USER TITLE -->
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							<?php
								$name_display=get_user_meta($current_user->ID,'first_name',true).' '.get_user_meta($current_user->ID,'last_name',true);
							echo (trim($name_display)!=""? $name_display : $current_user->display_name );?>
						</div>
						<div class="profile-usertitle-job">
							<?php echo get_user_meta($current_user->ID,'occupation',true); ?>
						</div>
					</div>
					<!-- END SIDEBAR USER TITLE -->
					<!-- SIDEBAR BUTTONS -->
					<div class="profile-userbuttons">
						<button type="button" onclick="edit_profile_image('profile_image_main');"  class="btn"><?php esc_html_e('Change Image','ivdirectories'); ?> </button>
					</div>
					<!-- END SIDEBAR BUTTONS -->
					<!-- SIDEBAR MENU -->
					<div class="profile-usermenu">
						<?php
							$active='all-post';
							if(isset($_GET['profile']) AND $_GET['profile']=='setting' ){
								$active='setting';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='level' ){
								$active='level';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){
								$active='all-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
								$active='new-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
								$active='new-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='bidding' ){
								$active='bidding';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='favorites' ){
								$active='favorites';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='who-is-interested' ){
								$active='who-is-interested';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='messageboard' ){
									$active='messageboard';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='balance' ){
								$active='balance';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){
								$active='all-post';
							}
							$post_type=  'directories';
						?>
						<ul class="nav">
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menu_listinghome' ) ) {
									$account_menu_check= get_option('_iv_directories_menu_listinghome');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="">
									<a href="<?php echo get_post_type_archive_link( $directory_url) ; ?>">
                    <i class="fas fa-home"></i>
									<?php esc_html_e('Listing Home','ivdirectories');	 ?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_mylevel' ) ) {
									$account_menu_check= get_option('_iv_directories_mylevel');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='level'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=level">
										<i class="fas fa-user-clock"></i>
									<?php esc_html_e('Membership Level','ivdirectories');	 ?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menusetting' ) ) {
									$account_menu_check= get_option('_iv_directories_menusetting');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='setting'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=setting">
                    <i class="fa fa-cog"></i>
									<?php esc_html_e('Account Settings','ivdirectories');?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menuallpost' ) ) {
									$account_menu_check= get_option('_iv_directories_menuallpost');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='all-post'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=all-post">
                    <i class="fas fa-list-ul"></i>
									<?php esc_html_e('All Listing','ivdirectories');?>  </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menunewlisting' ) ) {
									$account_menu_check= get_option('_iv_directories_menunewlisting');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='new-post'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=new-post">
                    <i class="fas fa-plus-square"></i>
									<?php  esc_html_e('New Listing','ivdirectories');?> </a>
								</li>
								<?php
								}
							?>
							<li class="<?php echo ($active=='messageboard'? 'active':''); ?> ">
								<a href="<?php echo get_permalink(); ?>?&profile=messageboard">
									<i class="far fa-envelope"></i>
								<?php  esc_html_e('Message','ivdirectories');?></a>
							</li>	
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menufavorites' ) ) {
									$account_menu_check= get_option('_iv_directories_menufavorites');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='favorites'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=favorites">
                    <i class="fab fa-gratipay"></i>
									<?php  esc_html_e('My Favorites','ivdirectories');?> </a>
								</li>
								<?php
								}
							?>
							<?php
								$account_menu_check= '';
								if( get_option( '_iv_directories_menuinterested' ) ) {
									$account_menu_check= get_option('_iv_directories_menuinterested');
								}
								if($account_menu_check!='yes'){
								?>
								<li class="<?php echo ($active=='who-is-interested'? 'active':''); ?> ">
									<a href="<?php echo get_permalink(); ?>?&profile=who-is-interested">
                    <i class="fas fa-user-plus"></i>
									<?php  esc_html_e('Who is Interested','ivdirectories');?> </a>
								</li>
								<?php
								}
							?>
							<?php     $old_custom_menu = array();
								if(get_option('iv_directories_profile_menu')){
									$old_custom_menu=get_option('iv_directories_profile_menu' );
								}
								$ii=1;
								if($old_custom_menu!=''){
									foreach ( $old_custom_menu as $field_key => $field_value ) { ?>
									<li class="<?php echo ($active=='new-post'? 'active':''); ?> ">
										<a href="<?php echo esc_url($field_value); ?>">
											<i class="fa fa-cog"></i>
										<?php echo esc_html($field_key);?> </a>
									</li>
									<?php
									}
								}
							?>
							<li class="<?php echo ($active=='log-out'? 'active':''); ?>">
								<a href="<?php echo wp_logout_url( home_url() ); ?>" >
									<i class="fas fa-sign-out-alt"></i>
									<?php esc_html_e('Sign out','ivdirectories');?>
								</a>
							</li>
						</ul>
					</div>
					<!-- END MENU -->
				</div>
				<!-- END PORTLET MAIN -->
				<!-- PORTLET MAIN -->
				<!-- END PORTLET MAIN -->
			</div>
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
		<?php ?>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="listng-acc">
				<?php
					if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){
						include(  wp_iv_directories_template. 'private-profile/profile-all-post-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
						include( wp_iv_directories_template. 'private-profile/profile-new-post-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='level' ){
						include(  wp_iv_directories_template. 'private-profile/profile-level-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){
						include(  wp_iv_directories_template. 'private-profile/profile-edit-post-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='favorites' ){
						include(  wp_iv_directories_template. 'private-profile/my-favorites-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='who-is-interested' ){
						include(  wp_iv_directories_template. 'private-profile/interested-1.php');
						}elseif(isset($_GET['profile']) AND $_GET['profile']=='setting' ){
						include(  wp_iv_directories_template. 'private-profile/profile-setting-1.php');
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='messageboard' ){
						include(  wp_iv_directories_template. 'private-profile/messageboard.php');
					}else{
						include(  wp_iv_directories_template. 'private-profile/profile-all-post-1.php');
					}
				?>
			</div>
		</div>
	</div>
</div>
<?php
	$currencyCode = get_option('_iv_directories_api_currency');
	wp_enqueue_script('iv_directory-ar-script-27', wp_iv_directories_URLPATH . 'admin/files/js/my-account.js');
	wp_localize_script('iv_directory-ar-script-27', 'dirpro', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'wp_iv_directories_URLPATH'		=> wp_iv_directories_URLPATH,
	'current_user_id'	=>get_current_user_id(),
	'SetImage'		=>esc_html__('Set Image','ivdirectories'),
	'GalleryImages'=>esc_html__('Gallery Images','ivdirectories'),
	'cancelmessage' => esc_html__('Are you sure to cancel this Membership','ivdirectories'),
	'currencyCode'=>  $currencyCode,
	'dirwpnonce'=> wp_create_nonce("myaccount"),
	'dirwpnonce2'=> wp_create_nonce("signup2"),
	'permalink'=> get_permalink(),
	"sProcessing"=>  esc_html__('Processing','ivdirectories'),
	"sSearch"=>   esc_html__('Search','ivdirectories'),
	"lengthMenu"=>   esc_html__('Display _MENU_ records per page','ivdirectories'),
	"zeroRecords"=>  esc_html__('Nothing found - sorry','ivdirectories'),
	"info"=>  esc_html__('Showing page _PAGE_ of _PAGES_','ivdirectories'),
	"infoEmpty"=>   esc_html__('No records available','ivdirectories'),
	"infoFiltered"=>  esc_html__('(filtered from _MAX_ total records)','ivdirectories'),
	"sFirst"=> esc_html__('First','ivdirectories'),
	"sLast"=>  esc_html__('Last','ivdirectories'),
	"sNext"=>     esc_html__('Next','ivdirectories'),
	"sPrevious"=>  esc_html__('Previous','ivdirectories'),
	) );
?>
