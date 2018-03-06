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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Service;

use CuyZ\Notiz\Core\Channel\Payload;
use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Data\SlackBot;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\EntitySlackSettings;

class EntitySlackBotMapper
{
    /**
     * @var EntitySlackNotification
     */
    private $notification;

    /**
     * @var EntitySlackSettings
     */
    private $notificationSettings;

    /**
     * @param Payload $payload
     */
    public function __construct(Payload $payload)
    {
        $this->notification = $payload->getNotification();
        $this->notificationSettings = $payload->getNotificationDefinition()->getSettings();
    }

    /**
     * Returns either a custom bot or a defined one.
     *
     * @return SlackBot
     * @throws EntryNotFoundException
     */
    public function getBot()
    {
        if ($this->notification->isBotCustom()) {
            return SlackBot::fromNotification($this->notification);
        }

        $botIdentifier = $this->notification->getBot();

        foreach ($this->notificationSettings->getBots() as $bot) {
            if ($bot->getIdentifier() === $botIdentifier) {
                return SlackBot::fromBotDefinition($bot);
            }
        }

        throw EntryNotFoundException::entitySlackBotNotFound($botIdentifier);
    }
}
