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
