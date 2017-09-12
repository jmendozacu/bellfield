<?php
/**
*
*/

class Launch_Bellfield_Block_Import extends Mage_Core_Block_Template
{
    
    protected $_product = null;
    
    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }
        return $this->_product;
    }
    
    
}
