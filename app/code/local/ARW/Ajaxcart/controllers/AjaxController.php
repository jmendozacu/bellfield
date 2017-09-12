<?php
class ARW_Ajaxcart_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $idProduct = Mage::app()->getRequest()->getParam('product_id');
        $IsProductView = Mage::app()->getRequest()->getParam('IsProductView');
        $params = Mage::app()->getRequest()->getParams();
        unset($params['product_id']);
        unset($params['IsProductView']);
        $product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load($idProduct);
        $responseText = '';
        if ($product->getId())
        {
            try{
                if(($product->getTypeId() == 'simple' && !($product->getRequiredOptions())) || count($params) > 0 || ($product->getTypeId() == 'virtual' && !($product->getRequiredOptions()))){
                    if(!array_key_exists('qty', $params)) {
                        $params['qty'] = $product->getStockItem()->getMinSaleQty();  
                    }  
                    $cart = Mage::getSingleton('checkout/cart');
                    $cart->addProduct($product, $params);
                    $cart->save();
                    Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
                    if (!$cart->getQuote()->getHasError()){
                        $responseText = $this->addToCartResponse($product, $cart, $IsProductView, $params,0);    
                    }    
                }
                else{
                     $responseText = $this->showOptionsResponse($product, $IsProductView);    
                }
                    
            }
            catch (Exception $e) {
                $responseText = $this->addToCartResponse($product, $cart, $IsProductView, $params, $e->getMessage());
                Mage::logException($e);
            }
        }
        $this->getResponse()->setBody($responseText);
    }
    
    private function showOptionsResponse($product, $IsProductView){
        Mage::register('current_product', $product);                  
        Mage::register('product', $product);         
        $block = Mage::app()->getLayout()->createBlock('catalog/product_view', 'catalog.product_view');
        $textScript = ('true' == !$IsProductView)? ' optionsPrice['.$product->getId().'] = new Product.OptionsPrice('.$block->getJsonConfig().');': '';
		$html='<p><span class="product-name">'.$product->getName().'</span></p>';
        $html = '<script type="text/javascript">
                    optionsPrice = new Product.OptionsPrice('.$block->getJsonConfig().'); 
                    '.$textScript.'  
                 </script><form id="product_addtocart_form" enctype="multipart/form-data">'; 
        $js = Mage::app()->getLayout()->createBlock('core/template', 'product_js')
                            ->setTemplate('catalog/product/view/options/js.phtml');
        $js->setProduct($product);
        $html .= $js->toHtml();
        $options = Mage::app()->getLayout()->createBlock('catalog/product_view_options','product_options')
                            ->setTemplate('catalog/product/view/options.phtml')
                            ->addOptionRenderer('text','catalog/product_view_options_type_text','arw/ajaxcart/checkout/cart/options/type/text.phtml')
                            ->addOptionRenderer('select','catalog/product_view_options_type_select','arw/ajaxcart/checkout/cart/options/type/select.phtml')
                            ->addOptionRenderer('file','catalog/product_view_options_type_file','catalog/product/view/options/type/file.phtml')
                            ->addOptionRenderer('date','catalog/product_view_options_type_date','catalog/product/view/options/type/date.phtml');
        $options->setProduct($product);
        $html .= $options->toHtml();                                            
         
        if ($product->isConfigurable())
        {
            $configurable = Mage::app()->getLayout()->createBlock('catalog/product_view_type_configurable', 'product_configurable_options');
            $configurable ->setTemplate('arw/ajaxcart/catalog/product/view/type/options/configurable.phtml');
            $configurableData = Mage::app()->getLayout()->createBlock('catalog/product_view_type_configurable', 'product_type_data')
                            ->setTemplate('catalog/product/view/type/configurable.phtml');
            $configurable->setProduct($product);
            $configurableData->setProduct($product);
            $htmlCong = $configurable->toHtml();
            $html .= $htmlCong.$configurableData->toHtml();
        }
		if($product->isGrouped()){
              $blockGr = Mage::app()->getLayout()->createBlock('catalog/product_view_type_grouped', 'catalog.product_view_type_grouped')
                                                 ->setTemplate('catalog/product/view/type/grouped.phtml'); 
              $html .= $blockGr->toHtml();                                                                             
        }
         
        if ($product->getTypeId() == 'downloadable')
        {
            $downloadable = Mage::app()->getLayout()->createBlock('downloadable/catalog_product_links', 'product_downloadable_options')
                            ->setTemplate('downloadable/catalog/product/links.phtml');
			$html .= $downloadable->toHtml();
		}
       if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
			 $blockBn = Mage::app()->getLayout()->createBlock('bundle/catalog_product_view_type_bundle', 'product.info.bundle.options') ;                                           
			 $blockBn ->addRenderer('select', 'bundle/catalog_product_view_type_bundle_option_select');
			 $blockBn->addRenderer('multi', 'bundle/catalog_product_view_type_bundle_option_multi');
			 $blockBn->addRenderer('radio', 'bundle/catalog_product_view_type_bundle_option_radio', 'bundle/catalog/product/view/type/bundle/option/radio.phtml');
			 $blockBn->addRenderer('checkbox', 'bundle/catalog_product_view_type_bundle_option_checkbox', 'bundle/catalog/product/view/type/bundle/option/checkbox.phtml');
			 $blockBn->setTemplate('bundle/catalog/product/view/type/bundle/options.phtml');
			 $html .= $blockBn->toHtml();
			 $blockBn->setTemplate('bundle/catalog/product/view/type/bundle.phtml');
			 $html .= $blockBn->toHtml();
       }
       else{
            $price = Mage::app()->getLayout()->createBlock('catalog/product_view', 'product_view')
                                ->setTemplate('catalog/product/view/price_clone.phtml');
            $html .= '<strong>'.$this->__('Price :').'</strong>'.$price->toHtml();
       }
          
        
        $html .= '</form>';
		$html .='<p class="action-cart"><a class="button btn-cart text-uppercase button-primary">'.$this->__('Add to Cart').'</a><a class="button btn-cancel text-uppercase">'.$this->__('Cancel').'</a></p>';
        $result = array(
			'dataOption'   =>  $html, 
            'action' =>  'ajaxCartObj.sendAjax('.$product->getId().', 1);', 
			'add_to_cart' =>  '0' ,
          );
         return Zend_Json::encode($result);    
    } 
   
    public function cartAction()
    {   
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']);
        $myCart = Mage::app()->getLayout()->createBlock('checkout/cart_sidebar', 'cart_sidebar')
                             ->setTemplate('checkout/cart/sidebar.phtml');
        $this->getResponse()->setBody($myCart->toHtml());
    }
    public function checkoutAction()
    {   
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']); 
        $this->loadLayout(array('checkout_cart_index'));
        $_formkey = Mage::app()
            ->getLayout()->createBlock('core/template', 'formkey')
            ->setTemplate('core/formkey.phtml');
        $myCart = Mage::app()
            ->getLayout('checkout_cart_index')
            ->getBlock('checkout.cart')
            ->setChild('formkey', $_formkey);
        $this->getResponse()->setBody($myCart->toHtml());
    }
    
    public function reloadCartAction()
    { 
        $_SERVER['REQUEST_URI'] = str_replace(Mage::getBaseUrl(), '/index.php/', $_SERVER['HTTP_REFERER']); 
        $myCart = Mage::app()->getLayout()->createBlock('checkout/cart_sidebar', 'cart_sidebar')
                             ->setTemplate('arw/ajaxcart/checkout/cart/mini_cart.phtml')
                              ->addItemRender('simple','checkout/cart_item_renderer','arw/ajaxcart/checkout/cart/sidebar/default.phtml')
                              ->addItemRender('default','checkout/cart_item_renderer','arw/ajaxcart/checkout/cart/sidebar/default.phtml')
                              ->addItemRender('grouped','checkout/cart_item_renderer_grouped','arw/ajaxcart/checkout/cart/sidebar/default.phtml')
                              ->addItemRender('configurable','checkout/cart_item_renderer_configurable','arw/ajaxcart/checkout/cart/sidebar/default.phtml')
                              ->addItemRender('bundle','bundle/checkout_cart_item_renderer','arw/checkout/cart/ajaxcart/sidebar/default.phtml');
        $this->getResponse()->setBody($myCart->toHtml());
    }

    private function addToCartResponse($product, $cart, $IsProductView, $params, $text){
        $total_item = Mage::getSingleton('checkout/cart')->getItemsCount();
        $result = array(
            'dataOption'     => '<p class="text-center"><span class="product-name">'.$this->__('%s was added to your shopping cart',$product->getName()).'</span></p>',
            'count'     =>  '<span class="total-badge">'.$total_item.'</span>',
            'add_to_cart' =>  '1',
        );
        if($text) {
            $result['dataOption'] = '<p>' . $text . '</p>';
        }
        else {
            Mage::unregister('current_product');
            Mage::unregister('product');
            Mage::register('current_product', $product);
            Mage::register('product', $product);
            $param_p=$this->_getProductRequest($params);
            //if($param_p['options'] || $param_p['super_attribute'] || $param_p['bundld_options'] || $param_p['super_group'] || $param_p['links']) {
            //    $result['dataOption'].='<p> You can choose options : </p>';
            //}
            //$result['dataOption'].='<p><a href="'.$product->getProductUrl().'"><img class="" src="'.Mage::helper('catalog/image')->init($product, 'small_image')->resize(50,50).'" alt="'.$product->getLabel().'" /></a></p>';
            //$result['dataOption'].='<p><span>'.Mage::helper('core')->currency($product->getFinalPrice(),true,false).'</span></p>';
//            if($param_p['options']){
//                $result['dataOption'] .= '<div class="option-custom">';
//                foreach($param_p['options'] as $key_o=>$value_o) {
//                    $result['dataOption'] .='<p>';
//                    $option=$product->getOptionById($key_o);
//                    $result['dataOption'] .='<span>'.$option->getTitle().':'.'</span>';
//                    $result['dataOption'] .= '<span >'.$value_o.'</span>';
//                    $result['dataOption'] .='</p>';
//                }
//                $result['dataOption'] .='</div>';
//            }
//            if($param_p['links']){
//                $result['dataOption'] .='<div class="option-d">';
//                $result['dataOption'] .='<p>'.$product->getLinksTitle().'</p>';
//                $result['dataOption'] .='<ul>';
//                foreach($param_p['links'] as $key_d=>$value_d) {
//                    foreach($product->getDownloadableLinks() as $link)
//                    {
//                        if($link->getId()==$value_d) {
//                            $result['dataOption'] .='<li>'.$link->getTitle().'</li>';
//                            break;
//                        }
//                    }
//                }
//                $result['dataOption'] .='</ul>';
//                $result['dataOption'] .='</div>';
//            }
//            if($param_p['super_group']) {
//                $result['dataOption'] .='<div class="option-group">';
//                foreach($param_p['super_group'] as $key_g=>$value_g) {
//                    $model_p=Mage::getModel('catalog/product')->load($key_g);
//                    $result['dataOption'] .='<p><span>'.$model_p->getName().':'.'</span>';
//                    $result['dataOption'] .= '<span >'.$value_g.'</span></p>';
//                }
//                $result['dataOption'] .='</div>';
//            }
//            if(count($param_p['super_attribute'])) {
//                $result['dataOption'] .='<div class="option-cf">';
//                foreach($param_p['super_attribute'] as $key=>$value)
//                {
//                    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $key);
//                    $result['dataOption'] .='<p><span>'.$this->__($attribute->getName()).':'.'</span>';
//                    $result['dataOption'] .= '<span>'.$attribute->getSource()->getOptionText($value).'</span></p>';
//                }
//                $result['dataOption'] .='</div>';
//            }
//            if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
//                $result['dataOption'].=$this->getBundleOptions($product);
//            }
            $block = Mage::app()->getLayout()->createBlock('ajaxcart/ajaxcart', 'ajaxcart.js');
//            if (Mage::getSingleton('checkout/cart')->getSummaryQty() == 1) {
//                $result['dataOption'] .=  "<p>".$this->__('There is') .' <a href="'.$block->getUrl('checkout/cart').'" id="items-count">1' . $this->__(' item') . '</a> '.$this->__('in your cart.')."</p>";
//            }
//            else {
//                $result['dataOption'] .=  "<p>".$this->__('There are') .' <a href="'.$block->getUrl('checkout/cart').'" id="items-count">'.Mage::getSingleton('checkout/cart')->getSummaryQty().  $this->__(' items') . '</a> '.  $this->__('in your cart.')."</p>";
//            }
//            $result['dataOption'] .= '<p>' . $this->__('Cart Subtotal:') . ' <span class="total-price">' .  Mage::helper('checkout')->formatPrice($this->getSubtotal($cart));
//            if ($_subtotalInclTax = $this->getSubtotalInclTax($cart)) {
//                $result['dataOption'] .= '<br />(' . Mage::helper('checkout')->formatPrice($_subtotalInclTax) .' ' . Mage::helper('tax')->getIncExcText(true). ')';
//            }
//            $result['dataOption'] .='</span></p>';
            
            $result['dataOption'] .='<p class="text-center"><a class="button" href="'.Mage::getUrl('onestepcheckout').'">'.$this->__('Checkout').'</a><a class="button cart-continue">'.$this->__('Continue').'</a></p>';
            //$result['dataOption'] .='<p class="text-center"><a class="button" href="'.Mage::getUrl('checkout/onepage', array('_secure'=>true)).'">'.$this->__('Checkout').'</a><a class="button cart-continue">'.$this->__('Continue').'</a></p>';
        }
        $result = $this->replaceJs($result);
        return Zend_Json::encode($result);
    }
    public function getSubtotal($cart, $skipTax = true)
    {
        $subtotal = 0;
        $totals = $cart->getQuote()->getTotals();
        $config = Mage::getSingleton('tax/config');
        if (isset($totals['subtotal'])) {
            if ($config->displayCartSubtotalBoth()) {
                if ($skipTax) {
                    $subtotal = $totals['subtotal']->getValueExclTax();
                } else {
                    $subtotal = $totals['subtotal']->getValueInclTax();
                }
            } elseif($config->displayCartSubtotalInclTax()) {
                $subtotal = $totals['subtotal']->getValueInclTax();
            } else {
                $subtotal = $totals['subtotal']->getValue();
                if (!$skipTax && isset($totals['tax'])) {
                    $subtotal+= $totals['tax']->getValue();
                }
            }
        }
        return $subtotal;
    }
    
    public function getSubtotalInclTax($cart)
    {
        if (!Mage::getSingleton('tax/config')->displayCartSubtotalBoth()) {
            return 0;
        }
        return $this->getSubtotal($cart, false);
    }
    //replace js   
    private function replaceJs($result)
    {
         $arrScript = array();
         $result['script'] = '';               
         preg_match_all("@<script type=\"text/javascript\">(.*?)</script>@s",  $result['dataOption'], $arrScript);
         $result['dataOption'] = preg_replace("@<script type=\"text/javascript\">(.*?)</script>@s",  '', $result['dataOption']);
         foreach($arrScript[1] as $script){ 
             $result['script'] .= $script;                 
         }
         $result['script'] =  preg_replace("@var @s",  '', $result['script']); 
         return $result;
    }  
    protected function _getProductRequest($requestInfo)
    {
        if ($requestInfo instanceof Varien_Object) {
            $request = $requestInfo;
        } elseif (is_numeric($requestInfo)) {
            $request = new Varien_Object(array('qty' => $requestInfo));
        } else {
            $request = new Varien_Object($requestInfo);
        }

        if (!$request->hasQty()) {
            $request->setQty(1);
        }

        return $request;
    }	
	protected function getBundleOptions($product)
    {
		
			$html='<div>';
			$optionCollection = $product->getTypeInstance()->getOptionsCollection();
				$selectionCollection = $product->getTypeInstance()->getSelectionsCollection($product->getTypeInstance()->getOptionsIds());
				$options = $optionCollection->appendSelections($selectionCollection);
				foreach( $options as $option )
				{	
					
					$_selections = $option->getSelections();
					foreach( $_selections as $selection )
					{
						if($selection->getName())
						{	
							$html .='<p class="option-bundle"><span>'.$option->getTitle().'</span></p>';
							$html .= '<p><span>'.$selection->getName().'</span></p>';
						}else
						{
							$html .=''; 
						}
					}
					
				}
				$html .= '</div>';
        return $html;
    }
    public function deleteAction()
    {
        $id  =  (int) $this->getRequest()->getPost('id');
        $cart = Mage::getSingleton('checkout/cart');
        $response = array(
            'message'       => '',
            'cart_count' => '<span class="total-badge">'.$cart->getItemsCount().'</span>'
        );

        if ($id) {
            try {
                $response['message'] = $this->__('Item was removed successfully.');
                $cart->removeItem($id)
                    ->save();
            } catch (Exception $e) {
                $response['message'] = $this->__('Cannot remove the item.');
				$response['mlog'] = $e->getMessage();
                Mage::logException($e);
            }
        }
        $response['cart_count'] = '<span class="total-badge">'.$cart->getItemsCount().'</span>';
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }
	
	
	
	public function import_categoriesAction(){
		exit;
		$data = file_get_contents("./json.txt");				// It contains all categories in JSON
		$data = json_decode($data, true);
		
		require_once 'app/Mage.php';
		Mage::app("admin");
		
		foreach($data as $key => $value){
			if($value['level'] == 6){		// change for every level, start from 2
			
				echo "<br />";
			
				$category = Mage::getModel('catalog/category');
				$category->setName($value['name']);
				$category->setUrlKey($value['url_key']);				
				$category->setIsActive($value['is_active']);
				//$category->setEventId(1);
				$category->setThumbnail($value['thumbnail']);
				$category->setImage($value['image']);
				$category->setDescription($value['description']);
				$category->setMetaTitle($value['meta_title']);
				$category->setMetaDescription($value['meta_description']);
				$category->setIncludeInMenu($value['include_in_menu']);
				
				$category->setDisplayMode('PRODUCTS');
				$category->setIsAnchor($value['is_anchor']); //for active achor
				$category->setStoreId(Mage::app()->getStore()->getId());
				
				if($value['level'] > 2){
					$path_tree = array();
				
					foreach($value['path'] as $_level => $name){
						$_tree_category = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $name)->addFieldToFilter('level',$_level)->getFirstItem();
						$path_tree[] = $_tree_category->getId();
					}	
				
					$path_tree = "1/2/".implode("/", $path_tree);
					$category->setPath($path_tree);
				}else{
					$parentCategory = Mage::getModel('catalog/category')->load(trim($value['parent_id']));
					$category->setPath($parentCategory->getPath());
				}
				
				try{
					//$parentCategory = Mage::getModel('catalog/category')->load($value['parent_id']);			
					$category->save();					
					echo "done <br />";
					
				} catch(Exception $e) {
					var_dump($e);
				}
			}
		}
	}
	
	public function super_attr_id($id){
		$attrs = array(141=>159, 157=>161, 156=>160, 134=>149, 155=>151, 75=>75, 81=>81, 154=>150, 92=>92, 139=>152, 172=>156, 153=>158, 152=>148, 160=>147, 150=>153, 140=>162);
		
		return $attrs[$id];
	}
	
	public function asid($row){
		if($row['attribute_set_id'] == 10){
			$attribute_set_id = 9;
		}elseif($row['attribute_set_id'] == 11){
			$attribute_set_id = 10;
		}
		return $attribute_set_id;
	}
	
	public function get_option_value_id($attribute_code=false, $value=false){
		
		$to_find = "";
		if($value){
			$to_find = trim($value);
		}
	
		if($attribute_code){
			$attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", trim($attribute_code));
			$options = $attribute_details->getSource()->getAllOptions(false);
			foreach($options as $option){
				
				if($option["label"] == $to_find){
					return $option["value"];
				}
			}
		}
		return false;
	}
	
	public function import_productsAction(){
		error_reporting(E_ALL);
		$data = file_get_contents("./test_configurable.txt");				// It contains all categories in JSON
		$data = json_decode($data, true);
		
		require_once 'app/Mage.php';
		Mage::app("admin");
		
		$count = 0;
		$dup = 0;
		foreach($data as $row){
			$count++;
			$load_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($row['sku']));
				
			if(!$load_product){
				$this->create_product($row);
			}else{
				$dup++;
			}
		}
		echo $count;
		echo "<br />";
		echo "Dup = ".$dup;
	}
	
	public function import_configurable_assocAction(){
		error_reporting(E_ALL);
		$data = file_get_contents("./test_configurable.txt");				// It contains all categories in JSON
		$data = json_decode($data, true);
		
		require_once 'app/Mage.php';
		Mage::app("admin");
		
		$n = 0;
		foreach($data as $sku => $row){
			$n++;
			
			if($n > 0){
				$product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($sku));
				echo $product->getSku();
				
				$simple_products = array();
				$child_products = array();
				foreach($row['childs'] as $n => $child){
					
					$child_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($child));
					$simple_products[] = $child_product;
					$child_products[] = $child_product->getId();
				}
				
				try{
					Mage::getResourceSingleton('catalog/product_type_configurable')->saveProducts($product, $child_products);
					
					//Super attribute ids
					$super_attr_ids = array();
					foreach($row['super_attribute_codes'] as $s_a){
						$__attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", trim($s_a));
						$super_attr_ids[] = $__attribute->getAttributeId();
					}	
					
					$product->getTypeInstance()->setUsedProductAttributeIds($super_attr_ids);
					$configurableAttributesData = $product->getTypeInstance()->getConfigurableAttributesAsArray();
	 
					$product->setCanSaveConfigurableAttributes(true);
					$product->setConfigurableAttributesData($configurableAttributesData);
					
					$configurableProductsData = array();
					foreach($simple_products as $simple_product){
						
						$attribute_details = array();
						foreach($row['super_attribute_codes'] as $super_attribute_code){
						
							$_attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", trim($super_attribute_code));
						
							$attribute_details[] = array(
								'label' => $simple_product->getAttributeText(trim($super_attribute_code)),
								'attribute_id' => $_attribute->getAttributeId(),
								'value_index' => $this->get_option_value_id(trim($super_attribute_code), trim($simple_product->getAttributeText(trim($super_attribute_code)))),
								'is_percent' => '0',
								'pricing_value' => $simple_product->getPrice()
							);
						}
						
						$configurableProductsData[$simple_product->getId()] = array($attribute_details);
						$configurableAttributesData[0]['values'][] = $attribute_details;
					}
					
					$product->setConfigurableProductsData($configurableProductsData);
					
					//$product->getResource()->save($product);
					$product->save();
					
					//sleep(10);
					
					/*$usedProducts = $product->getTypeInstance(true)->getUsedProducts(null, $product);
					foreach($usedProducts as $p){
						$_p = Mage::getModel("catalog/product")->load($p->getId());
						foreach($row['super_attribute_codes'] as $super_attribute_code){
							echo $value = $_p->getData(trim($super_attribute_code));
							echo "<br />";
							try{
								Mage::getSingleton('catalog/product_action')->updateAttributes(array($product->getId()), array(trim($super_attribute_code) => $value), 0);
							}catch(Exception $e){
								echo "<br />";
								echo $e->getMessage();
							}
						}	
					}*/
					
					echo "<br />created<br />";
							
				}catch(Exception $e){
					echo "<br />";
					echo $e->getMessage();
				}
			}
		}
	}	
	
	public function import_products_oldAction(){
		error_reporting(E_ALL);
		$data = file_get_contents("./test_configurable.txt");				// It contains all categories in JSON
		$data = json_decode($data, true);
		
		require_once 'app/Mage.php';
		Mage::app("admin");
		
		/*foreach($data as $row){
			//print_r($row);
			$content = file_get_contents('http://bellfieldclothing.com/media/catalog/product'.$row['image']);
			$image = explode('/', $row['image']);
			
			file_put_contents('media/import/'.$image[3], $content);
			$new_path = 'media/import/'.$image[3];
			echo "<br /><br />";
		}
		exit;*/
		
		foreach($data as $row){
		
			if($row['type_id'] == 'configurable'){
				
				$load_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($row['sku']));
				
				if(!$load_product){
					//Create all simple products first
					$simple_products = array();
					foreach($row['childs'] as $child_id => $childs){
						$simple_products[] = $this->create_simple($childs);
					}
					
					echo count($simple_products);
					echo " - ";
					//Create Configurable Product
					$config_product = $this->create_config($row);
					echo $row['sku'];
					echo "<br />";
					///////////////////////////////////////////////////////////////////////////////////////////////
					
					//Super attribute ids
					$super_attr_ids = array();
					foreach($row['super_attribute_codes'] as $s_a){
						$__attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", trim($s_a));
						$super_attr_ids[] = $__attribute->getAttributeId();
					}	
					
					$config_product->getTypeInstance()->setUsedProductAttributeIds($super_attr_ids);
					$configurableAttributesData = $config_product->getTypeInstance()->getConfigurableAttributesAsArray();
	 
					$config_product->setCanSaveConfigurableAttributes(true);
					$config_product->setConfigurableAttributesData($configurableAttributesData);
					
					$configurableProductsData = array();
					foreach($simple_products as $simple_product){
						
						$attribute_details = array();
						foreach($row['super_attribute_codes'] as $super_attribute_code){
						
							$_attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", trim($super_attribute_code));
						
							$attribute_details[] = array(
								'label' => $simple_product->getAttributeText(trim($super_attribute_code)),
								'attribute_id' => $_attribute->getAttributeId(),
								'value_index' => $this->get_option_value_id(trim($super_attribute_code), trim($simple_product->getAttributeText(trim($super_attribute_code)))),
								'is_percent' => '0',
								'pricing_value' => $simple_product->getPrice()
							);
						}
						
						$configurableProductsData[$simple_product->getId()] = array($attribute_details);
						$configurableAttributesData[0]['values'][] = $attribute_details;
					}
					
					$config_product->setConfigurableProductsData($configurableProductsData);
					//$config_product->setConfigurableAttributesData($configurableAttributesData);
					
					try{
						$config_product->save();
						echo "<br />created<br />";
						
					}catch(Exception $e){
						echo $e->getMessage();
					}
				}else{
					echo "<br />Product exists - ".$row['sku']."<br />";
				}	
				
			}elseif($row['type_id'] == 'simple'){
				
				try {
					$_product
				//    ->setStoreId(1) //you can set data in store scope
					->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
					->setAttributeSetId(20) //ID of a attribute set named 'default'
					->setTypeId('simple') //product type
					->setCreatedAt(strtotime('now')) //product creation time
				//    ->setUpdatedAt(strtotime('now')) //product update time
					->setSku($row['sku']) //SKU
					->setName($row['name']) //product name
					->setAttributeSet($row['_attribute_set'])	//****************
					->setType($row['_type'])					//****************
					->setCategory($row['_category'])					//****************
					->setProductWebsites($row['_product_websites'])					//****************
					->setWeight($row['weight'])
					->setColor($row['color'])
					->setUrlKey($row['url_key'])
					->setStatus(1) //product status (1 - enabled, 2 - disabled)
					//->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
					->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
					->setManufacturer($row['manufacturer']) //manufacturer id
					->setColor($row['color'])
					//->setNewsFromDate('06/26/2014') //product set as new from
					//->setNewsToDate('06/30/2014') //product set as new to
					//->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
					->setPrice($row['price']) //price in form 11.22
					//->setCost(22.33) //price in form 11.22
					->setSpecialPrice($row['special_price']) //special price in form 11.22
					//->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
					//->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
					//->setMsrpEnabled(1) //enable MAP
					//->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
					//->setMsrp(99.99) //Manufacturer's Suggested Retail Price
					->setMetaTitle($row['meta_title'])
					->setMetaKeyword($row['meta_keyword'])
					->setMetaDescription($row['meta_description'])
					->setDescription($row['description'])
					->setShortDescription($row['short_description'])
					->setImage($row['image'])
					->setSmallImage($row['small_image'])
					->setThumbnail($row['thumbnail'])
					->setMediaGallery(array('images' => array(), 'values' => array())) //media gallery initialization
					->setStockData(array(
							'use_config_manage_stock' => 0, //'Use config settings' checkbox
							'manage_stock' => 1, //manage stock
							'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
							'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
							'is_in_stock' => 1, //Stock Availability
							'qty' => 999 //qty
						)
					)
					->setCategoryIds(array(3, 10)); //assign product to categories
					$_product->save();
				} catch (Exception $e) {
					Mage::log($e->getMessage());
					echo $e->getMessage();
				}
			}else{
			
			}
		}
	
	}
	
	public function create_product($row){
		$load_simple_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($row['sku']));
		
		if(!$load_simple_product){
			$_product = Mage::getModel('catalog/product');
			
			$_product
					//    ->setStoreId(1) //you can set data in store scope
						->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
						->setAttributeSetId($this->asid($row)) //ID of a attribute set named 'default'
						->setTypeId($row['type_id']) //product type
						//->setCreatedAt(strtotime('now')) //product creation time
					   	//->setUpdatedAt(strtotime('now')) //product update time
						->setSku($row['sku']) //SKU
						->setName($row['name']) //product name
						
						//->setCategory($row['_category'])					//****************
						//->setProductWebsites($row['_product_websites'])					//****************
						//->setWeight($row['weight'])
						//->setColor($row['color'])
						//->setSizeNumeric($row['size_numeric'])
						//->setUrlKey($row['url_key'])
						->setStatus(1) //product status (1 - enabled, 2 - disabled)
						->setTaxClassId($row['tax_class_id']) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
						->setVisibility($row['visibility']) //catalog and search visibility
						//->setManufacturer($row['manufacturer']) //manufacturer id
						//->setNewsFromDate('06/26/2014') //product set as new from
						//->setNewsToDate('06/30/2014') //product set as new to
						//->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
						->setPrice($row['price']) //price in form 11.22
						//->setCost(22.33) //price in form 11.22
						->setSpecialPrice($row['special_price']) //special price in form 11.22
						//->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
						//->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
						//->setMsrpEnabled(1) //enable MAP
						//->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
						//->setMsrp(99.99) //Manufacturer's Suggested Retail Price
						->setMetaTitle($row['meta_title'])
						->setMetaKeyword($row['meta_keyword'])
						->setMetaDescription($row['meta_description'])
						->setDescription($row['description'])
						->setShortDescription($row['short_description'])
						//->setImage($row['image'])
	//					->setSmallImage($row['small_image'])
	//					->setThumbnail($row['thumbnail'])
	//					->setMediaGallery(array('images' => array(), 'values' => array())) //media gallery initialization
						;
						
						if($row['type_id'] == 'configurable'){
							$_product->setStockData(array(
												'is_in_stock' => $row['stock_available'], //Stock Availability
											)
										);
						}else{
							$_product->setStockData(array(
												'is_in_stock' => $row['stock_available'], //Stock Availability
												'qty' => $row['qty'] //qty
											)
										);
						}
						
						
						if($row['size'] != ''){
							$_product->setData('size', $this->get_option_value_id('size', trim($row['size'])));
						}
						if($row['color'] != ''){
							$_product->setData('color', $this->get_option_value_id('color', trim($row['color'])));
						}
						if($row['shoe_size'] != ''){
							$_product->setData('shoe_size', $this->get_option_value_id('shoe_size', trim($row['shoe_size'])));
						}
						if($row['size_guide'] != ''){
							$_product->setData('size_guide', $this->get_option_value_id('size_guide', trim($row['size_guide'])));
						}
						if($row['event_id'] != ''){
							$_product->setData('event_id', $this->get_option_value_id('event_id', trim($row['event_id'])));
						}
						if($row['gender'] != ''){
							$_product->setData('gender', $this->get_option_value_id('gender', trim($row['gender'])));
						}
						if($row['jeans_size'] != ''){
							$_product->setData('jeans_size', $this->get_option_value_id('jeans_size', trim($row['jeans_size'])));
						}
						if($row['size_numeric'] != ''){
							$_product->setData('size_numeric', $this->get_option_value_id('size_numeric', trim($row['size_numeric'])));
						}
						if($row['size_womens'] != ''){
							$_product->setData('size_womens', $this->get_option_value_id('size_womens', trim($row['size_womens'])));
						}
						if($row['womens_shoes'] != ''){
							$_product->setData('womens_shoes', $this->get_option_value_id('womens_shoes', trim($row['womens_shoes'])));
						}
						
					try{	
						$product = $_product->save();
						$product = Mage::getModel('catalog/product')->load($product->getId());
						
						return $product;
					} catch (Exception $e) {
						Mage::log($e->getMessage());
						echo $e->getMessage();
					}
		}else{
			echo "<br />Product exists - ".$row['sku']."<br />";
		}
	}
	
	public function create_config($row){
		
		$configProduct = Mage::getModel('catalog/product');
				
		$super_attribures = array();
		foreach($row['super_attributes'] as $attr){
			$super_attributes[] = $this->super_attr_id($attr);
		}
		
		$content = file_get_contents('http://bellfieldclothing.com/media/catalog/product'.$row['image']);
		$image = explode('/', $row['image']);
	
		file_put_contents('./media/import/'.$image[3], $content);
		$new_path = $image[3];
		
		
		try {
			$configProduct
				->setStoreId(1) //you can set data in store scope
				->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
				->setAttributeSetId($this->asid($row)) //ID of a attribute set named 'default'
				->setTypeId('configurable') //product type
				//->setCreatedAt(strtotime('now')) //product creation time
				//->setUpdatedAt(strtotime('now')) //product update time
				->setSku($row['sku']) //SKU
				->setName($row['name']) //product name
				//->setWeight(4.0000)
				->setStatus(1) //product status (1 - enabled, 2 - disabled)
				->setTaxClassId($row['tax_class_id']) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
				->setVisibility($row['visibility']) //catalog and search visibility
				//->setManufacturer(28) //manufacturer id
				//->setNewsFromDate(strtotime($row['news_to_date'])) //product set as new from
				//->setNewsToDate(strtotime($row['news_from_date'])) //product set as new to
				//->setCountryOfManufacture($row['country_of_manufacture']) //country of manufacture (2-letter country code)
				//->setBrand($row['brand'])
				//->setSize($row['size'])
				//->setColor($row['color'])
				//->setJeansSize($row['jeans_size'])
				//->setShoeSize($row['shoe_size'])
				->setStyleMens($row['style_mens_'])
				//->setSizeGuide($row['size_guide'])
				//->setStyleWomens($row['style_womens'])
				//->setSizeNumeric($row['size_numeric'])
				//->setWomensShoes($row['womens_shoes'])
				
				//->setEventId($row['event_id'])
				->setEanNumber($row['ean_number'])
				
				->setSeason($row['season'])
				->setImageStoring($row['image_storing'])
				
				
				->setUrlKey($row['url_key'])
				->setLocationNumber($row['location_number'])
				
				
				->setPrice($row['price']) //price in form 11.22
				//->setCost(22.33) //price in form 11.22
				->setSpecialPrice($row['special_price']) //special price in form 11.22
				->setSpecialFromDate(strtotime($row['special_from_date'])) //special price from (MM-DD-YYYY)
				->setSpecialToDate(strtotime($row['special_to_date'])) //special price to (MM-DD-YYYY)
				//->setMsrpEnabled(1) //enable MAP
				//->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
				//->setMsrp(99.99) //Manufacturer's Suggested Retail Price
				->setMetaTitle($row['meta_title'])
				->setMetaKeyword($row['meta_keyword'])
				->setMetaDescription($row['meta_description'])
				->setDescription($row['description'])
				->setShortDescription($row['short_description'])
				->setIsSaleable($row['is_saleable'])
				->setMediaGallery(array('images' => array(), 'values' => array())) //media gallery initialization
				->setStockData(array(
						//'use_config_manage_stock' => 0, //'Use config settings' checkbox
						//'manage_stock' => 1, //manage stock
						'is_in_stock' => $row['stock_available'], //Stock Availability
					)
				)
			;
			
			if($row['size'] != ''){
				$configProduct->setData('size', $this->get_option_value_id('size', trim($row['size'])));
			}
			if($row['color'] != ''){
				$configProduct->setData('color', $this->get_option_value_id('color', trim($row['color'])));
			}
			if($row['shoe_size'] != ''){
				$configProduct->setData('shoe_size', $this->get_option_value_id('shoe_size', trim($row['shoe_size'])));
			}
			if($row['size_guide'] != ''){
				$configProduct->setData('size_guide', $this->get_option_value_id('size_guide', trim($row['size_guide'])));
			}
			if($row['event_id'] != ''){
				$configProduct->setData('event_id', $this->get_option_value_id('event_id', trim($row['event_id'])));
			}
			if($row['gender'] != ''){
				$configProduct->setData('gender', $this->get_option_value_id('gender', trim($row['gender'])));
			}
			if($row['jeans_size'] != ''){
				$configProduct->setData('jeans_size', $this->get_option_value_id('jeans_size', trim($row['jeans_size'])));
			}
			if($row['size_numeric'] != ''){
				$configProduct->setData('size_numeric', $this->get_option_value_id('size_numeric', trim($row['size_numeric'])));
			}
			if($row['size_womens'] != ''){
				$configProduct->setData('size_womens', $this->get_option_value_id('size_womens', trim($row['size_womens'])));
			}
			if($row['womens_shoes'] != ''){
				$configProduct->setData('womens_shoes', $this->get_option_value_id('womens_shoes', trim($row['womens_shoes'])));
			}
			
			// Set Image To Gallery
			$mediaArray = array(
				'image'       => $new_path,
			);
			
			// Remove unset images, add image to gallery if exists
			$importDir = Mage::getBaseDir('media') . DS . 'import/';
			
			foreach($mediaArray as $imageType => $fileName) {
				$filePath = $importDir.$fileName;
				if ( file_exists($filePath) ) {
					try {
						$configProduct->addImageToMediaGallery($filePath, $imageType, false);
					} catch (Exception $e) {
						echo $e->getMessage();
					}
				} else {
					echo "Product does not have an image or the path is incorrect. Path was: {$filePath}<br/>";
				}
			}
			
			return $configProduct;
			
		} catch (Exception $e) {
			Mage::log($e->getMessage());
			echo $e->getMessage();
		}
	}
	
	public function create_simple($row){
		$load_simple_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($row['sku']));
		
		if(!$load_simple_product){
			$_product = Mage::getModel('catalog/product');
			
			$_product
					//    ->setStoreId(1) //you can set data in store scope
						->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
						->setAttributeSetId($this->asid($row)) //ID of a attribute set named 'default'
						->setTypeId('simple') //product type
						->setCreatedAt(strtotime('now')) //product creation time
					//    ->setUpdatedAt(strtotime('now')) //product update time
						->setSku($row['sku']) //SKU
						->setName($row['name']) //product name
						->setAttributeSet($this->asid($row))
						->setType($row['type_id'])					//****************
						//->setCategory($row['_category'])					//****************
						//->setProductWebsites($row['_product_websites'])					//****************
						//->setWeight($row['weight'])
						//->setColor($row['color'])
						//->setSizeNumeric($row['size_numeric'])
						//->setUrlKey($row['url_key'])
						->setStatus(1) //product status (1 - enabled, 2 - disabled)
						->setTaxClassId($row['tax_class_id']) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
						->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
						//->setManufacturer($row['manufacturer']) //manufacturer id
						//->setNewsFromDate('06/26/2014') //product set as new from
						//->setNewsToDate('06/30/2014') //product set as new to
						//->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
						->setPrice($row['price']) //price in form 11.22
						//->setCost(22.33) //price in form 11.22
						->setSpecialPrice($row['special_price']) //special price in form 11.22
						//->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
						//->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
						//->setMsrpEnabled(1) //enable MAP
						//->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
						//->setMsrp(99.99) //Manufacturer's Suggested Retail Price
						->setMetaTitle($row['meta_title'])
						->setMetaKeyword($row['meta_keyword'])
						->setMetaDescription($row['meta_description'])
						->setDescription($row['description'])
						->setShortDescription($row['short_description'])
						//->setImage($row['image'])
	//					->setSmallImage($row['small_image'])
	//					->setThumbnail($row['thumbnail'])
	//					->setMediaGallery(array('images' => array(), 'values' => array())) //media gallery initialization
						//->setStockData(array(
	//							'is_in_stock' => $row['stock_available'], //Stock Availability
	//							'qty' => $row['qty'] //qty
	//						)
	//					)
						//->setCategoryIds(array(3, 10)); //assign product to categories
						;
						
						/*foreach($row['child_attribute_values'] as $value_data){
							$_product->setData($value_data['code'], $this->get_option_value_id($value_data['code'], trim($value_data['label'])));
						}*/
						if($row['size'] != ''){
							$_product->setData('size', $this->get_option_value_id('size', trim($row['size'])));
						}
						if($row['color'] != ''){
							$_product->setData('color', $this->get_option_value_id('color', trim($row['color'])));
						}
						if($row['shoe_size'] != ''){
							$_product->setData('shoe_size', $this->get_option_value_id('shoe_size', trim($row['shoe_size'])));
						}
						if($row['size_guide'] != ''){
							$_product->setData('size_guide', $this->get_option_value_id('size_guide', trim($row['size_guide'])));
						}
						if($row['event_id'] != ''){
							$_product->setData('event_id', $this->get_option_value_id('event_id', trim($row['event_id'])));
						}
						if($row['gender'] != ''){
							$_product->setData('gender', $this->get_option_value_id('gender', trim($row['gender'])));
						}
						if($row['jeans_size'] != ''){
							$_product->setData('jeans_size', $this->get_option_value_id('jeans_size', trim($row['jeans_size'])));
						}
						if($row['size_numeric'] != ''){
							$_product->setData('size_numeric', $this->get_option_value_id('size_numeric', trim($row['size_numeric'])));
						}
						if($row['size_womens'] != ''){
							$_product->setData('size_womens', $this->get_option_value_id('size_womens', trim($row['size_womens'])));
						}
						if($row['womens_shoes'] != ''){
							$_product->setData('womens_shoes', $this->get_option_value_id('womens_shoes', trim($row['womens_shoes'])));
						}
						
					try{	
						$product = $_product->save();
						$product = Mage::getModel('catalog/product')->load($product->getId());
						
						return $product;
					} catch (Exception $e) {
						Mage::log($e->getMessage());
						echo $e->getMessage();
					}
		}else{
			echo "<br />Product exists - ".$row['sku']."<br />";
		}
	}
	
	public function no_image_productsAction(){
		
		$products = Mage::getModel('catalog/product')
								->getCollection()
								//->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
								->addAttributeToSelect('*')
								//->setPageSize(50)
								//->addFieldToFilter('special_price', array(array('gt'=>'0')))
								//->addAttributeToFilter('category_id', array('in' => trim(11)))
								//->addAttributeToFilter('status', 1)
								//->addAttributeToFilter('type_id', 'simple')
								->addAttributeToFilter(array(
											array (
												'attribute' => 'image',
												'like' => 'no_selection'
											),
											array (
												'attribute' => 'image', // null fields
												'null' => true
											),
											array (
												'attribute' => 'image', // empty, but not null
												'eq' => ''
											),
											array (
												'attribute' => 'image', // check for information that doesn't conform to Magento's formatting
												'nlike' => '%/%/%'
											),
									)
								)
								;
		echo count($products);	
	}
	
	public function import_imagesAction(){
		//$data = file_get_contents("./test_gallery.txt");				// It contains all categories in JSON
		$page = trim($_GET['p']);
		$data = file_get_contents("http://www.bellfieldclothing.com/usd/theme/export/export_products_images/p/".$page);
		$data = json_decode($data, true);
		
		//print_r($data);exit;
		require_once 'app/Mage.php';
		Mage::app("admin");
		
		// Remove unset images, add image to gallery if exists
		$importDir = Mage::getBaseDir('media') . DS . 'import/';
		
		//print_r($data);exit;
		
		foreach($data as $k => $product){
			$file = explode('/', $product['image']);
			
			$_product_img = file_get_contents("http://bellfieldclothing.com/media/catalog/product".$product['image']);			
			file_put_contents('./media/import/'.$file[3], $_product_img);
			
			//print_r($product['image']);
			//print_r($file);exit;
			/*echo $product['sku'];
			echo "<br />";*/
			$p = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($product['sku']));
			//$load_product = Mage::getModel('catalog/product')->load(770);
			$load_product = Mage::getModel('catalog/product')->load($p->getId());
			
			
			/*$mediaGallery = $load_product->getMediaGallery();
			echo $load_product->getSku();
			echo "<br />";
			if (isset($mediaGallery['images'])){
                echo count($mediaGallery['images']);
				echo " - ";
				echo count($product['gallery_images']);
				echo "<br />";
				echo "<br />";
				//if(count($mediaGallery['images'])==count($product['gallery_images'])){
					
				//}
				
			}*/
			
			
			if(isset($product['gallery_images']) && !empty($product['gallery_images'])){
				foreach($product['gallery_images'] as $k => $image){
					$_file = explode('/', $image);
					
					$_g_product_img = file_get_contents("http://bellfieldclothing.com/media/catalog/product".$image);
					file_put_contents('./media/import/'.$_file[3], $_g_product_img);
					
					$imgFile = $importDir . $_file[3];
				
					// Add three image sizes to media gallery
					$mediaArray = array(
								'thumbnail',
								'small_image',
								'image'
							);
					
					if (file_exists($imgFile)){
						try{
							$load_product->addImageToMediaGallery($imgFile, $mediaArray, false, false);
							
						} catch (Exception $e){
							echo $e->getMessage();
						}
					} else {
						echo "Could not match image to ".$product['sku']." Path was: ".$image."\n";
						break;
					}
				}
			}elseif($product['image'] != ''){			
				$imgFile = $importDir . $file[3];
				
				// Add three image sizes to media gallery
				$mediaArray = array(
							'thumbnail',
							'small_image',
							'image'
						);
				if (file_exists($imgFile)){
					try{
						$load_product->addImageToMediaGallery($imgFile, $mediaArray, false, false);
						//$load_product->save();
						
					} catch (Exception $e){
						echo $e->getMessage();
					}
				} else {
					echo "Could not match image to ".$product['sku']." Path was: ".$product['image']."\n";
					break;
				}
			}
			
			$load_product->save();
			echo "Sku: ".$product['sku']." updated.\n";
			echo "<br />";
			//
			$c = 0;
			$mediaGallery = $load_product->getMediaGallery();
			if (isset($mediaGallery['images'])){
                foreach ($mediaGallery['images'] as $image){
                    Mage::getSingleton('catalog/product_action')->updateAttributes(array($load_product->getId()), array('image'=>$image['file']), 0);
					Mage::getSingleton('catalog/product_action')->updateAttributes(array($load_product->getId()), array('small_image'=>$image['file']), 0);
					Mage::getSingleton('catalog/product_action')->updateAttributes(array($load_product->getId()), array('thumbnail'=>$image['file']), 0);
                    $c++;
                    break;
                }
            }
		}
		
		$page = $page+1;
		echo "<a href='http://bellfield.launchsolutions.co.uk/ajaxcart/ajax/import_images?p=".$page."'>NEXT</a>";
		
		?>
        <script type="text/javascript">
        window.setTimeout(function(){
			window.location = 'http://bellfield.launchsolutions.co.uk/ajaxcart/ajax/import_images?p=<?php echo $page?>';
		}, 10000);
        </script>
        <?php
		
		//exit;
		
		/*echo "Loading catalog...\n";
		$products = Mage::getModel('catalog/product')->setStoreId(13)->getCollection()->addAttributeToSelect('*');
		echo count($products) . " products selected for image import.\n";
		
		// Remove unset images, add image to gallery if exists
		$importDir = Mage::getBaseDir('media') . DS . 'import/';
		
		foreach ($products as $product){
			$sku = Mage::getModel('catalog/product')->load($product->getId())->getSku();
			if (strstr($sku, " ")){
				echo "Sku - ".$sku." contains whitespace, skipping.\n";
				continue;
			}
			
			$imgFile = $importDir . $sku . ".jpg";
			
			// Add three image sizes to media gallery
			$mediaArray = array(
						'thumbnail',
						'small_image',
						'image'
					);
			if (file_exists($imgFile)){
				try{
					$product->addImageToMediaGallery($imgFile, $mediaArray, false, false);
					$product->save();
					//echo "Sku: $sku updated.\n";
				} catch (Exception $e){
					echo $e->getMessage();
				}
			} else {
				echo "Could not match image to $sku. Path was: {$filePath}\n";
				break;
			}
		}*/
	}
	
}
