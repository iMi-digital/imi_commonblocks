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
 * All categories
 * @see Mage_Adminhtml_Model_System_Config_Source_Category
 * @category IMI
 * @package IMI_CommonBlocks
 * @author iMi digital GmbH <info@iMi.de>
 */
class IMI_CommonBlocks_Model_Config_Source_Category
{
    public function toOptionArray()
    {
        $collection = Mage::getResourceModel('catalog/category_collection');

        $collection->addAttributeToSelect('name')
            ->load();

        $options = array();

        $options[] = array(
            'label' => Mage::helper('adminhtml')->__('-- Please Select a Category --'),
            'value' => ''
        );
        foreach ($collection as $category) {
            $name = str_repeat('--', $category->getLevel() - 1) . ' ' .$category->getName();
            $options[] = array(
                'label' => $name,
                'value' => $category->getId()
            );
        }

        return $options;
    }
}
