<form action="#" id="message-pop"  name="message-pop"   method="POST" >
 <div class="form-group row">
		<label class=" control-label" for="Name"><?php esc_html_e( 'Name', 'ivdirectories' ); ?></label>
		<input class="form-control"  id="name" name ="name" type="text">
 </div>
  <div class="form-group row">
		  <label class=" control-label" for="eamil"><?php esc_html_e( 'Email', 'ivdirectories' ); ?></label>
		 <input class="form-control"  name="email_address" id="email_address" type="text">
 </div>
  <div class="form-group row">
		  <label class=" control-label"  for="message"><?php esc_html_e( 'Message', 'ivdirectories' ); ?></label>
		   <input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_html($id); ?>">
		   <?php
			 	$message=get_option('dircontact_form_message');	
						if($message==""){
							$message=esc_html__('I would like to inquire about your listing. Please contact me at your earliest convenience.','ivdirectories' );
							}			
		   ?>
		  <textarea class="form-control"  name="message-content" id="message-content"  cols="20" rows="3"><?php echo esc_html($message);?></textarea>
 </div>
</form>
