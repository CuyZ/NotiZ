# Add file definition

Adding a new definition file is easy, you just have to add a piece of code in 
the `ext_localconf.php` file of your extension.

Sometimes you may need more complex logic, in that case see chapter 
“[Advanced definition handling](Advanced-definition-handling.md)”.

## TypoScript definition file

> *`my_extension/ext_localconf.php`*
```php
<?php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][\CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::class][]
    = 'EXT:my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript';
```

> *`my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript`*
```
notiz {
    notifications {
        /*
         * Modifying the provided email notification settings…
         */
        entityEmail {
            settings {
                /*
                 * These recipients will be available by default in every 
                 * email notification record.
                 */
                globalRecipients {
                     10 = webmaster@acme.com
                }
            }
        }
    }
    
    eventGroups {
        /*
         * We add a new event group for our custom events.
         */
        my_extension {
            label = Events for My Extension

            events {
                /*
                 * Contact form is sent
                 * --------------------
                 *
                 * This event is bound to a signal sent by the contact 
                 * controller. It contains data about the user who submitted
                 * the form, that will be available in the notifications
                 * markers.
                 */
                contactFormSent {
                    label = Contact form sent

                    className = MyVendor\MyExtension\Event\ContactFormSentEvent

                    connection {
                        type = signal

                        className = MyVendor\MyContactExtension\Controller\ContactController
                        name = contactFormSent
                    }
                }
            }
        }
    }
}
```

---

[:books: Documentation index](../../README.md)

