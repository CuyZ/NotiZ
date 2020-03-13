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

namespace CuyZ\Notiz\Core\Exception;

use Exception;

abstract class NotizException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param array $arguments
     * @return static
     */
    protected static function makeNewInstance(string $message, int $code, array $arguments = []): self
    {
        return new static(vsprintf($message, $arguments), $code);
    }
}
