<?php

class Launch_Bellfield_Block_Adminhtml_Front_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('front_form', array('legend'=>Mage::helper('bellfield')->__('Item information')));
     
      
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('subtitle', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Sub Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'subtitle',
      ));
      $fieldset->addField('rollup_title', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Roll Over Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rollup_title',
      ));
      $fieldset->addField('rollup_subtitle', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Roll Over Sub Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'rollup_subtitle',
      ));
      
      
      $fieldset->addField('image', 'file', array(
          'label'     => Mage::helper('bellfield')->__('Image File'),
          'required'  => false,
          'name'      => 'image',
          'after_element_html' => (''!=Mage::registry('bellfield_data')->getData('image')?'<p style="margin-top: 5px"><img src="'.Mage::getBaseUrl('media') . 'front/' . Mage::registry('bellfield_data')->getData('image').'" /><br /><a href="'.$this->getUrl('*/*/*/', array('_current'=>true, 'delete'=>'image')).'">'.Mage::helper('bellfield')->__('Delete Image').'</a></p>':''),
          
	  ));
		
      $fieldset->addField('active', 'select', array(
          'label'     => Mage::helper('bellfield')->__('Status'),
          'name'      => 'active',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('bellfield')->__('Active'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('bellfield')->__('Disabled'),
              ),
          ),
      ));
      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Link'),
          'class'     => 'entry',
          'required'  => false,
          'name'      => 'url',
      ));
      
      $fieldset->addField('section', 'select', array(
          'name'      => 'section',
          'label'     => Mage::helper('brands')->__('Store Section'),
          'title'     => Mage::helper('brands')->__('Store Section'),
          'required'  => true,
          'values'    => array(
              ""=>"Select",
              "bellfield"=>"Kitchens",
              "bellfield-steps"=>"Kitchens Steps",
              "appliances"=>"Appliances",
              
            ),
      ));
      
      $fieldset->addField('order', 'text', array(
          'label'     => Mage::helper('bellfield')->__('Order'),
          'class'     => 'entry',
          'required'  => false,
          'name'      => 'order',
      ));

     
      if ( Mage::getSingleton('adminhtml/session')->getKitchensData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getKitchensData());
          Mage::getSingleton('adminhtml/session')->setKitchensData(null);
      } elseif ( Mage::registry('bellfield_data') ) {
          $form->setValues(Mage::registry('bellfield_data')->getData());
      }
      return parent::_prepareForm();
  }
}