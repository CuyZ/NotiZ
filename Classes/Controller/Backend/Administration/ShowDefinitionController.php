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

namespace CuyZ\Notiz\Controller\Backend\Administration;

use CuyZ\Notiz\Controller\Backend\BackendController;
use CuyZ\Notiz\Controller\Backend\Menu;
use CuyZ\Notiz\Core\Definition\DefinitionTransformer;
use CuyZ\Notiz\Service\RuntimeService;

class ShowDefinitionController extends BackendController
{
    /**
     * @var DefinitionTransformer
     */
    protected $definitionTransformer;

    /**
     * @var RuntimeService
     */
    protected $runtimeService;

    /**
     * Shows a tree for all definition values as well as errors and warnings
     * for every entry.
     */
    public function processAction()
    {
        $this->view->assign('definition', $this->definitionTransformer->getDefinitionArray());
        $this->view->assign('exception', $this->runtimeService->getException());
    }

    /**
     * @inheritdoc
     */
    protected function getMenu(): string
    {
        return Menu::ADMINISTRATION_DEFINITION;
    }

    /**
     * @param DefinitionTransformer $definitionTransformer
     */
    public function injectDefinitionTransformer(DefinitionTransformer $definitionTransformer)
    {
        $this->definitionTransformer = $definitionTransformer;
    }

    /**
     * @param RuntimeService $runtimeService
     */
    public function injectRuntimeService(RuntimeService $runtimeService)
    {
        $this->runtimeService = $runtimeService;
    }
}
