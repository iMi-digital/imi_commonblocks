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
 * Outputs current system version. Detection priority
 *
 * 1) File ../VERSION (to be filled from your deploy script)
 * 2) output of git describe
 *
 * If developer mode is on, also the time of the most recent cache clearing is shown.
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Version extends Mage_Core_Block_Template
{
    const CACHE_KEY = 'imi_commonblocks_version';

    protected function getVersionFile()
    {
        return BP . DS . '../' . 'VERSION';
    }

    /**
     * Return the version number from the VERSION file.
     * Those exist only on packaged rollouts.
     *
     * If Developer Mode is on, also the current time (last config cache clear) is shown.
     * We use the config cache as this is a good indicator for the last dev/testing rollout.
     *
     * @return string
     */
    protected function detectVersion()
    {
        $cache = Mage::app()->getCache();
        if ($cache->load('imi_commonblocks_version')) {
            $result = $cache->load(self::CACHE_KEY);
        } else {
            if (file_exists($this->getVersionFile())) {
                $result = file_get_contents($this->getVersionFile());
                $result = trim($result);
            } else {
                exec('git describe', $output);
                $result = trim(implode(' ', $output));
                if ($result != '') {
                    $result = 'GIT: ' . $result;
                } else {
                    $result = '?';
                }
            }
            $cache->save($result, self::CACHE_KEY, array(Mage_Core_Model_Config::CACHE_TAG));
        }

        if (Mage::getIsDeveloperMode()) {
            $result .= ' ' . $this->formatDate() . ' ' . $this->formatTime();
        }

        return $result;
    }

    public function _toHtml()
    {
        return $this->detectVersion();
    }
}
 