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