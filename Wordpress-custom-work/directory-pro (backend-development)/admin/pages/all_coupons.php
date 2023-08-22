<?php

if(isset($_REQUEST['delete_id']))  { 
	if (current_user_can( 'manage_options' ) ) {
			$post_id=sanitize_text_field($_REQUEST['delete_id']);
			wp_delete_post($post_id);
			delete_post_meta($post_id,true);
			$message=esc_html__("Deleted Successfully",'ivdirectories' );
	}
}
?>
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
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		
		
			<div class="row ">					
				<div class="col-md-12" id="submit-button-holder">					
					<div class="pull-right ">								
						
						<a class="btn btn-info "  href="<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'ivdirectories' );?> </a>
					</div>
				</div>
			</div>
			
			
			
			<div class="row">
			<?php
				include('footer.php');
			?>
				<div class="col-md-12 table-responsive">
					<h3  class="page-header"><?php esc_html_e( 'Coupon List', 'ivdirectories' );?> 
						<small >
							<?php
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") { 
								?>
								<span style="color: #0000FF;">
								<?php  esc_html_e( 'The Coupon Create Successfully', 'ivdirectories' ); ?>
								</span>
							<?php							
							}
							if (isset($message) AND $message <> "") { ?>
								<span style="color: #0000FF;"> 
									<?php echo esc_html($message); ?>
								</span>
							<?php	
							}
							?>
						</small>
					</h3>
					<table class="table table-striped col-md-12">
						<thead >
							<tr>
								
								<th><?php esc_html_e( 'Coupon Code/ Name', 'ivdirectories' );?> </th>
								<th><?php esc_html_e( 'Start Date', 'ivdirectories' );?> </th>
								<th><?php esc_html_e( 'End Date', 'ivdirectories' );?> </th>
								<th><?php esc_html_e( 'Uses Limit', 'ivdirectories' );?> </th>
								<th><?php esc_html_e( 'Amount', 'ivdirectories' );?>  </th>
								<th ><?php esc_html_e( 'Action', 'ivdirectories' );?> </th>
							</tr>
						</thead>
						<tbody>
							<?php
							global $wpdb, $post; $i=0;
							$query = new WP_Query(array(
								'post_type' => 'iv_coupon',
								'posts_per_page' => -1,
							));							
							while ($query->have_posts()) {
								$query->the_post();
								$post_id = get_the_ID();
								echo '<tr>';
									echo '<td>'. esc_html(get_the_title($post_id)).'</td>';
									echo '<td>'. esc_html(get_post_meta($post_id, 'iv_coupon_start_date', true)).'</td>';
									echo '<td>'. esc_html(get_post_meta($post_id, 'iv_coupon_end_date', true)).'</td>';
									echo '<td>'. esc_html(get_post_meta($post_id, 'iv_coupon_limit', true)).' / '.esc_html(get_post_meta($post_id, 'iv_coupon_used', true)).' </td>';
									
									echo '<td>'. esc_html(get_post_meta($post_id, 'iv_coupon_amount', true)).'</td>';
																		
									echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-iv_directories-coupon-update&id='.esc_html($post_id).'"> Edit</a> ';
									echo ' <a href="?page=wp-iv_directories-coupons-form&delete_id='.esc_html($post_id).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this form?\');">Delete</a></td>';										
									
									echo'</tr>';
									
									$i++;	
							}
							?>								
							</tbody>
						</table>
						
						<div class=" col-md-12  bs-callout bs-callout-info">		
					<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment.', 'ivdirectories' );?> 
												
						</div>
. 
					</div>
					
				</div>
				<div class="row">					
					<div class="col-md-12">					
						<div class="">								
							
							<a class="btn btn-info "  href="<?php echo wp_iv_directories_ADMINPATH; ?>admin.php?page=wp-iv_directories-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'ivdirectories' );?> </a>
						</div>
					</div>
				</div>
				<div class="row">
					<br/>	
				</div>
			
				
			</div>
		</div>
