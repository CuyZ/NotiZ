<?php
/**
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
use CuyZ\Notiz\Service\RuntimeService;
use Throwable;

class ShowExceptionController extends BackendController
{
    /**
     * @var RuntimeService
     */
    protected $runtimeService;

    /**
     * This action will be called if an exception was thrown during the building
     * of the definition. The exception will be displayed, using TYPO3 core
     * exception handling.
     *
     * @throws Throwable
     */
    public function processAction()
    {
        $exception = $this->runtimeService->getException();

        if (!$exception) {
            $this->forward('process', 'ShowDefinition');
        }

        throw $exception;
    }

    /**
     * @inheritdoc
     */
    protected function getMenu()
    {
        return Menu::ADMINISTRATION_DEFINITION;
    }

    /**
     * @param RuntimeService $runtimeService
     */
    public function injectRuntimeService(RuntimeService $runtimeService)
    {
        $this->runtimeService = $runtimeService;
    }
}
