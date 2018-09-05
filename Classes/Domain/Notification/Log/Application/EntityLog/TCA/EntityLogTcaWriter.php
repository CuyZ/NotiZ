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

namespace CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\TCA;

use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;

class EntityLogTcaWriter extends EntityTcaWriter
{
    const LOG_LLL = 'LLL:EXT:notiz/Resources/Private/Language/Notification/Log/Entity.xlf';

    /**
     * @return string
     */
    protected function getNotificationTcaServiceClass()
    {
        return EntityLogTcaService::class;
    }

    /**
     * @return string
     */
    protected function getChannelLabel()
    {
        return self::LOG_LLL . ':field.logger';
    }

    /**
     * @inheritdoc
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
                'levels' => [
                    'showitem' => 'level,levels_descriptions',
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
                        --div--;' . self::LOG_LLL . ':tab.log,
                            --palette--;' . self::LOG_LLL . ':palette.content;content,
                            --palette--;' . self::LOG_LLL . ':palette.levels;levels',
                ],
            ],

            'columns' => [
                'message' => [
                    'exclude' => 1,
                    'label' => self::LOG_LLL . ':field.message',
                    'config' => [
                        'type' => 'input',
                        'size' => 255,
                        'eval' => 'trim,required',
                    ],
                ],

                'level' => [
                    'exclude' => 1,
                    'label' => self::LOG_LLL . ':field.level',
                    'l10n_mode' => 'exclude',
                    'l10n_display' => 'defaultAsReadonly',
                    'config' => [
                        'type' => 'radio',
                        'items' => [],
                        'itemsProcFunc' => EntityLogTcaService::class . '->getLogLevelsList',
                        'eval' => 'required',
                    ],
                ],

                'levels_descriptions' => [
                    'exclude' => 1,
                    'label' => self::LOG_LLL . ':field.levels_descriptions_title',
                    'l10n_display' => 'defaultAsReadonly',
                    'config' => [
                        'type' => 'user',
                        'userFunc' => EntityLogTcaService::class . '->getLogLevelsDescriptions',
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

        $ctrl['title'] = self::LOG_LLL . ':title';

        return $ctrl;
    }
}
