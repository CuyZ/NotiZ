.. include:: ../../Includes.txt

.. _notification-email-dynamicSlots:

Dynamic slots fields for body
=============================

For a complex email body structure, fields may need to be added to the body
section of the backend record.

See the example below:

.. figure:: /Images/04-Notification/Email/notification-email-slots.png
    :alt: Email slots

This email is sent to give an update to a user about its feeds subscription.

The email body is composed of two slots: “first part” and “feed”. Both will be
used in the email rendering, but “feed” will be repeated for each feed entry.

See the Fluid template below:

.. code-block:: html

    {namespace nz=CuyZ\Notiz\ViewHelpers}

    <f:layout name="{layout}"/>

    ----------------------------------------------------------------------------
    The section below defines which slots can be used inside the `Body` section
    of this template.

    The following variables can be accessed within this section:

     - {event} – Contains the event definition selected in the notification.
     - {definition} – The full NotiZ definition.
    ----------------------------------------------------------------------------
    <f:section name="Slots">
        <nz:slot.text name="FirstPart"
                      label="First part"
                      rte="true" />

        <nz:slot.input name="SingleFeed"
                       label="Feed" />
    </f:section>

    ----------------------------------------------------------------------------
    The section below is used by the layout of this template. It will render the
    actual body of the template.

    The slots defined in the section above will be rendered here, after they
    have been processed with the marker replacement.

    You can access every marker defined by the event directly as Fluid
    variables.
    ----------------------------------------------------------------------------
    <f:section name="Body">
        <f:format.html>
            <nz:slot.render name="FirstPart" />
        </f:format.html>

        <ul>
            <f:for each="{feeds}" as="feed">
                <li>
                    <nz:slot.render name="SingleFeed" markers="{feed: feed}" />
                </li>
            </f:for>
        </ul>
    </f:section>

And here is the received email:

    Hello Jane Doe, you recently subscribed to news feeds about our products.
    You can find the list below:

     * New products (subscribed on 31/01/2018): Information about out new
       products
     * Discounts (subscribed on 28/01/2018): Get discounts on existing products

Slots types
-----------

Each slot must fill the ``name`` property and may fill the ``label`` property.

Input
'''''

.. code-block:: html

    <nz:slot.input name="MyInput"
                   label="My input slot" />

Text
''''

.. code-block:: html

    <nz:slot.text name="MyText"
                  label="My text slot"
                  rte="true"
                  rteMode="MyCustomRteConfiguration" />

============ =========== =======================================================
Property     Type        Description
============ =========== =======================================================
``rte``      Boolean     If ``true``, will render a textarea with the available
                         Rich Text Editor (CKEditor or legacy HTMLArea).

``rteMode``  String      Name of a declared custom RTE configuration.
============ =========== =======================================================

.. hint::

    Some excellent tutorials on how to customize CKEditor in TYPO3 can be found
    at:

    - `TYPO3worx — Configure CKEditor in TYPO3`_
    - `useTYPO3 — Feature spotlight CKEditor`_
    - `YouTube — Tutorial - Rich Text Editor`_

    .. _TYPO3worx — Configure CKEditor in TYPO3: https://typo3worx.eu/2017/02/configure-ckeditor-in-typo3/
    .. _useTYPO3 — Feature spotlight CKEditor: https://usetypo3.com/ckeditor.html
    .. _YouTube — Tutorial - Rich Text Editor: https://www.youtube.com/watch?v=0589lNwFCic

Use advanced slot rendering
---------------------------

.. tip::

    When a slot is rendered, the value filled by the user (in the notification
    record) is fetched and processed with the available markers (coming from the
    event).

The slot rendering can be used in several ways:

Default
'''''''

When calling the view-helper in inline-mode, it will render the processed value.

.. code-block:: html

    <f:section name="Body">
        <nz:slot.render name="MySlot" />
    </f:section>

Conditional rendering
'''''''''''''''''''''

If a given slot may be unregistered, the view-helper can be used like a
basic conditional Fluid view-helper. In this case, a new Fluid variable
containing the processed value is accessible: ``{slotValue}``

.. code-block:: html

    <f:section name="Body">
        <nz:slot.render name="MySlot">
            <f:then>{slotValue}</f:then>
            <f:else>Default value</f:else>
        </nz:slot.render>
    </f:section>

Wrapping
''''''''

The view-helper can be used as a wrapper for the slot value. In that case,
if the slot is not registered nothing will be rendered.

.. code-block:: html

    <f:section name="Body">
        <nz:slot.render name="MySlot">
            <hr />

            <div class="my-class">
                {slotValue -> f:format.html()}
            </div>
        </nz:slot.render>
    </f:section>
