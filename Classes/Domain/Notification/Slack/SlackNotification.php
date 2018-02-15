<?php

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
     * @return string
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getAvatar();
}
