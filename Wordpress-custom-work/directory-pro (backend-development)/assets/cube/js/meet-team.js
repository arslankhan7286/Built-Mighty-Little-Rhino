(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio

})(jQuery, window, document);

setTimeout(function(){ 
	    jQuery('#js-grid-meet-the-team').cubeportfolio({
        filters: '#js-filters-meet-the-team',
        layoutMode: 'grid',
        defaultFilter: '*',
        animationType: 'quicksand',
        gapHorizontal: 30,
        gapVertical: 30,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1500,
            cols:dirpro_data26.grid_col1500,
        }, {
            width: 1100,
            cols: dirpro_data26.grid_col1100,
        }, {
            width: 768,
            cols: dirpro_data26.grid_col768,
        } 
		, {
            width: 480,
            cols: dirpro_data26.grid_col480,
        }, 
		
		{ width: 375,
            cols: dirpro_data26.grid_col375,
            options: {
                caption: '',
                gapHorizontal: 30,
                gapVertical: 15,
            }
        }],
        caption: 'fadeIn',        
		displayType: 'lazyLoading',
        displayTypeSpeed: 50,
       
		 plugins: {
            sort: {
                element: '#js-sort-juicy-projects',
             }
        },
    });
	

}, 600); 
