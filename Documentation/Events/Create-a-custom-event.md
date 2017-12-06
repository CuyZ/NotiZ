# Create a custom event

Events are implemented using a class.

Here is an example event that will listen to a TYPO3 signal:

```php
<?php

namespace Acme\MyExtension\Domain\Event;

use CuyZ\Notiz\Event\AbstractEvent;
use Acme\MyExtension\Form\ContactForm;

class ContactFormSentEvent extends AbstractEvent
{
    /**
     * @label LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:message
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
     * @param ContactForm $form
     */
    public function run(ContactForm $form)
    {
        $this->message = $form->getMessage();
        $this->name = $form->getName();
    }
}
```

Variables annotated with `@marker` will be available for the channels, for instance:
- In an email, they will be available in the subject and body;
- In a log, the will be available in the message.

For example `$name` can be used as `#NAME#`.

## Registering the event

Events are registered in Typoscript:

```typoscript
config {
    tx_notiz {
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
}
```
