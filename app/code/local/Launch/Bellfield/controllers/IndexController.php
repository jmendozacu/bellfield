<?php

class Launch_Bellfield_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {

        $import=Mage::getModel("bellfield/import");
        $tabs = $import->gettabsExcel ();
        
        print_r($tabs);
        
        $import->processExcel("product_import_template_new_b2c");
        
       print_r( $import->messagelog);
    
    }


}