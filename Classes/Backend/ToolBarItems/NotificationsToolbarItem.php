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

namespace CuyZ\Notiz\Backend\ToolBarItems;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ExtensionConfigurationService;
use CuyZ\Notiz\Service\LocalizationService;
use CuyZ\Notiz\Service\ViewService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Adds an item to the TYPO3 backend tool bar.
 */
class NotificationsToolbarItem implements ToolbarItemInterface
{
    /**
     * If true, all information will be added to the toolbar menu.
     *
     * The first run of the toolbar rendering (during the rendering of the TYPO3
     * backend) wont be full. This can improve performance if a lot of
     * notifications were to be listed.
     *
     * Periodic asynchronous requests will be dispatched when the TYPO3 backend
     * is rendered. These Ajax requests will contain all information, as they
     * are running as background tasks.
     *
     * @var bool
     */
    protected $fullMenu = false;

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * @var DefinitionService
     */
    protected $definitionService;

    /**
     * @var ExtensionConfigurationService
     */
    protected $extensionConfigurationService;

    /**
     * @var ViewService
     */
    protected $viewService;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $this->definitionService = $objectManager->get(DefinitionService::class);
        $this->extensionConfigurationService = $objectManager->get(ExtensionConfigurationService::class);
        $this->viewService = $objectManager->get(ViewService::class);

        $this->initializeJavaScript();
    }

    /**
     * @return bool
     */
    public function checkAccess()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getItem()
    {
        return $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarItem')->render();
    }

    /**
     * @return bool
     */
    public function hasDropDown()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getDropDown()
    {
        try {
            return $this->getDropDownFromDefinition();
        } catch (Throwable $exception) {
        } catch (Exception $exception) {
            // @PHP7
        }

        return $this->getErrorDropDown($exception);
    }

    /**
     * Action called periodically by Ajax (used to refresh the toolbar).
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function renderMenuAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->fullMenu = true;

        $response->getBody()->write($this->getDropDown());

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * @return string
     */
    protected function getDropDownFromDefinition()
    {
        $view = $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarDropDown');

        if (!$this->definitionService->getValidationResult()->hasErrors()) {
            $definition = $this->definitionService->getDefinition();

            $view->assign('fullMenu', $this->fullMenu);
            $view->assign('definition', $definition);

            if ($this->fullMenu) {
                $notifications = [];
                $total = 0;

                foreach ($definition->getNotifications() as $notification) {
                    $number = $notification->getProcessor()->getTotalNumber();
                    $total += $number;

                    if ($number > 0) {
                        $notifications[] = $notification;
                    }
                }

                $view->assign('filledNotifications', $notifications);
                $view->assign('filledNotificationsTotal', $total);
            }
        }

        return $view->render();
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function getErrorDropDown($exception)
    {
        $view = $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarDropDownError');
        $view->assign('exception', $exception);
        $view->assign('isAdmin', Container::getBackendUser()->isAdmin());

        return $view->render();
    }

    /**
     * @return array
     */
    public function getAdditionalAttributes()
    {
        return [];
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        $index = $this->extensionConfigurationService->getConfigurationValue('toolbar.index');

        return max(min($index, 100), 0);
    }

    /**
     * Requires the JavaScript script that will refresh the toolbar every now
     * and then.
     */
    protected function initializeJavaScript()
    {
        $pageRenderer = $this->getPageRenderer();

        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Notiz/Toolbar');
        $pageRenderer->addInlineLanguageLabelArray([
            'notiz.toolbar.error.body' => LocalizationService::localize('Backend/Toolbar/Error:exception'),
            'notiz.toolbar.error.refresh_label' => LocalizationService::localize('Backend/Toolbar/Show:refresh'),
        ]);
    }

    /**
     * @param string $templateName
     * @return StandaloneView
     */
    protected function getFluidTemplateObject($templateName)
    {
        $view = $this->viewService->getStandaloneView($templateName);

        $view->assign('result', $this->definitionService->getValidationResult());

        $legacyLayout = version_compare(VersionNumberUtility::getCurrentTypo3Version(), '8.0.0', '<');
        $view->assign('legacyLayout', $legacyLayout);

        return $view;
    }

    /**
     * @return PageRenderer|object
     */
    protected function getPageRenderer()
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }
}
