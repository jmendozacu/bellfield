var ConfigurableSwatchesList = {
    swatchesByProduct: {},
    init: function(){
        var that = this;
        jQuery('.configurable-swatch-list li').each(function() {
            var $current_product = jQuery(this).closest('li.item');var image_type  = 'grid_image';
            if($current_product.parent('.products-grid').length > 0){image_type  = 'grid_image';}
            if($current_product.parent('.products-list').length > 0){image_type  = 'list_image';}
            that.initSwatch(this,$current_product,image_type);
			var $swatch = jQuery(this);
    if ($swatch.hasClass('filter-match')) {that.handleSwatchSelect($swatch,$current_product,image_type);
            }
        });
    },
    initSwatch: function(swatch,$product,image_type){
        var that = this;
        var $swatch = jQuery(swatch); var productId;
        if (productId = $swatch.data('product-id')) {
   if (typeof(this.swatchesByProduct[productId]) == 'undefined') {this.swatchesByProduct[productId] = [];
            }
            this.swatchesByProduct[productId].push($swatch);
$swatch.find('a').on('click', function() {that.handleSwatchSelect($swatch,$product,image_type);return false;
           });
        }
    },
    handleSwatchSelect: function($swatch,$product,image_type){
        var productId = $swatch.data('product-id');
        var label; if (label = $swatch.data('option-label')) {
		ConfigurableMediaImages.swapListImageByOption(productId, label,$product,image_type); }
        jQuery.each(this.swatchesByProduct[productId], function(key, $productSwatch) {
		$productSwatch.removeClass('selected');});
        $swatch.addClass('selected');
    }
} ;
jQuery(document).on('configurable-media-images-init', function(){ConfigurableSwatchesList.init();});