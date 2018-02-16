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

namespace CuyZ\Notiz\Core\Event\Support;

/**
 * This interface can be implemented by an object given to an event, when it
 * needs to transfer arbitrary data to a notification during dispatching.
 *
 * For instance, you can implement this interface in a custom scheduler task:
 *
 * ```
 * class MyCustomTask extends AbstractTask implements HasNotificationData
 * {
 *     protected $notificationData = [];
 *
 *     public function execute()
 *     {
 *         // Do things…
 *
 *         $this->notificationData['foo'] = 'bar';
 *
 *         // Do more things…
 *
 *         return true;
 *     }
 *
 *     public function getNotificationData()
 *     {
 *         return $this->notificationData;
 *     }
 * }
 * ```
 *
 * You can then use the marker `{data}` in your notification:
 *
 * `The task has been executed with "{data.foo}".`
 *
 * @see \CuyZ\Notiz\Domain\Event\Scheduler\SchedulerTaskEvent::fillTaskData
 */
interface HasNotificationData
{
    /**
     * Returns an array containing arbitrary data that can be used within the
     * markers of a notification.
     *
     * @return array
     */
    public function getNotificationData();
}
