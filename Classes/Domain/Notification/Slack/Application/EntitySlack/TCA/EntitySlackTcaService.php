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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\TCA;

use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;
use CuyZ\Notiz\Core\Notification\Settings\NotificationSettings;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\EntitySlackSettings;

class EntitySlackTcaService extends NotificationTcaService
{
    /**
     * @return string
     */
    protected function getNotificationIdentifier()
    {
        return 'entitySlack';
    }

    /**
     * Loads all bots provided by the notification and stores them as an array
     * to be used in the TCA.
     *
     * @param array $parameters
     */
    public function getBotsList(array &$parameters)
    {
        if ($this->definitionHasErrors()) {
            return;
        }

        foreach ($this->getNotificationSettings()->getBots() as $bot) {
            $parameters['items'][] = [
                $bot->getName(),
                $bot->getIdentifier(),
            ];
        }
    }

    /**
     * Loads all Slack channels provided by the notification and stores them as
     * an array to be used in the TCA.
     *
     * @param array $parameters
     */
    public function getSlackChannelsList(array &$parameters)
    {
        if ($this->definitionHasErrors()) {
            return;
        }

        foreach ($this->getNotificationSettings()->getChannels() as $channel) {
            $parameters['items'][] = [
                $channel->getLabel(),
                $channel->getIdentifier(),
            ];
        }
    }

    /**
     * @return bool
     */
    public function hasDefinedBot()
    {
        if ($this->definitionHasErrors()) {
            return false;
        }

        return count($this->getNotificationSettings()->getChannels()) > 0;
    }

    /**
     * @return bool
     */
    public function hasNoDefinedBot()
    {
        return !$this->hasDefinedBot();
    }

    /**
     * @return string
     */
    public function getNoDefinedBotText()
    {
        $view = $this->viewService->getStandaloneView('Backend/TCA/NoDefinedBotMessage');

        return $view->render();
    }

    /**
     * @return EntitySlackSettings|NotificationSettings
     */
    protected function getNotificationSettings()
    {
        return $this->getNotificationDefinition()->getSettings();
    }
}
