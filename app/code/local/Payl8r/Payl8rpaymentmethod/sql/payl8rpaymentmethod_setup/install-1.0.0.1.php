<?php

$installer = $this;
$statusTable = $installer->getTable('sales/order_status');
$statusStateTable = $installer->getTable('sales/order_status_state');

$installer->startSetup();

// add custom payl8r statuses
$installer->getConnection()->insertArray(
  $statusTable, array('status', 'label'), array(
  array('status' => 'payl8r_pending', 'label' => 'Payl8r (Pending)'),
  array('status' => 'payl8r_abandoned', 'label' => 'Payl8r (Abandoned)'),
  array('status' => 'payl8r_declined', 'label' => 'Payl8r (Declined)'),
  array('status' => 'payl8r_accepted', 'label' => 'Payl8r (Accepted)')
  )
);

// assign custom statuses to magento states
$installer->getConnection()->insertArray(
  $statusStateTable, array('status', 'state', 'is_default'), array(
    array(
      'status' => 'payl8r_pending',
      'state' => 'pending_payment',
      'is_defualt' => 1
    ),
    array(
      'status' => 'payl8r_abandoned',
      'state' => 'canceled',
      'is_defualt' => 0
    ),
    array(
      'status' => 'payl8r_declined',
      'state' => 'canceled',
      'is_defualt' => 0
    ),
    array(
      'status' => 'payl8r_accepted',
      'state' => 'processing',
      'is_defualt' => 0
    ),
  )
);

$installer->endSetup();
