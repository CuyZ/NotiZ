# Signals provided by the extension

## Modify email before it is sent

See chapter [Customize the email object](../Notifications/Email/Customize-email.md#customize-the-email-object)

## Definition was built

You may need to use NotiZ definition to initialize things in your own extension.

A signal will be dispatched when the definition object is complete, **only when 
no error was found when it was built**.

Note that you wont be able to modify the definition, only access its values.

> *`my_extension/ext_localconf.php`*
```php
<?php
$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$dispatcher->connect(
    \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
    \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::DEFINITION_BUILT_SIGNAL,
    \Vendor\MyExtension\Plugin\MyPluginService::class,
    'registerMyPlugin'
);
```

> *`my_extension/Classes/Plugin/MyPluginService.php`*
```php
<?php

namespace Vendor\MyExtension\Plugin;

use CuyZ\Notiz\Core\Definition\Tree\Definition;
use TYPO3\CMS\Core\SingletonInterface;

class MyPluginService implements SingletonInterface
{
    /**
     * Adds a custom plugin for every notification definition entry.
     *
     * @param Definition $definition
     */
    public function registerMyPlugin(Definition $definition)
    {
        foreach ($definition->getNotifications() as $notification) {
            $this->addSomePluginForNotification($notification);
        }
    }
}

```

## Event was dispatched

This signal is sent after an event was successfully dispatched with a 
notification.

Note that for every notification bound to a given event, the signal will be 
sent. It means that the signal may be sent several times for this very event.  

> *`my_extension/ext_localconf.php`*
```php
<?php
$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$dispatcher->connect(
    \CuyZ\Notiz\Core\Event\Runner\EventRunner::class,
    \CuyZ\Notiz\Core\Event\Runner\EventRunner::SIGNAL_EVENT_WAS_DISPATCHED,
    \Vendor\MyExtension\Service\MessageService::class,
    'eventWasDispatched'
);
```

> *`my_extension/Classes/Service/MessageService.php`*
```php
<?php
namespace Vendor\MyExtension\Service;

use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Notification\Notification;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MessageService implements SingletonInterface
{
    /**
     * When an event was dispatched with a notification, we add a Flash message
     * to warn the user. 
     * 
     * @param Event $event
     * @param Notification $notification
     */
    public function eventWasDispatched(Event $event, Notification $notification)
    {
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            vsprintf('The event "%s" was dispatched!', [$event->getDefinition()->getLabel()])
        );

        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $messageQueue->addMessage($message);
    }
}
```

## Error occurred during the dispatch of an event

If an error is thrown during the dispatch of an event with a notification, the
extension will catch it to prevent the request to end. 

You can detect when an error is caught by connecting to the signal like below:

> *`my_extension/ext_localconf.php`*
```php
<?php
$dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$dispatcher->connect(
    \CuyZ\Notiz\Core\Event\Runner\EventRunner::class,
    \CuyZ\Notiz\Core\Event\Runner\EventRunner::SIGNAL_EVENT_DISPATCH_ERROR,
    \Vendor\MyExtension\Error\ErrorLogger::class,
    'logEventDispatchError'
);
```

> *`my_extension/Classes/Error/ErrorLogger.php`*
```php
<?php
namespace Vendor\MyExtension\Error;

use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Notification\Notification;
use Psr\Log\LogLevel;
use Throwable;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ErrorLogger implements SingletonInterface
{
    /**
     * When an error occurs during the dispatch of an event we add an entry to
     * the TYPO3 logger. 
     * 
     * @param Throwable $error
     * @param Event $event
     * @param Notification $notification
     */
    public function logEventDispatchError(Throwable $error, Event $event, Notification $notification)
    {
        /** @var Logger $logger */
        $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);

        $logger->log(
            LogLevel::ERROR, 
            vsprintf(
                'Error sent during the dispatch of the event "%s" with a notification "%", message was: "".',
                [
                    $event->getDefinition()->getLabel(),
                    get_class($notification),
                    $error
                ]
            )
        );
    }
}
```

---

[:books: Documentation index](../README.md)
