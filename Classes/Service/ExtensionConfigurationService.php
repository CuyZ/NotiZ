<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
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
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Service to ease the reading of the extension configuration written in the
 * file `ext_conf_template.txt`.
 */
class ExtensionConfigurationService implements SingletonInterface
{
    /**
     * @param string $key
     * @return mixed
     *
     * @throws EntryNotFoundException
     */
    public function getConfigurationValue(string $key)
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '9.0.0', '<')) {
            return $this->getConfigurationValueLegacy($key);
        }

        /*
         * @deprecated When TYPO3 v8 is not supported anymore, inject this
         * service in constructor and fill a class property `$configuration`
         * for memoization.
         */
        $extensionConfiguration = $this->objectManager()->get(ExtensionConfiguration::class);

        $configuration = $extensionConfiguration->get(NotizConstants::EXTENSION_KEY);

        if (!ArrayUtility::isValidPath($configuration, $key, '.')) {
            throw EntryNotFoundException::extensionConfigurationEntryNotFound($key);
        }

        return ArrayUtility::getValueByPath($configuration, $key, '.');
    }

    /**
     * @param string $key
     * @return mixed
     *
     * @throws EntryNotFoundException
     */
    private function getConfigurationValueLegacy(string $key)
    {
        $configurationUtility = $this->objectManager()->get(ConfigurationUtility::class);
        $configuration = $configurationUtility->getCurrentConfiguration(NotizConstants::EXTENSION_KEY);

        if (!isset($configuration[$key]['value'])) {
            throw EntryNotFoundException::extensionConfigurationEntryNotFound($key);
        }

        return $configuration[$key]['value'];
    }

    /**
     * @return ObjectManager
     */
    private function objectManager(): ObjectManager
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return GeneralUtility::makeInstance(ObjectManager::class);
    }
}
