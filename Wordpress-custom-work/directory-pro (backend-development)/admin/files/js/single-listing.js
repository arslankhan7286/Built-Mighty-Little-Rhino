var ajaxurl = realpro_data.ajaxurl;
var paged =1;


(function($) {
    $.fn.bcSwipe = function(settings) {
    var config = { threshold: 50 };
    if (settings) {
      $.extend(config, settings);
    }

    this.each(function() {
      var stillMoving = false;
      var start;

      if ('ontouchstart' in document.documentElement) {
        this.addEventListener('touchstart', onTouchStart, false);
      }

      function onTouchStart(e) {
        if (e.touches.length == 1) {
          start = e.touches[0].pageX;
          stillMoving = true;
          this.addEventListener('touchmove', onTouchMove, false);
        }
      }

      function onTouchMove(e) {
        if (stillMoving) {
          var x = e.touches[0].pageX;
          var difference = start - x;
          if (Math.abs(difference) >= config.threshold) {
            cancelTouch();
            if (difference > 0) {
              $(this).carousel('next');
            }
            else {
              $(this).carousel('prev');
            }
          }
        }
      }

      function cancelTouch() {
        this.removeEventListener('touchmove', onTouchMove);
        start = null;
        stillMoving = false;
      }
    });

    return this;
    };
    })(jQuery);
    jQuery('#carouselExampleControls').bcSwipe({ threshold: 50 });
    jQuery('#similarPrppertycarousel').bcSwipe({ threshold: 50 });

    //make sticky bulletproof


