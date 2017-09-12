<?php

/**
 * eGlobe IT Solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@eglobeits.com so we can send you a copy immediately.
 */

/**
 * Free payment information block
 *
 * @category    Egits
 * @package     Egits_AdminPayment
 * @copyright   Copyright (c) 2015 Egits Technologies Pvt Ltd (http://www.eglobeits.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      eGlobe Magento Team <info@eglobeits.com>
 */

class Egits_AdminPayment_Model_Method_Free extends Mage_Payment_Model_Method_Abstract
{
    /**
     * XML Pathes for configuration constants
     */

    const XML_PATH_PAYMENT_FREE_ACTIVE = 'payment/adminpayment/active';
    const XML_PATH_PAYMENT_FREE_ORDER_STATUS = 'payment/adminpayment/order_status';
    const XML_PATH_PAYMENT_FREE_PAYMENT_ACTION = 'payment/adminpayment/payment_action';

    /**
     * The payment method will be available only for admin
     * @var boolean
     */
    protected $_canUseCheckout = false;

    /**
     * Payment code name
     *
     * @var string
     */
    protected $_code = 'adminpayment';

    /**
     * Check whether method is available
     *
     * @param Mage_Sales_Model_Quote $quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        return parent::isAvailable();
    }

}
