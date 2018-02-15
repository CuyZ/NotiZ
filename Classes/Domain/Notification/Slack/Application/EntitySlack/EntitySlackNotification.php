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

use CuyZ\Notiz\Domain\Notification\EntityNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Processor\EntitySlackNotificationProcessor;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;

class EntitySlackNotification extends EntityNotification implements SlackNotification
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $target;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

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
     * Must return a processor class name that does extend the class:
     *
     * @see \CuyZ\Notiz\Core\Notification\Processor\NotificationProcessor
     *
     * @return string
     */
    public static function getProcessorClassName()
    {
        return EntitySlackNotificationProcessor::class;
    }
}
