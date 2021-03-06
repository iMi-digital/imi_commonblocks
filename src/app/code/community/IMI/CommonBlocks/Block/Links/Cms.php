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
class IMI_CommonBlocks_Block_Links_Cms extends Mage_Page_Block_Template_Links
{
    /** @method getParentCategoryId */

    protected $_nodesData = null;

    function _construct()
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
     * Set parent node via URL identifier
     * will then set parentNodeId
     * @param $key
     */
    public function setParentNodeIdentifier($identifier)
    {
        $nodes = $this->getNodesData();
        foreach($nodes as $node) {
            if ($node['identifier'] == $identifier) {
                $this->setParentNodeId($node['node_id']);
                return;
            }
        }

        Mage::logException(new Mage_Exception(sprintf('Parent node identifier "%s" not found in current store ID: %s', $identifier, Mage::app()->getStore()->getId())));
    }

    /**
     * Load nodes data array
     *
     * @return array|null
     */
    protected function getNodesData()
    {
        if ($this->_nodesData == null) {
            $hierachy = Mage::getModel('enterprise_cms/hierarchy_node', array(
                'scope' => Enterprise_Cms_Model_Hierarchy_Node::NODE_SCOPE_STORE,
                'scope_id' => Mage::app()->getStore()->getId(),
            ))->getHeritage();

            $this->_nodesData = $hierachy->getNodesData();
        }

        return $this->_nodesData;
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

        $nodes = $this->getNodesData();

        $nodeModel = Mage::getModel('enterprise_cms/hierarchy_node');

        $foundAnyEntry = false;

        $insertedNodes = array();
        foreach ($nodes as $node) {
            if ($node['parent_node_id'] != $parentId) {
                continue;
            }

            $foundAnyEntry = true;

            $nodeData = $nodeModel->load($node['node_id']);

            // hide inactive pages
            if (!$nodeData
                || ($nodeData->getPageId() && !$nodeData->getPageIsActive())
            ) {
                continue;
            }

            // make sure to add a link only once
            if(in_array($nodeData->getLabel(), $insertedNodes))
            {
                continue;
            }

            $insertedNodes[] = $nodeData->getLabel();
            $this->addLink($nodeData->getLabel(), $nodeData->getUrl());
        }

        if (!$foundAnyEntry) {
            Mage::logException(new Mage_Exception(sprintf('No entries found for parent ID %s - node not in this store?', $parentId)));
            return $this;
        }

        return $this;
    }
}