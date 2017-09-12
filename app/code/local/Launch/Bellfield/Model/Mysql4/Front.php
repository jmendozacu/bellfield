<?php

class Launch_Bellfield_Model_Mysql4_Front extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('launch/front', 'id');
    }


}