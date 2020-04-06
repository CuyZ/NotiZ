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

namespace CuyZ\Notiz\Core\Notification\Processor;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Notification\Activable;
use CuyZ\Notiz\Core\Notification\Notification;

/**
 * A notification processor will be used by services to perform actions or fetch
 * data related to a given notification type.
 *
 * Notification fetching
 * ---------------------
 *
 * The main goal of the processor is to fetch notification entries. You  need to
 * implement the following methods that must return the correct notifications:
 *
 * @see \CuyZ\Notiz\Core\Notification\Processor\NotificationProcessor::getNotificationsFromEventDefinition
 * @see \CuyZ\Notiz\Core\Notification\Processor\NotificationProcessor::getAllNotifications
 */
abstract class NotificationProcessor
{
    /**
     * @var string
     */
    protected $notificationClassName;

    /**
     * WARNING
     * -------
     *
     * If you need to override the constructor, do not forget to call:
     * `parent::__construct`
     *
     * @param string $notificationClassName
     */
    public function __construct(string $notificationClassName)
    {
        $this->notificationClassName = $notificationClassName;
    }

    /**
     * Returns the notification instances after a filter on the given event
     * definition has been applied.
     *
     * @param EventDefinition $eventDefinition
     * @return Notification[]
     */
    abstract public function getNotificationsFromEventDefinition(EventDefinition $eventDefinition): array;

    /**
     * @param EventDefinition $eventDefinition
     * @return Notification[]
     */
    abstract public function getNotificationsFromEventDefinitionWithDisabled(EventDefinition $eventDefinition): array;

    /**
     * @param EventDefinition $eventDefinition
     * @return int
     */
    abstract public function countNotificationsFromEventDefinition(EventDefinition $eventDefinition): int;

    /**
     * @param string $identifier
     * @return Notification
     */
    abstract public function getNotificationFromIdentifier(string $identifier): Notification;

    /**
     * Returns all notification instances.
     *
     * @return Notification[]
     */
    abstract public function getAllNotifications(): array;

    /**
     * Returns all notification instances, including disabled ones.
     *
     * @return Notification[]
     */
    abstract public function getAllNotificationsWithDisabled(): array;

    /**
     * @return int
     */
    abstract public function getTotalNumber(): int;

    /**
     * @param Activable $notification
     * @return void
     */
    abstract public function enable(Activable $notification);

    /**
     * @param Activable $notification
     * @return void
     */
    abstract public function disable(Activable $notification);
}
