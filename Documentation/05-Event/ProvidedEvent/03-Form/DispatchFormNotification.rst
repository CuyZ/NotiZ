.. include:: ../../../Includes.txt

Form – Notification finisher
============================

.. important::

    To use this event, the `Form extension`_ must be installed and active.

-----

This event is triggered when a form that implements the notification dispatch
finisher is submitted.

The following properties can be used in notifications:

==================== ===========================================================
Property             Description
==================== ===========================================================
formValues           Form values submitted by the user

formRuntime          Runtime object of the form, contains a lot of useful
                     information

controllerContext    Current controller context that led to the submission of
                     the form
==================== ===========================================================

The form must be configured to use the provided finisher:

.. figure:: /Images/05-Events/ProvidedEvent/Form/notification-finisher.png
    :alt: Form notification finisher

The event can then be selected in notifications; the desired form must be
selected as well:

.. figure:: /Images/05-Events/ProvidedEvent/Form/notification-event.png
    :alt: Form notification event

.. _Form extension: https://docs.typo3.org/typo3cms/extensions/form/Index.html
