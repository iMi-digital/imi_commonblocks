<?php
/**
 * iMi Magento Module
 *
 * NOTICE OF LICENSE

 * This source file is subject to the Open Software License (OSL 3.0)
 * which is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @copyright  Copyright (c) 2013-2015 iMi digital GmbH (http://www.iMi.de)
 * @author iMi digital GmbH <info@iMi.de>
 * @license OSL-3.0
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

    /**
     * @return int|mixed Number of days to consider
     */
    public function getDays()
    {
        if ($this->getData('days')) {
            return $this->getData('days');
        } else {
            return Mage::getModel('imi_commonblocks/config')->getDays();
        }
    }

    /**
     * Get bestsellers
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract|Varien_Data_Collection_Db
     * @throws Mage_Exception
     */
    protected function _getProductCollection()
    {
        $bestsellers = Mage::getResourceModel('imi_commonblocks/bestsellers_collection');

        $bestsellers->setCategory($this->getCategory()->getId())
            ->setDays($this->getDays());
        $bestsellers->getSelect()->limit($this->getCount(),0);
        $bestsellerids = array();
        foreach($bestsellers as $row) {
            $bestsellerids[] = $row->getProductId();
        }

        $collection = parent::_getProductCollection();
        $collection->addFieldToFilter('entity_id', array('in' => $bestsellerids));
        if (count($bestsellerids) > 0) {
            $collection->getSelect()->order('field(e.entity_id, '. implode(',',$bestsellerids) . ')');
        }
        return $collection;
    }

}
