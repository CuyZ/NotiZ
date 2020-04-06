<?php
declare(strict_types=1);

/*
 * Copyright (C) 2020
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

use CuyZ\Notiz\Core\Exception\DuplicateEntryException;
use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Core\Property\PropertyEntry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class is a definition for a given property name of a given event type,
 * for instance it can define the property "markers" of the event "a user has
 * registered".
 *
 * It contains any number of independent entries, for instance "user_name" or
 * "user_email".
 *
 * ---
 *
 * A property definition is built by an event, because the event is the only one
 * to know which entries can be added.
 *
 * @see \CuyZ\Notiz\Core\Event\Support\HasProperties::buildPropertyDefinition
 *
 * In the method above, the definition can be manipulated to add new entries:
 *
 * @see \CuyZ\Notiz\Core\Property\Factory\PropertyDefinition::addEntry
 *
 * ---
 *
 * Please note that an event may handle several properties, for instance with
 * our last example the properties `markers` and `email` may be used:
 *
 * - `markers` contains concrete information that can be used in the message of
 *   the notification.
 * - `email` contains information about who will receive the notification.
 *
 * In this case, the two properties above have their own definition.
 */
class PropertyDefinition
{
    /**
     * @var string
     */
    protected $eventClassName;

    /**
     * @var string
     */
    protected $propertyType;

    /**
     * @var PropertyEntry[]
     */
    protected $properties = [];

    /**
     * @param string $eventClassName
     * @param string $propertyType
     */
    public function __construct(string $eventClassName, string $propertyType)
    {
        $this->eventClassName = $eventClassName;
        $this->propertyType = $propertyType;
    }

    /**
     * @return string
     */
    public function getEventClassName(): string
    {
        return $this->eventClassName;
    }

    /**
     * @return string
     */
    public function getPropertyType(): string
    {
        return $this->propertyType;
    }

    /**
     * @param string $name
     * @return PropertyEntry
     *
     * @throws DuplicateEntryException
     */
    public function addEntry(string $name): PropertyEntry
    {
        if ($this->hasEntry($name)) {
            throw DuplicateEntryException::propertyEntryDuplication($name, $this->eventClassName, $this->propertyType);
        }

        $this->properties[$name] = GeneralUtility::makeInstance($this->propertyType, $name);

        return $this->properties[$name];
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
            throw EntryNotFoundException::propertyEntryNotFound($name, $this->eventClassName, $this->propertyType, $this);
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
