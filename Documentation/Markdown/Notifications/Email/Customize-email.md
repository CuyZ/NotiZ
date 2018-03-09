# Customize email

## Have a dynamic email body

An email body can quickly become so complex that the default configuration is 
not enough.

NotiZ allows you to easily customize how the rendering is done, and even manage
the sections shown in the backend record, to give editors more control on the
body content.

### Use a custom Fluid template

By default, NotiZ uses the basic template located at 
`EXT:notiz/Resources/Private/Templates/Mail/Default.html`.

However, you may want to have more logic in the template for a given event. You 
can easily override it, the only thing to do is to create a template file that 
matches the event identifier (including the event group). The identifier needs 
to be transformed to the UpperCamelCase syntax.

For instance, let's take the example below:

```typoscript
notiz {
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
```

We can see the event `messageSent` that is inside the group `contactEvents`. If 
we want to override the template for this event, a file named 
`ContactEvents/MessageSent.html` must be created.

Also remember to register the template paths to your extension. You can do so in
the definition of the mail notification:

```typoscript
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
                  label="First part"
                  rte="true" />

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
```

And here is the received email:

> Hello Jane Doe, you recently subscribed to news feeds about our products. You 
  can find the list below:
>  * New products (subscribed on 31/01/2018): Information about out new products
>  * Discounts (subscribed on 28/01/2018): Get discounts on existing products

### Use advanced slot rendering

When a slot is rendered, the value filled by the user (in the notification 
record) is fetched and processed with the available markers (coming from the 
event).

The slot rendering can be used in several ways:

#### Default

If you just want to render the processed value, just call the view-helper:

```html
<f:section name="Body">
    <nz:slot.render name="MySlot" />
</f:section>
``` 

#### Conditional rendering

If a given slot may be unregistered, you can use the view-helper like a 
classical conditional Fluid view-helper. In this case, a new Fluid variable 
containing the processed value is accessible: `{slotValue}` 

```html
<f:section name="Body">
    <nz:slot.render name="MySlot">
        <f:then>{slotValue}</f:then>
        <f:else>Default value</f:else>
    </nz:slot.render>
</f:section>
```

#### Wrapping

You can also use the view-helper as a wrapper for the slot value. In that case,
if the slot is not registered nothing will be rendered.

```html
<f:section name="Body">
    <nz:slot.render name="MySlot">
        <hr />
        
        <div class="my-class">
            {slotValue -> f:format.html()}
        </div>
    </nz:slot.render>
</f:section>
```

## Customize the email object

If you need to do advanced modification on your mail, you can use a PHP signal.
Register the slot in your `ext_localconf.php` file :

> *`my_extension/ext_localconf.php`*
```php
<?php
$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$dispatcher->connect(
    \CuyZ\Notiz\Domain\Channel\Email\TYPO3\EmailChannel::class,
    \CuyZ\Notiz\Domain\Channel\Email\TYPO3\EmailChannel::EMAIL_SIGNAL,
    \Vendor\MyExtension\Service\Mail\MailTransformer::class,
    'transform'
);
```

Then modify your mail object as you need:

> *`my_extension/Classes/Service/Mail/MailTransformer.php`*
```php
<?php
namespace Vendor\MyExtension\Service\Mail;

use CuyZ\Notiz\Core\Channel\Payload;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MailTransformer implements SingletonInterface
{
    /**
     * @param MailMessage $mailMessage
     * @param Payload $payload
     */
    public function transform(MailMessage $mailMessage, Payload $payload)
    {
        $applicationContext = GeneralUtility::getApplicationContext();

        // We don't change anything in production.
        if ($applicationContext->isProduction()) {
            return;
        }

        // Add a prefix to the mail subject, containing the application context.
        $subject = "[$applicationContext][NotiZ] " . $mailMessage->getSubject();
        $mailMessage->setSubject($subject);
        
        // When not in production, we want the mail to be sent only to us.
        $mailMessage->setTo('webmaster@acme.com');
        $mailMessage->setCc([]);
        $mailMessage->setBcc([]);
    }
}
```

---

[:books: Documentation index](../../README.md)

[slots-example]: /Documentation/Images/EmailNotification/email-slots.png
