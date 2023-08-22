<style media="screen">
.bs-wizard {margin-bottom: 20px !important;}

/*Form Wizard*/
.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0 !important; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #bfbfbf; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #6c7a89; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #bfbfbf;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
/*END Form Wizard*/

</style>

	<div class="" id="erp_update_message"></div>


	<div class="row bs-wizard" style="border-bottom:0;">

                <div id="step-1" class="col-md-3 bs-wizard-step   ">
                  <div class="text-center bs-wizard-stepnum"><?php esc_html_e('Step 1','ivdirectories'); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">
					  <?php esc_html_e('Upload CSV File','ivdirectories'); ?>
                  </div>
                </div>

                <div id="step-2" class="col-md-3 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum"><?php esc_html_e('Step 2','ivdirectories'); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">
                  	<?php esc_html_e('Column mapping','ivdirectories'); ?>
                  </div>
                </div>

                <div id="step-3" class="col-md-3 bs-wizard-step disabled ">
                  <div class="text-center bs-wizard-stepnum"><?php esc_html_e('Step 3','ivdirectories'); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">
                  	<span><?php esc_html_e('Import','ivdirectories'); ?></span>
                  </div>
                </div>

                <div id="step-4" class="col-md-3 bs-wizard-step disabled"><!-- active -->
                  <div class="text-center bs-wizard-stepnum"><?php esc_html_e('Step 4','ivdirectories'); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center">
                  	<?php esc_html_e('Done!','ivdirectories'); ?>
                  </div>
                </div>
            </div>

	<div id="ep1">	
		<center>
		
		<button type="button" onclick="upload_csv_file('gallery_doc_div');" class="btn btn-success" > <?php esc_html_e('Upload CSV File','ivdirectories'); ?></button>
		
		</center>
		<div class="" id="uploaded_csv_file_name"></div>
		<input type="hidden" name="erp_csv_id" id="erp_csv_id" value="">
		<hr/>
		<center>		
		<p><?php esc_html_e('This tool allows you to import (or merge) listing data to your site from a CSV file.','ivdirectories'); ?></p>
		<p><?php esc_html_e('If CSV ID filed value match your listing ID then it will update/merge','ivdirectories'); ?></p>
		<a class="btn btn-info btn-xs" href="<?php echo  wp_iv_directories_URLPATH; ?>assets/sample-data.csv" download ><?php esc_html_e('Sample CSV File','ivdirectories'); ?></a>
		</center>
	</div>

	<div id="ep2" style="display: none;">
		<div id="data_maping"></div>
		<center>
		<button type="button" onclick="save_csv_file_to_database();"  class="btn btn-success" ><?php  esc_html_e('Run The importer','ivdirectories');?></button>
		</center>
	</div>
	<div id="ep3" style="display: none;">
		<center>
			<img src="<?php echo wp_iv_directories_URLPATH; ?>admin/files/images/loader.gif">
		<div class="progress" >
			<div class="progress-bar progress-bar-striped progress-bar-animated" id="progress-bar-csv" style="width: 0%;">0%</div>
		</div>
		</center>
	</div>
	<div id="ep4" style="display: none;">
		<center>
		<h2><?php esc_html_e('Done!','ivdirectories'); ?></h2>
		</center>
	</div>

<?php

wp_enqueue_script('iv_directory-ar-script-30', wp_iv_directories_URLPATH . 'admin/files/js/csv-import.js');
wp_localize_script('iv_directory-ar-script-30', 'dirpro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
	'Deselect'=>esc_html__("Deselect all filters",'ivdirectories'),
	'dirwpnonce'=> wp_create_nonce("csv"),

) );
?>
