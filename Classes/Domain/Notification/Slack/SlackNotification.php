<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
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
    public function getMessage(): string;

    /**
     * @return bool
     */
    public function hasCustomBot(): bool;

    /**
     * @return string
     */
    public function getBot(): string;

    /**
     * This method should return `true` if the notification has a custom
     * channel configured in addition to the defined ones.
     *
     * @return bool
     */
    public function hasCustomSlackChannel(): bool;

    /**
     * @return string
     */
    public function getSlackChannel(): string;

    /**
     * @return string
     */
    public function getTarget(): string;

    /**
     * @return string
     */
    public function getWebhookUrl(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getAvatar(): string;
}
