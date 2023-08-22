	
jQuery(window).on('load',function(){
	if (jQuery(".epinputdate")[0]){	
		jQuery( ".epinputdate" ).datepicker( );
	}
});	
function iv_save_post (){
	tinyMCE.triggerSave();	
	var ajaxurl = dirpro4.ajaxurl;
	var loader_image = dirpro4.loading_image;
				jQuery('#update_message').html(loader_image);
				var search_params={
					"action"  : 	"iv_directories_save_wp_post",	
					"form_data":	jQuery("#new_post").serialize(), 
					"_wpnonce":  	dirpro4.dirwpnonce,
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						if(response.code=='success'){
								var url = dirpro4.permalink+"?&profile=all-post";   						
								jQuery(location).attr('href',url);	
						}
						
						
					}
				});
	
}		 
		 
function iv_update_post (){ 
	tinyMCE.triggerSave();	
	var ajaxurl = dirpro4.ajaxurl;
	var loader_image = dirpro4.loading_image;
				jQuery('#update_message').html(loader_image);
				var search_params={
					"action"  : 	"iv_directories_update_wp_post",	
					"form_data":	jQuery("#edit_post").serialize(), 
					"_wpnonce":  	dirpro4.dirwpnonce,
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						if(response.code=='success'){
								var url = dirpro4.permalink+"?&profile=all-post";    						
								jQuery(location).attr('href',url);	
						}
					
					}
				});
	
	}
function add_day_field(){
	var main_opening_div =jQuery('#day-row1').html(); 
	jQuery('#day_field_div').append('<div class="clearfix"></div><div class=" row form-group" >'+main_opening_div+'</div>');

}
function  remove_post_image	(profile_image_id){
	jQuery('#'+profile_image_id).html('');
	jQuery('#feature_image_id').val(''); 
	jQuery('#post_image_edit').html('<button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Add</button>');  

}
function  remove_event_image	(profile_image_id){
	jQuery('#'+profile_image_id).html('');
	jQuery('#event_image_id').val(''); 
	jQuery('#event_image_edit').html('<button type="button" onclick="event_post_image(\'event_image_div\');"  class="btn btn-xs green-haze">Add</button>');  

}
function  remove_deal_image	(profile_image_id){
	jQuery('#'+profile_image_id).html('');
	jQuery('#deal_image_id').val(''); 
	jQuery('#deal_image_edit').html('<button type="button" onclick="deal_post_image(\'deal_image_div\');"  class="btn btn-xs green-haze">Add</button>');  

}	
 function edit_post_image(profile_image_id){	
				var image_gallery_frame;

              
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: dirpro4.SetImage,
                    button: {
                        text: dirpro4.SetImage,
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {
							jQuery('#'+profile_image_id).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');
							jQuery('#feature_image_id').val(attachment.id ); 
							jQuery('#post_image_edit').html('<button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Edit</button> &nbsp;<button type="button" onclick="remove_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Remove</button>');  
						   
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}
function event_post_image(profile_image_id){	
				var image_gallery_frame;

             
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: dirpro4.SetImage,
                    button: {
                        text: dirpro4.SetImage,
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {
							jQuery('#'+profile_image_id).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');
							jQuery('#event_image_id').val(attachment.id ); 
							jQuery('#event_image_edit').html('<button type="button" onclick="event_post_image(\'event_image_div\');"  class="btn btn-xs green-haze">Edit</button> &nbsp;<button type="button" onclick="remove_event_image(\'event_image_div\');"  class="btn btn-xs green-haze">Remove</button>');  
						   
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}
function deal_post_image(profile_image_id){	
				var image_gallery_frame;

              
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: dirpro4.SetImage,
                    button: {
                        text:dirpro4.SetImage,
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {
							jQuery('#'+profile_image_id).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');
							jQuery('#deal_image_id').val(attachment.id ); 
							jQuery('#deal_image_edit').html('<button type="button" onclick="deal_post_image(\'deal_image_div\');"  class="btn btn-xs green-haze">Edit</button> &nbsp;<button type="button" onclick="remove_deal_image(\'deal_image_div\');"  class="btn btn-xs green-haze">Remove</button>');  
						   
						}
					});
                   
                });               
				image_gallery_frame.open(); 
				
	}			
 function edit_gallery_image(profile_image_id){
				
				var image_gallery_frame;
				var hidden_field_image_ids = jQuery('#gallery_image_ids').val();
               
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: dirpro4.GalleryImages,
                    button: {
                        text: dirpro4.GalleryImages,
                    },
                    multiple: true,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        
                        if ( attachment.id ) {
							jQuery('#'+profile_image_id).append('<div id="gallery_image_div'+attachment.id+'" class="col-md-3"><img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'"><button type="button" onclick="remove_gallery_image(\'gallery_image_div'+attachment.id+'\', '+attachment.id+');"  class="btn btn-xs btn-danger">Remove</button> </div>');
							
							hidden_field_image_ids=hidden_field_image_ids+','+attachment.id ;
							jQuery('#gallery_image_ids').val(hidden_field_image_ids); 
							
							
						   
						}
					});
                   
                });               
				image_gallery_frame.open(); 

 }			

function  remove_gallery_image(img_remove_div,rid){	
	var hidden_field_image_ids = jQuery('#gallery_image_ids').val();	
	hidden_field_image_ids =hidden_field_image_ids.replace(rid, '');	
	jQuery('#'+img_remove_div).remove();
	jQuery('#gallery_image_ids').val(hidden_field_image_ids); 


}	
function remove_old_day(div_id){
	jQuery('#old_days'+div_id).remove();
}
function award_delete(id_delete){
	
	jQuery('#award_delete_'+id_delete).remove();
	
}
function newadd_award_field(){
	var main_award_div =jQuery('#award').html(); 
	jQuery('#awards').append('<div class="clearfix"></div><hr>'+main_award_div+'');
}
function add_award_field(){
	var main_award_div =jQuery('#awardmain').html(); 
	jQuery('#awards').append('<div class="clearfix"></div><hr>'+main_award_div+'');
}
function award_post_image(awardthis){	
				var image_gallery_frame;
           
                image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: dirpro4.SetImage,
                    button: {
                        text:dirpro.SetImage,
                    },
                    multiple: false,
                    displayUserSettings: true,
                });                
                image_gallery_frame.on( 'select', function() {
                    var selection = image_gallery_frame.state().get('selection');
                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();
                        if ( attachment.id ) {		
													
							jQuery(awardthis).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'"><input type="hidden" name="award_image_id[]" id="award_image_id[]" value="'+attachment.id+'">');
							
							
						}
					});                   
                });               
				image_gallery_frame.open(); 				
	}
jQuery(document).ready(function() {
	jQuery("input[name$='contact_source']").click(function() {
		var rvalue = jQuery(this).val();
		
		if(rvalue=='new_value'){jQuery("#new_contact_div" ).show();}
		if(rvalue=='user_info'){jQuery("#new_contact_div" ).hide();}
		
		
	});
});		