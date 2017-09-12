<?php

class Payl8r_Payl8rpaymentmethod_Helper_Data extends Mage_Core_Helper_Abstract {

  public function getPaymentGatewayUrl() {
    return $this->_getUrl('payl8rpaymentmethod/payment/gateway');
  }

  public function getOrderPlaceRedirectUrl() {
    return $this->_getUrl('payl8rpaymentmethod/payment/redirect');
  }

  public function prepareUrlParams($params = array()) {
    $params['_type'] = Mage_Core_Model_Store::URL_TYPE_LINK;
    if (isset($params['is_secure'])) {
      $params['_secure'] = (bool) $params['is_secure'];
    } elseif (Mage::app()->getStore()->isCurrentlySecure()) {
      $params['_secure'] = true;
    }
    return $params;
  }

  public function prepareRequest( $orderId, $order, $paymentMethod) {
    $test = $paymentMethod->getConfigData('test');
    $username = $paymentMethod->getConfigData('username');
    $publicKey = $paymentMethod->getConfigData('trans_key');

    $abortUrl = $this->_getUrl('payl8rpaymentmethod/payment/abort');
    $failUrl = $this->_getUrl('payl8rpaymentmethod/payment/fail');
    $successUrl = $this->_getUrl('checkout/onepage/success');
    $returnUrl = $this->_getUrl('payl8rpaymentmethod/payment/response');

    $products = [];
    foreach ($order->getAllVisibleItems() as $product) {
      $products[] = $product->getName();
    }
    $billing = $order->getBillingAddress();
    $shipping = $order->getShippingAddress();
    
    $data = array(
      "username" => $username,
      "request_data" => array(
        "return_urls" => array(
          "abort" => str_replace('http:', 'https:', $abortUrl),
          "fail" => str_replace('http:', 'https:', $failUrl),
          "success" => str_replace('http:', 'https:', $successUrl),
          "return_data" => str_replace('http:', 'https:', $returnUrl),
        ),
        "request_type" => "standard_finance_request",
        "test_mode" => (int)$test,
        "order_details" => array(
          "order_id" => $orderId,
          "description" => implode("<br>", $products),
          "currency" => "GBP",
          "total" => floatval($order->getGrandTotal())
        ),
        "customer_details" => array(
          "student" => 0,
          "firstnames" => $order->getCustomerFirstname(),
          "surname" => $order->getCustomerLastname(),
          "email" => $order->getCustomerEmail(),
          "phone" => $billing?$billing->getTelephone():'',
          "address" => $billing?$billing->getStreet(1):'',
          "city" => $billing?$billing->getCity():'',
          "country" => "UK",
          "postcode" => $billing?str_replace(' ', '', $billing->getPostcode()):'',
          "dob" => $order->getCustomerDob(),
        )
      )
    );
    
    $quote = Mage::getModel('sales/quote')->load($order->getQuoteId());    
    if( $shipping &&  !$quote->getShippingAddress()->getSameAsBilling() ) {
      $data["request_data"]["customer_details"]["delivery_name"] = $shipping->getFirstname() . ' ' . $shipping->getLastname();
      $data["request_data"]["customer_details"]["delivery_address"] = $shipping->getStreet(1);
      $data["request_data"]["customer_details"]["delivery_city"] = $shipping->getCity();
      $data["request_data"]["customer_details"]["delivery_postcode"] = $shipping->getPostcode();
      $data["request_data"]["customer_details"]["delivery_country"] = "UK";
    }
    
    $json_data = json_encode($data);
    openssl_public_encrypt($json_data, $crypted, $publicKey);


    return array(
      'rid' => $username,
      'data' => base64_encode($crypted),
      'action' => 'https://payl8r.com/process'
    );
  }

  public function processResponse( $response ) {
    Mage::log( $response, null, 'system.log', true );              
    $order = Mage::getModel('sales/order')->loadByIncrementId($response->order_id);
    switch( $response->status  ) {
      case 'ACCEPTED':
        $order->setStatus( 'payl8r_accepted', true, 'Payment Successful', true );
        $order->save();
        try {
          $order->queueNewOrderEmail();
        } catch (Exception $e) {} 
        break;
      case 'DECLINED':
        $order->setStatus( 'payl8r_declined', true, $response->reason, false );
        $order->save();
        break;
      case 'ABANDONED':
      default:
        $order->setStatus( 'payl8r_abandoned', true , $response->reason, false );
        $order->save();
        break;
    }

    
    Mage::log( $order->getState(), null, 'system.log', true );              

  }
  
  protected function _getUrl($route, $params = array()) {
    return parent::_getUrl($route, $this->prepareUrlParams($params));
  }

}
