.. include:: ../../../Includes.txt

TYPO3 – Record created/updated
==============================

This event is fired when any record is created/updated within the TYPO3 backend.

You must select which record type will fire the event, for instance
``tt_content``.

If you selected ``tt_content``, you shall also filter which type of record will
be filtered by filling the filter field with a valid regex, for instance
``/text(pic)?/``.

The following properties can be used in notifications:

============ ===================================================================
Property     Description
============ ===================================================================
status       Status of the record, either ``new`` or ``update``
table        Table of the record, for instance ``tt_content``
uid          Record uid
record       Raw record array
============ ===================================================================
