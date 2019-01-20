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

namespace CuyZ\Notiz\Backend\FormEngine\DataProvider;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ViewService;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * If a definition error is found, the whole TCA is modified for entity
 * notifications; instead of normal fields, an error message is shown.
 */
class DefinitionError implements FormDataProviderInterface
{
    /**
     * @var DefinitionService
     */
    private $definitionService;

    /**
     * @var ViewService
     */
    private $viewService;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        $this->definitionService = Container::get(DefinitionService::class);
        $this->viewService = Container::get(ViewService::class);
    }

    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        $tableName = $result['tableName'];

        if (!isset($GLOBALS['TCA'][$tableName]['ctrl'][EntityTcaWriter::NOTIFICATION_ENTITY])) {
            return $result;
        }

        if ($this->definitionService->getValidationResult()->hasErrors()) {
            ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA'][$tableName], $this->getDefinitionErrorTca());
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getDefinitionErrorTca()
    {
        return [
            'types' => [
                '0' => [
                    'showitem' => 'definition_error_message',
                ],
            ],
            'columns' => [
                'definition_error_message' => [
                    'config' => [
                        'type' => 'user',
                        'userFunc' => self::class . '->getDefinitionErrorMessage',
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getDefinitionErrorMessage()
    {
        $view = $this->viewService->getStandaloneView('Backend/TCA/DefinitionErrorMessage');

        $view->assign('result', $this->definitionService->getValidationResult());

        return $view->render();
    }
}
