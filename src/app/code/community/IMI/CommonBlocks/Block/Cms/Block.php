<?php

/**
 * CMS Static Block which can fetch the title
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Cms_Block extends Mage_Cms_Block_Block
{

    public function getTitle()
    {
        $blockId = $this->getBlockId();
        if ($blockId) {
            $block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($blockId);
            return $block->getTitle();
        }
        return null;
    }
}