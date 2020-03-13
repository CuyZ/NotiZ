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

namespace CuyZ\Notiz\Core\Property\Factory;

use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Core\Property\PropertyEntry;

/**
 * A container for a list of property entries that are fetched from a property
 * definition.
 *
 * @see \CuyZ\Notiz\Core\Property\Factory\PropertyDefinition
 *
 * The differences with a property definition is that you can not add more
 * entries, you may only modify the data from the existing ones: setting their
 * values, manipulating other arbitrary data, other...
 */
class PropertyContainer
{
    /**
     * @var PropertyDefinition
     */
    protected $definition;

    /**
     * @var PropertyEntry[]
     */
    protected $properties = [];

    /**
     * @param PropertyDefinition $definition
     */
    public function __construct(PropertyDefinition $definition)
    {
        $this->definition = $definition;

        foreach ($definition->getEntries() as $property) {
            /*
             * Every property is cloned, to insure the base property wont be
             * modified.
             */
            $this->properties[$property->getName()] = clone $property;
        }
    }

    /**
     * Freezes all registered properties entries.
     *
     * @see \CuyZ\Notiz\Core\Property\PropertyEntry::freeze
     */
    public function freeze()
    {
        foreach ($this->properties as $property) {
            $property->freeze();
        }
    }

    /**
     * @return string
     */
    public function getPropertyType(): string
    {
        return $this->definition->getPropertyType();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasEntry(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @return PropertyEntry
     *
     * @throws EntryNotFoundException
     */
    public function getEntry(string $name): PropertyEntry
    {
        if (false === $this->hasEntry($name)) {
            throw EntryNotFoundException::propertyEntryNotFound($name, $this->definition->getEventClassName(), $this->getPropertyType(), $this);
        }

        return $this->properties[$name];
    }

    /**
     * @return PropertyEntry[]
     */
    public function getEntries(): array
    {
        return $this->properties;
    }
}
