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

namespace CuyZ\Notiz\Domain\Notification\Slack;

use CuyZ\Notiz\Core\Notification\MultipleChannelsNotification;
use CuyZ\Notiz\Core\Notification\Notification;

interface SlackNotification extends Notification, MultipleChannelsNotification
{
    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return bool
     */
    public function isBotCustom();

    /**
     * @return string
     */
    public function getBot();

    /**
     * @return bool
     */
    public function hasCustomSlackChannel();

    /**
     * @return string
     */
    public function getSlackChannel();

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getWebhookUrl();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getAvatar();
}
