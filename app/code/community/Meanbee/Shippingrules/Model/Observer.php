<?php
/**
 * Meanbee_ShippingRules
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the H&O Commercial License
 * that is bundled with this package in the file LICENSE_HO.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.h-o.nl/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@h-o.com so we can send you a copy immediately.
 *
 * @category    Meanbee
 * @package     Meanbee_ShippingRules
 * @copyright   Copyright © 2013 H&O (http://www.h-o.nl/)
 * @license     H&O Commercial License (http://www.h-o.nl/license)
 * @author      Paul Hachmang – H&O <info@h-o.nl>
 *
 * 
 */
 
class Meanbee_Shippingrules_Model_Observer
{
    public function salesQuoteConfigGetProductAttributes(Varien_Event_Observer $event) {
        /** @var Varien_Object $attributes */
        $attributes = $event->getAttributes();

        $productAttrs = Mage::getResourceModel('catalog/product_attribute_collection');

        $productAttrs->addVisibleFilter();
        $productAttrs->addFieldToFilter('additional_table.is_used_for_promo_rules', array('gt' => 0));
        foreach ($productAttrs as $productAttr) {
        /** $productAttr Mage_Catalog_Model_Resource_Eav_Attribute */
            $attributes[$productAttr->getAttributeCode()] = '';
        }
        return $attributes;
    }
}
