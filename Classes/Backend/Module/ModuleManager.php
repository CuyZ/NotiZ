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

namespace CuyZ\Notiz\Backend\Module;

use CuyZ\Notiz\Backend\Module\Uri\UriBuilder;
use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Core\SingletonInterface;

abstract class ModuleManager implements SingletonInterface
{
    /**
     * @var DefinitionService
     */
    protected $definitionService;

    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * @param DefinitionService $definitionService
     */
    public function __construct(DefinitionService $definitionService)
    {
        $this->definitionService = $definitionService;
        $this->uriBuilder = Container::get(UriBuilder::class, $this);
    }

    /**
     * Returns the manager instance for the given module.
     *
     * @param string $module
     * @return ModuleManager
     */
    public static function for($module)
    {
        /** @var ModuleManager $moduleManager */
        $moduleManager = Container::get(__NAMESPACE__ . '\\' . $module . 'ModuleManager');

        return $moduleManager;
    }

    /**
     * @return UriBuilder
     */
    public function getUriBuilder()
    {
        return $this->uriBuilder;
    }

    /**
     * @return string
     */
    abstract public function getDefaultControllerName();

    /**
     * @return string
     */
    abstract public function getModuleName();
}
