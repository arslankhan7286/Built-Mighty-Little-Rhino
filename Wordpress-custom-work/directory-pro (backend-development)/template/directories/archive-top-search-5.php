<?php
	wp_enqueue_script("jquery");
	wp_enqueue_style('iv_property-style-111',wp_iv_directories_URLPATH .'admin/files/css/slider-search.css');
	wp_enqueue_style('epdirpro-stylejqueryUI-666', wp_iv_directories_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	
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
	$directory_url=get_option('_iv_directory_url');
	if($directory_url==""){$directory_url='directories';}
	$current_post_type=$directory_url;
	if ( is_front_page() ) {
		$form_action='action='.get_post_type_archive_link($current_post_type).'';
		}else{
		if(!isset($form_action)){
			$form_action='';
		}
	}
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>		
<form method="POST" role="form" <?php echo esc_html($form_action);?> >
	<div class="row px-0 m-0">
		<div class="form-group col-sm-12 mt-4 mt-md-5 px-0">
			<div class="inner-addon left-addon mx-0 d-flex align-items-center">
				<span class="glyphicon"><i class="fas fa-search"></i></span>
				<input type="text"  value="<?php echo esc_html($dirsearch);?>" class="" id="dirsearch" name="dirsearch" placeholder="<?php esc_html_e('Search','ivdirectories');?>"/>
				<input type="hidden"  value="<?php echo esc_html($dirsearchtype);?>"  id="dirsearchtype" name="dirsearchtype"/>
				<?php
					$pos = $main_class->get_unique_keyword_values('all',$current_post_type);
					$locations = $main_class->get_unique_location_values('all',$current_post_type);
				?>
			</div>
		</div>
		<div class="form-group col-sm-12  px-0">
			<div class="inner-addon right-addon d-flex align-items-center">
				<span class="glyphicon"><i class="fas fa-map-marker-alt"></i></span>
				<input type="text" class="" value="<?php echo esc_html($location);?>" placeholder="<?php  esc_html_e('Location','ivdirectories');?>" id="location" name="location"  />
				<input type="hidden"  value="<?php echo esc_html($locationtype);?>"  id="locationtype" name="locationtype"/>
			</div>
		</div>
	</div>
	<input id="submitbtn" type="submit" name="top-search" value="<?php  esc_html_e('Search','ivdirectories');?>" class="btn btn-block">
</form>
					
		
<?php
	$pos3 = $main_class->get_unique_keyword_values('all',$directory_url);
	$locations3 = $main_class->get_unique_location_values('all',$directory_url);
?>
<script>
	jQuery( function() {
		jQuery.widget( "custom.catcomplete", jQuery.ui.autocomplete, {
			_create: function() {
				this._super();
				this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
			},
			_renderMenu: function( ul, items ) {
				var that = this,
				currentCategory = "";
				jQuery.each( items, function( index, item ) {
					var li;
					if ( item.category != currentCategory ) {
						ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
						currentCategory = item.category;
					}
					li = that._renderItemData( ul, item );
					if ( item.category ) {
						li.attr( "aria-label", item.category + " : " + item.label );
					}
				});
			}
		});
		var data =<?php echo $pos3;?>;
		jQuery( "#dirsearch" ).catcomplete({
		  delay: 0,
		  minLength: 0,
		  source: data,
		  select: function(e, ui) {	
				jQuery( "#dirsearchtype" ).val(ui.item.category);
			}
		});
		var data =<?php echo $locations3;?>;
		jQuery( "#location" ).catcomplete({
		  delay: 0,
		  minLength: 0,
		  source: data,
		  select: function(e, ui) {		
				jQuery( "#locationtype" ).val(ui.item.category);
			}
		});
	} );
</script>