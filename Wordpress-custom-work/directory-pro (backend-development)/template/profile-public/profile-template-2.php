<?php
wp_enqueue_style('wp-iv_directories-piblic-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
wp_enqueue_script('iv_directories-piblic-12', wp_iv_directories_URLPATH . 'admin/files/js/bootstrap.min.js');


$display_name='';
$email='';
$user_id=1;
 if(isset($_REQUEST['id'])){	
	   $author_name= sanitize_text_field($_REQUEST['id']);
		$user = get_user_by( 'slug', $author_name );
	if(isset($user->ID)){
		$user_id=$user->ID;
		$display_name=$user->display_name;
		$email=$user->user_email;
	}
  }else{
	  global $current_user;
	   $current_user = wp_get_current_user();
	  $user_id=$current_user->ID;
	  $display_name=$current_user->display_name;
	  $email=$current_user->user_email;
	  if($user_id==0){
		$user_id=1;
	  }
  }	

  $iv_profile_pic_url=get_user_meta($user_id, 'iv_profile_pic_thum',true); 
	wp_enqueue_style('ep-style-font-awesome', wp_iv_directories_URLPATH . 'admin/files/css/all.min.css');
?>

 <meta name="viewport" content="width=device-width, initial-scale=1">

    
<!-- Bootstrap -->
 <div id="profile-template-5" class="bootstrap-wrapper around-separetor">
    <div class="wrapper direc-pub-pro">
      <div class="row">
        <div class="col-md-3 col-sm-3">
          <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet">
              <!-- SIDEBAR USERPIC -->
              <div class="profile-userpic text-center"> 
                  <?php			  	
				  	if($iv_profile_pic_url!=''){ ?>
					 <img src="<?php echo esc_url($iv_profile_pic_url); ?>">
					<?php
					}else{
					 echo'	 <img src="'. wp_iv_directories_URLPATH.'assets/images/Blank-Profile.jpg" class="agent">';
					}
				  	?>  
                      </div>
              <!-- END SIDEBAR USERPIC -->
              <!-- SIDEBAR USER TITLE -->
              <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                   <?php 
				   $name_display=esc_html(get_user_meta($user_id,'first_name',true)).' '.esc_html(get_user_meta($user_id,'last_name',true));
				   echo (trim($name_display)!=""? $name_display : $display_name );?>
                   
                </div>
                <div class="profile-usertitle-job">
                    <?php echo esc_html(get_user_meta($user_id,'occupation',true)); ?>
                </div>
              </div>
             
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet portlet0 light">
              <!-- STAT -->
              
              <!-- END STAT -->
              <div>
                <h4 class="profile-desc-title"><?php esc_html_e('About','ivdirectories'); ?>     <?php 
				   $name_display=esc_html(get_user_meta($user_id,'first_name',true)).' '.esc_html(get_user_meta($user_id,'last_name',true));
				   echo (trim($name_display)!=""? $name_display : esc_html($display_name) );?>
</h4>
                <span class="profile-desc-text"> <?php echo esc_html(get_user_meta($user_id,'description',true)); ?> </span>         
					<?php
					if( get_user_meta($user_id,'hide_phone',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-text">		                   
		                    <i class="fa fa-phone"></i>
					<?php echo 'Phone # :'. esc_html(get_user_meta($user_id,'phone',true)); ?>
						 </div>
					<?php
					}
					if( get_user_meta($user_id,'hide_mobile',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-text">		                   
		                    <i class="fa fa-mobile"></i>
					<?php echo 'Mobile # :'. esc_html(get_user_meta($user_id,'mobile',true)); ?>
						 </div>
					<?php
					}
					
					if( get_user_meta($user_id,'hide_email',true)==''){ ?>
						 <div class="margin-top-20 profile-desc-link"
						 ><a href="mailto:<?php echo esc_html($email); ?>">		                   
		                    <i class="fa fa-envelope"></i>
							<?php echo esc_html($email) ?>
							</a>
						 </div>
					<?php
					}
            ?>
							<div class="margin-top-20 profile-desc-link"><a href="http://<?php  echo esc_url(get_user_meta($user_id,'web_site',true)); ?>">		                   
							<i class="fa fa-globe"></i>
							<?php  echo esc_url(get_user_meta($user_id,'web_site',true));  ?>
							</a>
						 </div>
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-twitter"></i>
                  <a href="http://www.twitter.com/<?php  echo esc_html(get_user_meta($user_id,'twitter',true));  ?>/">@<?php  echo esc_html(get_user_meta($user_id,'twitter',true));  ?></a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-facebook"></i>
                  <a href="http://www.facebook.com/<?php  echo esc_html(get_user_meta($user_id,'facebook',true));  ?>/"><?php  echo esc_html(get_user_meta($user_id,'facebook',true));  ?></a>
                </div>
               
                <div class="margin-top-20 profile-desc-link">
                  <i class="fa fa-google-plus"></i>
                  <a href="http://www.plus.google.com/<?php  echo esc_html(get_user_meta($user_id,'gplus',true));  ?>/"><?php  echo esc_html(get_user_meta($user_id,'gplus',true));  ?></a>
                </div>
              </div>
            </div>
            <!-- END PORTLET MAIN -->
          </div>
          
          </div>
            <div class="col-md-9 col-sm-9">
              <div class="portlet dire-pro">
                  <div class="portlet-title tabbable-line clearfix">
                    <div class="caption caption-md pull-left">
                      <i class="icon-globe theme-font hide"></i>
                      <span class="caption-subject font-blue-madison bold uppercase"><?php esc_html_e('User Post','ivdirectories'); ?> </span>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="tab-content">
                      <!-- PERSONAL INFO TAB -->
                      <div class="tab-pane active" id="tab_1_1">
                        <div class="main row">           
                       <?php
							global $wpdb;
							$iv_post='directories';
							$per_page=9999;
							$row_strat=0;$row_end=$per_page;
							$current_page=0 ;
							if(isset($_REQUEST['cpage']) and $_REQUEST['cpage']!=1 ){   
								$current_page=sanitize_text_field($_REQUEST['cpage']); $row_strat =($current_page-1)*$per_page; 
								$row_end=$per_page;
							}
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type =%s and post_author=%d and post_status IN ('publish') ORDER BY  ID DESC  ",$iv_post,$user_id);
							$authpr_post = $wpdb->get_results($sql);
							$total_post=count($authpr_post);
							
							if($total_post>0){
								$i=0;
								foreach ( $authpr_post as $row )								
								{?>
										<div class="col-md-6 text-left">
											<div class="view view-tenth ">
											<?php 
											if ( get_the_post_thumbnail( $row->ID, 'thumbnail' )!="" ) { 
												 
	
												echo get_the_post_thumbnail( $row->ID, 'medium',array( 'class' => "home-img") );
													}else{ ?>
													<div style="width:300px; height:150px;border:1px solid #EEE"></div>
													 <?php 
													}
												 ?>

												<div class="mask">
														<h4> <?php echo do_shortcode($row->post_title);?></h4>
														<p><a href="<?php echo get_permalink( $row->ID ); ?>"><i class="fa fa-link"></i></a></p>
												</div>
										</div>
													<h3 class="post-onprofile-header text-left"><a href="<?php echo get_permalink( $row->ID ); ?>" class="post-list-header"><?php echo esc_html($row->post_title);?></a></h3>
													<p class="post-onprofile text-left">
													<?php
													 // $content=the_excerpt();
														$content_2 =  do_shortcode($row->post_content);
														
														 echo substr(strip_tags($content_2) ,0,75); ?></p>
														<p class="date">
														<?php esc_html_e('Post on :','ivdirectories'); ?> 
													 <?php echo date('d M Y',strtotime($row->post_date)); ?>
														</p>
												 </div>
												<?php
											 }
										 }                
												?>
								</div>				
							</div>
							<!-- END PERSONAL INFO TAB -->									
					</div>	
				</div>
				</div>
				</div>
</div>
</div>
</div>
  <script>
  (function($){
    jQuery(window).load(function() {
        jQuery('.home-img').find('img').each(function() {
            var imgClass = (this.width / this.height > 1) ? 'wide' : 'tall';
            jQuery(this).addClass(imgClass);
        })    
     
    })
   }); 
  </script>

