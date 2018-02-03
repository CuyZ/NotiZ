# Customize email body

An email body can quickly become so complex that the default configuration is 
not enough.

NotiZ allows you to easily customize how the rendering is done, and even manage
the sections shown in the backend record, to give editors more control on the
body content.

## Use a custom Fluid template

By default, NotiZ uses the basic template located at 
`EXT:notiz/Resources/Private/Templates/Mail/Default.html`.

However, you may want to have more logic in the template for a given event. You 
can easily override it, the only thing to do is to create a template file that 
matches the event identifier (including the event group). The identifier needs 
to be transformed to the UpperCamelCase syntax.

For instance, let's take the example below:

```typoscript
config {
    tx_notiz {
        eventGroups {
            contactEvents {
                label = Events related to contact forms

                events {
                    messageSent {
                        label = Contact form sent

                        // Other stuf…
                    }
                }
            }
        }
    }
}
```

We can see the event `messageSent` that is inside the group `contactEvents`. If 
we want to override the template for this event, a file named 
`ContactEvents/MessageSent.html` must be created.

Also remember to register the template paths to your extension. You can do so in
the definition of the mail notification:

```typoscript
config {
    tx_notiz {
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
}
```

## Register slots for dynamic fields in the backend record

For a complex email body structure, fields may need to be added to the body 
section of the backend record. See the example below:

![Slots example][slots-example]

This mail is sent to give an update to a user about its feeds subscription.

The mail body is composed of two slots: “first part” and “feed”. Both will be
used in the email rendering, but “feed” will be repeated for each feed entry.

See the Fluid template below:

```html
{namespace nz=CuyZ\Notiz\ViewHelpers}

<f:layout name="{layout}"/>

--------------------------------------------------------------------------------
The section below defines which slots can be used inside the `Body` section of
this template.

The following variables can be accessed within this section:

 - {event} – Contains the event definition selected in the notification.
 - {definition} – The full NotiZ definition.
--------------------------------------------------------------------------------
<f:section name="Slots">
    <nz:slot.text name="FirstPart"
                  label="First part" />

    <nz:slot.input name="SingleFeed"
                   label="Feed" />
</f:section>

--------------------------------------------------------------------------------
The section below is used by the layout of this template. It will render the
actual body of the template.

The slots defined in the section above will be rendered here, after they have
been processed with the marker replacement.

You can access every marker defined by the event directly as Fluid variables.
--------------------------------------------------------------------------------
<f:section name="Body">
    <nz:slot.render name="FirstPart" />

    <ul>
        <f:for each="{feeds}" as="feed">
            <li>
                <nz:slot.render name="SingleFeed" markers="{feed: feed}" />
            </li>
        </f:for>
    </ul>
</f:section>
```

And here is the received email:

> Hello Jane Doe, you recently subscribed to news feeds about our products. You 
  can find the list below:
>  * New products (subscribed on 31/01/2018): Information about out new products
>  * Discounts (subscribed on 28/01/2018): Get discounts on existing products

[slots-example]: /Documentation/Images/EmailNotification/email-slots.png

---

[:books: Documentation index](../../README.md)