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

namespace CuyZ\Notiz\Core\Exception;

use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Property\PropertyEntry;

class PropertyNotAccessibleException extends NotizException
{
    const PROPERTY_ENTRY_VALUE_NOT_ACCESSIBLE = 'The value for the property `%s` (type: `%s`) cannot be modified, because the entry has been frozen. Modifying the value can only occur while the event is being dispatched, see method `%s::fillPropertyEntries()`.';

    /**
     * @param PropertyEntry $propertyEntry
     * @return self
     */
    public static function propertyEntryValueNotAccessible(PropertyEntry $propertyEntry): self
    {
        return self::makeNewInstance(
            self::PROPERTY_ENTRY_VALUE_NOT_ACCESSIBLE,
            1504169712,
            [$propertyEntry->getName(), get_class($propertyEntry), Event::class]
        );
    }
}
