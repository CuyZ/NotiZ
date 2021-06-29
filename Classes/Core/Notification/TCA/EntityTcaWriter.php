<?php
declare(strict_types=1);

/*
 * Copyright (C)
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

namespace CuyZ\Notiz\Core\Notification\TCA;

use CuyZ\Notiz\Backend\FormEngine\DataProvider\DefaultEventFromGet;
use CuyZ\Notiz\Core\Notification\Service\NotificationTcaService;
use CuyZ\Notiz\Core\Notification\TCA\Processor\EventConfigurationProcessor;
use CuyZ\Notiz\Service\Traits\SelfInstantiateTrait;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class EntityTcaWriter implements SingletonInterface
{
    use SelfInstantiateTrait;

    const NOTIFICATION_ENTITY = 'notificationEntity';

    const LLL = 'LLL:EXT:notiz/Resources/Private/Language/Notification/Entity/Entity.xlf';

    /**
     * Contains the name of the TCA table.
     *
     * @var string
     */
    protected $tableName;

    /**
     * @var NotificationTcaService
     */
    protected $service;

    /**
     * @var array
     */
    private $data = [];

    /**
     * Manual injection for the TCA service depending on the entity type.
     */
    public function __construct()
    {
        $this->service = GeneralUtility::makeInstance($this->getNotificationTcaServiceClass());
    }

    /**
     * This method must create the basic TCA configuration. It must fill at
     * least the `ctrl` and `columns` sections.
     *
     * Default TYPO3 columns are added automatically, so no need to add them.
     * Common notifications columns are also added automatically.
     *
     * @return array
     */
    abstract protected function buildTcaArray(): array;

    /**
     * This method builds a TCA array and returns it to be used in a
     * configuration file.
     *
     * @param string $tableName
     * @return array
     */
    final public function getTcaArray(string $tableName): array
    {
        $this->tableName = $tableName;

        // Each sub-class starts to fill the array.
        $this->data = $this->buildTcaArray();

        // Some columns are common for all notification types
        $this->addCommonColumns();

        // The default columns are always the same.
        $this->addDefaultTypo3Columns();

        return $this->data;
    }

    /**
     * This method returns the TCA service class for the current entity type.
     * You can override it to return a class extending `NotificationTcaService`.
     *
     * @return string
     */
    abstract protected function getNotificationTcaServiceClass(): string;

    /**
     * Returns the title of the entity, can be a LLL reference.
     *
     * @return string
     */
    abstract protected function getEntityTitle(): string;

    /**
     * This method returns the LLL string to use for the `channel` column.
     *
     * @return string
     */
    protected function getChannelLabel(): string
    {
        return self::LLL . ':field.channel';
    }

    /**
     * @return array
     */
    protected function getDefaultCtrl(): array
    {
        return [
            'title' => $this->getEntityTitle(),

            'label' => 'title',
            'descriptionColumn' => 'description',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'dividers2tabs' => true,

            'rootLevel' => -1,
            'security' => [
                'ignoreWebMountRestriction' => true,
                'ignoreRootLevelRestriction' => true,
            ],

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

            self::NOTIFICATION_ENTITY => [
                'processor' => [
                    EventConfigurationProcessor::class,
                ],
                'dataProvider' => [
                    DefaultEventFromGet::ENABLE_DEFAULT_VALUE => true,
                ]
            ],
        ];
    }

    /**
     * Returns the default TYPO3 columns to include in the final TCA array.
     */
    private function addDefaultTypo3Columns()
    {
        $defaultColumns = [
            'sys_language_uid' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'foreign_table' => 'sys_language',
                    'foreign_table_where' => 'ORDER BY sys_language.title',
                    'default' => 0,
                    'items' => [
                        ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                        ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0],
                    ],
                ],
            ],
            'l10n_parent' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'exclude' => 1,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
                'l10n_display' => 'defaultAsReadonly',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'foreign_table' => $this->tableName,
                    'foreign_table_where' => "AND {$this->tableName}.pid=###CURRENT_PID### AND {$this->tableName}.sys_language_uid IN (-1,0)",
                    'items' => [
                        ['', 0],
                    ],
                ],
            ],
            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                ],
            ],
            't3ver_label' => [
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'max' => 255,
                ],
            ],
            'hidden' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
                'config' => [
                    'type' => 'check',
                ],
            ],
            'starttime' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputDateTime',
                    'eval' => 'datetime',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ]
                ]
            ],
            'endtime' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
                'config' => [
                    'type' => 'input',
                    'renderType' => 'inputDateTime',
                    'eval' => 'datetime',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ]
                ]
            ],
        ];

        ArrayUtility::mergeRecursiveWithOverrule(
            $this->data['columns'],
            $defaultColumns
        );
    }

    /**
     * This method adds the common columns used by all Entity Notifications.
     */
    private function addCommonColumns()
    {
        $commonColumns = [
            'title' => [
                'exclude' => 1,
                'label' => self::LLL . ":field.title",
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim,required',
                ],
            ],

            'description' => [
                'exclude' => 1,
                'label' => self::LLL . ":field.description",
                'config' => [
                    'type' => 'text',
                    'cols' => 40,
                    'rows' => 5,
                ],
            ],

            // Event configuration

            'event' => [
                'exclude' => 1,
                'label' => self::LLL . ":field.event",
                'l10n_mode' => 'exclude',
                'onChange' => 'reload',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'size' => 8,
                    'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getEventsList',
                    'eval' => 'required',
                ],
            ],

            /**
             * This FlexForm field is fully configured in:
             * @see \CuyZ\Notiz\Core\Notification\TCA\Processor\EventConfigurationProcessor
             */
            'event_configuration_flex' => [
                'label' => self::LLL . ':field.event_configuration',
                'config' => [
                    'type' => 'flex',
                    'default' => '',
                    'ds_pointerField' => 'event',
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],

            // Channel configuration

            'channel' => [
                'exclude' => 1,
                'label' => $this->getChannelLabel(),
                'l10n_mode' => 'exclude',
                'l10n_display' => 'defaultAsReadonly',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'itemsProcFunc' => $this->getNotificationTcaServiceClass() . '->getChannelsList',
                    'eval' => 'required',
                ],
            ],

            // Markers configuration

            'markers' => [
                'exclude' => 1,
                'label' => self::LLL . ":field.markers",
                'l10n_display' => 'defaultAsReadonly',
                'config' => [
                    'type' => 'user',
                    'renderType' => 'notizMarkerLabel',
                    'parameters' => [
                        'serviceClass' => $this->getNotificationTcaServiceClass()
                    ]
                ],
            ],
        ];

        ArrayUtility::mergeRecursiveWithOverrule(
            $this->data['columns'],
            $commonColumns
        );
    }
}
