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

use TYPO3\CMS\Core\SingletonInterface;

final class TCAService implements SingletonInterface
{
    public function getTablesList(array &$parameters)
    {
        $tables = array_map(function ($table) {
            return [$table, $table];
        }, array_keys($GLOBALS['TCA']));

        sort($tables);

        $parameters['items'] = $tables;
    }
}
