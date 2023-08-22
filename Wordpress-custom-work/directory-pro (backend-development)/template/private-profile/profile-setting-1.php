          <div class="profile-content">
            
              <div class="portlet row light">

                  <div class="portlet-title tabbable-line clearfix">
                    <div class="caption caption-md">
                      <span class="caption-subject"><?php  esc_html_e('Profile','ivdirectories');?> </span>
                    </div>
                    <ul class="nav nav-tabs">
                      <li class="active">
                        <a href="#tab_1_1" data-toggle="tab"><?php  esc_html_e('Personal Info','ivdirectories');?> </a>
                      </li>
                      <li>
                        <a href="#tab_1_3" data-toggle="tab"><?php  esc_html_e('Change Password','ivdirectories');?> </a>
                      </li>
                      <li>
                        <a href="#tab_1_5" data-toggle="tab"><?php  esc_html_e('Social','ivdirectories');?> </a>
                      </li>
					  <li>
                        <a href="#tab_1_4" data-toggle="tab"><?php  esc_html_e('Privacy Settings','ivdirectories');?> </a>
                      </li>
                    </ul>
                  </div>
                  <div class="clearfix col-md-12"> </div>
                  <div class="portlet-body row">
                    <div class="tab-content col-md-12 ">
                    
                      <div class="tab-pane active" id="tab_1_1">
                        <form role="form" name="profile_setting_form" id="profile_setting_form" action="#">
                       												
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('First Name', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter First Name', 'ivdirectories'); ?>" name="first_name" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'first_name',true)); ?>"/>
							</div>
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Last Name', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter Last Name', 'ivdirectories'); ?>" name="last_name" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'last_name',true)); ?>"/>
							</div>
							
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Phone', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter phone number', 'ivdirectories'); ?>" name="phone" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'phone',true)); ?>"/>
							</div>
							
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Mobile', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter mobile number', 'ivdirectories'); ?>" name="mobile" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'mobile',true)); ?>"/>
							</div>
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Address', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter address', 'ivdirectories'); ?>" name="address" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'address',true)); ?>"/>
							</div>
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Occupation', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter occupation', 'ivdirectories'); ?>" name="occupation" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'occupation',true)); ?>"/>
							</div>
              <div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Description', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter description', 'ivdirectories'); ?>" name="description" class="form-control" value="<?php echo esc_attr(get_user_meta($current_user->ID,'description',true)); ?>"/>
							</div>
							<div class="form-group">
							<label class="control-label"><?php echo esc_html_e('Website', 'ivdirectories'); ?></label>
							<input type="text" placeholder="<?php esc_html_e('Enter website', 'ivdirectories'); ?>" name="web_site" class="form-control" value="<?php echo esc_url(get_user_meta($current_user->ID,'web_site',true)); ?>"/>
							</div>
							
                          <div class="margiv-top-10">
						    <div class="" id="update_message"></div>
						    <button type="button" onclick="update_profile_setting();"  class="btn green-haze"><?php  esc_html_e('Save Changes','ivdirectories');?></button>
                          
                          </div>
                        </form>
                      </div>
                      
					  <div class="tab-pane" id="tab_1_3">
                        <form action="" name="pass_word" id="pass_word">
                          <div class="form-group">
                            <label class="control-label"><?php  esc_html_e('Current Password','ivdirectories');?> </label>
                            <input type="password" id="c_pass" name="c_pass" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label"><?php  esc_html_e('New Password','ivdirectories');?> </label>
                            <input type="password" id="n_pass" name="n_pass" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label"><?php  esc_html_e('Re-type New Password','ivdirectories');?> </label>
                            <input type="password" id="r_pass" name="r_pass" class="form-control"/>
                          </div>
                          <div class="margin-top-10">
                            <div class="" id="update_message_pass"></div>
							 <button type="button" onclick="iv_update_password();"  class="btn green-haze"><?php  esc_html_e('Change Password','ivdirectories');?> </button>
                           `
                          </div>
                        </form>
                      </div>
					  
					  <div class="tab-pane" id="tab_1_5">
                        <form action="#" name="setting_fb" id="setting_fb">
                          <div class="form-group">
                            <label class="control-label">FaceBook</label>
                            <input type="text" name="facebook" id="facebook" value="<?php echo esc_url(get_user_meta($current_user->ID,'facebook',true)); ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Linkedin</label>
                            <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_url(get_user_meta($current_user->ID,'linkedin',true)); ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Twitter</label>
                            <input type="text" name="twitter" id="twitter" value="<?php echo esc_url(get_user_meta($current_user->ID,'twitter',true)); ?>" class="form-control"/>
                          </div>
						  <div class="form-group">
                            <label class="control-label">Google+ </label>
                            <input type="text" name="gplus" id="gplus" value="<?php echo esc_url(get_user_meta($current_user->ID,'gplus',true)); ?>"  class="form-control"/>
                          </div>
						  
						  
                          <div class="margin-top-10">
						     <div class="" id="update_message_fb"></div>
                            <button type="button" onclick="iv_update_fb();"  class="btn green-haze"><?php  esc_html_e('Save Changes','ivdirectories');?> </button>
                           `
                          </div>
                        </form>
                      </div>
                      <div class="tab-pane" id="tab_1_4">
                        <form action="#" name="setting_hide_form" id="setting_hide_form">
                        <div class="table-responsive">
                          <table class="table table-light table-hover">
                       
                          <tr>
                            <td style="font-size:14px">
                              <?php  esc_html_e('Hide Email Address ','ivdirectories');?> 
                            </td>
                            <td>
                              <label class="uniform-inline">
                              <input type="checkbox" id="email_hide" name="email_hide"  value="yes" <?php echo( get_user_meta($current_user->ID,'hide_email',true)=='yes'? 'checked':''); ?>/> <?php  esc_html_e('Yes','ivdirectories');?>  </label>
                            </td>
                          </tr>
                          <tr>
                            <td style="font-size:14px">
                               <?php  esc_html_e('Hide Phone Number','ivdirectories');?> 
                            </td>
                            <td>
                              <label class="uniform-inline">
                              <input type="checkbox" id="phone_hide" name="phone_hide" value="yes" <?php echo( get_user_meta($current_user->ID,'hide_phone',true)=='yes'? 'checked':''); ?>  /> <?php  esc_html_e('Yes','ivdirectories');?>  </label>
                            </td>
                          </tr>
                          <tr>
                            <td style="font-size:14px">
                              <?php  esc_html_e('Hide Mobile Number','ivdirectories');?> 
                            </td>
                            <td>
                              <label class="uniform-inline">
                              <input type="checkbox" id="mobile_hide" name="mobile_hide" value="yes"  <?php echo( get_user_meta($current_user->ID,'hide_mobile',true)=='yes'? 'checked':''); ?> /> <?php  esc_html_e('Yes','ivdirectories');?>  </label>
                            </td>
                          </tr>
                          </table>
                          </div>
                          <!--end profile-settings-->
                          <div class="margin-top-10">
						  <div class="" id="update_message_hide"></div>
						   <button type="button" onclick="iv_update_hide_setting();"  class="btn green-haze"><?php  esc_html_e('Save Changes','ivdirectories');?> </button>
                          
                           
                          </div>
                        </form>
                      </div>
                    
                  </div>
                </div>
              </div>
            </div>
          <!-- END PROFILE CONTENT -->

        
