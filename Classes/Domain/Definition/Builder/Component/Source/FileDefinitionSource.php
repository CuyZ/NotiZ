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

namespace CuyZ\Notiz\Domain\Definition\Builder\Component\Source;

use CuyZ\Notiz\Core\Definition\Builder\Component\Source\DefinitionSource;
use CuyZ\Notiz\Core\Exception\FileNotFoundException;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Abstraction layer to ease registration of files containing definition.
 *
 * It enables automatic import of files:
 *
 * @see \CuyZ\Notiz\Domain\Definition\Builder\Component\Source\FileDefinitionSource::includeConfiguredSources
 */
abstract class FileDefinitionSource implements DefinitionSource, SingletonInterface
{
    /**
     * @var array
     */
    protected $filePaths = [];

    /**
     * When the class is initialized, configured files are automatically
     * included.
     */
    public function initializeObject()
    {
        $this->includeConfiguredSources();
    }

    /**
     * Registers a path to a file that should contain definition for the API.
     *
     * @param string $path
     * @return $this
     *
     * @throws FileNotFoundException
     */
    public function addFilePath($path)
    {
        if (isset($this->filePaths[$path])) {
            return $this;
        }

        $absolutePath = GeneralUtility::getFileAbsFileName($path);

        if (false === file_exists($absolutePath)) {
            throw FileNotFoundException::definitionSourceTypoScriptFileNotFound($path);
        }

        $this->filePaths[$path] = $absolutePath;

        return $this;
    }

    /**
     * This will automatically register paths to TypoScript files that were
     * registered inside `ext_localconf.php` files:
     *
     * ```
     * $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][\MyVendor\MyExtension\Domain\Definition\Source\MyFileDefinitionSource::class][]
     *     = 'EXT:my_extension/Configuration/Foo/my_definition.foo'
     * ```
     */
    private function includeConfiguredSources()
    {
        // @PHP7
        $configuredSources = isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][static::class])
            ? $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][static::class]
            : [];

        foreach ($configuredSources as $configuredSource) {
            $this->addFilePath((string)$configuredSource);
        }
    }
}
