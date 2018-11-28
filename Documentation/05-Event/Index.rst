.. include:: ../Includes.txt

Events
======

Events are one of the main aspect of the extension. Each event is a PHP class
representing something happening in an application.

They can contain variables that will be made available in the dispatched
notification.

An event class is bound to either a TYPO3 signal or a hook.

Provided events
---------------

The extension comes with several events out of the box. They can be used right
after installation.

See chapter “:ref:`events-providedEvent`” for a full list of all provided
events.

Add custom event
----------------

In most cases, adding a custom event will require developer skills. See chapter
“:ref:`administrator-events`” for more information.

Properties
----------

Events will process valuable information that are used to fill so-called
“properties”.

Properties can contain any type of value and can be used in several ways,
depending on their type.

See chapter “:ref:`events-property`” for more information.

.. toctree::
    :hidden:
    :titlesonly:
    :glob:

    */Index
