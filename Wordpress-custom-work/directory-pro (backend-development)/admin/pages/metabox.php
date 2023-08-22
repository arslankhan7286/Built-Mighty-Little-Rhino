 <div class="bootstrap-wrapper">
 	<div class="dashboard-eplugin container-fluid">
 		<?php	
		global $wpdb, $post;	
		
		// Save action   iv_directories_meta_save  
		//*************************	plugin file *********
			
 		 $iv_directories_approve= get_post_meta( $post->ID,'iv_directories_approve', true );
		 $iv_directories_current_author= $post->post_author;
		 
		 $current_user = wp_get_current_user();
		 $userId=$current_user->ID;
		 if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						
							 
 		?>
 		
 		<div class="row">
 			<div class="col-md-12">
				<?php esc_html_e( 'User ID :', 'iv_directories' )?>
 				<select class="form-control" id="iv_directories_author_id" name="iv_directories_author_id">
 					<?php	
					$query = new WP_User_Query(array(							
							'posts_per_page' => -1,
						));	
					$authors = $query->get_results();
					if (!empty($authors)) {
						 foreach ($authors as $author){	
							$userid=$author->ID;
							echo '<option value="'.$userid.'"'. ($iv_directories_current_author == $userid ? "selected" : "").' >'. $userid.' | '.$author->user_email.' </option>';		
						}					
					}							
 					?> 					
 				</select>
 			</div>  
 			<div class="col-md-12"> <label>
 				<input type="checkbox" name="iv_directories_approve" id="iv_directories_approve" value="yes" <?php echo ($iv_directories_approve=="yes" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Approve', 'iv_directories' )?></strong>
				</label>
 			</div> 
 			
 		</div>	  
 		<?php
			}
 		?>
 		<br/>
		<div class="row">
 			<div class="col-md-12">
				 <label>
				 <?php
				  $dirpro_featured= get_post_meta( $post->ID,'dirpro_featured', true );
				 ?>
 				<input type="checkbox" name="dirpro_featured" id="dirpro_featured" value="featured" <?php echo ($dirpro_featured=="featured" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Featured (display on top)', 'iv_directories' )?></strong>
				</label>
			</div>
		</div>		
			
		
 	</div>
 </div>		
