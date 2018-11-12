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

use CuyZ\Notiz\Core\Support\NotizConstants;
use Romm\ConfigurationObject\ConfigurationObjectInstance;
use TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\TypoScriptService;

/**
 * This definition source component is used to fetch a definition array from
 * TypoScript files.
 *
 * Simple TypoScript file registration
 * -----------------------------------
 *
 * To add a TypoScript source file you can add the following line in the
 * `ext_localconf.php` file of your extension:
 *
 * ```
 * $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['NotiZ']['Definition']['Source'][\CuyZ\Notiz\Domain\Definition\Builder\Component\Source\TypoScriptDefinitionSource::class][]
 *     = 'EXT:notiz_example/Configuration/TypoScript/Shop.typoscript';
 * ```
 *
 * Advanced TypoScript file registration
 * -------------------------------------
 *
 * In some cases you may need more complex logic to register files; you can then
 * use a definition component service (see example below).
 *
 * To know how to register a new component:
 *
 * @see \CuyZ\Notiz\Core\Definition\Builder\DefinitionBuilder
 *
 * ```
 * class MyCustomComponents
 * {
 *     public function register(\CuyZ\Notiz\Core\Definition\Builder\Component\DefinitionComponents $components)
 *     {
 *         if ($this->someCustomCondition()) {
 *             $typoScriptSource = $components->getSource(\CuyZ\Notiz\Core\Definition\Builder\Component\Source\DefinitionSource::SOURCE_TYPOSCRIPT);
 *             $typoScriptSource->addFilePath('EXT:my_extension/Definition/TypoScript/NotiZ/setup.typoscript');
 *         }
 *     }
 * }
 * ```
 */
class TypoScriptDefinitionSource extends FileDefinitionSource
{
    /**
     * @var ConfigurationObjectInstance
     */
    protected $objectDefinition;

    /**
     * @var TypoScriptService|\TYPO3\CMS\Core\TypoScript\TypoScriptService
     */
    protected $typoScriptService;

    /**
     * @param TypoScriptService $typoScriptService
     */
    public function __construct(TypoScriptService $typoScriptService)
    {
        $this->typoScriptService = $typoScriptService;
    }

    /**
     * Loops on each registered TypoScript definition file, transforms every
     * content in a plain definition array.
     *
     * The arrays are merged to have a single array tree which is then returned.
     *
     * @return array
     */
    public function getDefinitionArray()
    {
        $content = '';

        foreach ($this->filePaths as $path) {
            $content .= GeneralUtility::getUrl($path) . LF;
        }

        /** @var TypoScriptParser $typoScriptParser */
        $typoScriptParser = GeneralUtility::makeInstance(TypoScriptParser::class);
        $content = TypoScriptParser::checkIncludeLines($content);
        $typoScriptParser->parse($content);

        $definition = $this->typoScriptService->convertTypoScriptArrayToPlainArray($typoScriptParser->setup);

        return isset($definition[NotizConstants::DEFINITION_ROOT_PATH])
            ? $definition[NotizConstants::DEFINITION_ROOT_PATH]
            : [];
    }
}
