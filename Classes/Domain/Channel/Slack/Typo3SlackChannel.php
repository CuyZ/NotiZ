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

namespace CuyZ\Notiz\Domain\Channel\Slack;

use CuyZ\Notiz\Core\Channel\AbstractChannel;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\EntitySlackNotification;
use CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\Service\EntitySlackMessageBuilder;
use CuyZ\Notiz\Domain\Notification\Slack\SlackNotification;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Typo3SlackChannel extends AbstractChannel
{
    /**
     * @var array
     */
    protected static $supportedNotifications = [
        SlackNotification::class,
    ];

    /**
     * @var EntitySlackMessageBuilder
     */
    protected $messageBuilder;

    /**
     * @var SlackNotification
     */
    protected $notification;

    /**
     * Manual dependency injection.
     */
    final protected function initialize()
    {
        $this->messageBuilder = $this->objectManager->get(
            EntitySlackMessageBuilder::class,
            $this->payload
        );

        $this->notification = $this->payload->getNotification();
    }

    /**
     * Send the slack notification.
     */
    protected function process()
    {
        $webhookUrl = '----';

        $data = [
            'channel' => $this->notification->getTarget(),
            'username' => $this->notification->getName(),
            'text' => $this->messageBuilder->getMessage(),
            'icon_emoji' => $this->notification->getAvatar(),
        ];

        $data = json_encode($data);

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        //Execute CURL
        $result = curl_exec($ch);

        /**
         * TODO
         *
         * Put the name, avatar and webhook url in the channel definition.
         * Check how we can support Slack rich messages.
         */

        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result, __CLASS__ . ':' . __LINE__ . ' $result');
//        die;
    }
}
