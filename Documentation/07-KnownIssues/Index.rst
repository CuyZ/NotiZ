.. include:: ../Includes.txt

Known issues
============

.. contents::
    :local:

SQL error: 'Field 'xxx' doesn't have a default value'
-----------------------------------------------------

If this error occurs, a parameter must be changed in the Install Tool.

In the ``All configuration`` menu, search for ``setDBinit``.

In the ``[SYS][setDBinit]`` textarea, put ``SET SESSION sql_mode=''`` and save.

Notification translation is not working
---------------------------------------

Unfortunately, TYPO3 8.7 provides inconsistent behaviour with entities
translations, meaning you may encounter issues when working with translated
notifications.

At the moment, we do not provide a working solution for this for TYPO3 8.7
instances. If this is a concern for you, please consider contacting us for
trying to find a solution together.

.. note::

    TYPO3 9.5 instances are not affected by this issue, notification translation
    should work fine on these instances.
