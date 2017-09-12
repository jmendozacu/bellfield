/**
* @author Amasty Team
* @copyright Copyright (c) 2010-2011 Amasty (http://www.amasty.com)
* @package Amasty_Pgrid
*/

var amDefConf = new Class.create();

amDefConf.prototype = {
    initialize: function()
    {
        
    },
    
    select: function()
    {
        var separatorIndex = window.location.href.indexOf('#');
        if (separatorIndex != -1) return;

        var args = $A(arguments);
        $$('.product-options .super-attribute-select').each(function(select, i){
            if (args[i])
            {
                select.value = args[i];
                spConfig.configureElement(select);

                /*compatibility with magento swatches*/
                var swatchImage = jQuery("#swatch" + args[i] + ' span.swatch-label');
                if(swatchImage) swatchImage.trigger("click");
            }
        });
    }
};