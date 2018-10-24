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

use CuyZ\Notiz\Core\Notification\Service\LegacyNotificationTcaService;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Builds the TCA array for the event configuration.
 *
 * It is a FlexForm field, with as many definition sheets as there are events
 * using FlexForm. Display conditions are dynamically assigned to show the
 * correct definition depending on the selected event.
 */
class EventConfigurationProvider extends GracefulProvider
{
    const COLUMN = '__eventConfiguration';

    /**
     * @param array $result
     * @return array
     */
    public function process(array $result)
    {
        $tableName = $result['tableName'];

        if (!isset($GLOBALS['TCA'][$tableName]['ctrl'][self::COLUMN])) {
            return $result;
        }

        $columnName = $GLOBALS['TCA'][$tableName]['ctrl'][self::COLUMN];

        if (!isset($GLOBALS['TCA'][$tableName]['columns'][$columnName])) {
            return $result;
        }

        $this->fillEventConfigurationTca($tableName, $columnName);

        return $result;
    }

    /**
     * @param string $tableName
     * @param string $columnName
     */
    private function fillEventConfigurationTca($tableName, $columnName)
    {
        $flexFormDs = [];
        $displayConditions = [];

        foreach ($this->definitionService->getDefinition()->getEvents() as $event) {
            $provider = $event->getConfiguration()->getFlexFormProvider();

            if ($provider->hasFlexForm()) {
                $identifier = $event->getFullIdentifier();

                $flexFormDs[$identifier] = $provider->getFlexFormValue();
                $displayConditions[] = $identifier;
            }
        }

        // If no definition is found, the field is not shown at all.
        if (empty($flexFormDs)) {
            $GLOBALS['TCA'][$tableName]['columns'][$columnName]['config'] = ['type' => 'passthrough'];
        }

        /**
         * @deprecated Value can be empty when TYPO3 v7 is not supported anymore.
         */
        $flexFormDs['default'] = 'FILE:EXT:notiz/Configuration/FlexForm/Event/DefaultEventFlexForm.xml';

        $GLOBALS['TCA'][$tableName]['columns'][$columnName]['config']['ds'] = $flexFormDs;

        $GLOBALS['TCA'][$tableName]['columns'][$columnName]['displayCond'] = version_compare(VersionNumberUtility::getCurrentTypo3Version(), '8.0.0', '<')
            ? 'USER:' . LegacyNotificationTcaService::class . '->displayEventFlexForm:' . $tableName . ':' . implode(',', $displayConditions)
            : 'FIELD:event:IN:' . implode(',', $displayConditions);
    }
}
