<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		
		<div class="row">
			<div class="col-md-12">
				
				<h3 class="page-header" ><?php esc_html_e('My Account','ivdirectories');?> <small>  </small> </h3>
				
				
				
			</div>
		</div>
		
		
		<div class="form-group col-md-12 row">
			
			<div class="row ">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Short Code','ivdirectories');?> </label>
				<div class="col-md-4" >
					[iv_directories_profile_template]
				</div>
				<div class="col-md-4" id="success_message">
				</div>
			</div>
			<div class="row ">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Php Code','ivdirectories');?> </label>
				<div class="col-md-10" >
							<p>
										&lt;?php
										echo do_shortcode('[iv_directories_profile_template]');
										?&gt;</p>	
				</div>
			</div>
			<div class="row ">
				<label for="text" class="col-md-2 control-label"> <?php esc_html_e('My Account Page','ivdirectories');?> </label>
				<div class="col-md-10" >
				
					<?php 
					$form_wizard=get_option('_iv_directories_profile_page');
						 ?>
					<a class="btn btn-info btn-xs " href="<?php echo get_permalink( $form_wizard ); ?>" target="blank"><?php esc_html_e('View Page','ivdirectories');?> </a>
				
					
				</div>
			</div>
			<?php
			include('profile-fields.php');
			?>
						
		</div>
		
			
		
	</div>
</div>

