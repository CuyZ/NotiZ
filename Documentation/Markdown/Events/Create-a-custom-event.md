# Create a custom event

An event is a class that should extend `\CuyZ\Notiz\Core\Event\AbstractEvent`.

In addition to the required methods, the event must implement the `run` method.
This method takes the signal/hook arguments as parameters.

If you need a more specific implementation for your event, you can instead
implement the interface `\CuyZ\Notiz\Core\Event\Event`.

Once your event is created, you will have to register it into NotiZ.

Here is an example event that will listen to a TYPO3 signal:

```php
<?php

namespace Acme\MyExtension\Domain\Event;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use Acme\MyExtension\Form\ContactForm;

class ContactFormSentEvent extends AbstractEvent
{
    /**
     * @label The message sent by the user
     * @marker
     *
     * @var string
     */
    private $message;

    /**
     * @label LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:name
     * @marker
     *
     * @var string
     */
    private $name;
    
    /**
     * @label The email of the user
     * @email
     * 
     * @var string
     */
    private $email;
    
    /**
     * @param ContactForm $form
     */
    public function run(ContactForm $form)
    {
        $this->message = $form->getMessage();
        $this->name = $form->getName();
        $this->email = $form->getEmail();
    }
}
```

Variables annotated with `@marker` will be available for the notifications, for instance:
- In an email, they will be available in the subject and body;
- In a log, the will be available in the message.

For example `$name` can be used as `#NAME#`.

Variables annotated with `@email` will be available in the recipients lists for email notifications.

## Registering the event

Events are registered in Typoscript:

```typoscript
notiz {
    eventGroups {
        contactEvents {
            label = Events related to contact forms

            events {
                messageSent {
                    label = Contact form sent

                    className = Acme\MyExtension\Domain\Event\ContactFormSentEvent

                    connection {
                        type = signal

                        className = Acme\MyExtension\Controller\ContactController
                        name = sendMessage
                    }
                }
            }
        }
    }
}
```

---

[:books: Documentation index](../README.md)
