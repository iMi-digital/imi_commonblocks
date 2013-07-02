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
class IMI_CommonBlocks_Block_Links_Cms extends Mage_Page_Block_Template_Links
{
    /** @method getParentCategoryId */

    protected function _construct()
    {
        parent::_construct();

        /** same caching policy as in @see \Mage_Catalog_Block_Navigation::_construct */
        $this->addData(array('cache_lifetime' => false));
        $this->addCacheTag(array(
            Mage_Cms_Model_Page::CACHE_TAG,
            Mage_Core_Model_Store_Group::CACHE_TAG
        ));
    }

    /**
     * @see \Enterprise_Cms_Model_Observer::addCmsToTopmenuItems
     * @return $this|Mage_Page_Block_Template_Links
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $parentId = $this->getParentNodeId();

        if (empty($parentId)) {
            Mage::logException(new Mage_Exception('Parent Node not set'));
            return $this;
        }
        $hierarchyModel = Mage::getModel('enterprise_cms/hierarchy_node', array(
            'scope' => Enterprise_Cms_Model_Hierarchy_Node::NODE_SCOPE_STORE,
            'scope_id' => Mage::app()->getStore()->getId(),
        ))->getHeritage();

        $nodes = $hierarchyModel->getNodesData();

        $nodeModel = Mage::getModel('enterprise_cms/hierarchy_node');

        foreach ($nodes as $node) {
            if ($node['parent_node_id'] != $parentId) {
                continue;
            }

            $nodeData = $nodeModel->load($node['node_id']);

            // hide inactive pages
            if (!$nodeData
                || ($nodeData->getPageId() && !$nodeData->getPageIsActive())
            ) {
                continue;
            }

            $this->addLink($nodeData->getLabel(), $nodeData->getUrl());
        }

        return $this;
    }
}