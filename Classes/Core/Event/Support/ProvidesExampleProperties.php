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

namespace CuyZ\Notiz\Core\Event\Support;

/**
 * Interface that can be implemented by an event to give example properties that
 * will be used in the backend module to show a preview of a notification bound
 * to this event.
 *
 * Example:
 *
 * ```
 * class MyEvent implements Event, ProvidesExampleProperties
 * {
 *     protected $someValue;
 *
 *     public function getExampleProperties()
 *     {
 *          return [
 *              'someValue' => 'Some value example',
 *          ];
 *     }
 * }
 * ```
 */
interface ProvidesExampleProperties
{
    /**
     * Returns an array in which the key of an entry is the name of a property
     * and its value is a human-readable example value.
     *
     * @return array
     */
    public function getExampleProperties(): array;
}
