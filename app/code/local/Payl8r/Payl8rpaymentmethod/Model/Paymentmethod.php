<?php
// app/code/local/Payl8r/Payl8rpaymentmethod/Model/Paymentmethod.php
class Payl8r_Payl8rpaymentmethod_Model_Paymentmethod extends Mage_Payment_Model_Method_Abstract {
  protected $_code  = 'payl8rpaymentmethod';
  protected $_formBlockType = 'payl8rpaymentmethod/form_payl8rpaymentmethod';
  protected $_infoBlockType = 'payl8rpaymentmethod/info_payl8rpaymentmethod';
 
  public function assignData($data)
  {
    $info = $this->getInfoInstance();
     
    if ($data->getCustomFieldOne())
    {
      $info->setCustomFieldOne($data->getCustomFieldOne());
    }
     
    if ($data->getCustomFieldTwo())
    {
      $info->setCustomFieldTwo($data->getCustomFieldTwo());
    }
 
    return $this;
  }
 
  public function validate()
  {
    parent::validate();
 
    return $this;
  }
  
  public function isAvailable($quote = null) {
    if( $quote ) {
      $billing = $quote->getBillingAddress();
      if($billing->getCountry() !== 'GB') {
        return false;
      }
	  
	  if($quote->getGrandTotal() <= 50) {
        return false;
      }
    }
    return parent::isAvailable($quote);
  }
 
  public function getOrderPlaceRedirectUrl()
  {
    return Mage::helper('payl8rpaymentmethod')->getOrderPlaceRedirectUrl();
  }
}