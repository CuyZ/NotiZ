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

use CuyZ\Notiz\Core\Notification\Service\LegacyNotificationTcaService;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Builds the TCA array for the event configuration.
 *
 * It is a FlexForm field, with as many definition sheets as there are events
 * using FlexForm. Display conditions are dynamically assigned to show the
 * correct definition depending on the selected event.
 */
class EventConfigurationProcessor extends GracefulProcessor
{
    const COLUMN = 'event_configuration_flex';

    /**
     * @param string $tableName
     */
    protected function doProcess($tableName)
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
            $GLOBALS['TCA'][$tableName]['columns'][self::COLUMN]['config'] = ['type' => 'passthrough'];
        }

        /**
         * @deprecated Value can be empty when TYPO3 v7 is not supported anymore.
         */
        $flexFormDs['default'] = 'FILE:EXT:notiz/Configuration/FlexForm/Event/DefaultEventFlexForm.xml';

        $GLOBALS['TCA'][$tableName]['columns'][self::COLUMN]['config']['ds'] = $flexFormDs;

        $GLOBALS['TCA'][$tableName]['columns'][self::COLUMN]['displayCond'] = version_compare(VersionNumberUtility::getCurrentTypo3Version(), '8.0.0', '<')
            ? 'USER:' . LegacyNotificationTcaService::class . '->displayEventFlexForm:' . $tableName . ':' . implode(',', $displayConditions)
            : 'FIELD:event:IN:' . implode(',', $displayConditions);
    }
}
