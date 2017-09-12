<?php 
/**
 * ITORIS
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ITORIS's Magento Extensions License Agreement
 * which is available through the world-wide-web at this URL:
 * http://www.itoris.com/magento-extensions-license.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@itoris.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extensions to newer
 * versions in the future. If you wish to customize the extension for your
 * needs please refer to the license agreement or contact sales@itoris.com for more information.
 *
 * @category   ITORIS
 * @package    ITORIS_LAYEREDNAVIGATION
 * @copyright  Copyright (c) 2012 ITORIS INC. (http://www.itoris.com)
 * @license    http://www.itoris.com/magento-extensions-license.html  Commercial License
 */

/**
 * Model that represents categories filter as tree.
 */
class Itoris_LayeredNavigation_Model_Layer_MultiFilter_Category_Tree
			extends Itoris_LayeredNavigation_Model_Layer_MultiFilter_Category {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Prepare filter items: subcategories of the current category recursively.
	 *
	 * @return Itoris_LayeredNavigation_Model_Layer_MultiFilter_Category_Tree
	 */
	protected function _initItems() {
		$category   = $this->getCategory();

		/** @var $category Mage_Catalog_Model_Categeory */
		
		$top_level_cat = false;
		if($category->getLevel() > 2){
			
			$men_cat_id = Mage::getStoreConfig('theme/general/men_root_cat_id');
			$women_cat_id = Mage::getStoreConfig('theme/general/women_root_cat_id');
			
			$cat_path = explode("/", $category->getPath());
			foreach($cat_path as $cat_path_id){
				if(trim($cat_path_id) == trim($women_cat_id)){
					$top_level_cat = trim($women_cat_id);
				}
				if(trim($cat_path_id) == trim($men_cat_id)){
					$top_level_cat = trim($women_cat_id);
				}
			}
		}
		
		if($top_level_cat){
			$category = Mage::getModel('catalog/category')->load($top_level_cat);
		}
		
		
		$allChildCategories = array();
		$categories = $category->getChildrenCategories();

		$this->getAllChildCategories($categories, $allChildCategories);

		$this->getLayer()->getProductCollection()->addCountToCategories($allChildCategories);

		$allowedChildCategories = array();
		foreach ($allChildCategories as $category) {
			if ($category->getIsActive() && count($category->getProductCount()) > 0) {
				$allowedChildCategories[] = $category;

				$category->setFilter($this);
				$category->setValue($category->getId());
			}
		}

		$rootCategories = array();
		foreach ($categories as $root) {
			if(in_array($root, $allowedChildCategories)) {
				$rootCategories[] = $root;
			}
		}

		$this->setAllowedChildCategories($allowedChildCategories);

		$this->_items = $rootCategories;
		return $this;
	}

	/**
	 * Applied filter items should be marked to be shown as checked checkbox
	 * otherwise they will be passed to the browser as hidden inputs.
	 */
	public function updateStateItemsStatus() {
		/** @var $helper Itoris_LayeredNavigation_Helper_Data */
		$helper = Mage::helper('itoris_layerednavigation');
		$helper->initFilterItems($this->getLayer()->getState(), $this->getAllowedChildCategories());
	}

	public function setItems($items) {
		$this->_items = $items;
	}

	public function setAllowedChildCategories($allowedChildCategories) {
		$this->allowedChildCategories = $allowedChildCategories;
	}

	public function getAllowedChildCategories() {
		return $this->allowedChildCategories;
	}

	/**
	 * Array of active categories that have at least one product.
	 *
	 * @var array
	 */
	protected $allowedChildCategories;
}
?>