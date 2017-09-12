<?php

class Launch_Bellfield_Block_Adminhtml_Front_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('front_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('launch')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('launch')->__('Item Information'),
          'title'     => Mage::helper('launch')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('launch/adminhtml_front_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}