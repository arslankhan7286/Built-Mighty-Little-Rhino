<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'Deal/ Coupon Message Subject', 'ivdirectories' );?> : </label>
		<div class="col-md-4 ">
			
				<?php
				$iv_directories_deal_email_subject = get_option( 'iv_directories_deal_email_subject');
				?>
				
				<input type="text" class="form-control" id="deal_email_subject" name="deal_email_subject" value="<?php echo esc_html($iv_directories_deal_email_subject); ?>" >
		
	</div>
</div>
<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'Deal/ Coupon Message Template ', 'ivdirectories' );?>: </label>
		<div class="col-md-10 ">
				<?php
					$settings_forget = array(															
						'textarea_rows' =>'20',	
						'editor_class'  => 'form-control',														 
						);
					$content_client = get_option( 'iv_directories_deal_email');
					$editor_id = 'iv_directories_deal_email';
															
					?>
			<textarea id="<?php echo esc_html($editor_id) ;?>" name="<?php echo esc_html($editor_id) ;?>" rows="20" class="col-md-12 ">
			<?php echo esc_textarea($content_client); ?>
			</textarea>				

	</div>
</div>
