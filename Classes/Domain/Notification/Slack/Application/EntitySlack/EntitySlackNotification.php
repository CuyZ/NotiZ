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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack;

use CuyZ\Notiz\Core\Notification\Activable;
use CuyZ\Notiz\Core\Notification\Creatable;
use CuyZ\Notiz\Core\Notification\Viewable;
use CuyZ\Notiz\Core\Notification\Editable;
use CuyZ\Notiz\Core\Notification\CustomSettingsNotification;
use CuyZ\Notiz\Domain\Notification\EntityNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Processor\EntitySlackNotificationProcessor;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\EntitySlackSettings;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;

class EntitySlackNotification extends EntityNotification implements
    SlackNotification,
    CustomSettingsNotification,
    Creatable,
    Editable,
    Viewable,
    Activable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var bool
     */
    protected $customBot;

    /**
     * @var string
     */
    protected $bot;

    /**
     * @var string
     */
    protected $slackChannel;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var string
     */
    protected $webhookUrl;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function hasCustomBot(): bool
    {
        return $this->customBot;
    }

    /**
     * @param bool $customBot
     */
    public function setCustomBot(bool $customBot)
    {
        $this->customBot = $customBot;
    }

    /**
     * @return string
     */
    public function getBot(): string
    {
        return $this->bot;
    }

    /**
     * @param string $bot
     */
    public function setBot(string $bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return bool
     */
    public function hasCustomSlackChannel(): bool
    {
        return !empty($this->target) || !empty($this->webhookUrl);
    }

    /**
     * @return string
     */
    public function getSlackChannel(): string
    {
        return $this->slackChannel;
    }

    /**
     * @param string $slackChannel
     */
    public function setSlackChannel(string $slackChannel)
    {
        $this->slackChannel = $slackChannel;
    }

    /**
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * @param string $webhookUrl
     */
    public function setWebhookUrl(string $webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public static function getProcessorClassName(): string
    {
        return EntitySlackNotificationProcessor::class;
    }

    /**
     * @return string
     */
    public static function getSettingsClassName(): string
    {
        return EntitySlackSettings::class;
    }

    /**
     * @return string
     */
    public static function getDefinitionIdentifier(): string
    {
        return 'entitySlack';
    }
}
