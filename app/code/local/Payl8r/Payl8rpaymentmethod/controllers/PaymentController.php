<?php

// app/code/local/Payl8r/Payl8rpaymentmethod/controllers/PaymentController.php
class Payl8r_Payl8rpaymentmethod_PaymentController extends Mage_Core_Controller_Front_Action {

  public function gatewayAction() {
    if ($this->getRequest()->get("orderId")) {
      $arr_querystring = array(
        'flag' => 1,
        'orderId' => $this->getRequest()->get("orderId")
      );

      $params = Mage::helper('payl8rpaymentmethod')->prepareUrlParams(array('_query' => $arr_querystring));
      Mage_Core_Controller_Varien_Action::_redirect('payl8rpaymentmethod/payment/response', $params);
    }
  }

  public function redirectAction() {
    $paymentMethod = Mage::getModel('payl8rpaymentmethod/paymentmethod');

    // get current order
    $order = Mage::getModel('sales/order');
    $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
    if (!$orderId) {
      $params = Mage::helper('payl8rpaymentmethod')->prepareUrlParams();
      Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', $params);
      return;
    }
    $order->loadByIncrementId($orderId);

    // get config 
    if ($orderId) {
      $payl8rParams = Mage::helper('payl8rpaymentmethod')->prepareRequest($orderId, $order, $paymentMethod);
    }

    // create block with iframe
    $this->loadLayout();
    $block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'payl8rpaymentmethod', array('template' => 'payl8rpaymentmethod/redirect.phtml'));
    // pass parameters to html
    if ($block) {
      $block->addData($payl8rParams);
    }
    $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');

    // add created block to content container
    $this->getLayout()->getBlock('content')->append($block);

    // remove some blocks from the default layout
    $this->getLayout()->getBlock('header')->unsetChild('topSearch');
    $this->getLayout()->getBlock('header')->unsetChild('topMenu');
    $this->getLayout()->getBlock('header')->unsetChild('topContainer');

    $this->renderLayout();
  }

  public function responseAction() {
    $paymentMethod = Mage::getModel('payl8rpaymentmethod/paymentmethod');
    $publicKey = $paymentMethod->getConfigData('trans_key');

    $response = $this->getRequest()->get('response');

    if ($encrypted_response = base64_decode($response)) {
      if (openssl_public_decrypt($encrypted_response, $json_response, $publicKey)) {
        if ($decoded_response = json_decode($json_response)) {
          if (isset($decoded_response->return_data)) {
            if ($decoded_response->return_data->order_id != '') {
              Mage::helper('payl8rpaymentmethod')->processResponse($decoded_response->return_data);
              echo 'OK';
            }
          }
        }
      }
    }
    return null;
  }

  public function abortAction() {
    $session = Mage::getSingleton('checkout/session');
    $session->setQuoteId($session->getPaypalStandardQuoteId(true));
    if ($session->getLastRealOrderId()) {
      $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
      if ($order->getId()) {
        $order->cancel()->save();
      }
      Mage::helper('paypal/checkout')->restoreQuote();
    }
    $this->_redirect('checkout/cart');
  }

  public function failAction() {
    $session = Mage::getSingleton('checkout/session');
    $session->setQuoteId($session->getPaypalStandardQuoteId(true));
    if ($session->getLastRealOrderId()) {
      $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
      if ($order->getId()) {
        $order->cancel()->save();
      }
      Mage::helper('paypal/checkout')->restoreQuote();
    }
    $this->_redirect('checkout/onepage/failure');
  }

  
}
