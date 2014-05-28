<?php

/**
 * iMi Magento Module
 *
 * NOTICE OF LICENSE

 * This source file is subject to the Open Software License (OSL 3.0)
 * which is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @copyright  Copyright (c) 2013 iMi digital GmbH (http://www.iMi.de)
 * @author iMi digital GmbH <info@iMi.de>
 * @license OSL-3.0
 * @category IMI
 * @package IMI_CommonBlocks
 */

class IMI_CommonBlocks_Model_Config {

    /**
     * Get external link-part
     *
     * @param $code Config code
     * @return mixed
     */
    public function getExternalLinkPart($code)
    {
        $linkpart = Mage::getStoreConfig('local_general/links/' . $code , null);

        return $linkpart;
    }

    public function getFavoritesCategory()
    {
        return Mage::getStoreConfig('local_general/favorites/category');
    }

    public function getAutomatic()
    {
        return Mage::getStoreConfig('local_general/favorites/automatic');
    }

    public function getDays()
    {
        $days = Mage::getStoreConfig('local_general/favorites/automatic_days');
        return $days;
    }

}
