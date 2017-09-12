<?php

class Launch_Bellfield_Model_Mysql4_Postcodes extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('launch/postcodes', 'id');
    }


}