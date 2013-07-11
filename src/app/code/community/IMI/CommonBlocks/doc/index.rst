IMI_CommonBlocks
====

imi_commonblocks/links_categories
---------------------------------

Generate list of child categories for a template links block (which can be included in the footer for example)

First it is necessary to call the action ``setParentCategoryId`` in the layout XML.



imi_commonblocks/products_list/simple
-------------------------------------

Simple product list.

Uses the standard template which should include something like:

.. code::php

   $simpleView = $this->getIsSimpleView();  // simplified view


imi_commonblocks/subcategories
------------------------------

A block meant to be included in catalog/category/view.phtml to show a list of sub categories.

Insert to view.phtml:

.. code::php

    <?php echo $this->getChildHtml('subcategories') ?>

The block has to be inserted on those pages where the sub categories shall be visibile:

.. code::xml

    <reference name="category.products">
        <block type="imi_commonblocks/subcategories" name="category.products.subcategories" as="subcategories"
               template="catalog/category/subcategories.phtml"/>
    </reference>