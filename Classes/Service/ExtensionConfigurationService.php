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

namespace CuyZ\Notiz\Service;

use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Core\Support\NotizConstants;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service to ease the reading of the extension configuration written in the
 * file `ext_conf_template.txt`.
 */
class ExtensionConfigurationService implements SingletonInterface
{
    /**
     * @var array
     */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get(NotizConstants::EXTENSION_KEY);
    }

    /**
     * @param string $key
     * @return mixed
     *
     * @throws EntryNotFoundException
     */
    public function getConfigurationValue(string $key)
    {
        if (!ArrayUtility::isValidPath($this->configuration, $key, '.')) {
            throw EntryNotFoundException::extensionConfigurationEntryNotFound($key);
        }

        return ArrayUtility::getValueByPath($this->configuration, $key, '.');
    }

}
