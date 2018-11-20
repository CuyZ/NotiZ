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

namespace CuyZ\Notiz\Controller\Backend\Manager;

use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Notification\Notification;

/**
 * Lists all notifications entries belonging to a given type.
 */
class ListNotificationsController extends ManagerController
{
    /**
     * @param string $notificationIdentifier
     * @param string $filterEvent
     */
    public function processAction($notificationIdentifier, $filterEvent = null)
    {
        $definition = $this->getDefinition();

        if (!$definition->hasNotification($notificationIdentifier)) {
            $this->addErrorMessage(
                'Backend/Module/Manager/ListNotifications:notification_type_not_found',
                $notificationIdentifier
            );

            $this->forward('process', 'Backend\\Manager\\ListNotificationTypes');
        }

        $notificationDefinition = $definition->getNotification($notificationIdentifier);
        $notifications = $this->getNotifications($notificationIdentifier, $filterEvent);

        $this->view->assign('notificationDefinition', $notificationDefinition);
        $this->view->assign('notifications', $notifications);
    }

    /**
     * @return string
     */
    protected function getMenu()
    {
        return Menu::MANAGER_NOTIFICATIONS;
    }

    /**
     * @param string $notificationIdentifier
     * @param string|null $filterEvent
     * @return Notification[]
     */
    private function getNotifications($notificationIdentifier, $filterEvent)
    {
        $definition = $this->getDefinition();

        $notificationDefinition = $definition->getNotification($notificationIdentifier);
        $processor = $notificationDefinition->getProcessor();

        if ($filterEvent) {
            $eventDefinition = $definition->getEventFromFullIdentifier($filterEvent);

            $this->view->assign('eventDefinition', $eventDefinition);
            $this->view->assign('fullEventIdentifier', $filterEvent);

            return $processor->getNotificationsFromEventDefinition($eventDefinition);
        }

        return $processor->getAllNotifications();
    }
}
