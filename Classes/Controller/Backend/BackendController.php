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

namespace CuyZ\Notiz\Controller\Backend;

use CuyZ\Notiz\Backend\Module\AdministrationModuleHandler;
use CuyZ\Notiz\Controller\Backend\Administration\ShowExceptionController;
use CuyZ\Notiz\Controller\Backend\Administration\IndexController;
use CuyZ\Notiz\Controller\Backend\Administration\ShowDefinitionController;
use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Core\Definition\Tree\Definition;
use CuyZ\Notiz\Service\LocalizationService;
use CuyZ\Notiz\Service\ViewService;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

abstract class BackendController extends ActionController
{
    /**
     * @var DefinitionService
     */
    protected $definitionService;

    /**
     * @var AdministrationModuleHandler
     */
    protected $administrationModuleHandler;

    /**
     * @var ViewService
     */
    protected $viewService;

    /**
     * Checking if the definition contains errors.
     */
    public function initializeAction()
    {
        $this->checkDefinitionError();
    }

    /**
     * @param ViewInterface $view
     */
    public function initializeView(ViewInterface $view)
    {
        if (!$this->definitionService->getValidationResult()->hasErrors()) {
            $this->view->assign('definition', $this->getDefinition());
        }

        $view->assignMultiple([
            'result' => $this->definitionService->getValidationResult(),
            'request' => $this->request,
            'menu' => $this->getMenu(),
        ]);
    }

    /**
     * Must return a menu identifier. You should use a constant of the following
     * interface: @see \CuyZ\Notiz\Controller\Backend\Menu
     *
     * @return string
     */
    abstract protected function getMenu();

    /**
     * If the definition contain errors, the request is forwarded. If the user
     * is an administrator the administration module is shown, otherwise an
     * error message is shown.
     */
    protected function checkDefinitionError()
    {
        if (!$this->definitionService->getValidationResult()->hasErrors()) {
            return;
        }

        if (IndexController::class === $this->request->getControllerObjectName()
            || ShowDefinitionController::class === $this->request->getControllerObjectName()
            || ShowExceptionController::class === $this->request->getControllerObjectName()
        ) {
            return;
        }

        if ($this->administrationModuleHandler->canBeAccessed()) {
            $this->redirectToUri((string)$this->administrationModuleHandler->getUriBuilder()->build());
        }

        if ('definitionError' !== $this->request->getControllerActionName()) {
            $this->forward('definitionError');
        }
    }

    /**
     * Action called when an error was found during definition being built (if
     * the user is not an administrator).
     */
    public function definitionErrorAction()
    {
        return $this->viewService->getStandaloneView('Backend/DefinitionError')->render();
    }

    /**
     * @param string $key
     * @param mixed ...$arguments
     */
    protected function addErrorMessage($key, ...$arguments)
    {
        $this->addFlashMessage(
            LocalizationService::localize($key, $arguments),
            '',
            AbstractMessage::ERROR
        );
    }

    /**
     * @return Definition
     */
    protected function getDefinition()
    {
        return $this->definitionService->getDefinition();
    }

    /**
     * @param DefinitionService $definitionService
     */
    public function injectDefinitionService(DefinitionService $definitionService)
    {
        $this->definitionService = $definitionService;
    }

    /**
     * @param AdministrationModuleHandler $administrationModuleHandler
     */
    public function injectAdministrationModuleHandler(AdministrationModuleHandler $administrationModuleHandler)
    {
        $this->administrationModuleHandler = $administrationModuleHandler;
    }

    /**
     * @param ViewService $viewService
     */
    public function injectViewService(ViewService $viewService)
    {
        $this->viewService = $viewService;
    }
}
