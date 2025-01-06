( function( $ ) {
	jQuery(document).ready( function(){
        // CODE FOR CAR GURU INTEGRATION
        if( jQuery(".cd-vehicle-gurus").length > 0 && (typeof cardealer_carguru != 'undefined') ){
            var CarGurus = window.CarGurus || {}; window.CarGurus = CarGurus;
            CarGurus.DealRatingBadge = window.CarGurus.DealRatingBadge || {};
            CarGurus.DealRatingBadge.options = {
                "style": "STYLE1",
                "minRating": cardealer_carguru.carguru_rating,
                "defaultHeight": cardealer_carguru.carguru_height
            };

            var script = document.createElement('script');
            script.src = "https://static.cargurus.com/js/api/en_US/1.0/dealratingbadge.js";
            script.async = true;
            var entry = document.getElementsByTagName('script')[0];
            entry.parentNode.insertBefore(script, entry);

			if ( jQuery("section.product-listing.default .car-item").length > 0 && jQuery('.masonry-main .all-cars-list-arch.masonry').length == 0 ) {
				// Select and loop the container element of the elements you want to equalise
				var highestBox = 0;

				// Reset height of elements
				$( '.car-item' ).height('');

				// Select and loop the elements you want to equalise
				jQuery('.car-item').each(function(){
					// If this box is higher than the cached highest then store it
					if(jQuery(this).height() > highestBox) {
						highestBox = jQuery(this).height();
					}
				});
				// Set the height of all those children to whichever was highest
				if( jQuery("body").hasClass("page-template-sold-cars") || jQuery('.all-cars-list-arch').length > 0 ) {
					jQuery('.car-item').height(highestBox);
				}
			}
        }
    });
} )( jQuery );