<?php

/**
 * Product:       Xtento_OrderExport (1.8.4)
 * ID:            z5MBfREyIoH/Qp4tKJu7lnd/g9ENXIdX9z9fcLsWfKg=
 * Packaged:      2015-07-14T18:57:47+00:00
 * Last Modified: 2012-12-09T19:18:14+01:00
 * File:          app/code/local/Xtento/OrderExport/Block/Adminhtml/Destination/Edit/Tab/Type/Sftp.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Block_Adminhtml_Destination_Edit_Tab_Type_Sftp extends Xtento_OrderExport_Block_Adminhtml_Destination_Edit_Tab_Type_Ftp
{
    // SFTP Configuration
    public function getFields($form, $type = 'FTP')
    {
        parent::getFields($form, 'SFTP');
    }
}