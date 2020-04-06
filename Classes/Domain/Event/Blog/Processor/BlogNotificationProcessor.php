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

namespace CuyZ\Notiz\Domain\Event\Blog\Processor;

use T3G\AgencyPack\Blog\Notification\NotificationInterface;
use T3G\AgencyPack\Blog\Notification\Processor\ProcessorInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

class BlogNotificationProcessor implements ProcessorInterface, SingletonInterface
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Manual dependency injection.
     */
    public function __construct()
    {
        $this->dispatcher = GeneralUtility::makeInstance(Dispatcher::class);
    }

    /**
     * @param NotificationInterface $notification
     */
    public function process(NotificationInterface $notification)
    {
        $this->dispatcher->dispatch(self::class, $notification->getNotificationId(), [$notification]);
    }
}
