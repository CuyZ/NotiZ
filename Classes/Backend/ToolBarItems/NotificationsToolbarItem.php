<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
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

use CuyZ\Notiz\Backend\Module\ManagerModuleHandler;
use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ExtensionConfigurationService;
use CuyZ\Notiz\Service\LocalizationService;
use CuyZ\Notiz\Service\ViewService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
     * @var ManagerModuleHandler
     */
    protected $managerModuleHandler;

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
        $this->managerModuleHandler = $objectManager->get(ManagerModuleHandler::class);

        $this->initializeJavaScript();
    }

    /**
     * @return bool
     */
    public function checkAccess(): bool
    {
        return $this->managerModuleHandler->canBeAccessed();
    }

    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarItem')->render();
    }

    /**
     * @return bool
     */
    public function hasDropDown(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getDropDown(): string
    {
        try {
            return $this->getDropDownFromDefinition();
        } catch (Throwable $exception) {
            return $this->getErrorDropDown($exception);
        }
    }

    /**
     * Action called periodically by Ajax (used to refresh the toolbar).
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function renderMenuAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->fullMenu = true;

        $response->getBody()->write($this->getDropDown());

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * @return string
     */
    protected function getDropDownFromDefinition(): string
    {
        $view = $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarDropDown');

        if (!$this->definitionService->getValidationResult()->hasErrors()) {
            $definition = $this->definitionService->getDefinition();

            $view->assign('fullMenu', $this->fullMenu);
            $view->assign('definition', $definition);

            if ($this->fullMenu) {
                $notifications = [];
                $total = 0;

                foreach ($definition->getListableNotifications() as $notification) {
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
    protected function getErrorDropDown(Throwable $exception): string
    {
        $view = $this->getFluidTemplateObject('Backend/ToolBar/NotificationToolBarDropDownError');
        $view->assign('exception', $exception);
        $view->assign('isAdmin', Container::getBackendUser()->isAdmin());

        return $view->render();
    }

    /**
     * @return array
     */
    public function getAdditionalAttributes(): array
    {
        return [];
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        $index = $this->extensionConfigurationService->getConfigurationValue('toolbar.index');

        return (int)max(min($index, 100), 0);
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
            'notiz.toolbar.error.body' => LocalizationService::localize('Backend/Toolbar:exception'),
            'notiz.toolbar.error.refresh_label' => LocalizationService::localize('Backend/Toolbar:refresh'),
        ]);
    }

    /**
     * @param string $templateName
     * @return StandaloneView
     */
    protected function getFluidTemplateObject(string $templateName): StandaloneView
    {
        $view = $this->viewService->getStandaloneView($templateName);

        $view->assign('result', $this->definitionService->getValidationResult());

        return $view;
    }

    /**
     * @return PageRenderer
     */
    protected function getPageRenderer(): PageRenderer
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return GeneralUtility::makeInstance(PageRenderer::class);
    }
}
