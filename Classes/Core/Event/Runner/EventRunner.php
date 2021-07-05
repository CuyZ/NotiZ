<?php
declare(strict_types=1);

/*
 * Copyright (C)
 * Nathan Boiron <nathan.boiron@gmail.com>
 * Romain Canon <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 NotiZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CuyZ\Notiz\Core\Event\Runner;

use Closure;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Event\Exception\CancelEventDispatch;
use CuyZ\Notiz\Core\Event\NotizEvent;
use CuyZ\Notiz\Core\Event\Service\EventFactory;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Notification\NotificationDispatcher;
use CuyZ\Notiz\Service\ExtensionConfigurationService;
use Throwable;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * This class is used as a bridge between the trigger of an event and a
 * notification dispatch.
 */
class EventRunner implements SingletonInterface
{

    /**
     * @var ExtensionConfigurationService
     */
    protected $extensionConfigurationService;

    /**
     * @var NotificationDispatcher
     */
    protected $notificationDispatcher;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var EventRunnerContainer
     */
    protected $eventRunnerContainer;

    /**
     * @param NotificationDispatcher $notificationDispatcher
     * @param EventDispatcher $eventDispatcher
     * @param ExtensionConfigurationService $extensionConfigurationService
     */
    public function __construct(
        NotificationDispatcher $notificationDispatcher,
        EventDispatcher $eventDispatcher,
        ExtensionConfigurationService $extensionConfigurationService,
        EventRunnerContainer $eventRunnerContainer
    ) {
        $this->notificationDispatcher = $notificationDispatcher;
        $this->eventDispatcher = $eventDispatcher;
        $this->extensionConfigurationService = $extensionConfigurationService;
        $this->eventRunnerContainer = $eventRunnerContainer;
    }

    /**
     * @param EventDefinition $eventDefinition
     * @param mixed ...$arguments
     */
    public function process(EventDefinition $eventDefinition, ...$arguments)
    {
        $notifications = $this->notificationDispatcher->fetchNotifications($eventDefinition);

        foreach ($notifications as $notification => $dispatchCallback) {
            $event = EventFactory::create($eventDefinition, $notification);
            $doDispatch = true;

            if (is_callable([$event, 'run'])) {
                try {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $event->run(...$arguments);
                } catch (CancelEventDispatch $exception) {
                    $doDispatch = false;
                }
            }

            if ($doDispatch) {
                $this->dispatchEvent($dispatchCallback, $event, $notification);
            }

            unset($event);
        }
    }

    /**
     * Does the actual dispatch work. Two signals are sent:
     *
     * - When the dispatch ran well;
     * - If an error occurred during the dispatch.
     *
     * @param Closure $callback
     * @param Event $event
     * @param Notification $notification
     *
     * @throws Throwable
     * @see \CuyZ\Notiz\Core\Event\Runner\DispatchedEvent
     * @see \CuyZ\Notiz\Core\Event\Runner\DispatchErrorEvent
     *
     */
    protected function dispatchEvent(Closure $callback, Event $event, Notification $notification)
    {
        try {
            $callback($event);

            $this->eventDispatcher->dispatch(new DispatchedEvent($event, $notification));
        } catch (Throwable $exception) {
            $this->eventDispatcher->dispatch(new DispatchErrorEvent($exception, $event, $notification));

            $gracefulMode = $this->extensionConfigurationService->getConfigurationValue('dispatch.graceful_mode');

            if (!$gracefulMode) {
                throw $exception;
            }
        }
    }

    /**
     * @return \Closure
     */
    public function getClosure(EventDefinition $definition): \Closure
    {
        return function (...$args) use ($definition) {
            $this->process($definition, ...$args);
        };
    }

    /**
     * This object should never be serialized, because it contains services that
     * can have properties filled with closures (a closure can't be serialized).
     *
     * We need to make sure it won't happen, because there are cases where TYPO3
     * can serialize this object, because the TYPO3 slot dispatcher contains a
     * reference to it; if a closure is registered, an exception is thrown.
     *
     * @return array
     */
    public function __sleep(): array
    {
        return [];
    }

    public function __invoke(NotizEvent $event)
    {
        $identifier = $event->getIdentifier();
        $args = $event->getArgs();

        if ($this->eventRunnerContainer->has($identifier)) {
            $eventDefinition = $this->eventRunnerContainer->get($identifier);
            $this->process($eventDefinition, ...$args);
        }
    }

}
