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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Data;

use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\Channels\Channel as ChannelDefinition;

class SlackChannel
{
    /**
     * @var string
     */
    private $webhookUrl;

    /**
     * @var string
     */
    private $target;

    /**
     * @param string $webhookUrl
     * @param string $target
     */
    private function __construct(string $webhookUrl, string $target)
    {
        $this->webhookUrl = $webhookUrl;
        $this->target = $target;
    }

    /**
     * @param EntitySlackNotification $notification
     * @return static
     */
    public static function fromNotification(EntitySlackNotification $notification): self
    {
        return new static(
            $notification->getWebhookUrl(),
            $notification->getTarget()
        );
    }

    /**
     * @param ChannelDefinition $channel
     * @return static
     */
    public static function fromDefinition(ChannelDefinition $channel): self
    {
        return new static($channel->getWebhookUrl(), $channel->getTarget());
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }
}
