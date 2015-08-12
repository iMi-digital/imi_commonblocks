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
 * Generate a list of categories
 *
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Links_Categories extends Mage_Page_Block_Template_Links
{
    /** @method getParentCategoryId */

    protected function _construct()
    {
        parent::_construct();

        /** same caching policy as in @see \Mage_Catalog_Block_Navigation::_construct */
        $this->addData(array('cache_lifetime' => false));
        $this->addCacheTag(array(
            Mage_Catalog_Model_Category::CACHE_TAG,
            Mage_Core_Model_Store_Group::CACHE_TAG
        ));
    }

    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $category = Mage::getModel('catalog/category');
        $category->load($this->getParentCategoryId());

        if (!$category->getId()) {
            throw new Mage_Core_Exception(sprintf('Category id "%s" not found', $this->getParentCategoryId()));
        }
        $children = $category->getChildrenCategories();

        foreach($children as $child)  { /* @var $child Mage_Catalog_Model_Category */
            $this->addLink($child->getName(), $child->getUrl());
        }
        return $this;
    }
}