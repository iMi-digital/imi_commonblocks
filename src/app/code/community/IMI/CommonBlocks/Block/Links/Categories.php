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
    public function getParentCategoryId()
    {
        return 3; // "Vileda/Products"
    }

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

    public function getSubCategories()
    {
        $helper = Mage::helper('catalog/category');
        $all = $helper->getStoreCategories();
        echo count($all);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $category = Mage::getModel('catalog/category');
        $category->load($this->getParentCategoryId());
        $children = $category->getChildrenCategories();

        foreach($children as $child)  { /* @var $child Mage_Catalog_Model_Category */
            $this->addLink($child->getName(), $child->getUrl());
        }
        return $this;
    }
}