<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Feed
 */

    class Amasty_Feed_Model_Attribute_Compound_Parentid extends Amasty_Feed_Model_Attribute_Compound_Abstract
    {
        function getCompoundData($productData){
            return $productData['parent_id'];
        }
    }