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

namespace CuyZ\Notiz\Backend\Module;

use CuyZ\Notiz\Backend\Module\Uri\UriBuilder;
use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Core\SingletonInterface;

abstract class ModuleHandler implements SingletonInterface
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
     * @return ModuleHandler
     */
    public static function for(string $module): ModuleHandler
    {
        /** @var ModuleHandler $moduleHandler */
        $moduleHandler = Container::get(__NAMESPACE__ . '\\' . $module . 'ModuleHandler');

        return $moduleHandler;
    }

    /**
     * @return UriBuilder
     */
    public function getUriBuilder(): UriBuilder
    {
        return $this->uriBuilder;
    }

    /**
     * @return bool
     */
    public function canBeAccessed(): bool
    {
        return Container::getBackendUser()->modAccess($GLOBALS['TBE_MODULES']['_configuration'][$this->getModuleName()], false);
    }

    /**
     * @return string
     */
    abstract public function getDefaultControllerName(): string;

    /**
     * @return string
     */
    abstract public function getModuleName(): string;
}
