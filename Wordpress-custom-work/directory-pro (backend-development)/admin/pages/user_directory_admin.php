<?php
wp_enqueue_style('wp-iv_directories-style-11', wp_iv_directories_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('dataTables', wp_iv_directories_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('dataTables', wp_iv_directories_URLPATH . 'admin/files/js/jquery.dataTables.js');
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<?php
				include('footer.php');
		?>
		<div class="row">
			<div class="col-md-12">				
				<h3 class="page-header" ><?php  esc_html_e('User Setting','ivdirectories')	;?>  <small>  </small> </h3>						
			</div>
		</div>
	<div class="form-group col-md-12 row">
			<table id="user-data" class="display table" width="100%">
				<thead>
					<tr>
					 <th> <?php  esc_html_e('User ID','ivdirectories')	;?> </th>	
					  <th> <?php  esc_html_e('Create Date','ivdirectories')	;?> </th>						 
					  <th> <?php  esc_html_e('User Name','ivdirectories')	;?></th>
					  <th> <?php  esc_html_e('Email','ivdirectories')	;?> </th>
					  <th> <?php  esc_html_e('Expiry Date','ivdirectories')	;?> </th>
					  <th> <?php  esc_html_e('Payment Status','ivdirectories')	;?> </th>							  
					  <th> <?php  esc_html_e('Role','ivdirectories')	;?> </th>
					 
					  <th><?php  esc_html_e('Action','ivdirectories')	;?></th>
					</tr>
				</thead>
				<tbody>
				
	      				
								
				        <?php
				       
				     
						$no=20;	
						 $paged = (isset($_REQUEST['paged'])) ? sanitize_text_field($_REQUEST['paged']) : 1;
						
						if($paged==1){
						  $offset=0;  
						}else {
						   $offset= ($paged-1)*$no;
						}
				        $args = array();
				        $args['number']='99999999';				        
				        $args['orderby']='registered';
				        $args['order']='DESC'; 
				       
				        									
						
				        $user_query = new WP_User_Query( $args );			
						
				        // User Loop
				        if ( ! empty( $user_query->results ) ) {
				        	foreach ( $user_query->results as $user ) {								
								
								?>
									<tr>
									  <td><?php echo $user->ID; ?></td>		
									  <td><?php echo date("d-M-Y h:m:s A" ,strtotime($user->user_registered) ); ?></td>							 
									  <td><?php echo esc_html($user->display_name); ?></td>
									  <td><?php echo esc_html($user->user_email); ?></td>
									  <td><?php
												
											$exp_date= get_user_meta($user->ID, 'iv_directories_exprie_date', true);
											if($exp_date!=''){
												echo date('d-M-Y',strtotime($exp_date));
											}	
											
											?></td>
									  <td>
									  <?php 
										echo get_user_meta($user->ID, 'iv_directories_payment_status', true);
										?>
										</td>	
									  
									  <td><?php
										if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
											foreach ( $user->roles as $role )
												echo ucfirst($role);
										}
										?>
									  </td>
									  
									  <td>		<a class="btn btn-primary btn-xs" href="?page=wp-iv_directories-user_update&id=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Edit','ivdirectories')	;?></a> 
												<a class="btn btn-danger btn-xs" href="<?php echo admin_url().'/users.php'?>"><?php  esc_html_e('Delete','ivdirectories')	;?> </a>
									  </td>
									</tr>
													
						<?php  	
								
							}
						
						} 

					?>
					  </tbody>
				</table>
										
			
			
	</div>	
	</div>
</div>
<script>
	jQuery(function() {
    jQuery('#package_sel').change(function() {
        this.form.submit();
    });
});

jQuery(window).on('load',function(){
	jQuery('#user-data').show();				
	var oTable = jQuery('#user-data').dataTable();
	oTable.fnSort( [ [1,'DESC'] ] );
});	
</script>


