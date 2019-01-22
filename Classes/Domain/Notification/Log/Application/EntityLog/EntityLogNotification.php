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

namespace CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog;

use CuyZ\Notiz\Core\Notification\Activable;
use CuyZ\Notiz\Core\Notification\Creatable;
use CuyZ\Notiz\Core\Notification\Viewable;
use CuyZ\Notiz\Core\Notification\Editable;
use CuyZ\Notiz\Domain\Notification\EntityNotification;
use CuyZ\Notiz\Domain\Notification\Log\Application\EntityLog\Processor\EntityLogNotificationProcessor;
use CuyZ\Notiz\Domain\Notification\Log\LogNotification;

class EntityLogNotification extends EntityNotification implements
    LogNotification,
    Creatable,
    Editable,
    Viewable,
    Activable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $level;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel(string $level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public static function getProcessorClassName(): string
    {
        return EntityLogNotificationProcessor::class;
    }

    /**
     * @return string
     */
    public static function getDefinitionIdentifier(): string
    {
        return 'entityLog';
    }
}
