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
 * Simple product list
 *
 * @category IMI
 * @package IMI_MODULE
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Block_Product_List_Simple extends Mage_Catalog_Block_Product_List
{
    public function __construct()
    {
        parent::__construct();
        $this->setModuleName('Mage_Catalog');
    }

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

    /**
     * How many items to show?
     *
     * @return mixed
     */
    public function getCount()
    {
        if (!$this->getData('count')) {
            $this->setData('count', 3);
        }

        return $this->getData('count');
    }

    protected function getCategory()
    {
        if ($this->getData('category_id') == 'current') {
            $category = Mage::registry('current_category');
        } elseif ($this->getData('category_id') == '') {
            if ($favoritesCategoryId = Mage::getModel('imi_commonblocks/config')->getFavoritesCategory()) {
                $category = Mage::getModel('catalog/category')->load($favoritesCategoryId);
            } else {
                $category = Mage::registry('current_category');
            }
        } else {
            $category = Mage::getModel('catalog/category')->load($this->getData('category_id'));
        }
        if (!$category->getId()) {
            throw new Mage_Exception(sprintf('Category ID "%s" not found', $this->getData('category_id')));
        }
        return $category;
    }

    /**
     * @return Varien_Data_Collection_Db
     * @throws Mage_Exception
     * @throws Mage_Core_Exception
     */
    protected function _getProductCollection()
    {
        $category = $this->getCategory();

        $collection = $category->getProductCollection();

        /* @see \Mage_Catalog_Model_Layer::prepareProductCollection */
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite();
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);


        $collection->setPageSize($this->getCount());

        return $collection;
    }

    public function getCacheKeyInfo()
    {
        $info = parent::getCacheKeyInfo();
        $info[] = $this->getCategory()->getId();
        return $info;
    }


}
