<?php

class Inchoo_Shipping_Helper_Data extends
    Mage_Core_Helper_Abstract
{
    const XML_EXPRESS_MAX_WEIGHT = 'carriers/inchoo_shipping/express_max_weight';
    const XML_CUSTOM_SHIPPING_PRICE = 'carriers/inchoo_shipping/shipping_price_custom';

    /**
     * Get max weight of single item for express shipping
     *
     * @return mixed
     */
    public function getExpressMaxWeight()
    {
        return Mage::getStoreConfig(self::XML_EXPRESS_MAX_WEIGHT);
    }
	public function getShippingPriceCustom()
    {
        return Mage::getStoreConfig(self::XML_CUSTOM_SHIPPING_PRICE);
    }
}