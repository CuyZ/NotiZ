# Add TypoScript definition

NotiZ is based on a huge configuration object (called the “*definition*”) that 
allows integrators to set up how events and notifications will be processed 
during runtime.

If you want to extend NotiZ or edit some existing definition value, you will 
need to register a path to an existing TypoScript file.

## 1. Register a definition component service

In your extension's `ext_localconf.php` file, add this piece of code:

> *`my_extension/ext_localconf.php`*
```php
<?php
$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

$dispatcher->connect(
    \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
    \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::COMPONENTS_SIGNAL,
    \Vendor\MyExtension\Service\DefinitionComponentService::class,
    'registerDefinitionComponents'
);
```

## 2. Register TypoScript file path

Now you need to create the actual definition component service:

> *`my_extension/Classes/Service/DefinitionComponentService.php`*
```php
<?php
namespace Vendor\MyExtension\Service;

use CuyZ\Notiz\Core\Definition\Builder\Component\DefinitionComponents;
use CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource;
use TYPO3\CMS\Core\SingletonInterface;

class DefinitionComponentService implements SingletonInterface
{
    /**
     * @param DefinitionComponents $definitionComponents
     */
    public function registerDefinitionComponents(DefinitionComponents $definitionComponents)
    {
        /** @var TypoScriptDefinitionSource $typoScriptSource */
        $typoScriptSource = $definitionComponents->getSource(TypoScriptDefinitionSource::class);

        $typoScriptSource->addTypoScriptFilePath('EXT:my_extension/Configuration/TypoScript/MyCustomDefinition.typoscript');
    }
}
```

## 3. Write custom definition 

Finally, you can write definition in your newly registered file:

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

[:books: Documentation index](../README.md)
