.. include:: ../../Includes.txt

Log notification
================

General configuration
---------------------

The title can be an arbitrary label that will be used to identify the
notification in the TYPO3 backend.

A full description can also be added if needed.

.. figure:: /Images/04-Notification/Log/notification-log-general.png
    :alt: Log tab general

Event
-----

On this tab, an event must be selected among the ones available.

.. note::

    Some events might have a custom configuration. For instance, the event
    “TYPO3 > Scheduler task was executed” allows to select which specific task
    will fire the event.

.. figure:: /Images/04-Notification/Log/notification-log-event.png
    :alt: Log tab event

.. _notification-log-channel:

Channel
-------

The logger that will do the actual sending must be selected.

.. note::

    TYPO3 comes out of the box with a basic logger, more custom implementations
    may be added in the future.

    By default, this logger will write in a file located by default at
    ``typo3temp/logs/typo3_<hash>.log``.

.. figure:: /Images/04-Notification/Log/notification-log-channel.png
    :alt: Log tab channel

Log configuration
-----------------

On this tab, the log message and level can be configured.

.. hint::

    The message can use markers that will be replaced by dynamic values before
    the log is saved. See chapter “:ref:`events-property-marker`” for more
    information.

.. note::

    The log level is a `PSR-3 Log Level`_.

.. important::

    It is important to note that the chosen :ref:`logger <notification-log-channel>` might have a
    minimum log level that is higher than the notification log level.

    In that case the notification will not be logged.

.. figure:: /Images/04-Notification/Log/notification-log-configuration.png
    :alt: Log tab configuration

.. _PSR-3 Log Level: https://www.php-fig.org/psr/psr-3/#5-psrlogloglevel
