<?php

// app/code/local/Payl8r/Payl8rpaymentmethod/Block/Form/Payl8rpaymentmethod.php
class Payl8r_Payl8rpaymentmethod_Block_Form_Payl8rpaymentmethod extends Mage_Payment_Block_Form {

  protected function _construct() {
    
    $mark = Mage::getConfig()->getBlockClassName('core/template');
    $mark = new $mark;
    $mark->setTemplate('payl8rpaymentmethod/payment/mark.phtml');

    $this->setTemplate('payl8rpaymentmethod/form/payl8rpaymentmethod.phtml')
            ->setMethodTitle('') 
            ->setMethodLabelAfterHtml($mark->toHtml());
    
    return parent::_construct();    
  }

}
