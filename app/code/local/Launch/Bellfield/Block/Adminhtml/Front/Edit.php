<?php

class Launch_Bellfield_Block_Adminhtml_Front_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'launch';
        $this->_controller = 'adminhtml_front';
        
        $this->_updateButton('save', 'label', Mage::helper('launch')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('launch')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('front_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'front_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'front_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('front_data') && Mage::registry('front_data')->getId() ) {
            return Mage::helper('launch')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('front_data')->getTitle()));
        } else {
            return Mage::helper('launch')->__('Add Item');
        }
    }
}