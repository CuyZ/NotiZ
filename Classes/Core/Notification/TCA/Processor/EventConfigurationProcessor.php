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

namespace CuyZ\Notiz\Core\Notification\TCA\Processor;

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
    protected function doProcess(string $tableName)
    {
        $flexFormDs = [
            'default' => 'FILE:EXT:notiz/Configuration/FlexForm/Event/Default.xml',
        ];
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

        $GLOBALS['TCA'][$tableName]['columns'][self::COLUMN]['config']['ds'] = $flexFormDs;
        $GLOBALS['TCA'][$tableName]['columns'][self::COLUMN]['displayCond'] = 'FIELD:event:IN:' . implode(',', $displayConditions);
    }
}
