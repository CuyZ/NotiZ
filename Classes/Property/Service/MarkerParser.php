<?php

/*
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
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

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
        if (empty($markers)) {
            return $string;
        }

        $aux = [];

        // This will avoid looping on markers for each variable
        foreach ($markers as $marker) {
            $aux[$marker->getName()] = $marker;
        }

        $markers = $aux;

        preg_match_all(
            '/{
                        (
                            ([a-z]+[a-z0-1]*)           # The root variable
                            (?:\.[a-z]+[a-z0-1]*)*      # The other parts
                        )
                    }/xi',
            $string,
            $matches
        );

        if (empty($matches[0])) {
            return $string;
        }

        $identifiers = $matches[0];
        $variables = $matches[1];
        $roots = $matches[2];

        $replacePairs = [];

        foreach ($variables as $index => $variable) {
            $identifier = $identifiers[$index];
            $root = $roots[$index];
            $marker = $markers[$root];

            // We need to have the root name to allow the ObjectAccess class to
            // retrieve the value.
            $target = [
                $root => $marker->getValue(),
            ];

            $value = ObjectAccess::getPropertyPath($target, $variable);

            $replacePairs[$identifier] = $value;
        }

        return strtr($string, $replacePairs);
    }
}
