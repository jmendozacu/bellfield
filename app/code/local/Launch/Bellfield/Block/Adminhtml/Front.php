<?php
class Launch_Bellfield_Block_Adminhtml_Front extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_front';
    $this->_blockGroup = 'bellfield';
    $this->_headerText = Mage::helper('bellfield')->__('Front Page Items Manager');
    $this->_addButtonLabel = Mage::helper('bellfield')->__('Add Item');
    parent::__construct();
  }

  protected function _prepareLayout()
  {
      $this->setChild('add_new_button',
          $this->getLayout()->createBlock('adminhtml/widget_button')
          ->setData(array(
              'label'     => Mage::helper('bellfield')->__('Add Item'),
              'onclick'   => "setLocation('".$this->getUrl('*/*/new', array('store' => $this->getStoreId()))."')",
              'class'   => 'add'
          ))
      );

      $this->setChild('grid', $this->getLayout()->createBlock('bellfield/adminhtml_front_grid', 'frontGrid'));
      return parent::_prepareLayout();
  }



}