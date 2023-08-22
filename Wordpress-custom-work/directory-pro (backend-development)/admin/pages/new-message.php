<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'BCC to Admin all Message :', 'ivdirectories' );?> </label>
		<div class="col-md-4 ">
			
			<?php
			 $bcc_message='';
			 if( get_option( '_iv_directories_bcc_message' ) ) {
				  $bcc_message= get_option('_iv_directories_bcc_message'); 
			 }	 
			
			?><label>
		  <input  class="" type="checkbox" name="bcc_message" id="bcc_message" value="yes" <?php echo ($bcc_message=='yes'? 'checked':'' ); ?> > 
				<?php esc_html_e( 'Yes, Admin will  get all message.', 'ivdirectories' );?>
		
	</div>
</div>
<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Subject :', 'ivdirectories' );?> </label>
		<div class="col-md-4 ">
			
				<?php
				$iv_directories_contact_email_subject = get_option( 'iv_directories_contact_email_subject');
				?>
				
				<input type="text" class="form-control" id="contact_email_subject" name="contact_email_subject" value="<?php echo esc_html($iv_directories_contact_email_subject); ?>" >
		
	</div>
</div>
<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Template :', 'ivdirectories' );?> </label>
		<div class="col-md-10 ">
													<?php
					$settings_forget = array(															
						'textarea_rows' =>'20',	
						'editor_class'  => 'form-control',														 
						);
					$content_client = get_option( 'iv_directories_contact_email');
					$editor_id = 'message_email_template';
												
					?>
			<textarea id="message_email_template" name="message_email_template" rows="20" class="col-md-12 ">
			<?php echo esc_textarea($content_client); ?>
			</textarea>				

	</div>
</div>
