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

namespace CuyZ\Notiz\Domain\Definition\Builder\Component\Source;

use CuyZ\Notiz\Core\Definition\Builder\Component\Source\DefinitionSource;
use CuyZ\Notiz\Core\Exception\FileNotFoundException;
use Generator;
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
    private $filePaths = [];

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
     * The highest the given priority is, the sooner the file will be handled.
     * Files with the lowest priority have more chance to override definition
     * values.
     *
     * @param string $path
     * @param int $priority
     * @return $this
     *
     * @throws FileNotFoundException
     */
    public function addFilePath(string $path, int $priority = 0)
    {
        if (!isset($this->filePaths[$priority])) {
            $this->filePaths[$priority] = [];
            krsort($this->filePaths);
        }

        if (isset($this->filePaths[$priority][$path])) {
            return $this;
        }

        $absolutePath = GeneralUtility::getFileAbsFileName($path);

        if (false === file_exists($absolutePath)) {
            throw FileNotFoundException::definitionSourceFileNotFound($path);
        }

        $this->filePaths[$priority][$path] = $absolutePath;

        return $this;
    }

    /**
     * @return Generator
     */
    final protected function filePaths(): Generator
    {
        foreach ($this->filePaths as $priority => $paths) {
            foreach ($paths as $path) {
                yield $priority => $path;
            }
        }
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
        $configuredSources = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][static::class] ?? [];

        foreach ($configuredSources as $configuredSource) {
            $this->addFilePath((string)$configuredSource);
        }
    }
}
