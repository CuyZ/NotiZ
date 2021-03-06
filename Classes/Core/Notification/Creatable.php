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

namespace CuyZ\Notiz\Core\Notification;

/**
 * This interface can be implemented by notifications that can be created by an
 * editor.
 */
interface Creatable
{
    /**
     * @return bool
     */
    public static function isCreatable(): bool;

    /**
     * @param string $selectedEvent
     * @return string
     */
    public static function getCreationUri(string $selectedEvent = null): string;
}
