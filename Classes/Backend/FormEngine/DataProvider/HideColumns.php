<?php
declare(strict_types=1);

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

use CuyZ\Notiz\Core\Notification\TCA\EntityTcaWriter;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * This provider takes care of hiding every column until the event has been
 * selected for the notification entity.
 *
 * This prevents unwanted behaviours for columns that require the event to be
 * selected.
 */
class HideColumns implements FormDataProviderInterface
{
    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result): array
    {
        $tableName = $result['tableName'];

        if (!isset($GLOBALS['TCA'][$tableName]['ctrl'][EntityTcaWriter::NOTIFICATION_ENTITY])) {
            return $result;
        }

        if (empty($result['databaseRow']['event'])) {
            $GLOBALS['TCA'][$tableName]['types'][0]['showitem'] = 'title,description,--div--;' . EntityTcaWriter::LLL . ':tab.event,event';
        }

        return $result;
    }
}
