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
                'slack' => [
                    'showitem' => 'name,--linebreak--,avatar,--linebreak--,target',
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
                    --palette--;' . self::SLACK_LLL . ':palette.slack;slack
'
                ]
            ],

            'columns' => [

                'target' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.target',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'name' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.name',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'avatar' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.avatar',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'message' => [
                    'exclude' => 1,
                    'label' => self::SLACK_LLL . ':field.message',
                    'config' => [
                        'type' => 'text',
                        'size' => 4000,
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
