.. include:: ../../Includes.txt

.. _events-property:

Properties
==========

Events will process valuable information that are used to fill so-called
“properties”.

Properties can contain any type of value and can be used in several ways,
depending on their type.

.. note::

    For more information about creating custom properties, see chapter
    “:ref:`administrator-properties`”.

.. _events-property-marker:

Marker
------

Marker is the most common type of property: it can contain any value. It can be
used by a notification; the name of the marker will be replaced by the actual
value during runtime.

For instance the event “Extension installed” fills a marker named ``title``. In
the body of an email notification, if the value ``{title}`` is found it will be
replaced during runtime with the title of the installed extension.

.. code-block:: php
    :caption: ``EXT:notiz/Classes/Domain/Event/TYPO3/ExtensionInstalledEvent.php``

    class ExtensionInstalledEvent extends AbstractEvent
    {
        /**
         * @label Event/TYPO3/ExtensionInstalled:marker.title
         * @marker
         *
         * @var string
         */
        protected $title;
    }

.. figure:: /Images/05-Events/Property/marker.png
    :alt: List of markers

.. _events-property-email:

Email
-----

An email property contains a valid email address. These properties can be used
in the recipient fields of an email notification.

.. code-block:: php
    :caption: ``EXT:my_extension/Classes/Domain/Event/MyCustomEvent.php``

    class MyCustomEvent extends AbstractEvent
    {
        /**
         * @label User who connected to the application
         * @email
         *
         * @var string
         */
        protected $user;
    }

.. figure:: /Images/05-Events/Property/email.png
    :alt: Recipients emails
