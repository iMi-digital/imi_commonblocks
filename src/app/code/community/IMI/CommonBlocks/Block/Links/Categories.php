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
 * Generate a list of categories
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Links_Categories extends Mage_Page_Block_Template_Links
{

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->addLink('Mocked Category 1', 'link-mock1');
        $this->addLink('Mocked Category 2', 'link-mock2');

        return $this;
    }
}