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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack;

use CuyZ\Notiz\Core\Notification\Creatable;
use CuyZ\Notiz\Core\Notification\Viewable;
use CuyZ\Notiz\Core\Notification\Editable;
use CuyZ\Notiz\Core\Notification\CustomSettingsNotification;
use CuyZ\Notiz\Domain\Notification\EntityNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Processor\EntitySlackNotificationProcessor;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Settings\EntitySlackSettings;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;

class EntitySlackNotification extends EntityNotification implements SlackNotification, CustomSettingsNotification, Creatable, Editable, Viewable
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function hasCustomBot()
    {
        return $this->customBot;
    }

    /**
     * @param bool $customBot
     */
    public function setCustomBot($customBot)
    {
        $this->customBot = $customBot;
    }

    /**
     * @return string
     */
    public function getBot()
    {
        return $this->bot;
    }

    /**
     * @param string $bot
     */
    public function setBot($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return bool
     */
    public function hasCustomSlackChannel()
    {
        return !empty($this->target) || !empty($this->webhookUrl);
    }

    /**
     * @return string
     */
    public function getSlackChannel()
    {
        return $this->slackChannel;
    }

    /**
     * @param string $slackChannel
     */
    public function setSlackChannel($slackChannel)
    {
        $this->slackChannel = $slackChannel;
    }

    /**
     * @return string
     */
    public function getWebhookUrl()
    {
        return $this->webhookUrl;
    }

    /**
     * @param string $webhookUrl
     */
    public function setWebhookUrl($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public static function getProcessorClassName()
    {
        return EntitySlackNotificationProcessor::class;
    }

    /**
     * @return string
     */
    public static function getSettingsClassName()
    {
        return EntitySlackSettings::class;
    }

    /**
     * @return string
     */
    public static function getDefinitionIdentifier()
    {
        return 'entitySlack';
    }
}
