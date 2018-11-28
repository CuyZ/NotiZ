.. include:: ../Includes.txt

Introduction
============

NotiZ is an extension allowing to easily manage notifications in a TYPO3
instance.

Notifications listen to events fired within the application and can be
dispatched to several channels: emails, SMS, Slack messages…

Simple example
--------------

   *When a user registers on the application, an email must be sent with*
   *details about the registration.*

1. Create a new email notification
2. Bind it to the event “A new user registered”
3. Fill in the different email information (recipients, title, body…)
4. Let the extension dispatch the emails

For a more detailed example, see chapter “:ref:`example`”.

Managing notifications
----------------------

Notifications are managed within the TYPO3 backend, using a proper module that
will list existing notifications and allow to edit them or create new ones.

Administrators as well as editors can access parts of the module, depending on
their rights (see chapter “:ref:`administrator-rights`”).

Integration in your own workflow
--------------------------------

Events provided out of the box by the extension will probably not be sufficient.
You may want notifications to be dispatched using your own events.

Firing events from within custom extensions is quite simple and can be done even
if an application is already running in production.

See chapter “:ref:`administrator-events`” for more information.
