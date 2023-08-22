<?php
wp_enqueue_style('wp-iv_directories-bidding-style-102', wp_iv_directories_URLPATH . 'admin/files/css/colorbox.css');
wp_enqueue_script('wp-iv_directories-bidding-script-103', wp_iv_directories_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
global $wpdb;	
	$directory_url=get_option('_iv_directory_url');					
	if($directory_url==""){$directory_url='directories';}
wp_enqueue_style('wp_iv_directory-style-0A2', wp_iv_directories_URLPATH . 'admin/files/css/jquery.dataTables.css');

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
		$message=esc_html__( 'Deleted Successfully', 'ivdirectories' ) ;
	}

}
wp_enqueue_script('wp-iv_directories-dataTables-script-853', wp_iv_directories_URLPATH . 'admin/files/js/jquery.dataTables.js');
?>  

<div class="profile-content">

<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject">
<?php											
esc_html_e('Who is Interested','ivdirectories')	;	
?></span>
			</div>

		</div>
		
		<div class="portlet-body">
			<div class="tab-content">
			
				<div class="tab-pane active" id="tab_1_1">
<?php




if($message!=''){
echo  '<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'.$message.'.</div>';
}

?>

<div class="">					
<table id="user-data" class="display table" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><?php esc_html_e('User Name','ivdirectories'); ?></th>											
				<th><?php esc_html_e('Email','ivdirectories'); ?></th>											
				<th><?php esc_html_e('Directory','ivdirectories'); ?></th>
				<th> <?php esc_html_e('Contact','ivdirectories'); ?></th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th><?php esc_html_e('User Name','ivdirectories'); ?></th>											
				<th><?php esc_html_e('Email','ivdirectories'); ?></th>											
				<th><?php esc_html_e('Directory','ivdirectories'); ?></th>	
				<th> <?php esc_html_e('Contact','ivdirectories'); ?></th>
			
			</tr>
		</tfoot>

		<tbody>

			<?php	
			$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = %s and post_author='%d' and post_status IN ('publish','pending','draft' )  ",$directory_url,$current_user->ID );	
			
		$authpr_post = $wpdb->get_results($sql);
		 $total_post=count($authpr_post);	
		$iv_redirect_user = get_option( '_iv_directories_profile_public_page');
		$reg_page_user='';
		if($iv_redirect_user!='defult'){ 
			$reg_page_user= get_permalink( $iv_redirect_user) ; 										 
		}	
		if($total_post>0){
			$i=0;
			foreach ( $authpr_post as $row )								
			{		
					$user_list= get_post_meta($row->ID,'_favorites',true);	
					$user_list_arr2 = array();												 
					$user_list_arr = array_filter( explode(",", $user_list), 'strlen' ); 
					$i=0;
					foreach($user_list_arr as $arr){
						if(trim($arr)!=''){
							$user_list_arr2[$i]=$arr;
							$i++;
						}
					}
				if(sizeof($user_list_arr2)>0){	
					
						$args_users = array ('include'  =>$user_list_arr2,);
						// The User Query
						$user_query = new WP_User_Query( $args_users );
						
					if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ) {
																			
						?>
							<tr>
								
								<td><?php $reg_page_u=$reg_page_user.'?&id='.$user->user_login;  echo '<a href="'.esc_url($reg_page_u).'">'. $user->display_name.'</a>'; ?> </td>							 
								<td><?php echo esc_html($user->user_email); ?></td>
								
								<td><?php
									echo '<a href="'.esc_url( get_permalink( $row->ID ) ).'">'.esc_html($row->post_title) .'</a>';
									
									?>
								</td>
								<td>
									<a class='btn btn-primary btn-sm popup-contact' href="<?php echo admin_url('admin-ajax.php').'?action=iv_directories_contact_popup&dir-id='.$row->ID; ?>">
													<?php esc_html_e('Contact','ivdirectories'); ?>		 
									 </a>
								</td>
							</tr>

							<?php	
						}
						
					}
				}		
			}
		}	
			?>
		</tbody>
	</table>
</div>
</div>			 
		</div>
	</div>
</div>
</div>

          <!-- END PROFILE CONTENT -->
<?php
wp_enqueue_script('iv_directory-ar-script-28', wp_iv_directories_URLPATH . 'admin/files/js/interest.js');
wp_localize_script('iv_directory-ar-script-28', 'dirpro', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_iv_directories_URLPATH.'admin/files/images/loader.gif">',
		'wp_iv_directories_URLPATH'		=> wp_iv_directories_URLPATH,
		'current_user_id'	=>get_current_user_id(),	
		'SetImage'		=>esc_html__('Set Image','ivdirectories'),
		'GalleryImages'=>esc_html__('Gallery Images','ivdirectories'),		
		'dirwpnonce'=> wp_create_nonce("myaccount"),
		'permalink'=> get_permalink(),			
		) );

?>
<script>
jQuery(document).ready(function($) {		
		jQuery(".popup-contact").colorbox({transition:"None", width:"650px", height:"415px" ,opacity:"0.70"});
		
})	
</script>