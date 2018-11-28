.. include:: ../../Includes.txt

.. _administrator-definition-preview:

Preview definition
==================

The module “Administration” in the TYPO3 backend allows to see a tree view of
what has been filled in the definition.

This view has two goals:

1. **Being able to see every single value in the definition**

   It allows to understand what is processed by the extension during runtime.

   It can be used when doing definition manipulation, to see if everything goes
   as planned (see if a definition file is correctly imported, check if a value
   is valid…).

2. **View definition errors**

   When an error is found while the definition is being built, the error is
   detailed in the tree.

   It helps to understand what is the source of the error and how to correct it.

.. figure:: /Images/06-Administrator/01-Definition/preview-definition-tree.png
    :alt: Preview of the definition tree
