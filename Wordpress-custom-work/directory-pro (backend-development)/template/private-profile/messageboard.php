<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class=""> 
					<?php
						$iv_post = $directory_url; 
						esc_html_e('Contact Message','ivdirectories');	
					?></span>	
			</div>					
		</div>   
		
		<div class="table-responsive listing-table">
			<?php				
				global $wpdb;
					$args = array(
				'post_type' => 'directorypro_message', 
				'post_status' => 'private',
				'posts_per_page'=> '-1',
				'orderby' => 'date',
				'order'   => 'DESC',
				);
						
				$user_to = array(
				'relation' => 'AND',
				array(
				'key'     => 'user_to',
				'value'   => $current_user->ID,
				'compare' => '='
				),
				);			
				$args['meta_query'] = array(
					$user_to,
					);
				$the_query = new WP_Query( $args );
				
				if ( $the_query->have_posts() ) {
					
				?>
				<table  id="message-board" class="display table" cellspacing="0" width="100%">
					<thead>
						<!--<tr class="table-head"> -->
						<tr class="">
							<th><?php  esc_html_e('Date','ivdirectories');?></th>	
							<th><?php  esc_html_e('Message','ivdirectories');?></th>						
							<th><?php  esc_html_e('Actions','ivdirectories');?></th>
						</tr>
					</thead>
					<?php
						$i=0; 
						while ( $the_query->have_posts() ) : $the_query->the_post();					
						$id = get_the_ID();					
														
						?>
						<tr id="messagesmyaccount_<?php echo esc_html(trim($id));?>" >
							<td style=""> 
								<?php  echo get_the_time('d M, Y h:m a', $id); ?>		
							</td>
							<td >
										
										<div class="row">
											<div  class="col-md-2">
												<?php  esc_html_e('Name','ivdirectories');?>
											</div>
											<div  class="col-md-1">:</div>
											<div  class="col-md-9">
												 <?php  echo get_post_meta( $id, 'from_name', true); ?>
											</div>
											
											
										</div>	
										<div class="row margin-top-20">
											<div  class="col-md-2">
												<?php  esc_html_e('Email','ivdirectories');?>
											</div>
											<div  class="col-md-1">:</div>
											<div  class="col-md-3">
												<?php  echo get_post_meta( $id, 'from_email', true); ?>
											</div>
											<?php 
											if(get_post_meta($id,'from_phone',true)!=''){
											?>
											<div  class="col-md-2">
												<?php  esc_html_e('Phone','ivdirectories');?>
											</div>
											<div  class="col-md-1">:</div>
											<div  class="col-md-3">
											 <?php echo esc_attr(get_post_meta($id,'from_phone',true)); ?>
											</div>
											<?php
											}
											?>
										</div>	
										
									
										
										<?php
										if(get_post_meta($id,'dir_url',true)!=''){
										?>
										<div class="row margin-top-20">
											<div  class="col-md-2">
												<?php  esc_html_e('Listing','ivdirectories');?> 
											</div>
											<div  class="col-md-1">:</div>											
											<div  class="col-md-9">											
												 <?php  
												 $allowed_html = wp_kses_allowed_html( 'post' );	
												 echo  wp_kses(get_post_meta( $id, 'dir_url', true) ,$allowed_html );
													 ?>
											</div>
										</div>
										<?php
										}
										?>										
										<div class="row margin-top-20">
											<div  class="col-md-2">
												<?php  esc_html_e('Message','ivdirectories');?>
											</div>
											<div  class="col-md-1">:</div>
											<div  class="col-md-9">
										<?php												
												echo do_shortcode($the_query->post->post_content);
											?>	
											</div>	
										</div>	
								
							</td>	
							<td class="text-center "  align="center">									
								<button class="btn green-haze btn-delete" onclick="delete_message_myaccount('<?php echo esc_attr($id);?>','messagesmyaccount')"><i class="far fa-trash-alt"></i></button>
							</td>
						</tr>
						
												
				<?php
					endwhile;
				}	
				?>
				</table>		
			
		</div>	
	</div>
</div>