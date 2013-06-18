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
 *
 * @category IMI
 * @package IMI_MODULE
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Product_List_Simple extends Mage_Catalog_Block_Product_List
{
    /**
     * Mark this as simple view for the template
     * @return bool
     */
    public function getIsSimpleView()
    {
        return true;
    }

    public function getToolbarHtml()
    {
        return '';
    }

    public function getMode()
    {
        return 'grid';
    }


}
