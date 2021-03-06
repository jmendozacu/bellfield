<?php
/**
 * MageWorx
 * MageWorx SeoReports Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoReports
 * @copyright  Copyright (c) 2017 MageWorx (http://www.mageworx.com/)
 */



class MageWorx_SeoReports_Model_Resource_Product_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('mageworx_seoreports/product');
    }

    public function addFieldToFilter($field, $condition = null)
    {
        /** @var MageWorx_SeoReports_Helper_Config $helper */
        $helper = Mage::helper('mageworx_seoreports/config');

        if ($field == 'meta_title_error') {
            if ($condition == 'missing') {
                $field     = 'prepared_meta_title';
                $condition = array('eq' => '');
            }
            elseif ($condition == 'long') {
                $field     = 'meta_title_len';
                $condition = array('gt' => $helper->getMaxLengthMetaTitle());
            }
            elseif ($condition == 'duplicate') {
                $field     = 'meta_title_dupl';
                $condition = array('gt' => '1');
            }
        }
        elseif ($field == 'name_error') {
            if ($condition == 'duplicate') {
                $field     = 'name_dupl';
                $condition = array('gt' => '1');
            }
        }
        elseif ($field == 'meta_descr_error') {
            if ($condition == 'missing') {
                $field     = 'meta_descr_len';
                $condition = array('eq' => '0');
            }
            elseif ($condition == 'long') {
                $field     = 'meta_descr_len';
                $condition = array('gt' => $helper->getMaxLengthMetaDescription());
            }
        }
        elseif ($field == 'url_error') {
            if ($condition == 'duplicate') {
                $field     = 'url_dupl';
                $condition = array('gt' => '1');
            }
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Retrieve all ids for collection
     *
     * @return array
     */
    public function getAllIds()
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $idsSelect->reset(Zend_Db_Select::COLUMNS);

        $idsSelect->columns('product_id', 'main_table');
        return $this->getConnection()->fetchCol($idsSelect);
    }
}