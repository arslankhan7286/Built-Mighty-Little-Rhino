<?php
	$profile_url=get_permalink(); 
	global $current_user;
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$message='';
	if(isset($_GET['delete_id']))  {
		$post_id=sanitize_text_field($_GET['delete_id']);
		$post_edit = get_post($post_id); 
		if($post_edit->post_author==$current_user->ID){
			wp_delete_post($post_id);
			delete_post_meta($post_id,true);
			$message="Deleted Successfully";
		}	
		if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
			wp_delete_post($post_id);
			delete_post_meta($post_id,true);
			$message="Deleted Successfully";
		}	
	}
?>
<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class=""> 
					<?php
						$iv_post = $directory_url; 
						esc_html_e('All Listing','ivdirectories');	
					?></span>	
			</div>					
		</div>   
		<?php
			if($message!=''){
				echo  '<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'.$message.'.</div>';
			}
		?>
		<div class="table-responsive listing-table">
			<?php				
				global $wpdb;
				$per_page=10;$row_strat=0;$row_end=$per_page;
				$current_page=0 ;
				if(isset($_REQUEST['cpage']) and $_REQUEST['cpage']!=1 ){
					$current_page=sanitize_text_field($_REQUEST['cpage']); $row_strat =($current_page-1)*$per_page;
					$row_end=$per_page;
				}
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					$sql="SELECT * FROM $wpdb->posts WHERE post_type IN ('".$iv_post."')  and post_status IN ('publish','pending','draft' )  ORDER BY `ID` DESC";
					}else{
					$sql="SELECT * FROM $wpdb->posts WHERE post_type IN ('".$iv_post."')  and post_author='".$current_user->ID."' and post_status IN ('publish','pending','draft' )  ORDER BY `ID` DESC";
				}	
				$authpr_post = $wpdb->get_results($sql);
				$total_post=count($authpr_post);
				if($total_post>0){
				?>
				<table id="dirallposts" class="display table" cellspacing="0" width="100%">
					<thead>
						<!--<tr class="table-head"> -->
						<tr class="">
							<th><?php  esc_html_e('Title','ivdirectories');?></th>	
							<th><?php  esc_html_e('Date','ivdirectories');?></th>	
							<th><?php  esc_html_e('Expire','ivdirectories');?></th>	
							<th><?php  esc_html_e('Status','ivdirectories');?></th>	
							<th><?php  esc_html_e('View Count','ivdirectories');?></th>	
							<th><?php  esc_html_e('Actions','ivdirectories');?></th>
						</tr>
					</thead>
					<?php
						$i=0; 
						foreach ( $authpr_post as $row )								
						{								
						?>
						<tr>
							<td style=""> 
								<a class="profile-desc-link" href="<?php echo get_permalink($row->ID); ?>" >	
									<?php	
										// Get latlng from address* START********
										$dir_lat=get_post_meta($row->ID,'latitude',true);
										$dir_lng=get_post_meta($row->ID,'longitude',true);
										$address = get_post_meta($row->ID, 'address', true);
										if($address!=''){
											if($dir_lat=='' || $dir_lng==''){
												$latitude='';$longitude='';
												$prepAddr = str_replace(' ','+',$address);
												$geocode=wp_remote_fopen('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
												$output= json_decode($geocode);
												if(isset( $output->results[0]->geometry->location->lat)){
													$latitude = $output->results[0]->geometry->location->lat;
												}
												if(isset($output->results[0]->geometry->location->lng)){
													$longitude = $output->results[0]->geometry->location->lng;
												}												
												if($latitude!=''){
													update_post_meta($row->ID,'latitude',$latitude);
												}
												if($longitude!=''){
													update_post_meta($row->ID,'longitude',$longitude);
												}
											}
										}	
										// Get latlng from address* ENDDDDDD********	
									?>
								<?php echo esc_html($row->post_title); ?></a>
							</td>
							<td  style="font-size:14px">
								<?php echo date('d-M-Y',strtotime($row->post_date)); ?>
							</td>	
							<td style="font-size:14px">
								<?php
									$exp_date= get_user_meta($current_user->ID, 'iv_directories_exprie_date', true);
									if($exp_date!=''){
										$package_id=get_user_meta($current_user->ID,'iv_directories_package_id',true);
										$dir_hide= get_post_meta($package_id, 'iv_directories_package_hide_exp', true);
										if($dir_hide=='yes'){
											echo date('d-M-Y',strtotime($exp_date));
										}
									}
								?>
							</td>
							<td  style="font-size:14px"><?php $post_ststus=get_post_status($row->ID);  esc_html_e($post_ststus,'ivdirectories');  ?></td>
							<td>
								<?php 
								echo get_post_meta($row->ID,'dirpro_views_count',true); ?>
							</td>
							<td >
								<?php				
									$edit_post= $profile_url.'?&profile=post-edit&post-id='.$row->ID;						
								?>											
								<a href="<?php echo esc_url($edit_post); ?>" class="btn btn-xs green-haze" ><?php esc_html_e('Edit','ivdirectories'); ?></a> 										
								<a href="<?php echo esc_url($profile_url).'?&profile=all-post&delete_id='.$row->ID ;?>"  onclick="return confirm('Are you sure to delete this post?');"  class="btn btn-xs btn-danger"><?php esc_html_e('Delete','ivdirectories'); ?>										
								</a></td>
						</tr>
						<?php 
						}
					?>
				</table>										
				<?php
					}else{ 										
				?>
				<table> 
					<tr>
						<td colspan="100%">
							<?php esc_html_e('Currently you have no listings added. Please manage your account from the sidebar on the left.','ivdirectories'); ?>
						</td>
					</tr>
				</table> 
				<?php
				}	
			?>	
		</div>	
	</div>
</div>
<!-- END PROFILE CONTENT -->