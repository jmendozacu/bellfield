<?php
/**
*
*/

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');



$installer->run("

        CREATE TABLE IF NOT EXISTS `{$this->getTable('log')}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `date` datetime DEFAULT NULL,
        `description` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB


"
);



$installer->endSetup();