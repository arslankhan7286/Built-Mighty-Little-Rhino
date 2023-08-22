var ajaxurl = dirpro_data.ajaxurl;	
var paged =1;
function wpdirp_loadmore(){ 
	paged = paged+1;
	var ajaxurl = dirpro_data.ajaxurl;
	jQuery('#load-more').hide();
	jQuery('#dirpro_loadmore').show();
	var search_params={
		"action"  : 	"iv_directories_loadmore",	
		"form_data":	jQuery("#dirprosearch").serialize(), 	
		"paged": 			paged,	
		"_wpnonce":  	dirpro_data.dirwpnonce,
	};
	jQuery.ajax({					
		url : ajaxurl,					 
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){ 	
			jQuery("#js-grid-meet-the-team").cubeportfolio('append', response.data);	
			jQuery('#dirpro_loadmore').hide();		
			if(response.loadmore=='hide'){ 
				jQuery('#loadmore_button').html('<h3></h3>'); 
				}else{
				jQuery('#load-more').show();
			}	
		}
	});			
}
function show_phonenumber(phone,id){ 
	console.log(jQuery('#'+id).attr('id'));
	jQuery( "#"+id ).bind( "click", function() {
	});
}
function contact_close(){
	jQuery.colorbox.close();
}
function call_popup(dir_id){ 		
	
	var contactform =dirpro_data.ajaxurl+'?action=iv_directories_contact_popup_listing&dir_id='+dir_id;
	
	jQuery.colorbox({href: contactform,opacity:"0.70",closeButton:false,});
}
function contact_send_message_iv(){	
	var formc = jQuery("#message-pop");
	if (jQuery.trim(jQuery("#email_address",formc).val()) == "" || jQuery.trim(jQuery("#name",formc).val()) == "" || jQuery.trim(jQuery("#message-content",formc).val()) == "") { 
			alert(dirpro_data.message);
		} else {
		var ajaxurl = dirpro_data.ajaxurl;
		var loader_image =  dirpro_data.loading_image;
		jQuery('#update_message_popup').html(loader_image);
		var search_params={
			"action"  : 	"iv_directories_message_send",
			"form_data":	jQuery("#message-pop").serialize(),
			"_wpnonce":  	dirpro_data.dirwpnonce,
		};
		jQuery.ajax({
			url : ajaxurl,
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				jQuery('#update_message_popup').html(response.msg );
				jQuery("#message-pop").trigger('reset');
			}
		});
	}
}