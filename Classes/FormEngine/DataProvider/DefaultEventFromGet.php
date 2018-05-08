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

namespace CuyZ\Notiz\FormEngine\DataProvider;

use CuyZ\Notiz\Core\Definition\DefinitionService;
use CuyZ\Notiz\Core\Definition\Tree\Definition;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Will check if an argument `selectedEvent` exists in the request. If this
 * argument matches an existing event, it will be selected for the field
 * `event`.
 *
 * This service allows creating links for creating notifications in the form
 * engine, with a chosen event selected by default.
 */
class DefaultEventFromGet implements FormDataProviderInterface
{
    const ENABLE_DEFAULT_VALUE = 'enableDefaultValue';

    /**
     * @param array $result
     * @return array Result
     */
    public function addData(array $result)
    {
        // This feature is available for new records only.
        if ($result['command'] !== 'new') {
            return $result;
        }

        // The feature needs to be enabled in the `ctrl` section of the TCA.
        if (!isset($result['processedTca']['ctrl'][self::ENABLE_DEFAULT_VALUE])) {
            return $result;
        }

        // The argument `selectedEvent` must exist in the request.
        $selectedEvent = GeneralUtility::_GP('selectedEvent');

        if (!$selectedEvent) {
            return $result;
        }

        $definition = $this->getDefinition();

        // The given event must be a valid identifier.
        if (!$definition->hasEventFromFullIdentifier($selectedEvent)) {
            return $result;
        }

        $result['databaseRow']['event'] = $selectedEvent;

        return $result;
    }

    /**
     * @return Definition
     */
    protected function getDefinition()
    {
        /** @var DefinitionService $definitionService */
        $definitionService = Container::get(DefinitionService::class);

        return $definitionService->getDefinition();
    }
}
