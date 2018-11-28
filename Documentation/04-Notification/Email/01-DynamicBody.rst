.. include:: ../../Includes.txt

.. _notification-email-dynamicBody:

Dynamic email body
==================

An email body can quickly become so complex that the default configuration is
not enough.

The extension allows to easily customize how the rendering is done, and even
manage the sections shown in the backend record, to give editors more control on
the body content.

Register a custom template
--------------------------

By default, the basic template located at
``EXT:notiz/Resources/Private/Templates/Mail/Default.html`` is used.

However, it may be needed to have more logic in the template for a given event.
This can be done by creating a template file that matches the event identifier
(including the event group). The identifier needs to be transformed to the
“UpperCamelCase” syntax.

For instance, let's take the example below:

.. code-block:: typoscript

    notiz {
        eventGroups {
            contactEvents {
                label = Events related to contact forms

                events {
                    messageSent {
                        label = Contact form sent

                        // Other stuff…
                    }
                }
            }
        }
    }

We can see the event ``messageSent`` that is inside the group ``contactEvents``.
If we want to override the template for this event, a file named
``ContactEvents/MessageSent.html`` must be created.

.. tip::

    Remember to register the template paths of the custom extension. It can be
    done in the definition of the mail notification:

    .. code-block:: typoscript

        notiz {
            notifications {
                entityEmail {
                    view {
                        layoutRootPaths.50 = EXT:my_extension/Resources/Private/Layouts/Mail/
                        templateRootPaths.50 = EXT:my_extension/Resources/Private/Templates/Mail/
                        partialRootPaths.50 = EXT:my_extension/Resources/Private/Partials/Mail/
                    }
                }
            }
        }

Write a custom template
-----------------------

The template below can now be created.

.. hint::

    The following variables are accessible within the template:

    - ``{layout}`` – contains the name of the selected layout; see chapter
      “:ref:`notification-email-layout`” for more information.

    - ``{markers}`` – contains the markers of the event that renders this
      template; see chapter “:ref:`events-property-marker`” for more
      information.

.. code-block:: html
    :caption: ``EXT:my_extension/Resources/Private/Templates/Mail/ContactEvents/MessageSent.html``

    <f:layout name="{layout}"/>

    <f:section name="Title">
        Some title
    </f:section>

    <f:section name="Body">
        <p>Some body</p>

        <ul>
            <f:for each="{markers.messages}" as="message">
                <li>{message -> f:format.raw()}</li>
            </f:for>
        </ul>
    </f:section>

.. code-block:: html
    :caption: ``EXT:my_extension/Resources/Private/Layouts/Mail/CustomMailLayout.html``

    <h1>
        <f:render section="Title" />
    </h1>

    <div class="some-class">
        <f:render section="Body" />
    </div>
