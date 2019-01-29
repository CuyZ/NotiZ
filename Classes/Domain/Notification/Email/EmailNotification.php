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

namespace CuyZ\Notiz\Domain\Notification\Email;

use CuyZ\Notiz\Core\Notification\Notification;

interface EmailNotification extends Notification
{
    /**
     * @return string
     */
    public function getSender(): string;

    /**
     * @return string
     */
    public function getSendTo(): string;

    /**
     * @return string
     */
    public function getSendCc(): string;

    /**
     * @return string
     */
    public function getSendBcc(): string;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return string
     */
    public function getBody(): string;
}
