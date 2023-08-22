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
.html-active .switch-html, .tmce-active .switch-tmce {
	height: 28px!important;
	}
	.wp-switch-editor {
		height: 28px!important;
	}
</style>	
	

		<h3  class=""><?php esc_html_e('Directory URL','ivdirectories');  ?><small></small>	
		</h3>
	
		<br/>
		<div id="update_message"> </div>		 
					
			<form class="form-horizontal" role="form"  name='directory_url' id='directory_url'>											
					<?php
				
					$directory_url=get_option('_iv_directory_url');					
					if($directory_url==""){$directory_url='directories';}	
					
					
				
					?>
					<div class="form-group">
					<label  class="col-md-3 control-label"> <?php esc_html_e('Listing URL','ivdirectories');  ?></label>
						<div class="col-md-2">						
							<input type="text" class="form-control" name="dir_url" id="dir_url" value="<?php echo esc_html($directory_url);?>" placeholder="Enter string e.g directories">
							
						</div>
						<div class="col-md-2">	
							<?php esc_html_e( 'After update the Custom Post Type you have to "Save" the permalink again.  Otherwise, you will get 404 error.', 'ivdirectories' );?>
						</div>	
					</div>
				
					<div class="form-group">
					<label  class="col-md-3 control-label"> </label>
					<div class="col-md-8">						
						<button type="button" onclick="return  iv_update_dir_cpt_save();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivdirectories' );?></button>
					</div>
				</div>
				
				<?php											
					$directoryprosinglepage=get_option('directoryprosinglepage');
					if($directoryprosinglepage==''){$directoryprosinglepage='plugintemplate';}

					if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						
					if ( in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						
					?>
						<div class="form-group">
							<label  class="col-md-3 control-label"> <?php esc_html_e('Listing Detail Page','ivdirectories');  ?></label>
							<div class="col-md-9">
									<div class="col-md-12">
											<label>												
												<input type="radio" name="directoryprosinglepage"  value='plugintemplate' <?php echo ($directoryprosinglepage=='plugintemplate' ? 'checked':'' ); ?> >							
												<?php esc_html_e('Plugin Own Template','ivdirectories');  ?>							
											</label>	
									</div>
									<div class="col-md-12">	
											<label>												
												<input type="radio" name="directoryprosinglepage"  value='elementorpro' <?php echo ($directoryprosinglepage=='elementorpro' ? 'checked':'' ); ?> >							
												<?php esc_html_e('Elementor Pro Template','ivdirectories');  ?>							
											</label>								
									
									</div>	
								</div>	
						</div>	
				
					<?php
					}
				}
				
				?>
						
			</form>
								

	
<script>

function iv_update_dir_cpt_save(){
var search_params={
		"action"  : 	"iv_update_dir_cpt_save",	
		"form_data":	jQuery("#directory_url").serialize(), 
		"_wpnonce": '<?php echo wp_create_nonce("dir-url"); ?>',
	};
	jQuery.ajax({					
		url : ajaxurl,					 
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
			
		}
	})

}

	

</script>
