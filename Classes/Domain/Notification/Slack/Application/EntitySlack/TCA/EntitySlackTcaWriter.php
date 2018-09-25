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
                    'showitem' => 'custom_bot,--linebreak--,name,avatar,bot,--linebreak--,no_defined_bot',
                    'canNotCollapse' => true,
                ],
                'channel' => [
                    'showitem' => 'slack_channel,no_defined_slack_channel',
                    'canNotCollapse' => true,
                ],
                'channel_custom' => [
                    'showitem' => 'target,--linebreak--,webhook_url',
                    'canNotCollapse' => true,
                ],
            ],

            'types' => [
                '0' => [
                    'showitem' => '
                error_message,
                title, description, sys_language_uid, hidden,
                --div--;' . self::LLL_TABS . ':tab.event,
                    event, event_configuration_flex,
                --div--;' . self::LLL_TABS . ':tab.channel,
                    channel,
                --div--;' . self::SLACK_LLL . ':tab.content,
                    --palette--;' . self::SLACK_LLL . ':palette.content;content,
                --div--;' . self::SLACK_LLL . ':tab.slack,
                    --palette--;' . self::SLACK_LLL . ':palette.bot;bot,
                    --palette--;' . self::SLACK_LLL . ':palette.channel;channel,
                    --palette--;' . self::SLACK_LLL . ':palette.channel_custom;channel_custom
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

                'custom_bot' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.custom_bot',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->hasDefinedBot',
                    'config' => [
                        'type' => 'check',
                        'default' => 0,
                    ],
                ],

                'bot' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.bot',
                    'displayCond' => [
                        'AND' => [
                            'FIELD:custom_bot:=:0',
                            'USER:' . $this->getNotificationTcaServiceClass() . '->hasDefinedBot',
                        ],
                    ],
                    'config' => [
                        'type' => 'select',
                        'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getBotsList',
                        'size' => 1,
                        'maxitems' => 1,
                        'eval' => 'required',
                    ],
                ],

                'no_defined_bot' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.no_defined_bot',
                    'displayCond' => [
                        'AND' => [
                            'FIELD:custom_bot:=:0',
                            'USER:' . $this->getNotificationTcaServiceClass() . '->hasNoDefinedBot',
                        ],
                    ],
                    'config' => [
                        'type' => 'user',
                        'userFunc' => $this->getNotificationTcaServiceClass() . '->getNoDefinedBotText',
                    ],
                ],

                'name' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.name',
                    'displayCond' => [
                        /**
                         * @deprecated First level "AND" must be removed when
                         *             TYPO3 v7 is not supported anymore.
                         */
                        'AND' => [
                            'OR' => [
                                'FIELD:custom_bot:=:1',
                                'USER:' . $this->getNotificationTcaServiceClass() . '->hasNoDefinedBot',
                            ],
                        ]
                    ],
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'avatar' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.avatar',
                    'displayCond' => [
                        /**
                         * @deprecated First level "AND" must be removed when
                         *             TYPO3 v7 is not supported anymore.
                         */
                        'AND' => [
                            'OR' => [
                                'FIELD:custom_bot:=:1',
                                'USER:' . $this->getNotificationTcaServiceClass() . '->hasNoDefinedBot',
                            ],
                        ],
                    ],
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'no_defined_slack_channel' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.no_defined_slack_channel',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->hasNoDefinedSlackChannel',
                    'config' => [
                        'type' => 'user',
                        'userFunc' => $this->getNotificationTcaServiceClass() . '->getNoDefinedSlackChannelText',
                    ],
                ],

                'slack_channel' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.slack_channel',
                    'displayCond' => 'USER:' . $this->getNotificationTcaServiceClass() . '->hasDefinedSlackChannel',
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
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'webhook_url' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.webhook_url',
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

        $ctrl['requestUpdate'] .= ',custom_bot';

        return $ctrl;
    }

    /**
     * @return string
     */
    protected function getNotificationTcaServiceClass()
    {
        return EntitySlackTcaService::class;
    }

    /**
     * @return string
     */
    protected function getEntityTitle()
    {
        return self::SLACK_LLL . ':title';
    }
}
