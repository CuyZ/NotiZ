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
        $lll = 'LLL:EXT:notiz/Resources/Private/Language/Notification/Slack/Entity.xlf';

        return [
            'ctrl' => [
                'title' => "$lll:title",
                'label' => 'title',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'dividers2tabs' => true,

                'requestUpdate' => 'event',

                'languageField' => 'sys_language_uid',
                'transOrigPointerField' => 'l10n_parent',
                'transOrigDiffSourceField' => 'l10n_diffsource',
                'delete' => 'deleted',
                'enablecolumns' => [
                    'disabled' => 'hidden',
                    'starttime' => 'starttime',
                    'endtime' => 'endtime',
                ],
                'searchFields' => 'title,event',
                'iconfile' => $this->service->getNotificationIconPath(),
            ],

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
                    'showitem' => "
                error_message,
                title, sys_language_uid, hidden,
                --div--;" . self::LLL_TABS . ":tab.event,
                    event, event_configuration_flex,
                --div--;" . self::LLL_TABS . ":tab.channel,
                    channel,
                --div--;$lll:tab.content,
                    --palette--;$lll:palette.content;content,
                --div--;$lll:tab.slack,
                    --palette--;$lll:palette.slack;slack
"
                ]
            ],

            'columns' => [

                'target' => [
                    'exclude' => 1,
                    'label' => "$lll:field.target",
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'name' => [
                    'exclude' => 1,
                    'label' => "$lll:field.name",
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'avatar' => [
                    'exclude' => 1,
                    'label' => "$lll:field.avatar",
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'message' => [
                    'exclude' => 1,
                    'label' => "$lll:field.message",
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
