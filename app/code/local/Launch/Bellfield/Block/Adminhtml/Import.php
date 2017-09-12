<?php
class Launch_Bellfield_Block_Adminhtml_Import extends Mage_Core_Block_Template
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_import';
    $this->_blockGroup = 'bellfield';
    $this->_headerText = Mage::helper('bellfield')->__('Import');
 //   $this->_addButtonLabel = Mage::helper('kitchens')->__('Add Customer');
    parent::__construct();
  }


  function getProductIds() {

  	$read= Mage::getSingleton('core/resource')->getConnection('core_read');
  	$sql="SELECT entity_id FROM `catalog_product_entity`";

  	$readresult=$read->query($sql);
  	$productlist=array();


  	while ($row = $readresult->fetch() ) {
  		$productlist[]=$row['entity_id'];
  	}
	return $productlist;

  }
    function getCustomercsv() {

		$kitchens=Mage::getModel('bellfield/import');
		$kitchens->loadFile();

		return $kitchens->data;

  }




}