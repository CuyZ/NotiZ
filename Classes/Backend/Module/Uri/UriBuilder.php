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

namespace CuyZ\Notiz\Backend\Module\Uri;

use CuyZ\Notiz\Backend\Module\ModuleManager;
use CuyZ\Notiz\Core\Support\NotizConstants;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder as ExbaseUriBuilder;

class UriBuilder
{
    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @var ExbaseUriBuilder
     */
    protected $uriBuilder;

    /**
     * @param ModuleManager $moduleManager
     */
    public function __construct(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @param $controller
     * @return $this
     */
    public function forController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function forAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function withArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return UriInterface
     */
    public function build()
    {
        $module = $this->moduleManager->getModuleName();
        $controller = $this->controller ?: $this->moduleManager->getDefaultControllerName();

        $uri = $this->uriBuilder
            ->reset()
            ->setArguments(['M' => $module])
            ->uriFor(
                $this->action,
                $this->arguments,
                $controller,
                NotizConstants::EXTENSION_KEY,
                $module
            );

        return new Uri($uri);
    }

    /**
     * @param ExbaseUriBuilder $uriBuilder
     */
    public function injectUriBuilder(ExbaseUriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
    }
}
