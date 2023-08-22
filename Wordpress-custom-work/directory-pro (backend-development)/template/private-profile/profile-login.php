<?php
wp_enqueue_script('jquery');	
wp_enqueue_style('wp-iv_directories-style-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
wp_enqueue_style('wp-iv_directories-style-12', wp_iv_directories_URLPATH . 'admin/files/css/login.css');
wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>


<div id="login-2" class="bootstrap-wrapper login-main">
  <div class="menu-toggler sidebar-toggler"> </div>
  <div class="content"> 
    <!-- BEGIN LOGIN FORM -->
    <form id="login_form" class="login-form" action="" method="post">
      <h3 class="form-title">
        <?php  esc_html_e('Sign In','ivdirectories');?>
      </h3>
      <div class="display-hide" id="error_message"> </div>
      <div class="form-group"> 
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">
          <?php  esc_html_e('Username','ivdirectories');?>
        </label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php  esc_html_e('Username','ivdirectories');?>" name="username" id="username"/>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">
          <?php  esc_html_e('Password','ivdirectories');?>
        </label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php  esc_html_e('Password','ivdirectories');?>" name="password" id="password"/>
      </div>
      <div class="form-actions row">
        <div class="col-md-6">
          <button type="button" class="btn uppercase pull-left" onclick="return chack_login();" >
          <?php  esc_html_e('Login','ivdirectories');?>
          </button>
        </div>
        

        <div class="col-md-6 pull-right">
			<p class="pull-right para  text-right"> <a href="javascript:;" class="forgot-link">
			  <?php  esc_html_e('Forgot Password?','ivdirectories');?>
			  </a> 
			</p>
			</div>
      </div> 
      <div class="create-account">
        <p>
          <?php
			global $wpdb, $post;
			$iv_directories_pack='iv_directories_pack';
			$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$iv_directories_pack );
			$membership_pack = $wpdb->get_results($sql);
			$total_package=count($membership_pack);
			if($total_package>0){
				$iv_redirect = get_option( '_iv_directories_price_table');
			}else{
				$iv_redirect = get_option( '_iv_directories_registration');
			}					
			$reg_page= get_permalink( $iv_redirect); 
			?>
          <a  href="<?php echo esc_url($reg_page);?>" id="register-btn" class="uppercase">
          <?php  esc_html_e('Create an account','ivdirectories');?>
          </a> </p>
      </div>
    </form>
    <!-- END LOGIN FORM --> 
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form id="forget-password" name="forget-password" class="forget-form" action="" method="post" >
      <h3>
        <?php  esc_html_e('Forget Password ?','ivdirectories');?>
      </h3>
      <div id="forget_message">
        <p>
          <?php  esc_html_e('Enter your e-mail address','ivdirectories');?>
        </p>
      </div>
      <div class="form-group">
        <input class="form-control form-control-solid placeholder-no-fix" type="text"  placeholder="<?php  esc_html_e('Email','ivdirectories');?>" name="forget_email" id="forget_email"/>
      </div>
      <div class="">
        <button type="button" id="back-btn" class="btn btn-default uppercase margin-b-30">
        <?php  esc_html_e('Back','ivdirectories');?>
        </button>
        <button type="button" onclick="return forget_pass();"  class="btn btn-success uppercase pull-right margin-b-30">
        <?php  esc_html_e('Submit','ivdirectories');?>
        </button>
      </div>
    </form>
  </div>
</div>
<?php
wp_enqueue_script('iv_real-ar-script-27', wp_iv_directories_URLPATH . 'admin/files/js/login.js');
wp_localize_script('iv_real-ar-script-27', 'dirpro', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'forget_sent'=> esc_html__('Password Sent. Please check your email.','ivdirectories'),
		'login_error'=> esc_html__('Invalid Username & Password.','ivdirectories'),
		'login_validator'=> esc_html__('Enter Username & Password.','ivdirectories'),
		'forget_validator'=> esc_html__('Enter Email Address','ivdirectories'),
		'dirwpnonce'=> wp_create_nonce("login"),
		
		) );

?>
