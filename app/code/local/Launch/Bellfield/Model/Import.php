<?php
/**
 * @author jonsax
 *
 */
set_include_path(
        Mage::getBaseDir('base') . DS . 'lib' . DS . 'Excel' . PS .
                 get_include_path());
set_include_path(
        Mage::getBaseDir('base') . DS . 'lib' . DS . 'Dropbox' . PS .
                 get_include_path());
echo "<pre>";
echo get_include_path();

require_once "Dropbox/autoload.php";
// use Dropbox as dbx;
use \Dropbox as dbx;

class Launch_Bellfield_Model_Import extends Mage_Core_Model_Abstract
{

    var $feedVersion;

    var $dateCreated;

    var $supplier;

    var $locale;

    var $attributeSets;

    var $uplift = 0;

    var $skip_stock = 0;

    var $fields;

    var $rootCategory = 2;

    var $update_existing = true;

    var $force_images = false;

    var $add_new = true;
    
    var $reload_images = true;

    var $logfile = "ptdimport.log";

    var $debug = true;

    var $catdebug = false;

    var $grouped_only = false;

    var $fix_visibility_allvisible = false;

    var $messagelog = array();

    var $sheets = array();

    var $rowHeaders = array();
    
    var $accessToken="Y71ZsCfSjPAAAAAAAAA2wowx4XRu55gw6tCmBlNNfc_KuJwrnnrV6zZJxRmaXHqk"; 
    
    var $folderMetadata=array();

    public function _construct ()
    {
        $this->datafile = Mage::getBaseDir('base') . DS . 'datasync' . DS .
                 'products' . DS . 'products.xlsx';
        
        $this->attributeSets = array(
                "Default" => 4
        );
        
        /**
         * PHPExcel root directory
         */
        if (! defined('PHPEXCEL_ROOT')) {
            define('PHPEXCEL_ROOT', Mage::getBaseDir('lib') . DS);
            require (PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
        }
    }

    public function setDatafile ($file)
    {
        $this->datafile = $file;
        return $this;
    }

    public function setUpdate ($status)
    {
        $this->update_existing = $status;
        return $this;
    }

    public function setDebug ($status)
    {
        $this->debug = $status;
        return $this;
    }

    public function gettabsExcel ($type = "")
    {
        $inputFileType = '';
        // $inputFileType = 'Excel2007';
        $inputFileType = 'Excel5';
        // $inputFileType = 'Excel2007';
        // $inputFileType = 'Excel2003XML';
        // $inputFileType = 'OOCalc';
        // $inputFileType = 'SYLK';
        // $inputFileType = 'Gnumeric';
        // $inputFileType = 'CSV';
        
        $response = array();
        include 'PHPExcel/IOFactory.php';
        $inputFileType = PHPExcel_IOFactory::identify($this->datafile);
        
        // $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        
        $this->messagelog[] = 'Loading file ' .
                 pathinfo($this->datafile, PATHINFO_BASENAME) .
                 ' using IOFactory with a defined reader type of ' .
                 $this->datafile . '<br />';
        
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        // $objReader = PHPExcel_IOFactory::load($inputFileName); // Remove the
        // createReader line before this
        try {
            $this->sheets = $objReader->listWorksheetNames($this->datafile);
        } catch (Exception $e) {
            
            die($e->getMessage());
        }
        foreach ($this->sheets as $sheetName) {
            $response[] = $sheetName;
        }
        
        return $response;
    }

    public function processExcel (
            $worksheetName = "product_import_template_new_b2c", $start = 0, $max = 0, $sku = false, $console = false)
    {
    
$worksheetName = "Sheet1";

    require_once "Dropbox/AuthBase.php";
        require_once "Dropbox/WebAuthBase.php";
        require_once "Dropbox/AppInfo.php";
        require_once "Dropbox/Host.php";
        require_once "Dropbox/Path.php";
        require_once "Dropbox/WebAuthNoRedirect.php";
        require_once "Dropbox/Client.php";
        require_once "Dropbox/Checker.php";
        require_once "Dropbox/RequestUtil.php";
        require_once "Dropbox/Curl.php";
        require_once "Dropbox/RootCertificates.php";
        require_once "Dropbox/DropboxMetadataHeaderCatcher.php";
        require_once "Dropbox/CurlStreamRelay.php";
        
        require_once "Dropbox/SdkVersion.php";
        require_once "Dropbox/HttpResponse.php";
        require_once "Dropbox/Exception.php";
        require_once "Dropbox/Exception/ProtocolError.php";
        require_once "Dropbox/Exception/BadRequest.php";
        
        $appInfo = new \Dropbox\AppInfo("npk9yphh74os9d6", "mtqlg9jmm9bbz8m");
        $webAuth = new \Dropbox\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");
        
        
        /*
         * $authorizeUrl = $webAuth->start();
         *
         * echo "1. Go to: " . $authorizeUrl . "\n";
         * echo "2. Click \"Allow\" (you might have to log in first).\n";
         * echo "3. Copy the authorization code.\n";
         */
        
        /*
         * list($accessToken, $dropboxUserId) =
         * $webAuth->finish("Y71ZsCfSjPAAAAAAAAA2wfMyIG4wDW8sRd02pfLIlzI");
         * print "Access Token: " . $accessToken . "\n";
         */
        /*
         *
         * hi jonathan
         * Sent on:
         * 7:35 am
         * From:
         * Simon Lomas
         * dropbox logins - simon@stylewise-ltd.co.uk
         * From:
         * Simon Lomas
         * Bellfield123!
         * )
         * Access Token:
         * Y71ZsCfSjPAAAAAAAAA2wowx4XRu55gw6tCmBlNNfc_KuJwrnnrV6zZJxRmaXHqk
         * Array
         * (
         * [referral_link] => https://db.tt/L8e6aYkj
         * [display_name] => Jonathan Saxelby
         * [uid] => 59284256
         * [locale] => en
         * [email_verified] => 1
         * [team] =>
         * [quota_info] => Array
         * (
         * [datastores] => 0
         * [shared] => 4082035918
         * [quota] => 7784628224
         * [normal] => 1866162981
         * )
         *
         * [is_paired] =>
         * [country] => GB
         * [name_details] => Array
         * (
         * [familiar_name] => Jonathan
         * [surname] => Saxelby
         * [given_name] => Jonathan
         * )
         *
         * [email] => jonsax@itsax.com
         * )
         *
         * $accessToken="Y71ZsCfSjPAAAAAAAAA2wowx4XRu55gw6tCmBlNNfc_KuJwrnnrV6zZJxRmaXHqk";
         *
         * $dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");
         * $accountInfo = $dbxClient->getAccountInfo();
         * print_r($accountInfo);
         * $folderMetadata = $dbxClient->getMetadataWithChildren("/ECOM
         * IMAGERY/AW16/MENS");
         * print_r($folderMetadata);
         *
         *
         * die();
         *
         */
        $this->uplift = 0;
        
        if (! file_exists($this->datafile)) {
            $this->messagelog[] = "Source XLSX not loaded - " . $this->datafile;
            return false;
        }
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        
        // $start=157;
        /*
         * if (!in_array($worksheetName,$this->sheets )) { $this->messagelog[] =
         * "Error Sheet Not Found"; return false; }
         */

        $foundSheet = false;
        foreach ($this->sheets as $key => $wsname) {
            
            if ($wsname == $worksheetName) {
                $foundSheet = true;
                $sheetcase = $worksheetName;
            }
        }
        
        if (! $foundSheet) {
            $this->messagelog[] = "Error Sheet Not Found";
            return false;
        }
        
        // $sheetcase = array_search ( $worksheetName, $this->sheets );
        
        if (! $sheetcase) {
            $this->messagelog[] = "Error Sheet Parser Not Found";
            return false;
        }
        
        $this->currentSheet = $sheetcase;
        
        if ($this->delete_missing)
            $skulist = array();
        
        require_once ('PHPExcel/IOFactory.php');
        
        $inputFileType = 'Excel2007';
        // $inputFileType = 'Excel5';
        // $inputFileType = 'Excel2007';
        // $inputFileType = 'Excel2003XML';
        // $inputFileType = 'OOCalc';
        // $inputFileType = 'SYLK';
        // $inputFileType = 'Gnumeric';
        // $inputFileType = 'CSV';
        
        $this->messagelog[] = 'Loading file ' .
                 pathinfo($this->datafile, PATHINFO_BASENAME) .
                 ' using IOFactory with a defined reader type of ' .
                 $this->datafile . '<br />';
        
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        // $objPHPExcel = $objReader->load($inputFileName);
        $worksheetNames = $objReader->listWorksheetNames($this->datafile);
        
        $this->messagelog[] = "<pre>";
        // foreach ( $worksheetNames as $sheetName ) {
        // $this->messagelog[] = "<br>" . $sheetName;
        // }
        
        $objReader->setLoadSheetsOnly($worksheetName);
        $objReader->setReadDataOnly(true);
        
        /**
         * Define how many rows we want to read for each "chunk" *
         */
        $chunkSize = 400;
        /**
         * Create a new Instance of our Read Filter *
         */
        $chunkFilter = new chunkReadFilter();
        
        // $objReader->setReadFilter($chunkFilter)->setContiguous(true);
        
        // $objPHPExcel = $objReader->load ( $inputFileName );
        $objReader->setReadFilter($chunkFilter);
        
        if ($this->debug) {
            echo date('H:i:s') . " Begin Iterate worksheet - $start to 3000";
        }
        $rownumber = 0;
        
        for ($startRow = 1; $startRow <= 3000; $startRow += $chunkSize) :
            
            echo "\r\nread from $startRow for chunk $chunkSize  start from = $start";
            
            // if ( ( $startRow + $chunkSize) < $start ) continue;
            
            $objPHPExcel = false;
            $chunkFilter->setRows($startRow, $chunkSize);
            $objPHPExcel = $objReader->load($this->datafile);
            
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $this->messagelog[] = 'Worksheet - ' . $worksheet->getTitle();
                
                foreach ($worksheet->getRowIterator() as $row) {
                    $this->messagelog[] = ' Row number - ' . $row->getRowIndex();
                    
                    $rownumber ++;
                    
                    if ($rownumber == 1) {
                        
                        // set header columns as fields
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop
                                                                           // all
                                                                           // cells,
                                                                           // even
                                                                           // if
                                                                           // it
                                                                           // is
                                                                           // not
                                                                           // set
                        $colnum = 1;
                        
                        foreach ($cellIterator as $cell) {
                            
                            if (! is_null($cell)) {
                                $value = trim($cell->getCalculatedValue());
                                
                                $this->rowHeaders[$colnum] = $value;
                                $colnum ++;
                            }
                        }
                        
                        continue; // headers first row so continue;
                    }
                    
                    echo "\r\n $rownumber < $start";
                    // echo $row->getRowIndex();
                    /*
                     * if ($start > 0)
                     * if ($rownumber < $start)
                     * continue;
                     */
                    echo "\r\n $rownumber > $max";
                    /*
                     * if ($max > 0)
                     * if ($rownumber > $max)
                     * return;
                     */
                    if ($this->debug)
                        echo "Processing Row $rownumber - " . $row->getRowIndex();
                    
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Loop
                                                                       // all
                                                                       // cells,
                                                                       // even
                                                                       // if it
                                                                       // is not
                                                                       // set
                    
                    $result = $this->iterate($cellIterator);
                    
                    if ($sku) {
                        
                        if ($sku != $result->pobj->getSku()) {
                         echo "bad sku";
                            continue;
                            
                        }
                    }
                    
                    if (strtolower($sku) == "coming soon")
                        continue; // not a
                                      // valid
                                      // sku
                    
                    if ($result->rowvalidproduct) {
                        
                        $this->processItem($result);
                    } else {
                        $this->messagelog[] = "Not Valid";
                    }
                    
                    if ($this->delete_missing) {
                        $skulist[] = $result->pobj->getSku();
                    }
                    
                    unset($cellIterator);
                }
                
                unset($objPHPExcel);
                unset($result);
                /*
                 * if ($this->delete_missing) { // how to find the missing when
                 * we cannot read the whole work book :-( // not tested!!
                 * $sheetcatname = $this->sheets[$this->currentSheet]; // create
                 * categories here as will be the same for all sheet products
                 * $sheetCatId = $this->catExists($sheetcatname,
                 * $this->rootCategory); if (! empty($sheetCatId)) { // need to
                 * check if cat is changed $category =
                 * Mage::getModel("catalog/category")->load($sheetCatId);
                 * $productCollection =
                 * Mage::getResourceModel('catalog/product_collection')->addCategoryFilter($category);
                 * print_r($skulist); foreach ($productCollection as $product) {
                 * if (! in_array($product->getSku(), $skulist)) { echo "missing
                 * " . $product->getSku() . " :: "; } } } }
                 */
            }
        endfor
        ;
        
        // Echo memory peak usage
        $this->messagelog[] = date('H:i:s') . " Peak memory usage: " .
                 (memory_get_peak_usage(true) / 1024 / 1024) . " MB";
        
        $this->messagelog[] = "Done";
    }

