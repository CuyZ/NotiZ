.. include:: ../../Includes.txt

.. _administrator-rights:

Manage backend users rights
===========================

The access to the module “Manager” and each notification types can be configured
for users and user-groups.

.. hint::

    The module “Administration” can be accessed by administrators only; editors
    will never be allowed to access it.

.. note::

    The core extension “Backend User Administration” must be installed on the
    system to do the steps below.

Give access to the manager module
---------------------------------

In the module “Backend users”, when editing a user or a user-group record, a
list of accessible modules can be found.

A line for the module “Notification > Manager” can be found, it is unchecked by
default for every user. Checking it will give access to the wanted user(s).

Configure access to notification types
--------------------------------------

.. note::

    Only user-group can configure access to notification types and fields. A
    user must inherit from this user-group to be granted access.

In the module “Backend users”, when editing a user-group record, the actions
below can be done:

1. **Give read access** to each notification type in the section “Tables
   (listing)”. It will show each activated notification in the manager module.

2. **Give write access** to each notification type in the section “Tables
   (modify)”. It will show links to edit notifications in the manager module.

3. **Configure each field that can be edited** in the section “Allowed
   excludefields”. Only checked fields will be shown in the edition view of the
   notification.
