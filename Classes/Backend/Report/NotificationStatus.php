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

namespace CuyZ\Notiz\Backend\Report;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\LocalizationService;
use CuyZ\Notiz\Service\ViewService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Reports\Status;
use TYPO3\CMS\Reports\StatusProviderInterface;

/**
 * Adds an entry to the status report handled by TYPO3.
 *
 * If an error is found in the definition, an error report is added to the
 * queue, making it easier for administrators to see that something is wrong
 * with the extension.
 */
class NotificationStatus implements StatusProviderInterface, SingletonInterface
{
    /**
     * @var DefinitionService
     */
    protected $definitionService;

    /**
     * @var ViewService
     */
    protected $viewService;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        $this->definitionService = Container::get(DefinitionService::class);
        $this->viewService = Container::get(ViewService::class);
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        $result = $this->definitionService->getValidationResult();

        $viewMessage = $this->viewService->getStandaloneView('Backend/Report/NotificationStatus');
        $viewButtons = $this->viewService->getStandaloneView('Backend/Report/NotificationStatusButtons');

        $viewMessage->assign('result', $result);
        $viewButtons->assign('result', $result);

        return [
            Container::get(
                Status::class,
                LocalizationService::localize('Backend/Report/Report:status.definition'),
                $viewMessage->render(),
                $viewButtons->render(),
                $result->hasErrors()
                    ? Status::ERROR
                    : Status::OK
            )
        ];
    }
}