    function iterate ($cellIterator)
    {
        $colnum = 1;
        
        $this->pobj = new Varien_Object();
        
        $this->rowvalidproduct = true;
        
        $recipient = array();
        $occasion = array();
        $gifttype = array();
        $personalisation = array();
        
        foreach ($cellIterator as $cell) {
            
            // we get the column from the header rows.
            
            $attribute = $this->rowHeaders[$colnum];
            
            if (! is_null($cell)) {
                $value = trim($cell->getCalculatedValue());
                
                $this->pobj->setData($this->rowHeaders[$colnum], $value);
                
                $colnum ++;
            }
        }
        
        if ($this->pobj->getSku() == "")
            $this->rowvalidproduct = false;
        
        return $this;
    }

    function processItem ()
    {
        $resource = Mage::getSingleton('core/resource');
        
        $item = $this->getPobj();
        
        if (trim($item->getSku()) == "")
            return;
        
         $sku = $item->getSku();
           
        if (!$sku)
            return;
            
        $statuses = Mage_Catalog_Model_Product_Status::getOptionArray();
        $visibilities = Mage_Catalog_Model_Product_Visibility::getOptionArray();
        
        $product = false;
        
        $productid = Mage::getModel('catalog/product')->getIdBySku(
                trim($item->getSku()));
        
        if (! $productid) {
            $time_start = microtime(true);
            
            if (! $this->add_new) {
                $this->addlog(
                        printf(
                                "\r\n\e[01;34mSKip New Sku(%s): %s  Type: %s  -  %s\e[00m", 
                                $this->rowcount, $item->getSku(), 
                                $item->getType(), $item->getName()));
                return;
            }
            
            // return;
            $product = Mage::getModel('catalog/product');
            
            $this->addlog(
                    printf(
                            "\r\n\e[01;34mNew Product Sku(%s): %s  Type: %s  -  %s\e[00m", 
                            $this->rowcount, $item->getSku(), $item->getType(), 
                            $item->getName()));
            
            $pdata = $item->getData();
            // if (isset($pdata['small_image'])) unset($pdata['small_image']);
            // if (isset($pdata['main_image'])) unset($pdata['main_image']);
            // if (isset($pdata['thumbnail'])) unset($pdata['thumbnail']);
            
            $product->setData($pdata);
            
            $product->setWeight(1);
            
            $product->setDescription($item->getDescription());
            if ($item->getShortDescription()=="")
                $product->setShortDescription($item->getDescription());
            else
                $product->setShortDescription($item->getShortDescription());
                
            if ($this->price_only) {
                
                echo " .. Skip   new product for price only";
                return;
                
                // new ones not wrong
            }
            
            $product->setTypeId($item->getType());
            $product->setStatus(
                    Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
            
            $vis = array_search($item->getVisibility(), $visibilities);
            
            if ($product->getVisibility() != $vis) {
                $updated = true;
                $product->setVisibility($vis);
            }
            
            // $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
            // // catalog, search
            
            if (array_key_exists($item->getAttributeSet(), $this->attributeSets)) {
                $attributeSet = $this->attributeSets[$item->getAttributeSet()];
            } else {
                // find my id
                $attributeSetName = $item->getAttributeSet();
                $attribute_set = Mage::getModel("eav/entity_attribute_set")->getCollection();
                $attributeSet = $attribute_set->addFieldToFilter("attribute_set_name", 
                        $attributeSetName)
                    ->getFirstItem()
                    ->getId()
                ;
                
                if (empty($attributeSet))
                    $attributeSet = $this->attributeSets['Mens'];
                else
                    $this->attributeSets[$item->getAttributeSet()] = $attributeSet; // update
                                                                                        // my
                                                                                        // cached
                                                                                        // list
            }
            
            $product->setAttributeSetId($attributeSet);
            
            $product->setWebsiteIds(
                    array(
                            0,
                            1, 2,3
                    ));
            
            if ($item->getTaxClassId() == "Taxable Goods")
                $product->setTaxClassId(2); // taxable
                                                // goods
            else
                $product->setTaxClassId(0);
            
            $product->setPrice($item->getGbp() + $this->uplift);
            // $product->setSpecialPrice($item->getSpecialPrice());
            // $product->setCost($item->getCost());
            
            // $manufacturerId =
            // $this->getOptionValue("manufacturer",$item->getManufacturer());
            
            // $product->setManufacturer($manufacturerId);
            
            
            // drop down attributes
            

            $product->setSize($this->getOptionValue("size", $item->getSize()));
            $product->setColor($this->getOptionValue("color", $item->getColour()));
            $product->setJeansGuide($this->getOptionValue("jeans_size", $item->getJeansSize()));
            $product->setSizeGuide($this->getOptionValue("size_guide", $item->getSizeGuide()));
            $product->setSizeNumeric($this->getOptionValue("size_numeric", $item->getSizeNumeric()));
            $product->setChestSize($this->getOptionValue("chest_size", $item->getChestSize()));
            
            
            if ($item->getAttributeSet()=="Womens") $product->setGender(179);
            if ($item->getAttributeSet()=="Mens") $product->setGender(180);
            
            
            
            $product->setStockData(
                    array(
                            'is_in_stock' => 1,
                            'qty' => $item->getQty(),
                            'manage_stock' => 0,
                            'use_config_notify_stock_qty' => 0
                    ));
            
      //      $this->setCategories($product, $item);
            $product->setCategoryIds(explode(",",$item->getCategoryIds()));
            
            if ($product->getType() == "configurable") {
          //      $product->save();
                
                $satts = array();
                if ($item->getSuperAttribute1()) {
                    $attribute = Mage::getModel('eav/config')->getAttribute(
                            'catalog_product', $item->getSuperAttribute1());
                    
                    if ($attribute->getAttributeId())
                        $satts[] = $attribute->getAttributeId();
                }
                
                if ($item->getSuperAttribute2()) {
                    $attribute = Mage::getModel('eav/config')->getAttribute(
                            'catalog_product', $item->getSuperAttribute2());
                    
                    if ($attribute->getAttributeId())
                        $satts[] = $attribute->getAttributeId();
                }
                                
                $product->setCanSaveCustomOptions(true);
                
                
                if (! empty($satts)) {
                    
                    $product->getTypeInstance()->setUsedProductAttributeIds(
                            $satts, $product);
                    
                    // $configurableAttributesData =
                    // $product->getTypeInstance()->getConfigurableAttributesAsArray();
                    
                    $product->setCanSaveConfigurableAttributes(true);
                    
                    // $product->setConfigurableAttributesData($configurableAttributesData);
                    $product->save();
               
                    foreach ($satts as $satt) {
                        $writeConnection = $resource->getConnection('core_write');
                        $tableName = $resource->getTableName('catalog_product_super_attribute');
                        
                        $sql = sprintf("INSERT INTO $tableName (product_id,attribute_id) values (%s,%s)", $product->getId(),$satt);
                        echo $sql;
                        $result = $writeConnection->query($sql);
                    
                    }
                    
                }
            } else {
                
                
                $product->save();
                
            }
            
            
            if ($product->getType() == "simple" && $product->getParentSku()) {
                
                $configProduct= Mage::getModel("catalog/product")->loadByAttribute("sku",$item->getParentSku());
                
                
                if ($product->getDescription()=="") 
                       $product->setDescription($configProduct->getDescription());
                
               if ($product->getShortDescription()=="")
                   $product->setShortDescription($configProduct->getShortDescription());
                            
                
                if ($configProduct->getId()) {
                    
                    $this->addChildProduct($configProduct, $product);
                    
                }     
                
            }
            
            $productid = $product->getId();
            
            $this->addStockItem($product, $item);
            
            $categories = explode(",",$item->getCategoryIds());
            $product->setCategoryIds($categories);
            
            
            // if (trim($item->getGallery())!="") $this->addGallery($product,
            // $item);
            
            // if ($item->getType()=="grouped")
            // $this->addGrouped($product, $item);
            
            //$this->addImage($product, $item);
            $this->reAddImage($product, $item);
            
            
            
            // prices
            // gbp
            $product = Mage::getModel('catalog/product')
            ->setStoreId(1)
            ->load($productid);
                        
            $product->setPrice($item->getGbp());
            $product->save();
            
            // euro
            $product = Mage::getModel('catalog/product')
            ->setStoreId(2)
            ->load($productid);
            
            
            
            $product->setPrice($item->getEur());
            $product->save();
            
            // dollar
            $product = Mage::getModel('catalog/product')
            ->setStoreId(3)
            ->load($productid);
            
            
            
            $product->setPrice($item->getUsd());
            $product->save();
            
            
            
            $time_end = microtime(true);
            $execution_time = number_format($time_end - $time_start, 2);
            $this->addlog(
                    printf("Product added Sku: %s  Time: %s", $item->getSku(), 
                            $execution_time));
       } else { // Update existing
            
            $time_start = microtime(true);
            $product = Mage::getModel('catalog/product')->load($productid);
            
            
            if ($product->getType() == "configurable") {
                //      $product->save();
            
                $satts = array();
                if ($item->getSuperAttribute1()) {
                    $attribute = Mage::getModel('eav/config')->getAttribute(
                            'catalog_product', $item->getSuperAttribute1());
            
                    if ($attribute->getAttributeId())
                        $satts[] = $attribute->getAttributeId();
                }
            
                if ($item->getSuperAttribute2()) {
                    $attribute = Mage::getModel('eav/config')->getAttribute(
                            'catalog_product', $item->getSuperAttribute2());
            
                    if ($attribute->getAttributeId())
                        $satts[] = $attribute->getAttributeId();
                }
            
                $product->setCanSaveCustomOptions(true);
            
            
                if (! empty($satts)) {
            
                    $product->getTypeInstance()->setUsedProductAttributeIds(
                            $satts, $product);
            
                    // $configurableAttributesData =
                    // $product->getTypeInstance()->getConfigurableAttributesAsArray();
            
                    $product->setCanSaveConfigurableAttributes(true);
            
                    // $product->setConfigurableAttributesData($configurableAttributesData);
                    $product->save();
                     
                    foreach ($satts as $satt) {
                        $writeConnection = $resource->getConnection('core_write');
                        $tableName = $resource->getTableName('catalog_product_super_attribute');
            
                        $sql = sprintf("INSERT INTO $tableName (product_id,attribute_id) values (%s,%s)", $product->getId(),$satt);
                        echo $sql;
                        $result = $writeConnection->query($sql);
            
                    }
            
                }
            }
            
            
            if (! $this->update_existing) {
                $this->addlog(
                        printf(
                                "\r\n\e[01;34mSkip Existing for %s Sku(%s): %s  Type: %s  -  %s\e[00m", 
                                $item->getName(),
                                $this->rowcount, $item->getSku(), 
                                $item->getType(), $item->getName()));
                return;
            }
            /*
             * thes att ids are wrong
             *
             * if ($this->price_only) {
             *
             *
             * $writeConnection = $resource->getConnection('core_write');
             * $tableName =
             * $resource->getTableName('catalog_product_entity_decimal');
             *
             * $sql = "UPDATE $tableName set `value`=".$item->getPrice()." WHERE
             * `attribute_id`=64 AND `entity_id`=".$productid;
             * echo $sql;
             * $result = $writeConnection->query($sql);
             * $sql = "UPDATE $tableName set
             * `value`=".$item->getSpecialPrice()." WHERE `attribute_id`=65 AND
             * `entity_id`=".$productid;
             * $result = $writeConnection->query($sql);
             * $sql = "UPDATE $tableName set `value`=".$item->getCost()." WHERE
             * `attribute_id`=68 AND `entity_id`=".$productid;
             * $result = $writeConnection->query($sql);
             *
             *
             * return;
             *
             *
             * }
             */
            
            $product = Mage::getModel('catalog/product')->load($productid);
            $updated = true;
            
            
            $product->setCategoryIds(explode(",",$item->getCategoryIds()));
            
            $product->setSize($this->getOptionValue("size", $item->getSize()));
            $product->setColor($this->getOptionValue("color", $item->getColour()));
            $product->setJeansGuide($this->getOptionValue("jeans_size", $item->getJeansSize()));
            $product->setSizeGuide($this->getOptionValue("size_guide", $item->getSizeGuide()));
            
 //           $size_numeric = intval($item->getSizeNumeric());
            $product->setSizeNumeric($this->getOptionValue("size_numeric", $item->getSizeNumeric()));
            
            if ($item->getAttributeSet()=="Womens") $product->setGender(179);
            if ($item->getAttributeSet()=="Mens") $product->setGender(180);
            
            if ($product->getType() == "simple" && $product->getParentSku()) {
            
                $configProduct= Mage::getModel("catalog/product")->loadByAttribute("sku",$item->getParentSku());
            
            
                if ($product->getDescription()=="")
                    $product->setDescription($configProduct->getDescription());
            
                    if ($product->getShortDescription()=="")
                        $product->setShortDescription($configProduct->getShortDescription());
            
            
                        if ($configProduct->getId()) {
            
            
                            $this->addChildProduct($configProduct, $product);
            
            
            
            
                        }
            
            }
            
            
            
            
            
            if ($product->getType() == "configurable") {
                $usedatts = $product->getTypeInstance()->getConfigurableAttributesAsArray();
            }
            
            if ($this->fix_images) {
                $this->addlog(
                        printf(
                                "\r\nFixing Images for Sku(%s): %s  Type: %s  -  %s", 
                                $this->rowcount, $item->getSku(), 
                                $item->getType(), $item->getName()));
                
                $this->reAddImage($product, $item);
                return;
            }
            if ($this->reload_images) {
                // $this->addlog(printf("\r\nReload Images for Sku: %s Type: %s
                // - %s", $item->getSku(), $item->getType(), $item->getName()));
                
                $this->reAddImage($product, $item);
                return;
            }
            if ($this->grouped_only && $product->getTypeId() != 'grouped') {
                $this->addlog(
                        printf("\r\nNot grouped for Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
                
                return;
            }
            
            $this->addlog(
                    printf(
                            "\r\n\e[01;34mUpdate Sku(%s): %s  Type: %s  -  %s\e[00m", 
                            $this->rowcount, $item->getSku(), $item->getType(), 
                            $item->getName()));
            
            // can do a if update only here to speed up
            
            if ($item->getType() != "grouped" &&
                     $product->getPrice() != $item->getPrice()) {
                
                // $updated = true;
                $product->setPrice($item->getPrice() + $this->uplift);
                $this->addlog(
                        printf("\r\n     Update Price Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
                
                $writeConnection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName(
                        'catalog_product_entity_decimal');
                
                $sql = "UPDATE $tableName set `value`=" . $item->getPrice() .
                         " WHERE `attribute_id`=64 AND `entity_id`=" . $productid;
                $result = $writeConnection->query($sql);
            }
            
            if ($item->getType() != "grouped" &&
                     $product->getSpecialPrice() != $item->getSpecialPrice()) {
                // $updated = true;
                $product->setSpecialPrice(
                        $item->getSpecialPrice() + $this->uplift);
                $this->addlog(
                        printf(
                                "\r\n     Update Special Price Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
                
                $writeConnection = $resource->getConnection('core_write');
                $tableName = $resource->getTableName(
                        'catalog_product_entity_decimal');
                
                $sql = "UPDATE $tableName set `value`=" .
                         $item->getSpecialPrice() .
                         " WHERE `attribute_id`=65 AND `entity_id`=" . $productid;
                $result = $writeConnection->query($sql);
            }
            
            
            if ($product->getName() != $item->getName()) {
                $updated = true;
                $product->setName($item->getName());
                $this->addlog(
                        printf("\r\n     Update Title Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            if ($product->getDescription() != $item->getDescription()) {
                // $updated = true;
                $product->setDescription($item->getDescription());
                /*
                $attribute = Mage::getModel('eav/config')->getAttribute(
                        'catalog_product', 'description');
                
                if ($attribute->getAttributeId()) {
                    
                    $writeConnection = $resource->getConnection('core_write');
                    $tableName = $resource->getTableName(
                            'catalog_product_entity_text');
                    
                    $sql = "DELETE FROM $tableName where `attribute_id`=" .
                             $attribute->getAttributeId() . " AND `entity_id`=" .
                             $product->getEntityId();
                    
                    // echo "\r\n$sql";
                    
                    $result = $writeConnection->query($sql);
                    
                    $sql = "INSERT INTO $tableName (
                        `entity_type_id`,
                        `attribute_id`,
                        `store_id`,
                        `entity_id`,
                        `value`) VALUES (4, " .
                             $attribute->getAttributeId() . ", 0, " .
                             $product->getEntityId() . ", '" .
                             $item->getDescription() . "')";
                    
                    $result = $writeConnection->query($sql);
                }
                */
                $this->addlog(
                        printf(
                                "\r\n     Update Description Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            if ($product->getShortDescription() != $item->getShortDescription()) {
                $updated = true;
                $product->setShortDescription($item->getShortDescription());
                $this->addlog(
                        printf(
                                "\r\n     Update Short Description Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }/*

            if ($product->getUrlKey() != $item->getUrlKey()) {
                $updated = true;
                $product->setUrlKey($item->getUrlKey());
                $this->addlog(
                        printf(
                                "\r\n     Update Url Key Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            */
            
            if ($product->getCondition() != $item->getCondition()) {
                $this->updateAttribute($product, $item, "condition", 
                        $type = "varchar");
                $product->setCondition($item->getCondition());
                $this->addlog(
                        printf(
                                "\r\n     Update Condition Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            if ($product->getSupplier() != $item->getSupplier()) {
                
                $this->updateAttribute($product, $item, "supplier", 
                        $type = "varchar");
                $product->setSupplier($item->getSupplier());
                
                $this->addlog(
                        printf(
                                "\r\n     Update Supplier Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            if ($product->getWeight() &&
                     $product->getWeight() != $item->getWeight()) {
                $updated = true;
                $product->setWeight($item->getWeight());
                $this->addlog(
                        printf(
                                "\r\n     Update Weight Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            if ($product->getPackageId() !=
                     $this->getOptionValue("package_id", $item->getPackageId())) {
                
                $value = $this->getOptionValue("package_id", 
                        $item->getPackageId());
                
                $updated = true;
                $product->setPackageId($value);
                $this->addlog(
                        printf(
                                "\r\n     Update Package Id Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            /*
             *
             * if ($product->getStatus() != $item->getStatus()) {
             *
             * $product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
             * }
             */
            
            if ($product->getAttributeText('manufacturer') !=
                     $item->getManufacturer()) {
                $updated = true;
                
                $manufacturer = $this->getOptionValue("manufacturer", 
                        $item->getManufacturer);
                
                $product->setManufacturer($manufacturer);
                $this->addlog(
                        printf(
                                "\r\n     Update Manufacturer Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            for ($i = 1; $i <= 6; $i ++) {
                
                if ($product->getData('bullet' . $i) !=
                         $item->getData('bullet' . $i)) {
                    // $updated = true;
                    $product->setData('bullet' . $i, 
                            $item->getData('bullet' . $i));
                    $this->addlog(
                            printf("\r\n     Update Bullet %s With: %s ", $i, 
                                    $item->getData('bullet' . $i)));
                    
                    $attribute = Mage::getModel('eav/config')->getAttribute(
                            'catalog_product', 'bullet' . $i);
                    
                    if ($attribute->getAttributeId()) {
                        $resource = Mage::getSingleton('core/resource');
                        
                        $writeConnection = $resource->getConnection(
                                'core_write');
                        $tableName = $resource->getTableName(
                                'catalog_product_entity_varchar');
                        
                        $sql = "DELETE FROM $tableName where `attribute_id`=" .
                                 $attribute->getAttributeId() .
                                 " AND `entity_id`=" . $product->getEntityId();
                        
                        // echo "\r\n$sql";
                        
                        $result = $writeConnection->query($sql);
                        
                        $sql = "INSERT INTO $tableName (
                                                `entity_type_id`,
                                                `attribute_id`,
                                                `store_id`,
                                                `entity_id`,
                                                `value`) VALUES (4, " .
                                 $attribute->getAttributeId() . ", 0, " .
                                 $product->getEntityId() . ", '" .
                                 $item->getData('bullet' . $i) . "')";
                        $result = $writeConnection->query($sql);
                    }
                }
            }
            
            // tax_class_id -- should not change ?
            if ($item->getTaxClassId() == "Taxable Goods")
                $taxClassId = 2; // taxable
                                     // goods
            else
                $taxClassId = 0;
            
            if ($item->getType() != "grouped" &&
                     $product->getTaxClassId() != $taxClassId) {
                $updated = true;
                $product->setTaxClassId($taxClassId);
                $this->addlog(
                        printf(
                                "\r\n     Update Tax Class Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            // visibility
            
            $vis = array_search($item->getVisibility(), $visibilities);
            
            if ($product->getVisibility() != $vis) {
                $updated = true;
                $product->setVisibility($vis);
                $this->addlog(
                        printf(
                                "\r\n     Update Visibility %s Sku: %s  Type: %s  -  %s", 
                                $i, $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            
            /*
            $status = array_search($item->getStatus(), $statuses);
            
            if ($product->getStatus() != $status) {
                
                $updated = true;
                $this->addlog(
                        printf(
                                "\r\n     Update Status %s Sku: %s  Type: %s  -  %s", 
                                $i, $item->getSku(), $item->getType(), 
                                $item->getName()));
                
                
                
                
                
                if (! in_array($status, $statuses))
                    $product->setStatus(
                            Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                else
                    $product->setStatus($status);
            }
            */
            // product_type_id -- should not change ?
            // is_in_stock -- automatic based on stock
            $others = array(
                    "meta_title",
                    "meta_keyword",
                    "retailer_barcode",
                    "meta_description",
                    "manufacturers_part_no",
                    "local_stock"
            );
            
            foreach ($others as $oitem) {
                if ($product->getData($oitem) != $item->getData($oitem)) {
                    $updated = true;
                    $product->setData($oitem, $item->getData($oitem));
                    $this->addlog(
                            printf(
                                    "\r\n     Update %s Sku: %s  Type: %s  -  %s", 
                                    ucwords(str_replace("_", " ", $oitem)), 
                                    $item->getSku(), $item->getType(), 
                                    $item->getName()));
                }
            }
            // $stockItem =
            // Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
            
            if ($product->getStockItem()->getQty() != $item->getQty()) {
                
                if (isset($this->skip_stock) && $this->skip_stock == 1) {} else {
                    $updated = true;
                    $this->addStock($product, $item);
                    $this->addlog(
                            printf(
                                    "\r\n    Update Stock Sku: %s  Type: %s  -  %s", 
                                    $item->getSku(), $item->getType(), 
                                    $item->getName()));
                }
            }
            /*
             * if ($item->getTaxClassId()=="Taxable Goods") $taxclass=2; //
             * taxable goods
             * else $taxclass=0;
             *
             * if ($product->getTaxClassId() != $taxclass) {
             * $updated = true;
             *
             * $product->setTaxClassId($taxclass);
             *
             * }
             */
            
            /*
            if ($this->setCategories($product, $item, $updateOnly = false)) {
                $updated = true;
                $this->addlog(
                        printf(
                                "\r\n    Update Categories Sku: %s  Type: %s  -  %s", 
                                $item->getSku(), $item->getType(), 
                                $item->getName()));
            }
            */
            
            
            
            // grouped @ToDo
            // grouped product child position – Number before reach sku in
            // grouped field
            if ($item->getType() == "grouped") {
                $this->addGrouped($product, $item);
            }
            
            $manufacturerId = $this->getOptionValue("manufacturer", 
                    $item->getManufacturer());
            if ($product->getManufacturer() != $manufacturerId) {
                $updated = true;
                $product->setManufacturer($manufacturerId);
            }
            
            if (true) {
                $product->save();
                $time_end = microtime(true);
                
                $execution_time = number_format($time_end - $time_start, 2);
                $this->addlog(
                        printf(
                                "\r\n\e[7mUpdated Product (time: %s) Sku: %s  Type: %s  -  %s\e[00m\r\n", 
                                $execution_time, $item->getSku(), 
                                $item->getType(), $item->getName()));
            } else {
                $time_end = microtime(true);
                
                $execution_time = number_format($time_end - $time_start, 2);
                $this->addlog(
                        printf(
                                "\r\n\e[7mProduct Not Updated (time: %s) Sku: %s  Type: %s  -  %s\e[00m\r\n", 
                                $execution_time, $item->getSku(), 
                                $item->getType(), $item->getName()));
            }
            
            if ($this->force_images || $item->getImageChange()) {
                $this->reAddImage($product, $item, true);
                $time_end = microtime(true);
                
                $execution_time = number_format($time_end - $time_start, 2);
                $this->addlog(
                        printf("\r\n\e[7mImages Updated (time: %s) \e[00m\r\n", 
                                $execution_time));
            }
        }
        
        if ($product)
            unset($product);
    }

    function updateAttribute ($product, $item, $name, $type = "varchar")
    {
        $attribute = Mage::getModel('eav/config')->getAttribute(
                'catalog_product', $name);
        
        if ($attribute->getAttributeId()) {
            $resource = Mage::getSingleton('core/resource');
            
            $writeConnection = $resource->getConnection('core_write');
            $tableName = $resource->getTableName(
                    'catalog_product_entity_' . $type);
            
            $sql = "DELETE FROM $tableName where `attribute_id`=" .
                     $attribute->getAttributeId() . " AND `entity_id`=" .
                     $product->getEntityId();
            
            // echo "\r\n$sql";
            
            $result = $writeConnection->query($sql);
            
            $sql = "INSERT INTO $tableName (
                `entity_type_id`,
                `attribute_id`,
                `store_id`,
                `entity_id`,
                `value`) VALUES (4, " .
                     $attribute->getAttributeId() . ", 0, " .
                     $product->getEntityId() . ", '" . $item->getData($name) .
                     "')";
            
            $result = $writeConnection->query($sql);
        }
    }


    function addGallery ($product, $item, $console = false)
    {
        $gimages = explode(",", $item->getGallery());
        
        if (empty($gimages))
            return;
        
        $gallery = $product->getMediaGalleryImages();
        
        foreach ($gimages as $gimage) {
            
            $basename = trim(basename($gimage));
            
            $filename = $this->dest_image_dir . DS . $basename;
            
            if (! file_exists($filename)) {
                if ($this->debug) {
                    echo "\r\n file does not exist filename = " . $filename;
                }
                
                continue;
            }
            
            if ($this->debug) {
                echo "\r\n filename = " . $filename;
            }
            
            $product->addImageToMediaGallery($filename, null, false, false);
        }
    }

    function fixImages ($product)
    {
        $gallery = $product->getMediaGalleryImages();
        
        if (sizeof($gallery) < 1)
            return;
        
        $attributes = $product->getTypeInstance(true)->getSetAttributes(
                $product);
        $gallerya = $attributes['media_gallery'];
        
        $updated = false;
        // remove missing images
        foreach ($gallery as $image) {
            // echo "\r\nChecking path for " . $image->getPath();
            
            if (! file_exists($image->getPath())) {
                $updated = true;
                echo "\r\nRemoving path for " . $image->getPath();
                $gallerya->getBackend()->removeImage($product, 
                        $image->getFile());
            }
        }
        if ($updated)
            $product->save();
        
        if ($product->getImage() == "no_selection" || $product->getImage() == "") {
            foreach ($product->getMediaGalleryImages() as $galimage) {
                if ($product->getImage() == "no_selection" ||
                         $product->getImage() == "") {
                    echo "\r\nFixing No Image " . $product->getSku();
                    
                    $product->setImage($galimage->getFile());
                    $product->setSmallImage($galimage->getFile());
                    $product->setThumbnail($galimage->getFile());
                    $product->save();
                }
            }
        }
    }

    function reAddImage ($product, $item, $console = false)
    {
        $dest_dir = Mage::getBaseDir() . DS . '/media/import';
        
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $gallerytableName = $resource->getTableName(
                'catalog_product_entity_media_gallery');
        $galleryValuestableName = $resource->getTableName(
                'catalog_product_entity_media_gallery_value');
        
        $productVarTable = $resource->getTableName(
                'catalog_product_entity_varchar');
        $productFlatTable = 'mg_catalog_product_flat_1';
        
        $image = $product->getImage();
        
        $gallery = $product->getMediaGalleryImages();
        
        $attributes = $product->getTypeInstance(true)->getSetAttributes(
                $product);
        $gallerya = $attributes['media_gallery'];
        
        
        
        if (sizeof($gallery) > 0 &&
                 ($item->getImageChange() == 1 || $this->force_images)) {
            
            $sql = "DELETE FROM $gallerytableName WHERE (`entity_id` = '" .
             $product->getEntityId() . "')";
            
            echo $sql;
            
            $result = $writeConnection->query($sql);
        }
        
        $additional_images = explode(",",$item->getAdditionalImages());
        
        if ($item->getMainImage() == "" && count($additional_images)) {
            
            
            $image_name = trim(array_shift($additional_images));
            unset ($additional_images[0]);
            
            
            
        } else {
            $image_name = $item->getMainImage();
        }
        
        
         $main_image = str_replace(array("%20"," "), "_", $image_name);
         $main_image_path = $dest_dir . DS . $main_image;

        $basename = basename($main_image);
        // calculcate directory
        $mediapath = Mage::getBaseDir('media') . DS . "catalog/product" . DS .
                 substr($basename, 0, 1) . DS . substr($basename, 1, 1) . DS;
        $mainimage = DS . substr($basename, 0, 1) . DS . substr($basename, 1, 1) . DS .
                 $main_image;
         if (! file_exists($main_image_path)) {
             $filename = $this->downloadImageFile($item->getMainImage(), $main_image_path, $image_name , $item);
         } else {
             $filename = $main_image;
         }
         
        if (! file_exists($mediapath . DS . $main_image) || $item->getImageChange() == 1 ||
                 $this->force_images) {
            if (! file_exists($mediapath))
                mkdir($mediapath, 0777, true);
            
            echo "\r\ncopy from " . $dest_dir . DS . $main_image . "  to  " .
                     $mediapath . DS . $main_image;
        }
        // print_r($item);
        // print_r($product->getData());
        
        if ($this->debug) {
            
            echo "\r\n Main image = $main_image";
            echo "\r\n Product image = " . $product->getMainImage();
        }

        
        
        
        
        if (count($additional_images)) {
            
            
            
            
            foreach ($additional_images as $index => $aimage) {
            
            
            if (trim($aimage)=="") continue;
            
            
            $additional_image = str_replace(array("%20"," "), "_", $aimage);
            $additional_image_path = $dest_dir . DS . $additional_image;
            
            $additional_images[$index] = $additional_image;
            
            // calculcate directory
            $mediapath = Mage::getBaseDir('media') . DS . "catalog/product" . DS .
            substr($basename, 0, 1) . DS . substr($basename, 1, 1) . DS;
         //   $mainimage = DS . substr($basename, 0, 1) . DS . substr($basename, 1, 1) . DS .
         //   $additional_image;
         
            echo "get add image $additional_image_path";
            
            if (! file_exists($additional_image_path)) {
                $filename = $this->downloadImageFile($aimage, $additional_image_path, $aimage , $item);
            } else {
                $filename = $additional_image;
            }
             $aimage = $basename = basename($additional_image);
            
            if (! file_exists($mediapath . DS . $filename) || $item->getImageChange() == 1 ||
                    $this->force_images) {
                        if (! file_exists($mediapath))
                            mkdir($mediapath, 0777, true);
            
                        echo "\r\ncopy from " . $dest_dir . DS . $filename . "  to  " .
                                $mediapath . DS . $filename;
                        
                        copy($dest_dir . DS . $filename,
                                $mediapath . DS . $filename);
                                
                    }
            
            }
            
            
            
            
            
            
        }
        
        
        
          
        
        $itemImages = array();
        // delete existing for a clean start
        // $sql = "DELETE FROM $gallerytableName WHERE (`entity_id` =
        // '".$product->getEntityId() ."')";
        
        // $result = $writeConnection->query($sql);
        $gimages = array_merge(array(
                $main_image
        ),$additional_images );
        
        $done_images = array();
        
        foreach ($gimages as $pos => $gimage) {
            $gbasename = basename($gimage);
            
            // print_r($done_images);
            
            if (in_array($gbasename, $done_images)) {
                echo "\r\n\e[31;1mError - Duplicate Image file " . $dest_dir . DS .
                         $gbasename . " \e[00m";
                continue; // skip existing
            } else {
                $done_images[] = $gbasename;
            }
            
            if (trim($gbasename) == "")
                continue;
            if (empty($gbasename))
                continue;
            
            $gmediapath = Mage::getBaseDir('media') . DS . "catalog/product" . DS .
                     substr($gbasename, 0, 1) . DS . substr($gbasename, 1, 1) . DS;
            $gmainimage = DS . substr($gbasename, 0, 1) . DS . substr($gbasename, 1, 1) .
                     DS . $gbasename;
            
            if (! file_exists($mediapath . DS . $gbasename)) {
                if (! file_exists($mediapath))
                    mkdir($mediapath, 0777, true);
                
                if ($this->debug)
                    echo "\r\ncopy gallery image from " . $dest_dir . DS .
                             $gbasename . "  to  " . $mediapath . DS . $gbasename;
                
                if (file_exists($dest_dir . DS . $gbasename)) {
                    copy($dest_dir . DS . $gbasename, 
                            $mediapath . DS . $gbasename);
                } else {
                    echo "\r\n\e[31;1mError - Missing Image file " . $dest_dir . DS .
                             $gbasename . " \e[00m";
                }
            }
            
            // $product->addImageToMediaGallery($mediapath . DS . $gbasename, array(),
            // false, false);
            try {
            $sql = "INSERT INTO $gallerytableName (`value`, entity_id, attribute_id) VALUES ('" .
                     $gmainimage . "', '" . $product->getEntityId() . "', 88)";
            
            $result = $writeConnection->query($sql);
            $value_id = $writeConnection->lastInsertId();
            
            $sql = "INSERT INTO $galleryValuestableName  (`value_id`, `store_id`, `label`, `position`, `disabled`) VALUES ('" .
                     $value_id . "', 0, '" . $item->getMainImageLabel() . "', '" .
                     ($pos + 1) . "', '0')";
            
            $result = $writeConnection->query($sql);
            } catch (Exception $e) {
                Mage::Log($e->getMessage());
                
            }
        }
        
        
        
        // set product main image
        $sql = "DELETE FROM $productVarTable WHERE (`entity_id` = '" . $product->getEntityId() .
                 "') AND attribute_id in (85,86,87)";
        
        $result = $writeConnection->query($sql);
        
        $imatts=array(85,86,87);
        
        $pid= $product->getId();
        
        foreach ($imatts as $im) {
       
            $sql = "INSERT INTO $productVarTable (entity_type_id, attribute_id, store_id,entity_id, value) VALUES (
                4,
                $im,
                0,
                 $pid,         
                '$mainimage');";
            
            $result = $writeConnection->query($sql);
        }
/*
         * $sql = "UPDATE $productFlatTable SET " .
         * "image = '".$mainimage."'".
         * ",small_image = '".$mainimage."'".
         * ",thumbnail='".$mainimage."'".
         *
         * " WHERE (`entity_id` = '".$product->getEntityId() ."') ";
         *
         *
         * $result = $writeConnection->query($sql);
         */
        
        if ($this->debug) {
            
            echo "\r\n\e[7mImages Updated \e[00m\r\n";
        }
    }







  function addChildProduct($configProduct, $product) {
     
     
     // catalog_product_super_link
     
     
     
     $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();
     
     
     $ids = $configProduct
     ->getTypeInstance()
     ->getUsedProductIds();
      
     
     print_r($ids);
     if (in_array($product->getid(),$ids)) return; // already associated
     else $ids[]=$product->getid();
     
     Mage::getResourceSingleton('catalog/product_type_configurable')
     ->saveProducts($configProduct, $ids);
      
     
 }






function addImage ($product, $item, $console = false)
{
$dest_dir = Mage::getBaseDir() . DS . '/media/import';

if ($item->getMainImage()) {
    
    $parts = explode("?", $item->getMainImage());
    $parts = explode("/", $parts[0]);
    $main_image = str_replace("%20", "_", $parts[0]);
    $main_image_path = $dest_dir . DS . $main_image;
    
    if (! file_exists($main_image_path)) {
        $filename = $this->downloadImageFile($item->getMainImage(), 
                $main_image_path);
    } else {
        $filename = $main_image;
    }
} else {
    return false;
}

$gallery = $product->getMediaGalleryImages();

if (sizeof($gallery) > 0 && $item->getImageChange() != 1 && ! $this->force_images)
    return; // do not reload

if (trim($item->getImage()) == "")
    return false;

$image = array();
$load = true;

$attributes = $product->getTypeInstance(true)->getSetAttributes($product);
$gallerya = $attributes['media_gallery'];

if (sizeof($gallery) > 0 && ($item->getImageChange() == 1 || $this->force_images)) {
    // remove old images first
    
    foreach ($gallery as $image) {
        $gallerya->getBackend()->removeImage($product, $image->getFile());
    }
    // $product->save();
    // $product= $product->load($product->getId());
}

if ($gallery) {
    foreach ($gallery as $galimage) {
        if (strpos(basename($galimage->getFile()), $basename) !== false) {
            return true;
            $load = false;
        }
    }
}

if ($this->debug) {
    echo "\r\n Main Image filename = " . $filename;
}

if ($load && $filename && ! empty($basename)) {
    
    $product->addImageToMediaGallery($filename, 
            array(
                    'image',
                    'small_image',
                    'thumbnail'
            ), false, false);
}

$attributes = $product->getTypeInstance(true)->getSetAttributes($product);
$mediaGalleryBackendModel = $attributes['media_gallery']->getBackend();

$gimages = explode(",", $item->getGallery());

if (empty($gimages))
    return;

$gallery = $product->getMediaGalleryImages();
$farray = array();

foreach ($gimages as $gimage) {
    
    $gbasename = trim(basename($gimage));
    
    if ($gbasename == $basename)
        continue; // skip same imnages in gallery
    
    if (in_array($gbasename, $farray)) {
        continue;
    }
    
    $farray[] = $gbasename;
    
    if (trim($gbasename) == "")
        continue;
    
    $filename = $this->dest_image_dir . DS . $gbasename;
    
    if (! file_exists($filename)) {
        if ($this->debug) {
            echo "\r\n file does not exist filename = " . $filename;
        }
        continue;
    }
    
    if ($this->debug) {
        echo "\r\n Gallery filename = " . $filename;
    }
    
    $product->addImageToMediaGallery($filename, 
            array(
                    "label" => $altText
            ), false, false);
}
$images = $product->getMediaGalleryImages();

$attributes = $product->getTypeInstance(true)->getSetAttributes($product);
$mediaGalleryBackendModel = $attributes['media_gallery']->getBackend();

foreach ($images as $image) {
    $atts = array(
            'label' => $altText
    );
    $mediaGalleryBackendModel->updateImage($product, $image->getFile(), $atts);
}

$product->save();
}

function addStock ($product, $item)
{

// set Stock levels
$stockItem = $product->getStockItem();

$in_stock = ($item->getQty() > 0 ? 1 : 0);

// $product->getResource()->save($product);
if (! $stockItem && $stockItem->getId()) {
    $stockItem = Mage::getModel('cataloginventory/stock_item');
    $stockItem->setData('stock_id', 1);
}

$stockItem->setData('stock_id', 1);
$stockItem->setData('product_id', $product->getId());
$stockItem->assignProduct($product);
$stockItem->setData('qty', $item->getQty());
$stockItem->setData('manage_stock', 1);
$stockItem->setData('use_config_manage_stock', 1);
$stockItem->setData('use_config_notify_stock_qty', 1);
$stockItem->setData('use_config_min_sale_qty', 1);
$stockItem->setData('use_config_backorders', 1);
$stockItem->setData('is_in_stock', $in_stock);
// $stockItem->setData('backorders', 1);
$stockItem->setData('stock_status_changed_automatically', 1);

return true;

// set Stock levels
$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct(
        $product);

$in_stock = ($item->getQty() > 0 ? 1 : 0);

$product->getResource()->save($product);
if (! $stockItem && $stockItem->getId()) {
    $stockItem = Mage::getModel('cataloginventory/stock_item');
    $stockItem->setData('stock_id', 1);
}

$stockItem->setData('stock_id', 1);
$stockItem->setData('product_id', $product->getId());
$stockItem->assignProduct($product);
$stockItem->setData('qty', $item->getQty());
$stockItem->setData('manage_stock', 1);
$stockItem->setData('use_config_manage_stock', 1);
$stockItem->setData('use_config_notify_stock_qty', 1);
$stockItem->setData('use_config_min_sale_qty', 1);
$stockItem->setData('use_config_backorders', 1);
$stockItem->setData('is_in_stock', $in_stock);
// $stockItem->setData('backorders', 1);
$stockItem->setData('stock_status_changed_automatically', 1);

try {
    // $product->save ();
    $stockItem->save();
} catch (Exception $ex) {
    
    $stockItem->delete();
    if ($this->debug)
        echo "\r\n id = " . $stockItem->getId() . " " . $ex->getMessage();
    $this->messagelog[] = $ex->getMessage();
    // handle the error here!!
}
unset($stockItem);
}

/*
 *
 * This adds the whole stock item instead of
 */
function addStockItem ($product, $item)
{

// set Stock levels
$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct(
        $product);

$in_stock = ($item->getQty() > 0 ? 1 : 0);

if ($product->getType()=="configurable")$in_stock=1;

$product->getResource()->save($product);
if (! $stockItem && $stockItem->getId()) {
    $stockItem = Mage::getModel('cataloginventory/stock_item');
    $stockItem->setData('stock_id', 1);
}

$stockItem->setData('stock_id', 1);
$stockItem->setData('product_id', $product->getId());
$stockItem->assignProduct($product);
$stockItem->setData('qty', $item->getQty());
$stockItem->setData('manage_stock', 1);
$stockItem->setData('use_config_manage_stock', 1);
$stockItem->setData('use_config_notify_stock_qty', 1);
$stockItem->setData('use_config_min_sale_qty', 1);
$stockItem->setData('use_config_backorders', 1);
$stockItem->setData('is_in_stock', $in_stock);
// $stockItem->setData('backorders', 1);
$stockItem->setData('stock_status_changed_automatically', 1);


    
    
try {
    // $product->save ();
    $stockItem->save();
} catch (Exception $ex) {
    
    $stockItem->delete();
    if ($this->debug)
        echo "\r\n id = " . $stockItem->getId() . " " . $ex->getMessage();
    $this->messagelog[] = $ex->getMessage();
    // handle the error here!!
}
unset($stockItem);
}

function getOptionValue ($code, $arg_value)
{

// echo " code = $code $arg_value";
$this->message .= "Set Product Value for $code - $arg_value";

$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 
        $code);
foreach ($attribute->getSource()->getAllOptions(true) as $option) {
    
    // echo "<br> label " . $option['label'] . " value = $arg_value";
    
    if ($option['label'] == $arg_value) {
        return $option['value'];
    }
}
// not there make new
return $this->addOption($code, $arg_value, $attribute);
}

function addOption ($code, $atitle, $attribute)
{
$val = str_replace('èé', 'e', $atitle);
$val = str_replace('ò', 'o', $atitle);

// $this->message .= "Adding Att value for $code - $atitle";
$this->addlog(printf("Adding Attribute value for $code - $atitle"));

// echo "Adding Att value for $code - $atitle";
$options = $attribute->getSource()->getAllOptions(false);
$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

$attribute_options_model->setAttribute($attribute);
$options = $attribute_options_model->getAllOptions(false);

$attribute->setData('option', 
        array(
                'value' => array(
                        'option' => array(
                                $atitle
                        )
                )
        ));
$attribute->save();

// now find the new value
foreach ($attribute->getSource()->getAllOptions(true) as $option) {
    if ($option['label'] == $atitle) {
        $attribute = null;
        return $option['value'];
    }
}
$attribute = null;

return false;
}

function setCategories ($product, $item, $updateOnly = false)
{

// categories
$catids = $old = $product->getCategoryIds();

if (! is_array($catids))
    $catids = array();

$catArray = explode(",", $item->getCategories());
$this->productCats = array(
        $this->rootCategory
);

foreach ($catArray as $cat) {
    $destcats = explode(",", trim($cat));
    
    foreach ($destcats as $subcat) {
        $rootcat = $this->rootCategory;
        $subcatpaths = explode("/", $subcat);
        
        if ($this->catdebug)
            echo "\r\n$subcat";
        foreach ($subcatpaths as $subcatpath) {
            
            $subcatclean = trim(str_replace(":1", "", $subcatpath));
            if ($this->catdebug)
                echo "\r\n\t $subcatpath";
            
            $parent = $rootcat;
            $rootcat = $this->catExists($subcatclean, $rootcat);
            
            if (! $rootcat) {
                // if ($this->debug) echo "\r\n\r\nCreate new category
                // ($rootcat) ";
                $isAnchor = (strpos($subcatpath, ":1") === true ? 1 : 0);
                
                $rootcat = $this->createCat($subcatclean, $parent, $isAnchor);
                if ($this->catdebug)
                    echo "\r\n\r\ncreated new category ($rootcat)  ";
            } else {
                if ($this->catdebug)
                    echo "\r\n\r\nFound category ($rootcat)  ";
                $isAnchor = (strpos($subcatpath, ":1") === true ? 1 : 0);
            }
        }
        
        // add to destination cats if not exists
        if (! in_array($rootcat, $this->productCats))
            $this->productCats = array_merge($this->productCats, 
                    (array) $rootcat);
    }
}

foreach ($this->productCats as $cat) {
    
    if (! in_array($cat, $catids))
        $catids[] = $cat;
}

// check for categories to remove
foreach ($catids as $k => $cat) {
    
    if (! in_array($cat, $this->productCats))
        unset($catids[$k]); // unset
                                // if not
                                // in old
}

// $catids = array_merge($this->productCats, $catids);

if ($old !== $catids) {
    $product->setCategoryIds($catids);
    $this->addlog(
            printf("Setting Categories for " . $product->getSku() . " %s", 
                    print_r($catids, true)));
    return true;
}

return false;
}

function catExists ($name, $rootCat)
{
// $name = strtolower($name);
// $name = ucwords($name);
$parentCategory = Mage::getModel('catalog/category')->load($rootCat);
$collection = Mage::getModel('catalog/category')->getCollection()
    ->
// ->setStoreId('0')
// ->addIdFilter($parentCategory->getChildren())
addAttributeToSelect('entity_id')
    ->addAttributeToSelect('name')
    ->addAttributeToFilter('parent_id', $rootCat)
    ->addAttributeToFilter('name', $name);
// ->addAttributeToFilter('url_key', $this->string_to_url($name))

// if ($this->debug) echo "\r\n" . $collection->getSelect();

return $collection->getFirstItem()->getEntityId();
}

function createCat ($name, $parentId, $isAnchor)
{
$catId = false;

if ($parentId) {
    $urlKey = $this->string_to_url($name);
    
    $currentCategory = Mage::getModel('catalog/category')->getCollection()
        ->addFieldToFilter('url_key', $urlKey)
        ->setCurPage(1)
        ->addAttributeToFilter('parent_id', $parentId)
        ->setPageSize(1)
        ->getFirstItem();
    
    $isAnchor = 1;
    
    if (! $currentCategory->getId()) {
        $this->addlog(printf("Create Category %s", $name));
        $category = Mage::getModel('catalog/category');
        $category->setName($name)
            ->setUrlKey($urlKey)
            ->setIsActive(1)
            ->setDisplayMode('PRODUCTS')
            ->setIsAnchor($isAnchor)
            ->setDescription($name);
        // ->setAttributeSetId($category->getDefaultAttributeSetId());
        
        $parentCategory = Mage::getModel('catalog/category')->load($parentId);
        $category->setPath($parentCategory->getPath());
        $category->save();
        
        $this->addlog(
                printf("Created Category %s, path %s", $name, 
                        $category->getPath()));
        
        $catId = $category->getEntityId();
        
        unset($category);
    } else {
        return $currentCategory->getId();
    }
} else {
    
    die("no parent id");
}

return $catId;
}

function addlog ($message)
{
// if ($this->debug)
// echo "\r\n$message";
Mage::Log($message, false, $this->logfile);
}

function fixVisibility ()
{
$products = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToSelect("visibility")
    ->addAttributeToFilter("visibility", 
        array(
                "nin" => array(
                        Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                        Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE
                )
        ));

$resource = Mage::getSingleton('core/resource');

/**
 * Retrieve the read connection
 */
$readConnection = $resource->getConnection('core_read');

/**
 * Retrieve the write connection
 */
$writeConnection = $resource->getConnection('core_write');
$tableName = $resource->getTableName('catalog_product_entity_int');
$productFlatTable = 'mg_catalog_product_flat_1';

if ($this->fix_visibility_allvisible) {
    foreach ($products as $product) {
        
        if ($this->sku) {
            if ($product->getSku() != $this->sku)
                continue;
        }
        
        if ($product->getVisibility() ==
                 Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) {
            continue;
        }
        if ($product->getVisibility() ==
                 Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE) {
            continue;
        }
        
        echo "\r\nset visibility  for sku " . $product->getSku();
        echo " vis:" . $product->getVisibility() . ":";
        $product->setVisibility(
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH); // catalog,
                                                                         // search
        $product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $product->save();
    }
}
$products = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToFilter("type_id", array(
        "eq" => "grouped"
))
    ->addAttributeToSelect("visibility");

foreach ($products as $product) {
    if ($this->sku) {
        if ($product->getSku() != $this->sku)
            continue;
    }
    
    // get children
    $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts(
            $product);
    if ($_associatedProducts) {
        foreach ($_associatedProducts as $_product) {
            
            if ($_product->getVisibility() !=
                     Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE) {
                echo "\r\nset Grouped Child visibility  for sku " .
                 $_product->getSku();
                echo " vis:" . $_product->getVisibility() . ": to " .
                         Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
                /*
                 * $_product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
                 * $_product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
                 * $_product->save();
                 * // catalog, search
                 *
                 */
                
                $sql = "UPDATE $tableName SET VALUE=" .
                         Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE .
                         " WHERE (`attribute_id` = '91') AND (entity_id =" .
                         $_product->getEntityId() . ")";
                
                // echo $sql;
                
                $result = $writeConnection->query($sql);
                
                $sql = "UPDATE $productFlatTable SET visibility=" .
                         Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE .
                         " WHERE (entity_id =" . $_product->getEntityId() . ")";
                
                // echo $sql;
                $result = $writeConnection->query($sql);
            }
        }
    }
}
}

    
    function downloadImageFile ($imageUrl, $file, $sourcename, $item)
    {
        
        // find on dropbox
        
        
        $searchname = urldecode($sourcename);
        
        if ($item->getAttributeSet()=="Womens") {
            
            $dirname = "/ECOM IMAGERY/SS17/WOMENS/Web";
            
        } else {
            
            
        }
        
        $dirname = "/ECOM IMAGERY/SS17/Menswear & Womenswear/Web";
        
        $dbxClient = new dbx\Client($this->accessToken, "PHP-Example/1.0");
        $accountInfo = $dbxClient->getAccountInfo();
    //    print_r($accountInfo);
        $folderMetadata = $dbxClient->getMetadataWithChildren($dirname);
         
         $found =  false;
         foreach ($folderMetadata['contents'] as $item) {
             
             if ($found) continue;
           //   print_r($item);
             if ($item['is_dir']==1) continue;
             if (stripos($item['path'],$searchname) !==false) {
                 try  {
                 $found=true;
                 $fd = fopen($file, 'w');
                  
                 $file = $dbxClient->getFile($item['path'],$fd);
                 
                 fclose($fd);
                 return $sourcename;
                 
                 } catch (Exception $e) {
                     continue;
                 }
               
             }
             
         }
         
         return false;
             
        
    }
    
    function string_to_url ($source)
    {
        // if ($this->debug) echo "\r\n source = $source " ;
        $source = str_replace("&", "", $source);
        $source = str_replace(",", "", $source);
        $source = str_replace("  ", " ", $source);
        
        $source = preg_replace("/[^a-z^A-Z^0-9^ ^-]/", "", $source);
        $source = strtolower($source);
        $source = preg_replace('/\s+/', " ", $source);
        $source = trim($source);
        $source = str_replace(" ", "-", $source);
        return $source;
    }

}

class chunkReadFilter implements PHPExcel_Reader_IReadFilter
{

private $_startRow = 0;

private $_endRow = 0;

/**
 * Set the list of rows that we want to read
 */
public function setRows ($startRow, $chunkSize)
{
$this->_startRow = $startRow;
$this->_endRow = $startRow + $chunkSize;
}

public function readCell ($column, $row, $worksheetName = '')
{
// Only read the heading row, and the configured rows
if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
    return true;
}
return false;
}
}
