<?php
declare(strict_types=1);

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

/**
 * Show detailed information about a given event.
 */
class ShowEventController extends ManagerController
{
    /**
     * Show detailed information about a given event.
     *
     * @param string $eventIdentifier
     */
    public function processAction(string $eventIdentifier)
    {
        $definition = $this->getDefinition();

        if (!$definition->hasEventFromFullIdentifier($eventIdentifier)) {
            $this->addErrorMessage(
                'Backend/Module/Manager:show_event.event_not_found',
                $eventIdentifier
            );

            $this->forward('process', 'Backend\Manager\ListEvents');
        }

        $eventDefinition = $definition->getEventFromFullIdentifier($eventIdentifier);

        $notifications = [];

        foreach ($definition->getListableNotifications() as $notification) {
            $notifications[] = [
                'definition' => $notification,
                'count' => $notification->getProcessor()->countNotificationsFromEventDefinition($eventDefinition),
            ];
        }

        $this->view->assign('eventDefinition', $eventDefinition);
        $this->view->assign('notifications', $notifications);
    }

    /**
     * @return string
     */
    protected function getMenu(): string
    {
        return Menu::MANAGER_EVENTS;
    }
}
