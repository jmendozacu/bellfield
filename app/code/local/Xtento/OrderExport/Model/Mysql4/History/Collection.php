<?php

/**
 * Product:       Xtento_OrderExport (1.8.4)
 * ID:            z5MBfREyIoH/Qp4tKJu7lnd/g9ENXIdX9z9fcLsWfKg=
 * Packaged:      2015-07-14T18:57:47+00:00
 * Last Modified: 2012-12-02T17:53:37+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Mysql4/History/Collection.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Mysql4_History_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('xtento_orderexport/history');
    }
}