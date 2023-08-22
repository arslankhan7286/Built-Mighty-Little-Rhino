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
<?php
	wp_enqueue_style('multiselect-css', wp_iv_directories_URLPATH . 'admin/files/css/jquery.multiselect.css');
	wp_enqueue_script('multiselect-js', wp_iv_directories_URLPATH . 'admin/files/js/jquery.multiselect.js');
	
	global $wpdb;
	global $current_user;
	global $wp_roles;
	$ii=1;

	
?>		
		
		<form id="dir_fields" name="dir_fields" class="form-horizontal" role="form" onsubmit="return false;">	
		
			<div class="panel panel-info">
				<div class="panel-heading"><h4><?php esc_html_e('Directory Listing Fields','ivdirectories');?></h4></div>
				<div class="panel-body">
					<table id="all_fieldsdatatable" name="all_fieldsdatatable"  class="display table" width="100%">					
						<thead>
							<tr>
								<th > <?php  esc_html_e('Input Name','ivdirectories')	;?> </th>
								<th > <?php  esc_html_e('Label','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Type','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Value [Dropdown,checkbox & Radio Button]','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Fileld for User Role','ivdirectories')	;?> </th>	
								<th><?php  esc_html_e('Action','ivdirectories')	;?></th>
							</tr>
						</thead>
						<tbody>							
							<?php
									//update_option('iv_directories_fields', '');
								
								$default_fields = array();
								$field_set=get_option('iv_directories_fields' );
								
								if($field_set!=""){
									$default_fields=get_option('iv_directories_fields' );
									}else{
									$default_fields['business_type']='Business Type';
									$default_fields['main_products']='Main Products';
									$default_fields['number_of_employees']='Number Of Employees';
									$default_fields['main_markets']='Main Markets';
									$default_fields['total_annual_sales_volume']='Total Annual Sales Volume';	
								}
								$i=0;								
								$field_type=  	get_option( 'iv_membership_field_type' );
								$field_type_value=  	get_option( 'iv_membership_field_type_value' );
								$field_type_roles=  	get_option( 'iv_membership_field_type_roles' );
								$sign_up_array=  get_option( 'iv_membership_signup_fields' );
								$myaccount_fields_array=  get_option( 'iv_membership_myaccount_fields' );
								$require_array=  get_option( 'iv_membership_signup_require' );								
								
								
								
								foreach ( $default_fields as $field_key => $field_value ) {
									$sign_up='';									
									if(isset($sign_up_array[$field_key]) && $sign_up_array[$field_key] == 'yes') {
										$sign_up=$sign_up_array[$field_key] ;
									}
									$require='';
									if(isset($require_array[$field_key]) && $require_array[$field_key] == 'yes') {
										$require=$require_array[$field_key];
									}
									$myaccount_one='';									
									if(isset($myaccount_fields_array[$field_key]) && $myaccount_fields_array[$field_key] == 'yes') {
										$myaccount_one=$myaccount_fields_array[$field_key];
									}
									
									
								?>
								<tr  id="wpdatatablefield_<?php echo esc_attr($i);?>">
									<td style="width:15%">
										<input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="<?php echo esc_attr($field_key); ?>"> 
									</td>
									<td style="width:15%">
										<input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="<?php echo esc_attr($field_value);?>" >
									</td>
									<td id="inputtypell_<?php echo esc_attr($i);?>" style="width:10%">
										
										<?php $field_type_saved= (isset($field_type[$field_key])?$field_type[$field_key]:'' );?>
										<select class="form-select" name="field_type[]" id="field_type[]">
											<option value="text" <?php echo ($field_type_saved=='text'? "selected":'');?> ><?php esc_html_e('Text','ivdirectories');?></option>
											<option value="textarea" <?php echo ($field_type_saved=='textarea'? "selected":'');?> ><?php esc_html_e('Text Area','ivdirectories');?></option>
											<option value="dropdown" <?php echo ($field_type_saved=='dropdown'? "selected":'');?> ><?php esc_html_e('Dropdown','ivdirectories');?></option>
											<option value="radio" <?php echo ($field_type_saved=='radio'? "selected":'');?> ><?php esc_html_e('Radio button','ivdirectories');?></option>
											<option value="datepicker" <?php echo ($field_type_saved=='datepicker'? "selected":'');?> ><?php esc_html_e('Date Picker','ivdirectories');?></option>
											<option value="checkbox" <?php echo ($field_type_saved=='checkbox'? "selected":'');?> ><?php esc_html_e('Checkbox','ivdirectories');?></option>
											<option value="url" <?php echo ($field_type_saved=='url'? "selected":'');?> ><?php esc_html_e('URL','ivdirectories');?></option>
										</select>
										
									</td>
									<td style="width:25%">
										<textarea class="form-control" rows="3" name="field_type_value[]" id="field_type_value[]" placeholder="<?php  esc_html_e('Separated by comma','ivdirectories');?> "><?php echo esc_attr((isset($field_type_value[$field_key])?$field_type_value[$field_key]:''));?></textarea>
									</td>
									<td id="roleall_<?php echo esc_attr($i);?>">									
									<?php $field_user_role_saved= $field_type_roles[$field_key];
										if($field_user_role_saved==''){$field_user_role_saved=array('all');}
										
										?>									
									<select name="field_user_role<?php echo esc_attr($i);?>[]" multiple="multiple" class="form-select" size="6">
										<option value="all" <?php echo (in_array('all',$field_user_role_saved)? "selected":'');?>> <?php esc_html_e('All Users','ivdirectories');?> </option>
										<?php										
											foreach ( $wp_roles->roles as $key_role=>$value_role ){?>
												<option value="<?php echo esc_attr($key_role); ?>" <?php echo (in_array($key_role,$field_user_role_saved)? "selected":'');?>> <?php echo esc_html($key_role);?> </option>
											
											<?php												
											}
										?>
									</select>
										
									</td>
							
									<td style="width:5%">
									
									<button class="btn btn-danger btn-xs" onclick="return iv_remove_field('<?php echo esc_attr($i); ?>');"><?php esc_html_e('Delete','ivdirectories');?> </button>
									
									</td>
								</tr>	
								<?php
									$i++;
								}
							?>
						</tbody>
						<tfoot>
							<tr>
								<th> <?php  esc_html_e('Input Name','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Label','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Type','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Value[Dropdown,checkbox & Radio Button]','ivdirectories')	;?> </th>
								<th> <?php  esc_html_e('Fileld for User Role','ivdirectories');?> </th>	
								<th><?php  esc_html_e('Action','ivdirectories')	;?></th>
							</tr>
						</tfoot>
					</table>
					
					<div id="custom_field_div">
					</div>
					<div class="col-xs-12">
						<button class="btn btn-warning " onclick="return iv_add_field();"><?php esc_html_e('Add More Field','ivdirectories');?></button>
					</div>
				</div>
			</div>
		
		
			 	
	<div class="panel panel-info">
		<div class="panel-heading"><h4><?php  esc_html_e('Show/hide section in add/edit listing','ivdirectories'); ?></h4></div>
		<div class="panel-body">	
			<?php
				$dir_addedit_contactinfotitle=get_option('dir_addedit_contactinfotitle');	
				if($dir_addedit_contactinfotitle==""){$dir_addedit_contactinfotitle='Contact Info';}	
				$dir_addedit_contactinfo=get_option('dir_addedit_contactinfo');	
				if($dir_addedit_contactinfo==""){$dir_addedit_contactinfo='yes';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_contactinfotitle" value="<?php echo esc_html( $dir_addedit_contactinfotitle);?>">		
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_contactinfo" id="dir_addedit_contactinfo" value='yes' <?php echo ($dir_addedit_contactinfo=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Contact Info','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_contactinfo" id="dir_addedit_contactinfo" value='no' <?php echo ($dir_addedit_contactinfo=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Contact Info','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');	
				if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}	
				$dir_contact_form=get_option('dir_contact_form');	
				if($dir_contact_form==""){$dir_contact_form='yes';}
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_contactustitle" value="<?php echo esc_html( $dir_addedit_contactustitle);?>">							
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_contact_form" id="dir_contact_form" value='yes' <?php echo ($dir_contact_form=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Default Form','ivdirectories');  ?>
					</label>	
				</div>						
				<div class="col-md-7">
					<label>											
						<input type="radio"  name="dir_contact_form" id="dir_contact_form" value='no' <?php echo ($dir_contact_form=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Other "Form Plugin" e.g. Contact Form7','ivdirectories');  ?>
					</label>
					<?php
						$dir_form_shortcode=get_option('dir_form_shortcode');									
					?>
					<input type="text" name="dir_form_shortcode" id="dir_form_shortcode" placeholder="shortcode" value='<?php echo esc_html( $dir_form_shortcode);?>' >
				</div>									
			</div>
			<?php
				$dir_addedit_claimtitle=get_option('dir_addedit_claimtitle');	
				if($dir_addedit_claimtitle==""){$dir_addedit_claimtitle='Claim The Listing';}	
				$dir_claim_form=get_option('dir_claim_form');	
				if($dir_claim_form==""){$dir_claim_form='yes';}
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_claimtitle" value="<?php echo esc_html( $dir_addedit_claimtitle);?>">							
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_claim_form" id="dir_claim_form" value='yes' <?php echo ($dir_claim_form=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Default Form','ivdirectories');  ?>
					</label>	
				</div>						
				<div class="col-md-7">
					<label>											
						<input type="radio"  name="dir_claim_form" id="dir_claim_form" value='no' <?php echo ($dir_claim_form=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Other "Form Plugin" e.g. Contact Form7','ivdirectories');  ?>
					</label>
					<?php
						$dir_claimform_shortcode=get_option('dir_claimform_shortcode');									
					?>
					<input type="text" name="dir_claimform_shortcode" id="dir_claimform_shortcode" placeholder="shortcode" value='<?php echo esc_html( $dir_claimform_shortcode);?>' >
				</div>									
			</div>
			<?php
				$dir_addedit_videostitle=get_option('dir_addedit_videostitle');	
				if($dir_addedit_videostitle==""){$dir_addedit_videostitle='Videos';}	
				$dir_addedit_videos=get_option('dir_addedit_videos');	
				if($dir_addedit_videos==""){$dir_addedit_videos='yes';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_videostitle" value="<?php echo esc_html( $dir_addedit_videostitle);?>">							
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_videos" id="dir_addedit_videos" value='yes' <?php echo ($dir_addedit_videos=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Videos','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_videos" id="dir_addedit_videos" value='no' <?php echo ($dir_addedit_videos=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Videos','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_socialprofilestitle=get_option('dir_addedit_socialprofilestitle');	
				if($dir_addedit_socialprofilestitle==""){$dir_addedit_socialprofilestitle='Social Profiles';}
				$dir_addedit_socialprofiles=get_option('dir_addedit_socialprofiles');	
				if($dir_addedit_socialprofiles==""){$dir_addedit_socialprofiles='yes';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_socialprofilestitle" value="<?php echo esc_html($dir_addedit_socialprofilestitle);?>">							
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_socialprofiles" id="dir_addedit_socialprofiles" value='yes' <?php echo ($dir_addedit_socialprofiles=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Social Profiles','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_socialprofiles" id="dir_addedit_socialprofiles" value='no' <?php echo ($dir_addedit_socialprofiles=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Social Profiles','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_additionalinfotitle=get_option('dir_addedit_additionalinfotitle');	
				if($dir_addedit_additionalinfotitle==""){$dir_addedit_additionalinfotitle='Additional Info';}
				$dir_addedit_additionalinfo=get_option('dir_addedit_additionalinfo');	
				if($dir_addedit_additionalinfo==""){$dir_addedit_additionalinfo='yes';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_additionalinfotitle" value="<?php echo esc_html($dir_addedit_additionalinfotitle);?>">								
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_additionalinfo" id="dir_addedit_additionalinfo" value='yes' <?php echo ($dir_addedit_additionalinfo=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Additional Info','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_additionalinfo" id="dir_addedit_additionalinfo" value='no' <?php echo ($dir_addedit_additionalinfo=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Additional Info','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_openingtimetitle=get_option('dir_addedit_openingtimetitle');	
				if($dir_addedit_openingtimetitle==""){$dir_addedit_openingtimetitle='Opening Time';}
				$dir_addedit_openingtime=get_option('dir_addedit_openingtime');	
				if($dir_addedit_openingtime==""){$dir_addedit_openingtime='yes';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_openingtimetitle" value="<?php echo esc_html( $dir_addedit_openingtimetitle);?>">								
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_openingtime" id="dir_addedit_openingtime" value='yes' <?php echo ($dir_addedit_openingtime=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Opening Time','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_openingtime" id="dir_addedit_openingtime" value='no' <?php echo ($dir_addedit_openingtime=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Opening Time','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_bookingtitle=get_option('dir_addedit_bookingtitle');	
				if($dir_addedit_bookingtitle==""){$dir_addedit_bookingtitle='Booking';}
				$dir_addedit_booking=get_option('dir_addedit_booking');	
				if($dir_addedit_booking==""){$dir_addedit_booking='no';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_bookingtitle" value="<?php echo esc_html($dir_addedit_bookingtitle);?>">							
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_booking" id="dir_addedit_booking" value='yes' <?php echo ($dir_addedit_booking=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Booking','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_booking" id="dir_addedit_booking" value='no' <?php echo ($dir_addedit_booking=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Booking','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_awardtitle=get_option('dir_addedit_awardtitle');	
				if($dir_addedit_awardtitle==""){$dir_addedit_awardtitle='Awards';}	
				$dir_addedit_award=get_option('dir_addedit_award');	
				if($dir_addedit_award==""){$dir_addedit_award='no';}	
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_awardtitle" value="<?php echo esc_html($dir_addedit_awardtitle);?>">	
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_award" id="dir_addedit_award" value='yes' <?php echo ($dir_addedit_award=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Awards','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_award" id="dir_addedit_award" value='no' <?php echo ($dir_addedit_award=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Awards','ivdirectories');  ?>
					</label>
				</div>	
			</div>
			<?php
				$dir_addedit_eventtitle=get_option('dir_addedit_eventtitle');	
				if($dir_addedit_eventtitle==""){$dir_addedit_eventtitle='Event';}
				$dir_addedit_event=get_option('dir_addedit_event');	
				if($dir_addedit_event==""){$dir_addedit_event='no';}							
			?>
			<div class="form-group row">
				<input type="text" class="col-md-3 control-label"  name="dir_addedit_eventtitle" value="<?php echo esc_html($dir_addedit_eventtitle);?>">						
				<div class="col-md-2">
					<label>												
						<input type="radio" name="dir_addedit_event" id="dir_addedit_event" value='yes' <?php echo ($dir_addedit_event=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Event','ivdirectories');  ?>
					</label>	
				</div>
				<div class="col-md-3">	
					<label>											
						<input type="radio"  name="dir_addedit_event" id="dir_addedit_event" value='no' <?php echo ($dir_addedit_event=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Event','ivdirectories');  ?>
					</label>
				</div>	
			</div>
		</div>		 
	</div>
</form>		
<div class="row">					
	<div class="col-xs-12">					
		<div align="center">
			<div id="loading"></div>	
			<div id="success_message">	</div>	
			<button class="btn btn-info btn-lg" onclick="return update_dir_fields();"><?php esc_html_e( 'Save & Update', 'ivdirectories' );?> </button>
		</div>
		<p>&nbsp;</p>
	</div>
</div>


<?php
	wp_enqueue_script('wp-iv_directories-dashboard5', wp_iv_directories_URLPATH.'admin/files/js/profile-fields.js', array('jquery'), $ver = true, true );
	wp_localize_script('wp-iv_directories-dashboard5', 'profile_data', array( 			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'redirecturl'	=>  wp_iv_directories_ADMINPATH.'admin.php?&page=wp-iv_directories-settings',
	'adminnonce'=> wp_create_nonce("admin"),
	'pii'	=>$ii,
	'pi'	=> $i,
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
				