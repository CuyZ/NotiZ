<?php

/*
 * Copyright (C) 2018
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
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Domain\Repository\EntityNotificationRepository;

abstract class EntityNotificationProcessor extends NotificationProcessor
{
    /**
     * The repository needs to be injected in the child class.
     *
     * @var EntityNotificationRepository
     */
    protected $notificationRepository;

    /**
     * @param EventDefinition $definition
     * @return Notification[]
     */
    public function getNotificationsFromEventDefinition(EventDefinition $definition)
    {
        return $this->notificationRepository
            ->findFromEventDefinition($definition)
            ->toArray();
    }

    /**
     * @param EventDefinition $definition
     * @return Notification[]
     */
    public function getNotificationsFromEventDefinitionWithDisabled(EventDefinition $definition)
    {
        return $this->notificationRepository
            ->findFromEventDefinitionWithDisabled($definition)
            ->toArray();
    }

    /**
     * @param EventDefinition $definition
     * @return int
     */
    public function countNotificationsFromEventDefinition(EventDefinition $definition)
    {
        return $this->notificationRepository->countFromEventDefinition($definition);
    }

    /**
     * @param string $identifier
     * @return Notification|object
     */
    public function getNotificationFromIdentifier($identifier)
    {
        return $this->notificationRepository->findByIdentifierForce($identifier);
    }

    /**
     * @return Notification[]
     */
    public function getAllNotifications()
    {
        return $this->notificationRepository
            ->findAll()
            ->toArray();
    }

    /**
     * @return Notification[]
     */
    public function getAllNotificationsWithDisabled()
    {
        return $this->notificationRepository
            ->findAllWithDisabled()
            ->toArray();
    }

    /**
     * @return int
     */
    public function getTotalNumber()
    {
        return $this->notificationRepository
            ->findAll()
            ->count();
    }
}
