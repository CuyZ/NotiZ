<?php
/**
 * Copyright (C) 2017
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

namespace CuyZ\Notiz\Property\Service;

use CuyZ\Notiz\Domain\Property\Marker;

/**
 * Helper class to parse markers and replace them in a given string.
 */
class MarkerParser
{
    /**
     * @param string $string
     * @param Marker[] $markers
     * @return string
     */
    public function replaceMarkers($string, array $markers)
    {
        $replacePairs = [];

        foreach ($markers as $marker) {
            $replacePairs[$marker->getFormattedName()] = $marker->getValue();
        }

        return strtr($string, $replacePairs);
    }
}
