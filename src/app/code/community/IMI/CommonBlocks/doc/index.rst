IMI_CommonBlocks
====

In addition to the following blocks, the config sections `local_general` and `local_advanced` are created in the system
configuration.

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

imi_commonblocks/topsellers
---------------------------

Fetches the top sold products for the configured category.
The top sellers are fetched directly from the orders. No refresh of backend statistics is necessary.
The block is cached in the block cache for 24 hours (theme specific).

imi_commonblocks/dual
---------------------

Allows switching between the simple product list (products of a category) and the topsellers via backend configuration
Local > Advanced > Topsellers / Favorites.

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

imi_commonblocks/gatracking
---------------------------

A block which displays Google Analytics Tracking code.

.. code::php

    <?php echo $this->getChildHtml('gatracking') ?>

The block has to be inserted on product detail reseller block, to pass parameters of shown product

.. code::xml

     <reference name="product.resellers">
            <block type="imi_commonblocks/gatracking" name="catalog.products.gatracking" as="gatracking"
                   template="catalog/product/view/gatracking.phtml"/>
     </reference>