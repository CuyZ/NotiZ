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

namespace CuyZ\Notiz\Core\Notification\TCA\Processor;

use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;
use TYPO3\CMS\Core\Database\TableConfigurationPostProcessingHookInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GracefulProcessorRunner implements SingletonInterface, TableConfigurationPostProcessingHookInterface
{
    /**
     * This method runs just after the TCA was registered.
     *
     * It instantiates and runs a list of "graceful processors" that modify some
     * TCA that requires more complex logic (which can fail for any reason).
     */
    public function processData()
    {
        foreach ($GLOBALS['TCA'] as $tableName => $configuration) {
            $processors = $configuration['ctrl'][EntityTcaWriter::NOTIFICATION_ENTITY]['processor'] ?? [];

            foreach ($processors as $processorClassName) {
                /** @var GracefulProcessor $processor */
                $processor = GeneralUtility::makeInstance($processorClassName);

                $processor->process($tableName);
            }
        }
    }
}
