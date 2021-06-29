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

namespace CuyZ\Notiz\Service\Extension;

use CuyZ\Notiz\Backend\Report\NotificationStatus;
use CuyZ\Notiz\Backend\FormEngine\ButtonBar\ShowNotificationDetailsButton;
use CuyZ\Notiz\Backend\Module\ManagerModuleHandler;
use CuyZ\Notiz\Core\Support\NotizConstants;
use CuyZ\Notiz\Service\Traits\SelfInstantiateTrait;
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * This class replaces the old-school procedural way of handling configuration
 * in `ext_tables.php` file.
 *
 * @internal
 */
class TablesConfigurationService implements SingletonInterface
{
    use SelfInstantiateTrait;

    /**
     * @var string
     */
    protected $extensionKey = NotizConstants::EXTENSION_KEY;

    /**
     * Main processing methods that will call every method of this class.
     */
    public function process()
    {
        self::registerBackendModule();
        self::registerEntityNotificationControllers();
        self::registerReportStatus();
    }

    /**
     * Registers the main backend module used to display notifications,
     * definition and more.
     */
    protected function registerBackendModule()
    {
        ExtensionUtility::registerModule(
            'CuyZ.Notiz',
            'notiz',
            '',
            '',
            [],
            [
                'access' => '',
                'icon' => '',
                'iconIdentifier' => 'tx-notiz-icon-main-module',
                'labels' => "LLL:EXT:{$this->extensionKey}/Resources/Private/Language/Backend/Module/Main/Main.xlf",
                'sub' => []
            ]
        );

        ExtensionUtility::registerModule(
            'CuyZ.Notiz',
            'notiz',
            'notiz_manager',
            '',
            [
                'Backend\Manager\ListNotificationTypes' => 'process',
                'Backend\Manager\ListNotifications' => 'process',
                'Backend\Manager\NotificationActivation' => 'process',
                'Backend\Manager\ListEvents' => 'process',
                'Backend\Manager\ShowEvent' => 'process',
            ],
            [
                'access' => 'user,group',
                'icon' => NotizConstants::EXTENSION_ICON_PATH_MODULE_MANAGER,
                'labels' => "LLL:EXT:{$this->extensionKey}/Resources/Private/Language/Backend/Module/Manager/Manager.xlf",
            ]
        );

        ExtensionUtility::registerModule(
            'CuyZ.Notiz',
            'notiz',
            'notiz_administration',
            '',
            [
                'Backend\Administration\Index' => 'process',
                'Backend\Administration\ShowDefinition' => 'process',
                'Backend\Administration\ShowException' => 'process',
            ],
            [
                'access' => 'admin',
                'icon' => NotizConstants::EXTENSION_ICON_PATH_MODULE_ADMINISTRATION,
                'labels' => "LLL:EXT:{$this->extensionKey}/Resources/Private/Language/Backend/Module/Administration/Administration.xlf",
            ]
        );
    }

    /**
     * Dynamically registers the controllers for existing entity notifications.
     */
    protected function registerEntityNotificationControllers()
    {
        ManagerModuleHandler::get()->registerEntityNotificationControllers();
    }

    /**
     * @see \CuyZ\Notiz\Backend\Report\NotificationStatus
     */
    protected function registerReportStatus()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['NotiZ'][] = NotificationStatus::class;
    }
}
