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

namespace CuyZ\Notiz\Core\Property\Support;

use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Factory\PropertyDefinition;

/**
 * This interface must be implemented by classes intended to build property
 * definitions for a given event.
 *
 * To create a new builder, you need to have a class with the same name as your
 * event at which you append `PropertyBuilder`. The method `build` of your
 * builder will then be automatically called when needed.
 *
 * Example:
 *
 * `MyVendor\MyExtension\Domain\Event\MyEvent` -> Event
 * `MyVendor\MyExtension\Domain\Event\MyEventPropertyBuilder` -> Builder
 */
interface PropertyBuilder
{
    const BUILDER_SUFFIX = 'PropertyBuilder';

    /**
     * @param PropertyDefinition $definition
     * @param Notification $notification
     * @return void
     */
    public function build(PropertyDefinition $definition, Notification $notification);
}
