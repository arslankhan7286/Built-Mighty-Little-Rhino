<div class="agent-info__separator mx-5"></div>
<div class="row my-md-5 px-5">
	<div class="row col"> 
				<?php
				if(trim(get_post_meta($id,'event_title',true))!=''){?>
                <?php
				if(get_post_meta($id,'_event_image_id',true)!=''){?>
				<div class="col-md-4"> 
					<img class="img-fluid" src="<?php echo wp_get_attachment_url( get_post_meta($id,'_event_image_id',true) ); ?> " >
			   </div>
                <?php } ?>
               
				<div class="col-md-8">
				<p><?php echo esc_html(get_post_meta($id,'event_title',true)); ?>
				</p>
				<p>
				<?php echo esc_html(get_post_meta($id,'event_detail',true)); ?> 
				</p>				
				</div>
			<?php
				}
			?>			
		
	</div>
</div>