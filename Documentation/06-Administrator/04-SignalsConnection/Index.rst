.. include:: ../../Includes.txt

Signals provided by the extension
=================================

.. contents::
    :local:

Modify email before it is sent
------------------------------

See chapter “:ref:`notification-email-objectCustomization`”.

Definition was built
--------------------

The definition can be used in another workflow to customize a process.
Therefore, a signal is dispatched when the definition object is built.

.. important::

    The signal is dispatched only when **no error** was found when the
    definition was built.

.. note::

    Definition can't be modified that way, only read access is granted.

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    $dispatcher->connect(
        \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::class,
        \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder::DEFINITION_BUILT_SIGNAL,
        \Vendor\MyExtension\Plugin\MyPluginService::class,
        'registerMyPlugin'
    );

.. code-block:: php
    :caption: ``my_extension/Classes/Plugin/MyPluginService.php``

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

Event was dispatched
--------------------

This signal is sent after an event was successfully dispatched with a
notification.

Note that for every notification bound to a given event, the signal will be
sent. It means that the signal may be sent several times for this very event.

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    $dispatcher->connect(
        \CuyZ\Notiz\Core\Event\Runner\EventRunner::class,
        \CuyZ\Notiz\Core\Event\Runner\EventRunner::SIGNAL_EVENT_WAS_DISPATCHED,
        \Vendor\MyExtension\Service\MessageService::class,
        'eventWasDispatched'
    );

.. code-block:: php
    :caption: ``my_extension/Classes/Service/MessageService.php``

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
         * When an event was dispatched with a notification, we add a Flash
         * message to warn the user.
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

Error occurred during the dispatch of an event
----------------------------------------------

If an error is thrown during the dispatch of an event with a notification, the
extension will catch it to prevent the request to end.

Any caught error can be detected by connecting to the signal like below:

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    $dispatcher->connect(
        \CuyZ\Notiz\Core\Event\Runner\EventRunner::class,
        \CuyZ\Notiz\Core\Event\Runner\EventRunner::SIGNAL_EVENT_DISPATCH_ERROR,
        \Vendor\MyExtension\Error\ErrorLogger::class,
        'logEventDispatchError'
    );

.. code-block:: php
    :caption: ``my_extension/Classes/Error/ErrorLogger.php``

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
         * When an error occurs during the dispatch of an event we add an entry
         * to the TYPO3 logger.
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

Global properties manipulation
------------------------------

In order to globally handle things with properties (for instance markers), the
signals below can be used.

In the example below, we add a new global marker ``currentDate`` that will be
accessible for every notification.

.. code-block:: php
    :caption: ``my_extension/ext_localconf.php``

    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
    );

    /*
     * We add a new entry to the definition of the markers: `currentDate` that
     * will be later filled with the date of the day.
     *
     * This marker will be accessible to every notification, regardless of the
     * event and other selected configuration.
     */
    $dispatcher->connect(
        \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::class,
        \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::SIGNAL_PROPERTY_BUILD_DEFINITION,
        function (
            \CuyZ\Notiz\Core\Property\Factory\PropertyDefinition $propertyDefinition,
            \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition $eventDefinition,
            \CuyZ\Notiz\Core\Notification\Notification $notification
        ) {
            if ($propertyDefinition->getPropertyType() === \CuyZ\Notiz\Domain\Property\Marker::class) {
                $propertyDefinition->addEntry('currentDate')
                    ->setLabel('Formatted date of the day');
            }
        }
    );

    /*
     * Manually filling the marker `currentDate` with the date of the day.
     */
    $dispatcher->connect(
        \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::class,
        \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::SIGNAL_PROPERTY_FILLING,
        function (
            \CuyZ\Notiz\Core\Property\Factory\PropertyContainer $propertyContainer,
            \CuyZ\Notiz\Core\Event\Event $event
        ) {
            if ($propertyContainer->getPropertyType() === \CuyZ\Notiz\Domain\Property\Marker::class) {
                $propertyContainer->getEntry('currentDate')
                    ->setValue(date('d/m/Y'));
            }
        }
    );