jQuery('.variable-width').slick({
arrows: true,
dots: false,
infinite: true,

autoplay:realpro_data.autorun,
autoplaySpeed: 2000,
slidesToShow: 1,
centerMode: true,
variableWidth: true,
nextArrow: '.next',
prevArrow: '.previous',
responsive: [{
    breakpoint: 1024,
    settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: false
    }
}, {
    breakpoint: 600,
    settings: {
        slidesToShow: 2,
        slidesToScroll: 2
    }
}, {
    breakpoint: 480,
    settings: {
        slidesToShow: 1,
        slidesToScroll: 1
    }
}]
});
function contact_close(){
	jQuery.colorbox.close();
}
function call_popup_claim(dir_id){ 	
	var contactform =realpro_data.ajaxurl+'?action=iv_directories_claim_popup&dir_id='+dir_id;
	jQuery.colorbox({href: contactform,opacity:"0.70",closeButton:false,});
}
function call_popup(dir_id){ 		
	var contactform =realpro_data.ajaxurl+'?action=iv_directories_contact_popup_listing&dir_id='+dir_id;
	jQuery.colorbox({href: contactform,opacity:"0.70",closeButton:false,});
}
function contact_send_message_iv(){
		var formc = jQuery("#message-pop");
		if (jQuery.trim(jQuery("#email_address",formc).val()) == "") {
                  alert(realpro_data.Please_put_your_message);
        } else {
			var ajaxurl = realpro_data.ajaxurl;
			var loader_image =realpro_data.loading_image;
				jQuery('#update_message_popup').html(loader_image);
				var search_params={
					"action"  : 	"iv_directories_message_send",
					"form_data":	jQuery("#message-pop").serialize(),
					"_wpnonce":  	realpro_data.dirwpnonce,
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
function send_message_claim(){
	var isLogged =realpro_data.current_user_id;
	   if (isLogged=="0") {
                     alert(realpro_data.Please_login);
        } else {
			var form = jQuery("#message-claim");
			if (jQuery.trim(jQuery("#message-content", form).val()) == "") {
                  alert(realpro_data.Please_put_your_message);
			} else {
				var ajaxurl = realpro_data.ajaxurl;
				var loader_image = realpro_data.loading_image;
				jQuery('#update_message_claim').html(loader_image);
				var search_params={
					"action"  : 	"iv_directories_claim_send",
					"form_data":	jQuery("#message-claim").serialize(),
					"_wpnonce":  	realpro_data.dirwpnonce,
				};
				jQuery.ajax({
					url : ajaxurl,
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						jQuery('#update_message_claim').html('   '+response.msg );
						jQuery("#message-claim").trigger('reset');

					}
				});
			}
	   }

	}
function save_favorite(id) {

		  var isLogged =realpro_data.current_user_id;

                if (isLogged=="0") {
                     alert(realpro_data.Please_login);
                } else {

						var ajaxurl = realpro_data.ajaxurl;
						var search_params={
							"action"  : 	"iv_directories_save_favorite",
							"data": "id=" + id,
							"_wpnonce":  	realpro_data.dirwpnonce,
						};

						jQuery.ajax({
							url : ajaxurl,
							dataType : "json",
							type : "post",
							data : search_params,
							success : function(response){
								jQuery("#fav_dir"+id).html('<a style="text-decoration: none;color:#6f9a37;" data-toggle="tooltip" title="'+realpro_data.Added_to_Favorites+'" href="javascript:;" onclick="save_unfavorite('+id+')" ><i class="fas fa-heart " style="color:#6f9a37;"></i></a>');
								jQuery("#fav_title").html(realpro_data.Bookmarked);


							}
						});

				}

    }
	function iv_submit_review(){	

					if (realpro_data.current_user_id=="0") {
							 alert(realpro_data.Please_login);
					} else {
					var form = jQuery("#iv_review_form");
					if (jQuery.trim(jQuery("#review_comment", form).val()) == "") {
						  alert(realpro_data.comment);
					} else {
					 var ajaxurl = realpro_data.ajaxurl;
					   var loader_image = realpro_data.loading_image;
					   jQuery('#rmessage').html(loader_image);
					   var search_params={
						 "action"  :  "iv_directories_save_user_review",
						 "form_data": jQuery("#iv_review_form").serialize(),
						 "_wpnonce":  	realpro_data.dirwpnonce,
					   };
					   jQuery.ajax({
						 url : ajaxurl,
						 dataType : "json",
						 type : "post",
						 data : search_params,
						 success : function(response){
						  jQuery('#rmessage').html('<div class="col-sm-7 alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						  jQuery("#iv_review_form")[0].reset();


						}
					  });
				}
			}

	}	
	function save_unfavorite(id) {
		  var isLogged =realpro_data.current_user_id;

                if (isLogged=="0") {
                     alert(realpro_data.Please_login);
                } else {

						var ajaxurl = realpro_data.ajaxurl;
						var search_params={
							"action"  : 	"iv_directories_save_un_favorite",
							"data": "id=" + id,
							"_wpnonce":  	realpro_data.dirwpnonce,
						};

						jQuery.ajax({
							url : ajaxurl,
							dataType : "json",
							type : "post",
							data : search_params,
							success : function(response){
								jQuery("#fav_dir"+id).html('<a data-toggle="tooltip" style="text-decoration: none;color:#bdc3c7;"  title="'+realpro_data.Add_to_Favorites+'>" href="javascript:;" onclick="save_favorite('+id+')" ><i class="fas fa-heart" style="color:#bdc3c7;"></i></a>');

								jQuery("#fav_title").html(realpro_data.Bookmark);


							}
						});

				}

    }
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&"\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&"\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	return pattern.test(emailAddress);
}
jQuery(function(){
	jQuery('#myModalContact').modal({
	   show:false,
	   backdrop:'static',
	});
	 //now on button click

});

jQuery(function(){
jQuery('#myModalreport').modal({
   show:false,
   backdrop:'static'
});

});

const menubar = document.querySelector("#menubar");
const phoneMenubar = document.querySelector("#phone-menubar");
const topOfNav = menubar.offsetTop;
const topOfPhoneNav = phoneMenubar.offsetTop;

var mq = window.matchMedia( "(max-width: 480px)" );
console.log(topOfNav);

function fixNav(){
	if(window.scrollY >= 60 ){
		menubar.classList.add("fixedTop2");
		phoneMenubar.classList.add("fixedBottom");
	}
	else{
	
	
		menubar.classList.remove("fixedTop2");
		phoneMenubar.classList.remove("fixedBottom");
	}
}

window.addEventListener('scroll', fixNav);
