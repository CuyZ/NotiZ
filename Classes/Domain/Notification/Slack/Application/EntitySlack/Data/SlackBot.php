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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Data;

use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Bots\Bot;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;

class SlackBot
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @param string $name
     * @param string $avatar
     */
    private function __construct($name, $avatar)
    {
        $this->name = $name;
        $this->avatar = $avatar;
    }

    /**
     * @param SlackNotification $notification
     * @return static
     */
    public static function fromNotification(SlackNotification $notification)
    {
        return new static($notification->getName(), $notification->getAvatar());
    }

    /**
     * @param Bot $bot
     * @return static
     */
    public static function fromBotDefinition(Bot $bot)
    {
        return new static($bot->getName(), $bot->getAvatar());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return bool
     */
    public function hasEmojiAvatar()
    {
        return substr($this->avatar, 0, 1) === ':'
            && substr($this->avatar, -1, 1) === ':';
    }
}
