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


class IMI_CommonBlocks_Helper_Youtube extends Mage_Core_Helper_Abstract
{

    /**
     * Extract ID from URL
     * @param $url string YouTube URL
     */
    public function extractId($url)
    {
        if (preg_match('/v=([a-zA-Z0-9_-]*)/i', $url, $result)) {
            return $result[1];
        } else {
            return false;
        }
    }

    /**
     * @param $id string YouTube video ID
     */
    public function getEmbedLink($id)
    {
        return '//www.youtube.com/embed/' . $id . '?rel=0';
    }
}
