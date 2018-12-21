.. include:: ../../Includes.txt

PHP objects
===========

.. _administrator-objects-notification:

Notification
------------

A notification implements the interface
:php:`\CuyZ\Notiz\Core\Notification\Notification`, giving access to the methods
below.

.. tip::

    Please note that depending on the type of the notification, even more
    methods can be available.

.. container:: table-row

    Method
        :php:`Notification::getTitle()`
    Return type
        :php:`string`
    Description
        Returns the title of the notification.

.. container:: table-row

    Method
        :php:`Notification::getNotificationDefinition()`
    Return type
        :php:`\CuyZ\Notiz\Core\Definition\Tree\Notification\NotificationDefinition`
    Description
        Returns the definition object of the notification.

.. container:: table-row

    Method
        :php:`Notification::hasEventDefinition()`
    Return type
        :php:`bool`
    Description
        Returns whether the notification is bound to an event or not.

.. container:: table-row

    Method
        :php:`Notification::getEventDefinition()`
    Return type
        :php:`\CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition`
    Description
        Returns the definition object of the event bound to the notification.
        If no event is bound, an exception is thrown.

.. container:: table-row

    Method
        :php:`Notification::getEventConfiguration()`
    Return type
        :php:`array`
    Description
        Returns the configuration of the event. If no configuration is found, an
        empty array is returned.

.. _administrator-objects-event:

Event
-----

An event implements the interface :php:`\CuyZ\Notiz\Core\Event\Event`, giving
access to the following methods:

.. tip::

    Please note that depending on the type of the event, even more methods can
    be available.

.. container:: table-row

    Method
        :php:`Event::getDefinition()`
    Return type
        :php:`\CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition`
    Description
        Returns the definition object of the event.

.. container:: table-row

    Method
        :php:`Event::getNotification()`
    Return type
        :php:`\CuyZ\Notiz\Core\Notification\Notification`
    Description
        Returns the notification that is being dispatched by this event.
