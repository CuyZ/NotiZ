<?php
/**
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

namespace CuyZ\Notiz\Controller\Backend\Manager;

use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Notification\Activable;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;

class NotificationActivationController extends ManagerController
{
    /**
     * @param string $notificationType
     * @param string $notificationIdentifier
     * @param string $filterEvent
     */
    public function processAction($notificationType, $notificationIdentifier, $filterEvent = null)
    {
        $definition = $this->getDefinition();

        if (!$definition->hasNotification($notificationType)) {
            $this->addErrorMessage(
                'Backend/Module/Manager/ListNotifications:notification_type_not_found',
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
     * @param string $filterEvent
     * @throws StopActionException
     */
    private function returnToList($notificationType, $filterEvent)
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
    protected function getMenu()
    {
        return Menu::MANAGER_NOTIFICATIONS;
    }
}
