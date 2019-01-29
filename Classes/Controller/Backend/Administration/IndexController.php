<?php
declare(strict_types=1);

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

namespace CuyZ\Notiz\Controller\Backend\Administration;

use CuyZ\Notiz\Controller\Backend\BackendController;
use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Support\Url;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndexController extends BackendController
{
    /**
     * Shows various information and links about the extension.
     */
    public function processAction()
    {
        $this->view->assign('extensionConfigurationUri', $this->getExtensionConfigurationUri());
        $this->view->assign('docUrl', Url::documentation());
        $this->view->assign('docAddDefinitionUrl', Url::documentationTypoScriptDefinition());
        $this->view->assign('repositoryUrl', Url::repository());
        $this->view->assign('newIssueUrl', Url::newIssue());
        $this->view->assign('slackChannelUrl', Url::slackChannel());
    }

    /**
     * @inheritdoc
     */
    protected function getMenu(): string
    {
        return Menu::ADMINISTRATION_INDEX;
    }

    /**
     * URI to the extension configuration manager (can be accessed within the
     * extension manager).
     *
     * @return string
     */
    protected function getExtensionConfigurationUri(): string
    {
        return $this->uriBuilder
            ->reset()
            ->setArguments(['M' => 'tools_ExtensionmanagerExtensionmanager'])
            ->uriFor(
                'showConfigurationForm',
                [
                    'extension' => [
                        'key' => 'notiz'
                    ],
                    'returnUrl' => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
                ],
                'Configuration',
                'extensionmanager',
                'tools_ExtensionmanagerExtensionmanager'
            );
    }
}
