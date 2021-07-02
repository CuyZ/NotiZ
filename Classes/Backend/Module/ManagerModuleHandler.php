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

namespace CuyZ\Notiz\Backend\Module;

use CuyZ\Notiz\Controller\Backend\Manager\ListNotificationTypesController;
use CuyZ\Notiz\Controller\Backend\Manager\Notification\ShowEntityEmailController;
use CuyZ\Notiz\Controller\Backend\Manager\Notification\ShowEntityLogController;
use CuyZ\Notiz\Controller\Backend\Manager\Notification\ShowEntitySlackController;
use CuyZ\Notiz\Service\Traits\ExtendedSelfInstantiateTrait;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

class ManagerModuleHandler extends ModuleHandler
{
    use ExtendedSelfInstantiateTrait;

    /**
     * @return string
     */
    public function getDefaultControllerName(): string
    {
        return ListNotificationTypesController::class;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return 'notiz_NotizNotizManager';
    }

    /**
     * Dynamically registers the controllers for existing entity notifications.
     */
    public function registerEntityNotificationControllers()
    {
        $controllers = [
            ShowEntityEmailController::class => [
                'show',
                'preview',
                'previewError',
            ],
            ShowEntityLogController::class => [
                'show',
            ],
            ShowEntitySlackController::class => [
                'show',
            ],
        ];

        foreach ($controllers as $controller => $actions) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['Notiz']['modules'][$this->getModuleName()]['controllers'][$controller] = [
                'actions' => $actions,
                'className' => $controller,
                'alias' => ExtensionUtility::resolveControllerAliasFromControllerClassName($controller)
            ];
        }
    }
}
