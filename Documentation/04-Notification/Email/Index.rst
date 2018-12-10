.. include:: ../../Includes.txt

.. _notification-email:

Email notification
==================

General configuration
---------------------

The title can be an arbitrary label that will be used to identify the
notification in the TYPO3 backend.

A full description can also be added if needed.

.. figure:: /Images/04-Notification/Email/notification-email-general.png
    :alt: Email tab general

Event
-----

On this tab, an event must be selected among the ones available.

.. note::

    Some events might have a custom configuration. For instance, the event
    “TYPO3 > Scheduler task was executed” allows to select which specific task
    will fire the event.

.. figure:: /Images/04-Notification/Email/notification-email-event.png
    :alt: Email tab event

Channel
-------

The mailer that will do the actual sending must be selected.

.. note::

    TYPO3 comes out of the box with a basic mailer, custom implementations may
    be added in the future.

.. figure:: /Images/04-Notification/Email/notification-email-channel.png
    :alt: Email tab channel

Email content
-------------

.. _notification-email-layout:

Layout
''''''

A layout must be chosen for this email. This can be a custom one:

.. code-block:: typoscript

    notiz {
        notifications {
            entityEmail {
                settings {
                    view {
                        layouts {
                            myLayout {
                                label = My custom layout
                                path = Html/MyLayout
                            }
                        }

                        layoutRootPaths.50 = EXT:my_extension/Resources/Private/Layouts/Mail/
                        templateRootPaths.50 = EXT:my_extension/Resources/Private/Templates/Mail/
                        partialRootPaths.50 = EXT:my_extension/Resources/Private/Partials/Mail/
                    }
                }
            }
        }
    }

.. code-block:: html
    :caption: ``EXT:my_extension/Resources/Private/Layouts/Mail/Html/MyLayout.html``

    <html>
        <head>
            <style type="text/css">
                .some-class {
                    color: red;
                }
            </style>
        </head>
        <body>
            <div class="some-class">
                <f:render section="Body" optional="1" />
            </div>
        </body>
    </html>

.. figure:: /Images/04-Notification/Email/notification-email-layout.png
    :alt: Email layout

Subject and body
''''''''''''''''

On this tab, the mail subject and body can be configured.

.. hint::

    These fields can use markers that will be replaced by dynamic values before
    the email is sent. See chapter “:ref:`events-property-marker`” for more
    information.

.. hint::

    The body may be customized for complex emails. See the chapters
    “:ref:`notification-email-dynamicBody`” and
    “:ref:`notification-email-dynamicSlots`” for more information.

.. figure:: /Images/04-Notification/Email/notification-email-configuration.png
    :alt: Email tab configuration

.. _notification-email-recipients:

Recipients
----------

As many emails as needed can be added, for each type of recipient.

Email addresses can be written in two different formats:

- Without the name: ``john@example.com``
- With the name: ``John Smith <john@example.com>``

.. hint::

    Some events provide dynamic recipient emails. For instance, a contact form
    asking for the user's email address can provide it as a recipient "User that
    filled the form".

    See chapter “:ref:`events-property-email`” for more information.

Global recipients
'''''''''''''''''

Global recipients can also be defined and will be available in any email
notification; a good use-case is adding an administrator address as a global
recipient.

They can be configured in the definition at the path:
``notiz.notifications.entityEmail.settings.globalRecipients``.

.. figure:: /Images/04-Notification/Email/notification-email-recipients.png
    :alt: Email tab recipients

Sender
------

The default sender is configurable in the definition at the path:
``notiz.notifications.entityEmail.settings.defaultSender``.

It can also be overwritten in any notification entry.

.. figure:: /Images/04-Notification/Email/notification-email-sender.png
    :alt: Email tab sender

More
----

More aspect regarding emails can be found below:

.. toctree::
    :titlesonly:
    :glob:

    *
