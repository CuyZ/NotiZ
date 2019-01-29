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

namespace CuyZ\Notiz\Core\Notification\TCA\Processor;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ViewService;
use Throwable;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This processor must be used to complete the TCA of entity notifications, for
 * parts that require complex logic that may be failing under certain
 * circumstances (meaning an exception can be thrown for any reason).
 *
 * The goal is to apply this kind of logic after the TCA tree has been generated
 * and put in cache, because if something fails it would crash for the whole
 * backend.
 *
 * Using this graceful processor, if something breaks during the execution of
 * the child processor, the error is caught in order to prevent showing the
 * fatal error to the user; instead, a message is displayed with some
 * information about the exception.
 */
abstract class GracefulProcessor implements SingletonInterface
{
    /**
     * @var DefinitionService
     */
    protected $definitionService;

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
     * @param string $tableName
     * @throws Throwable
     */
    final public function process(string $tableName)
    {
        if ($this->definitionService->getValidationResult()->hasErrors()) {
            return;
        }

        $exception = null;

        try {
            $this->doProcess($tableName);
        } catch (Throwable $exception) {
            if (GeneralUtility::_GET('showException')) {
                throw $exception;
            }

            ArrayUtility::mergeRecursiveWithOverrule(
                $GLOBALS['TCA'][$tableName],
                $this->getDefinitionErrorTca($exception)
            );
        }
    }

    /**
     * @param string $tableName
     */
    abstract protected function doProcess(string $tableName);

    /**
     * @param Throwable $exception
     * @return array
     */
    private function getDefinitionErrorTca(Throwable $exception): array
    {
        return [
            'types' => [
                '0' => [
                    'showitem' => 'error_message',
                ],
            ],
            'columns' => [
                'error_message' => [
                    'config' => [
                        'type' => 'user',
                        'userFunc' => static::class . '->getErrorMessage',
                        'parameters' => [
                            'exception' => $exception,
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array $arguments
     * @return string
     */
    public function getErrorMessage($arguments): string
    {
        $view = $this->viewService->getStandaloneView('Backend/TCA/ErrorMessage');

        $frameSrc = GeneralUtility::getIndpEnv('REQUEST_URI') . '&showException=1';

        $view->assign('frameSrc', $frameSrc);
        $view->assign('exception', $arguments['parameters']['exception']);

        return $view->render();
    }
}
