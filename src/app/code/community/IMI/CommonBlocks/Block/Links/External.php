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

/**
 * Provide configurable external links
 *
 * @category IMI
 * @package IMI_CommonBlock
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Links_External extends Mage_Core_Block_Template
{

    /**
     * Maps the config code to the link to prepend
     */
    protected function getUrlMapInitial()
    {
        return array(
            'corporate' => '',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'http://www.twitter.com/',
            'googleplus' => 'https://plus.google.com/',
            'youtube' => 'http://www.youtube.com/user/',
            'instagram' => 'http://instagram.com/'
        );
    }

    public function _construct()
    {
        parent::_construct();
        $this->setUrlMap($this->getUrlMapInitial());
    }

    /**
     * Remove a link
     *
     * @param $code
     */
    public function removeLink($code)
    {
        $map = $this->getUrlMap();

        if (isset($map[$code])) {
            unset($map[$code]);
            $this->setUrlMap($map);
        }
    }

    /**
     * Check if the link is enabled
     *
     * @param $code
     * @return bool
     */
    public function hasLink($code)
    {
        // generally defined and not removed?
        $map = $this->getUrlMap();
        if (!isset($map[$code])) {
            return false;
        }

        // configured?
        return Mage::getSingleton('imi_commonblocks/config')->getExternalLinkPart($code) != '';
    }

    /**
     * Get the full link
     *
     * @param $code
     * @return string
     * @throws IMI_ViledaLocal_Exception
     */
    public function getLink($code) {
        if (!$this->hasLink($code)) {
            throw new IMI_ViledaLocal_Exception('No link configured. Check hasLink first!');
        }
        $map = $this->getUrlMap();
        return $map[$code] . Mage::getSingleton('imi_commonblocks/config')->getExternalLinkPart($code);
    }
}