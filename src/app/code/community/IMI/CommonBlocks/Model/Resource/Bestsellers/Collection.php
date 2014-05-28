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
 * Bestsellers live data
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Model_Resource_Bestsellers_Collection extends Mage_Sales_Model_Resource_Order_Item_Collection
{
    protected $_category = 0;

    /**
     * Number of days in the past to consider
     * @var
     */
    protected $_days;

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->_days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->_days = $days;
        return $this;
    }


    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
        return $this;
    }

    protected function _beforeLoad()
    {
        parent::_beforeLoad();

        $table = 'catalog/category_product_index';
        $this->join( array('cp' => $table), 'cp.product_id = main_table.product_id');
        $this->getSelect()->where('cp.category_id = ' . $this->getCategory());
        $this->getSelect()->where('cp.store_id = ' . Mage::app()->getStore()->getId());
        $this->getSelect()->where('main_table.created_at > (NOW() - INTERVAL ' . $this->getDays() . ' DAY)');
        $this->getSelect()->where('main_table.store_id = ' . Mage::app()->getStore()->getId());
        $this->getSelect()->group('main_table.product_id');
        $this->addExpressionFieldToSelect('counter', 'SUM({{main_table.qty_ordered}})', 'main_table.qty_ordered');
        $this->getSelect()->order('counter DESC');
        return $this;
    }


}