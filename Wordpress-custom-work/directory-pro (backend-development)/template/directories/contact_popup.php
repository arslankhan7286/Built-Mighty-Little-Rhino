<?php
	include( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
	$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	$id=$dir_id;
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle=esc_html__('Contact Us','ivdirectories');}
?>
<div class="bootstrap-wrapper">
	<div class="container">	
		<div class="row" >
			<div class="col-md-12">	
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html($dir_addedit_contactustitle); ?></h5>				
					<div class="ml-2" id="update_message_popup"></div> 
					<button onclick="contact_close();" type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php		
						include(wp_iv_directories_template.'directories/contact-form.php');
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" onclick="contact_close();"><?php esc_html_e( 'Close', 'ivdirectories' ); ?></button>
					<button type="button" onclick="contact_send_message_iv();" class="btn btn-secondary"><?php esc_html_e( 'Send Message', 'ivdirectories' ); ?></button>
				</div>
				<?php					
					
				?>	
			</div>
		</div>
	</div>
</div>