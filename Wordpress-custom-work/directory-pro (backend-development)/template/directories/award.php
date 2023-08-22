<div class="agent-info__separator mx-5"></div>
	<div class="row col mt-5">
	 <?php
	   for($i=0;$i<20;$i++){
		   if(get_post_meta($id,'_award_title_'.$i,true)!='' ){?>	  
			<div class="col-md-4">
				<p>
						<?php
							if(get_post_meta($id,'_award_image_id_'.$i,true)!=''){?>
                <img class="img-fluid" src="<?php echo wp_get_attachment_url( get_post_meta($id,'_award_image_id_'.$i,true) ); ?> " >
                <?php } ?>
				</p>
				</div>
				<div class="col-md-8">
				<p>
				<?php echo esc_html(get_post_meta($id,'_award_title_'.$i,true)); ?>
				</p>
				
				<p>
				 <?php echo esc_html(get_post_meta($id,'_award_year_'.$i,true)); ?>				
				 </p>
				<p>
					<?php echo esc_html(get_post_meta($id,'_award_description_'.$i,true)); ?> 
				</p>
				
				</div>
		<?php	
			}
		}
		  ?>
	</div>
