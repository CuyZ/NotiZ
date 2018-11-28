.. include:: ../Includes.txt

.. _example:

Example & Screenshots
=====================

@todo notiz-demo.gif

In this simple example we are going to create a notification to send an email
every time an extension is installed in the backend.

Add a new notification
----------------------

In the TYPO3 backend, open the notification manager module. A list of available
notification types is shown, we click on the button to create a new email
notification.

.. figure:: /Images/03-Example/notification-manager.png
    :alt: Add a new notification

Configuring the notification
----------------------------

Name
''''

The first thing to do is to name the notification: we use a short descriptive
title. We can also add a full description if needed.

.. figure:: /Images/03-Example/notification-email-general.png
    :alt: Notification tab general

Event
'''''

The extension comes out of the box with an event for when an extension is
installed. This event can be selected in the list.

.. figure:: /Images/03-Example/notification-email-event.png
    :alt: Notification tab event

Email content
'''''''''''''

We can then configure the email content: fill the subject and body; we can make
use of the available markers provided by the event.

.. figure:: /Images/03-Example/notification-email-configuration.png
    :alt: Notification tab configuration

Recipients
''''''''''

Recipients must be filled for the email to be received correctly. It can be
filled up with raw email address(es).

.. note::

    Some events may even suggest dynamic recipient, see chapter
    “:ref:`notification-email-recipients`” for more information.

.. figure:: /Images/03-Example/notification-email-recipients.png
    :alt: Notification tab recipients

Seeing the details of the notification
--------------------------------------

After saving the notification, the details can be viewed within the manager
module:

.. figure:: /Images/03-Example/notification-view-details.png
    :alt: Notification details

Triggering the notification
---------------------------

Now that the notification is configured, let's install an extension.

.. figure:: /Images/03-Example/install-extension.png
    :alt: Installing an extension

The received email
------------------

And here is the email we received:

.. figure:: /Images/03-Example/received-email.png
    :alt: The received email
