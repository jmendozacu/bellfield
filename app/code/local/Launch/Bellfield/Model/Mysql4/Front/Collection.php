<?php

class Launch_Bellfield_Model_Mysql4_Front_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('launch/front');
    }
}