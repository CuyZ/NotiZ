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

namespace CuyZ\Notiz\Backend\Module;

use CuyZ\Notiz\Service\Traits\ExtendedSelfInstantiateTrait;

class IndexModuleHandler extends ModuleHandler
{
    use ExtendedSelfInstantiateTrait;

    /**
     * @return string
     */
    public function getDefaultControllerName()
    {
        return 'Backend\\Manager\\ListNotificationTypes';
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return 'NotizNotiz_NotizNotizIndex';
    }

    /**
     * Dynamically registers the controllers for existing entity notifications.
     */
    public function registerEntityNotificationControllers()
    {
        $controllers = [
            'Backend\\Manager\\Notification\\ShowEntityEmail' => [
                'show',
                'preview',
                'previewError',
            ],
            'Backend\\Manager\\Notification\\ShowEntityLog' => [
                'show',
            ],
            'Backend\\Manager\\Notification\\ShowEntitySlack' => [
                'show',
            ],
        ];

        foreach ($controllers as $controller => $actions) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['Notiz']['modules'][$this->getModuleName()]['controllers'][$controller] = ['actions' => $actions];
        }
    }
}
