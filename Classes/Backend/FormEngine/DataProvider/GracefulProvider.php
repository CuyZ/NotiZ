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
use CuyZ\Notiz\Service\Container;
use CuyZ\Notiz\Service\ViewService;
use Exception;
use Throwable;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This provider must be used to complete the TCA of entity notifications, for
 * parts that require complex logic that may be failing under certain
 * circumstances (meaning an exception can be thrown for any reason).
 *
 * The goal is to apply this kind of logic after the TCA tree has been generated
 * and put in cache, because if something fails it would crash for the whole
 * backend.
 *
 * Using this graceful provider, if something breaks during the execution of the
 * child provider, the error is caught in order to prevent showing the fatal
 * error to the user; instead, a message is displayed with some information about
 * the exception.
 */
abstract class GracefulProvider implements FormDataProviderInterface
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
     * @param array $result
     * @return array
     * @throws Throwable
     */
    final public function addData(array $result)
    {
        if ($this->definitionService->getValidationResult()->hasErrors()) {
            return $result;
        }

        try {
            return $this->process($result);
        } catch (Throwable $exception) {
        } catch (Exception $exception) {
            // @PHP7
        }

        if ($exception) {
            if (GeneralUtility::_GET('showException')) {
                throw $exception;
            }

            ArrayUtility::mergeRecursiveWithOverrule(
                $GLOBALS['TCA'][$result['tableName']],
                $this->getDefinitionErrorTca($exception)
            );
        }

        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    abstract protected function process(array $result);

    /**
     * @param Throwable $exception
     * @return array
     */
    private function getDefinitionErrorTca($exception)
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
    public function getErrorMessage($arguments)
    {
        $view = $this->viewService->getStandaloneView('Backend/TCA/ErrorMessage');

        $frameSrc = GeneralUtility::getIndpEnv('REQUEST_URI') . '&showException=1';

        $view->assign('frameSrc', $frameSrc);
        $view->assign('exception', $arguments['parameters']['exception']);

        return $view->render();
    }
}
