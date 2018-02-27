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

namespace CuyZ\Notiz\Domain\Notification\Slack\Application\EntitySlack\TCA;

use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;

class EntitySlackTcaWriter extends EntityTcaWriter
{
    const SLACK_LLL = 'LLL:EXT:notiz/Resources/Private/Language/Notification/Slack/Entity.xlf';

    /**
     * This method must create the basic TCA configuration. It must fill at
     * least the `ctrl` and `columns` sections.
     *
     * Default TYPO3 columns are added automatically, so no need to add them.
     * Common notifications columns are also added automatically.
     *
     * @return array
     */
    protected function buildTcaArray()
    {
        return [
            'ctrl' => $this->getCtrl(),

            'palettes' => [
                'content' => [
                    'showitem' => 'message,markers',
                    'canNotCollapse' => true,
                ],
                'bot' => [
                    'showitem' => 'bot_custom,--linebreak--,bot,name,--linebreak--,avatar',
                    'canNotCollapse' => true,
                ],
                'channel' => [
                    'showitem' => 'slack_channel_custom,--linebreak--,slack_channel,webhookUrl,--linebreak--,webhook_url,--linebreak--,target',
                    'canNotCollapse' => true,
                ],
            ],

            'types' => [
                '0' => [
                    'showitem' => '
                error_message,
                title, sys_language_uid, hidden,
                --div--;' . self::LLL_TABS . ':tab.event,
                    event, event_configuration_flex,
                --div--;' . self::LLL_TABS . ':tab.channel,
                    channel,
                --div--;' . self::SLACK_LLL . ':tab.content,
                    --palette--;' . self::SLACK_LLL . ':palette.content;content,
                --div--;' . self::SLACK_LLL . ':tab.slack,
                    --palette--;' . self::SLACK_LLL . ':palette.bot;bot,
                    --palette--;' . self::SLACK_LLL . ':palette.channel;channel
'
                ]
            ],

            'columns' => [

                'message' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.message',
                    'config' => [
                        'type' => 'text',
                        'size' => 4000,
                        'eval' => 'trim,required',
                    ],
                ],

                'bot_custom' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.bot_custom',
                    'config' => [
                        'type' => 'check',
                        'default' => 0,
                    ],
                ],

                'bot' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.bot',
                    'displayCond' => 'FIELD:bot_custom:=:0',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getBotsList',
                        'size' => 1,
                        'maxitems' => 1,
                        'eval' => 'required',
                    ],
                ],

                'name' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.name',
                    'displayCond' => 'FIELD:bot_custom:=:1',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'avatar' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.avatar',
                    'displayCond' => 'FIELD:bot_custom:=:1',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'slack_channel_custom' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.slack_channel_custom',
                    'config' => [
                        'type' => 'check',
                        'default' => 0,
                    ],
                ],

                'slack_channel' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.slack_channel',
                    'displayCond' => 'FIELD:slack_channel_custom:=:0',
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getSlackChannelsList',
                        'renderType' => 'selectMultipleSideBySide',
                        'size' => 5,
                        'maxitems' => 128,
                    ],
                ],

                'target' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.target',
                    'displayCond' => 'FIELD:slack_channel_custom:=:1',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'webhook_url' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.webhook_url',
                    'displayCond' => 'FIELD:slack_channel_custom:=:1',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

            ],
        ];
    }

    /**
     * @return array
     */
    protected function getCtrl()
    {
        $ctrl = $this->getDefaultCtrl();

        $ctrl['title'] = self::SLACK_LLL . ':title';
        $ctrl['requestUpdate'] .= ',bot_custom,slack_channel_custom';

        return $ctrl;
    }

    /**
     * This method returns the TCA service class for the current entity type.
     * You can override it to return a class extending `NotificationTcaService`.
     *
     * @return string
     */
    protected function getNotificationTcaServiceClass()
    {
        return EntitySlackTcaService::class;
    }
}
