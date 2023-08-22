<?php
wp_enqueue_script("jquery");
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-autocomplete');	
wp_enqueue_style('iv-bootstrap-4', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap-4.css');
wp_enqueue_style('iv_property-style-111',wp_iv_directories_URLPATH .'admin/files/css/slider-search.css');
wp_enqueue_style('iv_property-style-148',wp_iv_directories_URLPATH .'admin/files/css/styles.css');


wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');


$dir_style_font=get_option('dir_style_font');
if($dir_style_font==""){$dir_style_font='no';}
if($dir_style_font=='yes'){
	wp_enqueue_style('epdirpro-font-110', wp_iv_directories_URLPATH . 'admin/files/css/quicksand-font.css');

}

global $post,$wpdb;
$directory_url=get_option('_iv_directory_url');
if($directory_url==""){$directory_url='directories';}
$main_class = new wp_iv_directories;

$dirsearch='';
$dirsearchtype='';
$locationtype='';
$location='';
if(isset($_REQUEST['dirsearchtype'])){
	$dirsearch=sanitize_text_field($_REQUEST['dirsearch']);
	$dirsearchtype=sanitize_text_field($_REQUEST['dirsearchtype']);
	$locationtype=sanitize_text_field($_REQUEST['locationtype']);
	$location=sanitize_text_field($_REQUEST['location']);
}


$form_action=get_post_type_archive_link($directory_url);
wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');

?>



<section id="slider-search" style="background: transparent; margin: 0; padding:0;">
  <div class="bootstrap-wrapper" style="background: transparent;">
    <div class="container" style="background: transparent;">
      <div class="row my-0 py-0">
        <div class="col-md-12 my-0 py-0">
          <form class="p-0 m-0" action="<?php echo esc_url($form_action) ; ?>" method="post">
            <div class="form-row" style="line-height: 0px !important;">
                <div class="form-group col-md-4">
                    <div class="inner-addon left-addon mx-0 d-flex align-items-center">
                        <span class="glyphicon"><i class="fas fa-search"></i></span>
                        <input type="text"  value="<?php echo esc_html($dirsearch);?>" class="" id="dirsearch" name="dirsearch" style="height: 40px !important;font-size: 14px !important;" placeholder="<?php esc_html_e('Search','ivdirectories');?>"/>
                        <input type="hidden"  value="<?php echo esc_html($dirsearchtype);?>"  id="dirsearchtype" name="dirsearchtype"/>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <div class="inner-addon right-addon d-flex align-items-center">
                        <span class="glyphicon"><i class="fas fa-map-marker"></i></span>
                        <input type="text" class="" value="<?php echo esc_html($location);?>" style="height: 40px !important;font-size: 14px !important;" placeholder="<?php esc_html_e('Location','ivdirectories');?>" id="location" name="location"  />
                        <input type="hidden"  value="<?php echo esc_html($locationtype);?>"  id="locationtype" name="locationtype"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="line-height: 0px !important;">
                    <button type="submit" id="dirpro_sbtn" class="btn btn-sm btn-block text-center" style="height: 40px !important;font-size: 14px !important;"><?php esc_html_e('Search','ivdirectories');?></button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
wp_enqueue_script('ep-slider-search-script', wp_iv_directories_URLPATH . 'admin/files/js/slider-search.js');
wp_localize_script('ep-slider-search-script', 'slider_data', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),

		) );

?>
