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

namespace CuyZ\Notiz\Domain\Property;

use CuyZ\Notiz\Core\Property\PropertyEntry;
use CuyZ\Notiz\Core\Support\NotizConstants;

/**
 * This property represents a single marker annotation in the `Event` class.
 *
 * @see \CuyZ\Notiz\Core\Event\Event
 */
class Marker extends PropertyEntry
{
    /**
     * Returns the name of the marker using the correct format.
     *
     * For example, `fooBar` becomes `#FOO_BAR#`
     *
     * @return string
     */
    public function getFormattedName(): string
    {
        return sprintf(
            NotizConstants::DEFAULT_MARKER_FORMAT,
            $this->getName()
        );
    }
}
