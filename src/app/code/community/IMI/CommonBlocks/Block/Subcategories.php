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
 * Show a list of current subcategories list, including thumbnails and image
 *
 * @category IMI
 * @package IMI_MODULE
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Subcategories extends Mage_Core_Block_Template
{
    /**
     * Get collection
     * - include thumbnails and image
     * @see \Mage_Catalog_Model_Resource_Category::getChildrenCategories
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCollection()
    {
        $layer = Mage::getSingleton('catalog/layer');
        $category = $layer->getCurrentCategory();

        $collection = $category->getCollection();
        /* @var $collection Mage_Catalog_Model_Resource_Category_Collection */
        $collection->addAttributeToSelect('url_key')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('all_children')
            ->addAttributeToSelect('is_anchor')
            ->addAttributeToSelect('thumbnail')
            ->addAttributeToSelect('image')
            ->addAttributeToFilter('is_active', 1)
            ->addIdFilter($category->getChildren())
            ->setOrder('position', Varien_Db_Select::SQL_ASC)
            ->joinUrlRewrite();

        return $collection;
    }

    /**
     * Get Thumbnail URL
     * @param Mage_Catalog_Model_Category $_category
     */
    public function getThumbnailUrl(Mage_Catalog_Model_Category $_category)
    {
        if (!$_category->getThumbnail()) {
            return null;
        }
        return Mage::getBaseUrl('media').'catalog/category/' . $_category->getThumbnail();
    }

}
