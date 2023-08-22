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

</style>
<?php			
global $current_user;
$ii=1;
$directory_url=get_option('_iv_directory_url');					
if($directory_url==""){$directory_url='directories';}
			
?>	
	<div class="row">
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class=""><?php esc_html_e('Demo Import','ivdirectories');?> </h3>
                </div>
                <div class="panel-body">
						
							<div class="progress">
							  <div id="dynamic" class=" progress-bar progress-bar-success progress-bar-striped active " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								<span id="current-progress"></span>
							  </div>
							</div>
						
						<div class="row">
						<div class="col-md-4"></div>
							<div class="col-md-4 " id="cptlink12" style="display: none;"> <a  class="btn btn-info " href="<?php echo get_post_type_archive_link( $directory_url) ; ?>" target="_blank"><?php esc_html_e('View All Listing','ivdirectories');?>  </a>
							</div>
						<div class="col-md-4"></div>	
						</div>	
						<div class="row" id="importbutton">						
							<div class="col-md-12 "> 
							<center>
							<button type="button" onclick="return  iv_import_medo();" class="btn btn-success"><?php esc_html_e('Import Demo Listing','ivdirectories');?> </button>
							</center>
							</div>
						</div>
						
						
						
						<script>							
						 var current_progress = 0;	
						function iv_import_medo(){
									 var interval = setInterval(function() {
										  current_progress += 10;
										  jQuery("#dynamic")
										  .css("width", current_progress + "%")
										  .attr("aria-valuenow", current_progress)
										  .text(current_progress + "% Complete");
										  if (current_progress >= 90)
											  clearInterval(interval);
									  }, 1000);
							
							var search_params={
									"action"  : "iv_directories_import_data",
									"_wpnonce": '<?php echo wp_create_nonce("demo-import"); ?>',
									 
								};
								jQuery.ajax({					
									url : ajaxurl,					 
									dataType : "json",
									type : "post",
									data : search_params,
									success : function(response){
										
										  current_progress = 90;
										  jQuery("#dynamic")
										  .css("width", current_progress + "%")
										  .attr("aria-valuenow", current_progress)
										  .text(current_progress + "% Complete");
										  jQuery('#cptlink12').show(1000);
										  jQuery('#importbutton').hide(500); 
									}
								})

							}
						</script>	
							
							
                </div>
           
		   </div>
        </div>
		
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><?php esc_html_e('Importing CSV Data ','ivdirectories');?></h3>                    
                </div>
                <div class="panel-body">
                    <div class="tab-content">
							<?php
							 include('csv-import.php');
							?>
							
						
                    </div>
                </div>
            </div>
        </div>
	<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 ><?php esc_html_e('Some Important shortcode','ivdirectories');?>
					<a class="btn btn-info btn-xs" href="http://help.eplug-ins.com/dirprodoc/#all-shortcode" target="_blank"><?php esc_html_e('All Shortcodes','ivdirectories');?>  </a>
					</h3> 
						
                </div>
                <div class="panel-body">
					<div class="tab-content">
							<div class="row">
									<div class="col-md-6">										
									<?php esc_html_e( 'Listing Filter ( you can use any parameter e.g. [listing_filter ] )', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">	
										[listing_filter  background_color="#EFEFEF" post_limit="3"]
									</div>
								</div>
									<hr/>


								<div class="row">
									<div class="col-md-6">										
									<?php esc_html_e( 'Featured Listing', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">	
										[directorypro_featured]
										<hr/>
										[directorypro_featured post_limit='3' category='test']
										</br> It will display 3 feature listingd of the "test" category(if any).
										<hr/>
										<br/>
										
										[directorypro_featured post_ids='1,2,6,9' ]
										</br> It will display the ID(s) of the listing only.
									</div>
								</div>
								

								<hr/>
								<div class="row">
									<div class="col-md-6">										
									<?php esc_html_e( 'Listing city [directorypro_cities] )', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">	
										[directorypro_cities cities="london,new york,FLORIDA,California"]
									</div>
								</div>
									<hr/>
								<div class="row">
									<div class="col-md-6">										
									<?php esc_html_e( 'Listing Categories [directorypro_categories] )', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">	
										[directorypro_categories]
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">										
									<?php esc_html_e( 'Listing Category Tree (With Sub Category)', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">	
										[directorypro_category_tree]
									</div>
								</div>


									
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									<?php esc_html_e( 'Search bar(You can use without slider too)', 'ivdirectories' );?>
									  
									</div>
										<div class="col-md-6">	
										[slider_search]
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									<?php esc_html_e( 'Listing Carousel', 'ivdirectories' );?>
									 
									</div>
										<div class="col-md-6">	
										[listing_carousel background_color='#EFEFEF' post_limit="10"]
									</div>
								</div>	
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									<?php esc_html_e( 'All Listings', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">
										[listing_layout_style_5 main_background_color="#EBEBEB" text_background_color="#fff" ]	
										<br/><br/>
										
										<p>List Left Faceted Search : [listing_layout_style_5] </p>
										<p>Top Filter & Search : [listing_layout_style_4] </p>
										<p>Grid Left Filter & Search : [listing_layout_grid_left_filter] </p>
										<p>Grid Left Faceted Search : [listing_layout_faceted_grid] </p>
										<p>Grid With Top A to Z Filter : [listing_layout_grid_a_to_z_filter] </p>
										
									</div>
								</div>	
								<hr/>
								<div class="row">
									<div class="col-md-6">	
									<?php esc_html_e( 'Listing Detail Page', 'ivdirectories' );?>
									</div>
										<div class="col-md-6">
										[listing_detail]	
										<br/><br/>
										
										<p>Steps :</p>
										<p>1)Create a page and add the shortcode [listing_detail] in page content section</p>
										<p>2)Set the page as the pisting detail template from Wp Dashboard -> Directory Pro -> Settings -> Settings -> Listing Detail Page -> Set your new page(1).  </p>										
										
									</div>
								</div>
								
								
					</div>			
                </div>
            </div>
        </div>			
		<div class="col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><?php esc_html_e('Home Page Content','ivdirectories');?></h3>  
						<small><?php esc_html_e('Create a full width page and paste the code','ivdirectories');?> </small>
						<p><a class="btn btn-info btn-xs" href="<?php echo  wp_iv_directories_URLPATH; ?>assets/directory-pro-slider.zip" download ><?php esc_html_e('Download & import the top Revolution Slider','ivdirectories');?>  </a> </p>
						
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                       <code>
					    [rev_slider alias="directory-pro-slider"][/rev_slider]  

						&nbsp;
						<h2 style="text-align: center;">Recent Listing</h2>
						&nbsp;
						<p style="text-align: center;">[listing_carousel post_limit="10"]</p>

						<h2 style="text-align: center;">Listing in New York</h2>
						&nbsp;
						<p style="text-align: center;">[listing_filter  post_limit="3"]</p>

						<h2 style="text-align: center;">Find a Listing That Fits Your Comfort</h2>
						<p style="text-align: center;">[directorypro_categories slugs="hotel,food" post_limit="3"]</p>

						<h2 style="text-align: center;">Browse Listings in these Cities</h2>						
						<p style="text-align: center;">[directorypro_cities cities="london,new york,FLORIDA,California"]</p>
												
                       </code>
                    </div>
                </div>
            </div>
        </div>
		
		
	</div>



			
		

