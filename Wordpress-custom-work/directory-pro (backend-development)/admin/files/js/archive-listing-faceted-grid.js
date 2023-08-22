var count = 0;
document.querySelector(".filter").addEventListener("click", function(){
	if(count===0){
		document.querySelector("#facets").style.display="block";
		count=1;
	}
	else{
		document.querySelector("#facets").style.display="none";
		count=0;
	}
});

var width = document.querySelector('#results').offsetWidth;
console.log(width);
// var clwidth = document.querySelector('.whole-container').clientWidth;
// console.log(clwidth);
var col;
if(width<500){
	col = 'col-lg-10 col-md-6 mx-auto';
}
else if(width>500 && width<600){
	col = 'col-lg-6 col-md-6';
}
else if(width>600 && width<850){
	col='col-lg-6 col-md-6';
}
else{
	col = 'col-lg-4 col-md-6';
}


  jQuery(function(){
          var item_template =
					'<div class="<%= col %>">' +
           '<div class="item">' +
            '<% if (obj.dir_top_img=="yes") {  %><div class="dirpro-list-img">'+'<% if (obj.featured) {  %> <span class="feature-text">'+dirpro_data.featured+'</span><% } %>' +'<a href="<%= obj.link %>">' +
                '<img class="img img-fluid" src="<%= obj.imageURL %>">' +
             '</a>'+
			 '</div><% } %>' +
             '<div class="list-content">' +
                 '<a href="<%= obj.link %>"><h4 class="name"><%= obj.title %></h4></a>' +
                 '<p class="tags">' +
    				 '<i class="fas fa-map-marker-alt"></i> <% if (obj.address) {  %><%= obj.address %> <% } %> ' +
					  '<% if (obj.city) {  %><%= obj.city %> <% } %> ' +
					 '<% if (obj.zipcode) {  %><%= obj.zipcode %> <% } %> ' +
                 '</p>' +
                 '<p class="category">' +
                     '<i class="fas fa-bookmark"></i> <% if (obj.category) {  %> <%= obj.category %><% } %>' +
                 '</p>' +
                 '<% if(obj.review_show >="yes" ){%>  <p class="author-star">' +
                    '<span class="star-icons">' +
						'<% if(obj.avg_review >=.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=1.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=1.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=2.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=2.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=3.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=3.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +
						'<% if(obj.avg_review >=4.75 ){%><i class="fas fa-star off-white"></i> <% }else if(obj.avg_review >=4.1){ %><i class="fas fa-star-half-alt half-off-white"></i> <% }else{ %><i class="far fa-star off-white"></i> <%} %>' +

                    '</span>' +
                 '</p><%}else{ %><p class="blankp"> </p> <%} %>' +
                 '<p class="client-contact">' +
                  '<% if (obj.call_button=="yes") {  %> <span class="number"><span onclick="show_phonenumber(\''+'<%= obj.phone %>'+'\',<%= obj.id %>)" class="call" id="<%= obj.id %>">'+dirpro_data.call+'</span></span><span class="mcall"><a href="tel:<%= obj.phone %>">'+dirpro_data.call+'</a></span> <% } %>' +
                   '<% if (obj.email_button=="yes") {  %><span class="email" onclick="call_popup(<%= obj.id %>)">'+dirpro_data.email+'</span><% } %>' +
                   '<% if (obj.sms_button=="yes") {  %> <span class="sms"><a href="sms:<%= obj.phone %>?&body='+dirpro_data.SMSbody+'">'+dirpro_data.SMS+'</a></span><% } %>' +
                 '</p>' +
             '</div>' +
             '<div class="clearboth"></div>' +
           '</div>'+
           '</div>';
        settings = {
          items            : jQuery.parseJSON(dirpro_data.dirpro_items),
          facets           : jQuery.parseJSON(dirpro_data.facets_json),
          resultSelector   : '#results',
          facetSelector    : '#facets',
          resultTemplate   : item_template,
          paginationCount  : dirpro_data.perpage,
          orderByOptions   :  {'title':dirpro_data.title , 'category': dirpro_data.category, 'RANDOM': dirpro_data.random},
          facetSortOption  : {'continent': ["North America", "South America"]}
        }

        // use them!
        jQuery.facetelize(settings);

      });
function show_phonenumber(phone,id){
	jQuery("#"+id).replaceWith(phone);
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
