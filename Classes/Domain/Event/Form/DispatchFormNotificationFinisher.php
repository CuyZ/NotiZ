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

namespace CuyZ\Notiz\Domain\Event\Form;

use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class DispatchFormNotificationFinisher extends AbstractFinisher
{
    const DISPATCH_NOTIFICATION = 'DispatchNotification';

    /**
     * @var Dispatcher
     */
    protected $slotDispatcher;

    /**
     * This finisher dispatches a signal that will be caught by NotiZ and allow
     * notifications to be sent.
     */
    protected function executeInternal()
    {
        $this->slotDispatcher->dispatch(
            self::class,
            self::DISPATCH_NOTIFICATION,
            [$this->finisherContext]
        );
    }

    /**
     * @param Dispatcher $slotDispatcher
     */
    public function injectSlotDispatcher(Dispatcher $slotDispatcher)
    {
        $this->slotDispatcher = $slotDispatcher;
    }
}
