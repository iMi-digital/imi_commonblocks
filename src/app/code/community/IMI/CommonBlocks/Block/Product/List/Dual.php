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
 * Block can act as topseller block or use a static category, depending on the system configuration
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Product_List_Dual extends IMI_CommonBlocks_Block_Product_List_Topsellers
{
    protected function _getProductCollection()
    {
        if (Mage::getModel('imi_commonblocks/config')->getAutomatic()) {
            return parent::_getProductCollection();
        } else {
            return IMI_CommonBlocks_Block_Product_List_Simple::_getProductCollection();
        }
    }


}