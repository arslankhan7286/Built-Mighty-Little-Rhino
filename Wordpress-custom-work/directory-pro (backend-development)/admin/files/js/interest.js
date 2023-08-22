jQuery(document).ready(function($) {		
		jQuery(".popup-contact").colorbox({transition:"None", width:"650px", height:"415px" ,opacity:"0.70"});
		
})	
jQuery(window).on('load',function(){
	jQuery('#user-data').show();				
	var oTable = jQuery('#user-data').dataTable();
	oTable.fnSort( [ [1,'DESC'] ] );
});