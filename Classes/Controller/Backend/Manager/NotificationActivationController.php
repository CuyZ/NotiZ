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

namespace CuyZ\Notiz\Controller\Backend\Manager;

use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Notification\Activable;

class NotificationActivationController extends ManagerController
{
    /**
     * @param string $notificationType
     * @param string $notificationIdentifier
     * @param string|null $filterEvent
     */
    public function processAction(string $notificationType, string $notificationIdentifier, string $filterEvent = null)
    {
        $definition = $this->getDefinition();

        if (!$definition->hasNotification($notificationType)) {
            $this->addErrorMessage(
                'Backend/Module/Manager:notification_type_not_found',
                $notificationType
            );

            $this->returnToList($notificationType, $filterEvent);
        }

        $notificationDefinition = $definition->getNotification($notificationType);
        $processor = $notificationDefinition->getProcessor();

        $notification = $processor->getNotificationFromIdentifier($notificationIdentifier);

        if (!$notification instanceof Activable) {
            $this->returnToList($notificationType, $filterEvent);
        }

        if ($notification->isActive()) {
            $processor->disable($notification);

            $this->returnToList($notificationType, $filterEvent);
        }

        $processor->enable($notification);

        $this->returnToList($notificationType, $filterEvent);
    }

    /**
     * @param string $notificationType
     * @param string|null $filterEvent [PHP 7.1]
     */
    private function returnToList(string $notificationType, $filterEvent)
    {
        $this->forward(
            'process',
            'Backend\\Manager\\ListNotifications',
            null,
            [
                'notificationIdentifier' => $notificationType,
                'filterEvent' => $filterEvent,
            ]
        );
    }

    /**
     * @return string
     */
    protected function getMenu(): string
    {
        return Menu::MANAGER_NOTIFICATIONS;
    }
}
