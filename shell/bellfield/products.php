<?php


require_once dirname(__FILE__).'/../abstract.php';




class Mage_Shell_Bellfield_Products extends Mage_Shell_Abstract
{

    /**
     * Run script
     *
     */
    public function run()
    {

        
        $import=Mage::getModel("bellfield/import");
        $tabs = $import->gettabsExcel ();
        
        $import->processExcel("product_import_template_new_b2c");
        
        print_r( $import->messagelog);
    
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f products.php -- [options]


  Used to import products from the file datasync/products/products.xlxs

USAGE;
    }
}



$shell = new Mage_Shell_Bellfield_Products();
$shell->run();

