.. include:: ../../../Includes.txt

TYPO3 – Caches cleared
======================

This event is fired every time some cache is cleared.

The following properties can be used in notifications:

============ ===================================================================
Property     Description
============ ===================================================================
cacheCommand Name of the executed cache command (common values are ``system``,
             ``page``, …)

pageUid      If the executed cache command is `page`, this marker contains the
             uid of the page of which cache was cleared
============ ===================================================================

For this event, the desired cache command can be selected as well:

.. figure:: /Images/05-Events/ProvidedEvent/TYPO3/clear-cache-options.png
    :alt: Cache command selection
