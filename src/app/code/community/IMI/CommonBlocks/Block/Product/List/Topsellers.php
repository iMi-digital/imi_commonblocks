<?php
/**
 * iMi Magento Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject of iMi.
 * You may not be allowed to change the sources
 * without authorization of iMi digital GmbH.
 *
 * @copyright  Copyright (c) 2013 iMi digital GmbH (http://www.iMi.de)
 * @author iMi digital GmbH <info@iMi.de>
 * @license proprietary
 * @category IMI
 * @package IMI_CommonBlocks
 */

/**
 * Simple product list
 * Topsellers of the current category
 * @category IMI
 * @package IMI_MODULE
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Product_List_Topsellers extends IMI_CommonBlocks_Block_Product_List_Simple
{
    protected function _getProductCollection()
    {
        /*$bestsellers = Mage::getResourceModel('sales/report_bestsellers_collection');
        $bestsellers->setPeriod('month')
            ->setDateRange('-1 month', null)
            ->addStoreRestrictions(array(Mage::app()->getStore()->getId()));
        $bestsellers->load();
        $bestsellerids = array();
        foreach($bestsellers as $bestseller) {
            $bestsellerids[] = $bestseller->getProductId();
        }
        var_dump($bestsellerids);*/

        $bestsellers = Mage::getResourceModel('imi_commonblocks/bestsellers_collection');

        $bestsellers->setCategory($this->getCategory()->getId())
            ->setDays($this->getDays());
        $bestsellers->getSelect()->limit(3,0);
        $bestsellerids = array();
        foreach($bestsellers as $row) {
            $bestsellerids[] = $row->getProductId();
        }
        $collection = parent::_getProductCollection();
        $collection->addFieldToFilter('entity_id', array('in' => $bestsellerids));
        $collection->getSelect()->order('field(e.entity_id, '. implode(',',$bestsellerids) . ')');
        return $collection;
    }
}
