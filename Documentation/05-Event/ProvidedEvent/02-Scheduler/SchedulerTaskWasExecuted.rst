.. include:: ../../../Includes.txt

Scheduler – Task successful
===========================

.. important::

  To use this event, the Scheduler extension must be installed on the system.

-----

This event is fired when a scheduler task is successfully executed.

The following properties can be used in notifications:

============ ===================================================================
Property     Description
============ ===================================================================
uid          Uid of the task, for instance `123`
title        Title of the task, for instance `Reporting`
description  Description of the task
data         Arbitrary data that can be filled by the task and used as markers
result       Result of the task process (should be a boolean value)
============ ===================================================================
