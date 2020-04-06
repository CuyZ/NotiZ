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

namespace CuyZ\Notiz\Core\Event\Support;

use CuyZ\Notiz\Core\Property\Builder\PropertyBuilder;
use CuyZ\Notiz\Core\Property\Factory\PropertyContainer;

/**
 * This interface can be implemented by an event if it can provide properties
 * that can be used by other services (markers, email, etc.).
 */
interface HasProperties
{
    /**
     * Must return an instance of a property builder that will be used to fetch
     * the definition for properties of the event.
     *
     * @return PropertyBuilder
     */
    public static function getPropertyBuilder(): PropertyBuilder;

    /**
     * Method called to fill the values of the properties that were added during
     * the definition phase, so they can be used by notifications.
     *
     * @see \CuyZ\Notiz\Core\Event\HasProperties::buildPropertyDefinition
     *
     * The property container passed as a parameter contains the entries added
     * in the definition: each one should be filled with a value that was
     * fetched during the dispatch process of the event.
     *
     * Be aware that this method may be called multiple times, as a notification
     * may need several property types.
     *
     * An example of implementation for this method can be:
     *
     * ```
     * public function fillPropertyEntries(PropertyContainer $container)
     * {
     *     switch ($container->getPropertyType()) {
     *         case Marker::class:
     *             $container->getEntry('user_name')
     *                 ->setValue($this->userName);
     *             break;
     *         case Email::class:
     *             $container->getEntry('user_email')
     *                 ->setValue($this->userEmail);
     *             break;
     *     }
     * }
     * ```
     *
     * @param PropertyContainer $container
     * @return void
     */
    public function fillPropertyEntries(PropertyContainer $container);
}
