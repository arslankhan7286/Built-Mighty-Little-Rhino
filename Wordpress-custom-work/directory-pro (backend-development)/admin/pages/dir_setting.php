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
<?php		
	$new_badge_day=get_option('_iv_new_badge_day');
	$dir_claim_show=get_option('_dir_claim_show');	
	if($dir_claim_show==""){$dir_claim_show='yes';}
	$search_button_show=get_option('_search_button_show');	
	if($search_button_show==""){$search_button_show='yes';}
	$dir_searchbar_show=get_option('_dir_searchbar_show');	
	if($dir_searchbar_show==""){$dir_searchbar_show='yes';}
	$dir_map_show=get_option('_dir_map_show');	
	if($dir_map_show==""){$dir_map_show='no';}
	$dir_social_show=get_option('_dir_social_show');	
	if($dir_social_show==""){$dir_social_show='yes';}
	$dir_contact_show=get_option('_dir_contact_show');	
	if($dir_contact_show==""){$dir_contact_show='yes';}
	$dir_load_listing_all=get_option('_dir_load_listing_all');	
	if($dir_load_listing_all==""){$dir_load_listing_all='yes';}
?>
<h3  class=""><?php esc_html_e('Directory Setting','ivdirectories');  ?><small></small>	</h3>
<form class="form-horizontal" role="form"  name='directory_settings' id='directory_settings'>
	<?php											
		$opt_style=	get_option('_archive_template');
		if($opt_style==''){$opt_style='style-5';}
	?>	
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default listing View','ivdirectories');  ?> <a class="btn btn-info btn-xs " href="<?php echo esc_html( get_post_type_archive_link( 'directories' )) ; ?>" target="blank"><?php esc_html_e('View Page','ivdirectories');  ?></a>
		</label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="option_archive"  value='style-5' <?php echo ($opt_style=='style-5' ? 'checked':'' ); ?> >
				<img src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/listview-selected.png";?>">
				<?php esc_html_e('Left Faceted Search','ivdirectories');  ?>
				
			</label>	
		</div>
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="option_archive" value='style-faceted-grid' <?php echo ($opt_style=='style-faceted-grid' ? 'checked':'' );  ?> > 
				<img src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/gridview.png";?>">
				<?php esc_html_e('Left Faceted Search','ivdirectories');  ?>
				
			</label>
		</div>	
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="option_archive" value='style-4' <?php echo ($opt_style=='style-4' ? 'checked':'' );  ?> >
				<img src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/gridview.png";?>">
				<?php esc_html_e('Top Filter','ivdirectories');  ?>				
			</label>
		</div>
		<div class="col-md-1">	
			<label>											
				<input type="radio"  name="option_archive" value='style-grid-left' <?php echo ($opt_style=='style-grid-left' ? 'checked':'' );  ?> > 
				<img src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/gridview.png";?>">
				<?php esc_html_e('Left Filter','ivdirectories');  ?>
				
			</label>
		</div>
		<div class="col-md-1">	
			<label>											
				<input type="radio"  name="option_archive" value='style-grid-a_to_z' <?php echo ($opt_style=='style-grid-a_to_z' ? 'checked':'' );  ?> > 
				<img src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/gridview.png";?>">
				<?php esc_html_e('With A to Z Filter','ivdirectories');  ?>
			</label>
		</div>	
		<?php
		$directoryprosinglepage=get_option('directoryprosinglepage');
		if($directoryprosinglepage==''){$directoryprosinglepage='plugintemplate';}
		?>
	</div>	
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
							<label >											
								<input type="radio" name="directoryprosinglepage"  value='custompage' <?php echo ($directoryprosinglepage=='custompage' ? 'checked':'' ); ?> >							
								<?php esc_html_e('Your Custom Page','ivdirectories');  ?>							
							</label>
							<?php
							$single_custompag=get_option('listing_single_custompage'); 
								$args = array(
								'child_of'     => 0,
								'sort_order'   => 'ASC',
								'sort_column'  => 'post_title',
								'hierarchical' => 1,															
								'post_type' => 'page'
								);
							?>
							<?php											
							 if ( $pages = get_pages( $args ) ){
								echo "<select id='listing_single_custompage'  name='listing_single_custompage'  class=''>";
								 echo "<option value='' >".esc_html__('Select Your Custom listing Detail Page','ivdirectories')."</option>";
								 
								foreach ( $pages as $page ) {
								  echo "<option value='{$page->ID}' ".($single_custompag==$page->ID ? 'selected':'').">{$page->post_title}</option>";
								}
								echo "</select>";
							  }
							?>
							
						</div>	
					</div>	
			</div>	
	
	<?php											
		

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
	
	
	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing default image','ivdirectories');  ?></label>
		<div class="col-md-2">
			<div id="current_defaultimage">	
				<?php
					if(get_option('default_image_attachment_id')!=''){
						$vip_img= wp_get_attachment_image_src(get_option('default_image_attachment_id'));
						if(isset($vip_img[0])){									
							$vip_image=$vip_img[0] ;
						}
						}else{
						$vip_image=wp_iv_directories_URLPATH."/assets/images/default-directory.jpg";
					}
				?>
				<img style="width:80px;"   src="<?php echo esc_url($vip_image);?>">
			</div>	
		</div>
		<div class="col-md-3">	
			<label>											
				<button type="button" onclick="change_default_image();"  class="btn btn-success btn-xs"><?php esc_html_e('Change Image','ivdirectories');  ?></button>
			</label>
		</div>	
	</div>		
	
	<?php
		 $dir_top_img=get_option('dir_top_img');	
		 if($dir_top_img==""){$dir_top_img='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Archive Listing Image (all listing page)','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_top_img" id="dir_top_img" value='yes' <?php echo ($dir_top_img=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Image','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_top_img" id="dir_top_img" value='no' <?php echo ($dir_top_img=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Image','ivdirectories');  ?>
			</label>
		</div>	
	</div>

	<?php
		$dir_listing_sort=get_option('_dir_listing_sort');
		if($dir_listing_sort==""){$dir_listing_sort='date';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('listings Order','ivdirectories');  ?></label>
		<div class="col-md-1">
			<label>
				<input type="radio" name="dir_listing_sort" id="dir_listing_sort" value='date' <?php echo ($dir_listing_sort=='date' ? 'checked':'' ); ?> ><?php esc_html_e(' New Listing','ivdirectories');  ?>
			</label>
		</div>
		<div class="col-md-1">
			<label>
				<input type="radio" name="dir_listing_sort" id="dir_listing_sort" value='old-date' <?php echo ($dir_listing_sort=='old-date' ? 'checked':'' ); ?> ><?php esc_html_e(' Old Listing','ivdirectories');  ?>
			</label>
		</div>
		<div class="col-md-1">
			<label>
				<input type="radio"  name="dir_listing_sort" id="dir_listing_sort" value='ASC' <?php echo ($dir_listing_sort=='ASC' ? 'checked':'' );  ?> > <?php esc_html_e(' A-Z','ivdirectories');  ?>
			</label>
		</div>
		<div class="col-md-1">
			<label>
				<input type="radio"  name="dir_listing_sort" id="dir_listing_sort" value='DESC' <?php echo ($dir_listing_sort=='DESC' ? 'checked':'' );  ?> > <?php esc_html_e(' Z-A','ivdirectories');  ?>
			</label>
		</div>
		<div class="col-md-1">
			<label>
				<input type="radio"  name="dir_listing_sort" id="dir_listing_sort" value='rand' <?php echo ($dir_listing_sort=='rand' ? 'checked':'' );  ?> > <?php esc_html_e('Random','ivdirectories');  ?>
			</label>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Search Form','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_searchbar_show" id="dir_searchbar_show" value='yes' <?php echo ($dir_searchbar_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Search Form','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_searchbar_show" id="dir_searchbar_show" value='no' <?php echo ($dir_searchbar_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Search Form','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	
	<?php											
		$dir5_review_show=get_option('dir5_review_show');	
		if($dir5_review_show==""){$dir5_review_show='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Review','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir5_review_show" id="dir5_review_show" value='yes' <?php echo ($dir5_review_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Review','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir5_review_show" id="dir5_review_show" value='no' <?php echo ($dir5_review_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Review','ivdirectories');  ?>
			</label>
		</div>	
	</div>	
	<?php
		$dir_style5_call=get_option('dir_style5_call');	
		if($dir_style5_call==""){$dir_style5_call='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Call Button','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_call" id="dir_style5_call" value='yes' <?php echo ($dir_style5_call=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Call Button','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_call" id="dir_style5_call" value='no' <?php echo ($dir_style5_call=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Call Button','ivdirectories');  ?>
			</label>
		</div>	
	</div>	
	<?php
		$dir_style5_email=get_option('dir_style5_email');	
		if($dir_style5_email==""){$dir_style5_email='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Email Button','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_email" id="dir_style5_email" value='yes' <?php echo ($dir_style5_email=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Email Button','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_email" id="dir_style5_email" value='no' <?php echo ($dir_style5_email=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Email Button','ivdirectories');  ?>
			</label>
		</div>	
	</div>		
	<?php
		$dir_style5_sms=get_option('dir_style5_sms');	
		if($dir_style5_sms==""){$dir_style5_sms='yes';}
	?>	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('SMS Button','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style5_sms" id="dir_style5_sms" value='yes' <?php echo ($dir_style5_sms=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show SMS Button','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style5_sms" id="dir_style5_sms" value='no' <?php echo ($dir_style5_sms=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide SMS Button','ivdirectories');  ?>
			</label>
		</div>	
	</div>		
	<div class="form-group row">
		<?php
			$dir_style5_perpage='20';						
			$dir_style5_perpage=get_option('dir_style5_perpage');	
			if($dir_style5_perpage==""){$dir_style5_perpage=20;}
		?>	
		<label  class="col-md-3 control-label">	<?php esc_html_e('Load Per Page','ivdirectories');  ?> </label>					
		<div class="col-md-2">																	
			<input  type="input" name="dir_style5_perpage" id="dir_style5_perpage" value='<?php echo esc_html($dir_style5_perpage); ?>'>
		</div>						
	</div>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Page Background color','ivdirectories');  ?></label>
		<?php
			$dir5_background_color=get_option('dir5_background_color');	
			if($dir5_background_color==""){$dir5_background_color='#EBEBEB';}	
		?>
		<div class="col-md-2">																		
			<input  type="input" name="dir5_background_color"  value='<?php echo esc_html( $dir5_background_color); ?>' >
		</div>
	</div>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Content Background color [List View]','ivdirectories');  ?></label>
		<?php
			$dir5_content_color=get_option('dir5_content_color');	
			if($dir5_content_color==""){$dir5_content_color='#fff';}	
		?>
		<div class="col-md-2">																	
			<input  type="input" name="dir5_content_color" id="dir5_content_color" value='<?php echo esc_html($dir5_content_color); ?>' >							
		</div>
	</div>
	
	<hr>
	<h4>
	<?php esc_html_e('List View','ivdirectories');  ?> </h4>
	Shortcode: [listing_layout_style_5]
	<hr>	
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_cat_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Categories';						
			$dir_facet_title=get_option('dir_facet_cat_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Categories','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> <?php esc_html_e('Left Faceted Search','ivdirectories');  ?></label>
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_cat_show" id="dir_facet_cat_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_cat_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_location_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='City';						
			$dir_facet_title=get_option('dir_facet_location_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('City','ivdirectories'); }	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_location_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_location_title" value="<?php echo esc_html($dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_area_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Area';						
			$dir_facet_title=get_option('dir_facet_area_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Area','ivdirectories'); }	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_area_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_area_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_features_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Features';						
			$dir_facet_title=get_option('dir_facet_features_title');	
			if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_features_show"  value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_features_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_zipcode_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Zipcode';						
			$dir_facet_title=get_option('dir_facet_zipcode_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Zipcode','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_zipcode_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_zipcode_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_state_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='State';						
			$dir_facet_title=get_option('dir_facet_state_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('State','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_state_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_state_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_country_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Country';						
			$dir_facet_title=get_option('dir_facet_country_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Country','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_country_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_country_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<div class="form-group">
		<?php
			$dir_facet_show='yes';						
			$dir_facet_show=get_option('dir_facet_review_show');	
			if($dir_facet_show==""){$dir_facet_show='yes';}							
			$dir_facet_title='Reviews';						
			$dir_facet_title=get_option('dir_facet_review_title');	
			if($dir_facet_title==""){$dir_facet_title=esc_html__('Reviews','ivdirectories');}	
		?>	
		<label  class="col-md-3 control-label"> </label>					
		<div class="col-md-2">																
			<input type="checkbox" name="dir_facet_review_show" value="yes" <?php echo ($dir_facet_show=='yes'? 'checked':'' ); ?> > <?php esc_html_e('Show','ivdirectories');?>
		</div>
		<div class="col-md-5">	
			<input type="text"  name="dir_facet_review_title" value="<?php echo esc_html( $dir_facet_title);?>">
		</div>	
	</div>
	<hr>
	<h4><?php esc_html_e('Grid View','ivdirectories');  ?> </h4>
	<p>Shortcode (Top Filter & Search) : [listing_layout_style_4] </p>
	<p>Shortcode (Left Filter & Search) : [listing_layout_grid_left_filter] </p>
	<p>Shortcode (Left Faceted Search) : [listing_layout_faceted_grid] </p>
	
	<hr>
	<?php
		$active_filter=get_option('active_filter');	
		if($active_filter==""){$active_filter='category';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Style 4 top Filter Type','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="active_filter" id="active_filter" value='category' <?php echo ($active_filter=='category' ? 'checked':'' ); ?> ><?php esc_html_e('Categories Button','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="active_filter" id="active_filter" value='tag' <?php echo ($active_filter=='tag' ? 'checked':'' );  ?> > <?php esc_html_e('Amenities/Tags Button','ivdirectories');  ?>
			</label>
		</div>	
	</div>

	<?php
		$dir_style_4top_filter=get_option('dir_style_4top_filter');	
		if($dir_style_4top_filter==""){$dir_style_4top_filter='yes';}
	?>					
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Grid Style top Filter Bar ','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_style_4top_filter" value='yes' <?php echo ($dir_style_4top_filter=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top Filter Bar','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_style_4top_filter"  value='no' <?php echo ($dir_style_4top_filter=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Filter Bar','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	
	<div class="form-group row">
		<label  class="col-md-2 control-label"> <?php esc_html_e('Grid columns(Only For Grid With Top Filter)','ivdirectories');?></label>	
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1500','ivdirectories');?></label>
		<?php
			$col1500=get_option('grid_col1500');	
			if($col1500==""){$col1500='5';}
		?>
		<input class="col-md-1"type="input" name="grid_col1500"  value="<?php echo esc_html( $col1500); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1100','ivdirectories');?></label>
		<?php
			$grid_col1100=get_option('grid_col1100');	
			if($grid_col1100==""){$grid_col1100='3';}
		?>
		<input class="col-md-1"type="input" name="grid_col1100"  value="<?php echo esc_html( $grid_col1100); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 768','ivdirectories');?></label>
		<?php
			$grid_col768=get_option('grid_col768');	
			if($grid_col768==""){$grid_col768='3';}
		?>
		<input class="col-md-1"type="input" name="grid_col768"  value="<?php echo esc_html( $grid_col768); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 1100','ivdirectories');?></label>
		<?php
			$grid_col480=get_option('grid_col480');	
			if($grid_col480==""){$grid_col480='2';}
		?>
		<input class="col-md-1"type="input" name="grid_col480" value="<?php echo esc_html( $grid_col480); ?>" >
		<label class="col-md-1 control-label"><?php esc_html_e('Width 375','ivdirectories');?></label>
		<?php
			$grid_col375=get_option('grid_col375');	
			if($grid_col375==""){$grid_col375='1';}
		?>
		<input class="col-md-1"type="input" name="grid_col375"  value="<?php echo esc_html( $grid_col375); ?>" >
	</div>
	<hr>
	<h4><?php esc_html_e('Listing Detail Page ','ivdirectories');  ?> </h4>
	<hr>					
	<?php
		$property_top_slider=get_option('directories_top_slider');	
		if($property_top_slider==""){$property_top_slider='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top Slider','ivdirectories');  ?>						
		</label>					
		<div class="col-md-2">
			<label>	
				<img style="width:40px;"   src="<?php echo wp_iv_directories_URLPATH."/admin/files/images/slider-arrow.png";?>"> 	
				<input type="radio" name="directories_top_slider" id="directories_top_slider" value='yes' <?php echo ($property_top_slider=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top slider','ivdirectories');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>									
				<input type="radio"  name="directories_top_slider" id="directories_top_slider" value='no' <?php echo ($property_top_slider=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Slider','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<?php
		$directories_slider_autorun=get_option('directories_slider_autorun');	
		if($directories_slider_autorun==""){$directories_slider_autorun='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top Slider Auto Run','ivdirectories');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="directories_slider_autorun"  value='yes' <?php echo ($directories_slider_autorun=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Slider Auto Run','ivdirectories');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="directories_slider_autorun" value='no' <?php echo ($directories_slider_autorun=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Slider Stop Auto Run','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<?php
		$directories_layout_single=get_option('directories_layout_single');	
		if($directories_layout_single==""){$directories_layout_single='two';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Page layout','ivdirectories');  ?></label>					
		<div class="col-md-2">
			<label>									
				<img style="width:40px;"   src="<?php echo esc_url(wp_iv_directories_URLPATH."/admin/files/images/two-col.png");?>">
				<input type="radio" name="directories_layout_single"  value='two' <?php echo ($directories_layout_single=='two' ? 'checked':'' ); ?> ><?php esc_html_e('Two Columns','ivdirectories');  ?> 
			</label>	
		</div>
		<div class="col-md-2">	
			<label>	
				<img style="width:40px;"   src="<?php echo esc_url(wp_iv_directories_URLPATH."/admin/files/images/one-col.png");?>">							
				<input type="radio"  name="directories_layout_single" value='one' <?php echo ($directories_layout_single=='one' ? 'checked':'' );  ?> > <?php esc_html_e('One Column','ivdirectories');  ?>
			</label>
		</div>
		<div class="col-md-3">	
			<label>	
				<img style="width:50px;"   src="<?php echo esc_url(wp_iv_directories_URLPATH."/admin/files/images/no-slider.png");?>">							
				<input type="radio"  name="directories_layout_single" value='right_feature_image' <?php echo ($directories_layout_single=='right_feature_image' ? 'checked':'' );  ?> > <?php esc_html_e('Feature Image-Top Right','ivdirectories');  ?>
			</label>
		</div>
	</div>
	<?php
		$property_top_4_icons=get_option('directories_top_4_icons');	
		if($property_top_4_icons==""){$property_top_4_icons='yes';}					
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top 4 Icons Set','ivdirectories');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="property_top_4_icons" id="property_top_4_icons" value='yes' <?php echo ($property_top_4_icons=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Top Icons','ivdirectories');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="property_top_4_icons" id="property_top_4_icons" value='no' <?php echo ($property_top_4_icons=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Top Icons','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Top 4 Icons & Text','ivdirectories');  ?><br/> <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank"> <?php esc_html_e('Show Icons[Font Awesome Icon]','ivdirectories');  ?>  </a></label>						
		<div class="col-md-2">
			<?php
				$directory_top_1_title=get_option('directory_top_1_title');	
				if($directory_top_1_title==""){$directory_top_1_title='Call Now';}	
				$directory_top_1_icon=get_option('directory_top_1_icon');	
				if($directory_top_1_icon==""){$directory_top_1_icon='fas fa-phone-volume';}								
			?>	
			<input type="text" name="directory_top_1_title"  value='<?php echo esc_html($directory_top_1_title); ?>'> 
			<input type="text" name="directory_top_1_icon"  value='<?php echo esc_html($directory_top_1_icon); ?>'> 
		</div>	
		<div class="col-md-2">
			<?php
				$directory_top_2_title=get_option('directory_top_2_title');	
				if($directory_top_2_title==""){$directory_top_2_title='Get Directions';}	
				$directory_top_2_icon=get_option('directory_top_2_icon');	
				if($directory_top_2_icon==""){$directory_top_2_icon='fas fa-map-marker';}								
			?>										
			<input type="text" name="directory_top_2_title"  value='<?php echo esc_html($directory_top_2_title); ?>'> 
			<input type="text" name="directory_top_2_icon"  value='<?php echo esc_html($directory_top_2_icon); ?>'> 
		</div>
		<div class="col-md-2">
			<?php
				$directory_top_3_title=get_option('directory_top_3_title');	
				if($directory_top_3_title==""){$directory_top_3_title='Leave a Review';}	
				$directory_top_3_icon=get_option('directory_top_3_icon');	
				if($directory_top_3_icon==""){$directory_top_3_icon='fas fa-comment-alt';}								
			?>										
			<input type="text" name="directory_top_3_title"  value='<?php echo esc_html($directory_top_3_title); ?>'> 
			<input type="text" name="directory_top_3_icon"  value='<?php echo esc_html($directory_top_3_icon); ?>'> 
		</div>
		<div class="col-md-2">
			<?php
				$directory_top_4_title=get_option('directory_top_4_title');	
				if($directory_top_4_title==""){$directory_top_4_title='Bookmark';}
				$directory_top_4_icon=get_option('directory_top_4_icon');	
				if($directory_top_4_icon==""){$directory_top_4_icon='fas fa-heart';}								
			?>										
			<input type="text" name="directory_top_4_title"  value='<?php echo esc_html($directory_top_4_title); ?>'> 
			<input type="text" name="directory_top_4_icon"  value='<?php echo esc_html($directory_top_4_icon); ?>'> 
		</div>
	</div>
	<?php
		$contact_info=get_option('_contact_info');	
		if($contact_info==""){$contact_info='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact info Block','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="contact_info"  value='yes' <?php echo ($contact_info=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Contact info Block','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="contact_info"  value='no' <?php echo ($contact_info=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Contact info Block','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_share_show=get_option('_dir_share_show');	
		if($dir_share_show==""){$dir_share_show='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Social Share','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_share_show" id="dir_share_show" value='yes' <?php echo ($dir_share_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Social Share','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_share_show" id="dir_share_show" value='no' <?php echo ($dir_share_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Social Share','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Us','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_contact_show" id="dir_contact_show" value='yes' <?php echo ($dir_contact_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Contact Us','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_contact_show" id="dir_contact_show" value='no' <?php echo ($dir_contact_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Contact Us','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_contact_form=get_option('dir_contact_form');	
		if($dir_contact_form==""){$dir_contact_form='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Form','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_contact_form" id="dir_contact_form" value='yes' <?php echo ($dir_contact_form=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Default Form','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-7">
			<label>											
				<input type="radio"  name="dir_contact_form" id="dir_contact_form" value='no' <?php echo ($dir_contact_form=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Other "Form Plugin" CF7,WP-Form [Show listing detail page]','ivdirectories');  ?>
			</label>
			<?php
				$dir_form_shortcode=get_option('dir_form_shortcode');	
			?>
			<input type="text" name="dir_form_shortcode" id="dir_form_shortcode" placeholder="shortcode" value='<?php echo esc_html($dir_form_shortcode);?>' >
		</div>	
	</div>
	<?php
		$contact_form=get_option('_contact_form_modal');	
		if($contact_form==""){$contact_form='popup';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Contact Form Type','ivdirectories');  ?></label>					
		<div class="col-md-2">
			<label>												
				<input type="radio" name="contact_form_modal" id="contact_form_modal" value='form' <?php echo ($contact_form=='form' ? 'checked':'' ); ?> ><?php esc_html_e('Show Form','ivdirectories');  ?> 
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="contact_form_modal" id="contact_form_modal" value='popup' <?php echo ($contact_form=='popup' ? 'checked':'' );  ?> > <?php esc_html_e('Popup','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<div class="form-group row">
		<?php											
			$dircontact_form_message=get_option('dircontact_form_message');	
			if($dircontact_form_message==""){$dircontact_form_message='I would like to inquire about your listing. Please contact me at your earliest convenience.';}
		?>	
		<label  class="col-md-3 control-label">	<?php esc_html_e('Contact Message','ivdirectories');  ?> </label>					
		<div class="col-md-9">																	
			<input  class="col-md-10" type="input" name="dircontact_form_message" value='<?php echo esc_html($dircontact_form_message); ?>'>
		</div>						
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Claim','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_claim_show" id="dir_claim_show" value='yes' <?php echo ($dir_claim_show=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show Claim','ivdirectories');  ?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_claim_show" id="dir_claim_show" value='no' <?php echo ($dir_claim_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Claim','ivdirectories');  ?>
			</label>
		</div>	
	</div>
	<?php
		$dir_single_map_show=get_option('directories_dir_map');	
		if($dir_single_map_show==""){$dir_single_map_show='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Map','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_single_map_show" id="dir_single_map_show" value='yes' <?php echo ($dir_single_map_show=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_single_map_show" id="dir_single_map_show" value='no' <?php echo ($dir_single_map_show=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<?php
		$similar_directories=get_option('_similar_directories');	
		if($similar_directories==""){$similar_directories='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Similar Listing','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="similar_directories" value='yes' <?php echo ($similar_directories=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="similar_directories"  value='no' <?php echo ($similar_directories=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<?php
		$dir_opening_time=get_option('dir_opening_time');	
		if($dir_opening_time==""){$dir_opening_time='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Opening Time','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_opening_time" value='yes' <?php echo ($dir_opening_time=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_opening_time"  value='no' <?php echo ($dir_opening_time=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<?php
		$directories_details=get_option('directories_details');	
		if($directories_details==""){$directories_details='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Details','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="directories_details" value='yes' <?php echo ($directories_details=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="directories_details"  value='no' <?php echo ($directories_details=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<?php
		$dir_features=get_option('_dir_features');	
		if($dir_features==""){$dir_features='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Features','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_features" value='yes' <?php echo ($dir_features=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_features"  value='no' <?php echo ($dir_features=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<?php
		$dirpro_videos=get_option('directories_dir_video');	
		if($dirpro_videos==""){$dirpro_videos='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Videos','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dirpro_videos" value='yes' <?php echo ($dirpro_videos=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Show', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dirpro_videos"  value='no' <?php echo ($dirpro_videos=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Hide', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	<hr>
	<h4><?php esc_html_e('Other Options','ivdirectories');  ?> </h4>
	<hr>
	<?php
		$user_can_publish=get_option('user_can_publish');	
		if($user_can_publish==""){$user_can_publish='yes';}	
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Non admin user can publish listing','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="user_can_publish" id="user_can_publish" value='yes' <?php echo ($user_can_publish=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Yes, Non Admin User can Publish', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="user_can_publish" id="user_can_publish" value='no' <?php echo ($user_can_publish=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'No,Admin will approve & publish', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	
	<?php
		$dir_search_redius=get_option('_dir_search_redius');	
		if($dir_search_redius==""){$dir_search_redius='Km';}	
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Directory Radius','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_search_redius" id="dir_search_redius" value='Km' <?php echo ($dir_search_redius=='Km' ? 'checked':'' ); ?> > <?php esc_html_e( 'Km', 'ivdirectories' );?>  
			</label>	
		</div>
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="dir_search_redius" id="dir_search_redius" value='Miles' <?php echo ($dir_search_redius=='Miles' ? 'checked':'' );  ?> > <?php esc_html_e( 'Miles', 'ivdirectories' );?>
			</label>
		</div>	
	</div>
	
	
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Map Zoom','ivdirectories');  ?></label>
		<?php
			$dir_map_zoom=get_option('_dir_map_zoom');	
			if($dir_map_zoom==""){$dir_map_zoom='7';}	
		?>
		<div class="col-md-2">
			<label>												
				<input  type="input" name="dir_map_zoom" class="form-control" id="dir_map_zoom" value='<?php echo esc_html($dir_map_zoom); ?>' >
			</label>	
		</div>
		<div class="col-md-2">
			<label>												
				<?php esc_html_e('20 is more Zoom, 1 is less zoom','ivdirectories');  ?> 
			</label>	
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('VIP image','ivdirectories');  ?></label>
		<div class="col-md-2">
			<div id="current_vip">	
				<?php
					if(get_option('vip_image_attachment_id')!=''){
						$vip_img= wp_get_attachment_image_src(get_option('vip_image_attachment_id'));
						if(isset($vip_img[0])){									
							$vip_image=$vip_img[0] ;
						}
						}else{
						$vip_image=wp_iv_directories_URLPATH."/assets/images/vipicon.png";
					}
				?>
				<img style="width:40px;"   src="<?php echo esc_url($vip_image);?>">
			</div>	
		</div>
		<div class="col-md-3">	
			<label>											
				<button type="button" onclick="change_vip_image();"  class="btn btn-success btn-xs"><?php esc_html_e('Change Image','ivdirectories');  ?></button>
			</label>
		</div>	
	</div>										
	<?php
		$dir_tags=get_option('_dir_tags');	
		if($dir_tags==""){$dir_tags='yes';}						
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Tags','ivdirectories');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="dir_tags" id="dir_tags" value='yes' <?php echo ($dir_tags=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Directories Tags', 'ivdirectories' );?>
			</label>	
		</div>
		<div class="col-md-3">	
			<label>											
				<input type="radio"  name="dir_tags" id="dir_tags" value='no' <?php echo ($dir_tags=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'Post Tags', 'a' );?>    
			</label>
		</div>	
	</div>
	<?php
		$eprecaptcha_api=get_option('eprecaptcha_api');	
		if($eprecaptcha_api==""){$eprecaptcha_api='';}	
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Recaptcha  API Key','ivdirectories');  ?></label>
		<div class="col-md-5">																		
			<input class="col-md-12 form-control" type="text" name="eprecaptcha_api" id="eprecaptcha_api" placeholder="Site Key" value='<?php echo esc_attr($eprecaptcha_api); ?>' >						
		</div>
		<div class="col-md-4">
			<label>												
				<b> <a href="<?php echo esc_url('https://www.google.com/recaptcha/admin/create');?>"> <?php esc_html_e( 'Get your API key here', 'ivdirectories' );?>     </a></b>
			</label>	
		</div>
		<div class="alert alert-primary" role="alert">
			<?php esc_html_e( 'Recaptcha: Please keep it blank if you are checking/using the signup/registration on your local server/host. If you active/put the Recaptcha key on local host then registration will not work.', 'ivdirectories' );?> 
		</div>
	</div>
	<?php
		$dir_map_api=get_option('_dir_map_api');	
		if($dir_map_api==""){$dir_map_api='';}	
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Google Map API Key','ivdirectories');  ?></label>
		<div class="col-md-5">																		
			<input class="col-md-12 form-control" type="text" name="dir_map_api" id="dir_map_api" value='<?php echo esc_html($dir_map_api); ?>' >						
		</div>
		<div class="col-md-4">
			<label>												
				<b> <a href="https://developers.google.com/maps/documentation/geocoding/get-api-key"> <?php esc_html_e( 'Get your API key here ', 'ivdirectories' );?></a></b>
			</label>	
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Cron Job URL','ivdirectories');  ?>						 
		</label>
		<div class="col-md-6">
			<label>												
				<b> <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=iv_directories_cron_job"><?php echo admin_url('admin-ajax.php'); ?>?action=iv_directories_cron_job </a></b>
			</label>	
		</div>
		<div class="col-md-3">
			<?php esc_html_e( 'Cron JOB Detail : Auto Bidding Renew update, Hide Listing( Package setting),Subscription Remainder email.', 'ivdirectories' );?>
		</div>		
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> </label>
		<div class="col-md-8">
			<div id="update_message11"> </div>	
			<button type="button" onclick="return  iv_update_dir_setting();" class="btn btn-success"><?php esc_html_e( 'Update', 'ivdirectories' );?></button>
		</div>
	</div>
</form>
<script>
function change_default_image(){	
		var image_gallery_frame;
		image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
			// Set the title of the modal.
			title: '<?php esc_html_e( 'Image', 'ivdirectories' ); ?>',
			button: {
				text: '<?php esc_html_e( 'Image', 'ivdirectories' ); ?>',
			},
			multiple: false,
			displayUserSettings: true,
		});                
		image_gallery_frame.on( 'select', function() {
			var selection = image_gallery_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.id ) {							
					var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
					var search_params = {
						"action": 	"iv_directories_update_default_image",
						"attachment_id": attachment.id,		
						"_wpnonce": '<?php echo wp_create_nonce("vipimage"); ?>',	
					};
					jQuery.ajax({
						url: ajaxurl,
						dataType: "json",
						type: "post",
						data: search_params,
						success: function(response) {   
							if(response=='success'){					
								jQuery('#current_defaultimage').html('<img width="80px" src="'+attachment.url+'">');                              
							}
						}
					});									
				}
			});
		});               
		image_gallery_frame.open(); 
	}
	function change_vip_image(){	
		var image_gallery_frame;
		image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
			// Set the title of the modal.
			title: '<?php esc_html_e( 'VIP Image', 'ivdirectories' ); ?>',
			button: {
				text: '<?php esc_html_e( 'VIP Image', 'ivdirectories' ); ?>',
			},
			multiple: false,
			displayUserSettings: true,
		});                
		image_gallery_frame.on( 'select', function() {
			var selection = image_gallery_frame.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.id ) {							
					var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
					var search_params = {
						"action": 	"iv_directories_update_vip_image",
						"attachment_id": attachment.id,		
						"_wpnonce": '<?php echo wp_create_nonce("vipimage"); ?>',	
					};
					jQuery.ajax({
						url: ajaxurl,
						dataType: "json",
						type: "post",
						data: search_params,
						success: function(response) {   
							if(response=='success'){					
								jQuery('#current_vip').html('<img width="40px" src="'+attachment.url+'">');                              
							}
						}
					});									
				}
			});
		});               
		image_gallery_frame.open(); 
	}
	function iv_update_dir_setting(){
		var search_params={
			"action"  : 	"iv_update_dir_setting",	
			"form_data":	jQuery("#directory_settings").serialize(), 
			"_wpnonce": '<?php echo wp_create_nonce("dir-settings"); ?>',
		};
		jQuery.ajax({					
			url : ajaxurl,					 
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				jQuery('#update_message11').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
			}
		})
	}
</script>