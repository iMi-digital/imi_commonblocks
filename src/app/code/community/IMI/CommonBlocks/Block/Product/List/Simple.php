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

    protected function _getProductCollection()
    {
        $categoryId = $this->getCategoryId();
        $category = Mage::getModel('catalog/category')->load($categoryId);

        if (!$category->getId()) {
            throw new Mage_Exception(sprintf('Category ID "%s" not found', $categoryId));
        }

        $collection = $category->getProductCollection();

        /* @see \Mage_Catalog_Model_Layer::prepareProductCollection */
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite($categoryId);
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);


        $collection->setPageSize($this->getCount()); /** TODO: make size configurable  */

        return $collection;
    }

    protected function _beforeToHtml()
    {
        $this->_getProductCollection()->load();

        return parent::_beforeToHtml();
    }


}
