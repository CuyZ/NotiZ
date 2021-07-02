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

namespace CuyZ\Notiz\Service\Scheduler;

use Throwable;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Overrides the TYPO3 core class in order to send signals on which NotiZ can
 * bind events.
 *
 * Two signals are sent:
 *
 * Signal: task was executed
 * -------------------------
 *
 * @see \CuyZ\Notiz\Service\Scheduler\SchedulerTaskExecutedEvent
 *
 * When a task was successfully executed.
 *
 * Two arguments are given to the slot:
 *
 * - `$task` - @see \TYPO3\CMS\Scheduler\Task\AbstractTask
 *   The executed task instance containing useful information.
 *
 * - `$result` - bool
 *   Result returned by the task execution process.
 *
 * Signal: task execution failed
 * -----------------------------
 *
 * @see \CuyZ\Notiz\Service\Scheduler\SchedulerTaskExecutionFailedEvent
 *
 * When something has gone wrong during the execution of the task (an exception
 * has been thrown).
 *
 * Two arguments are given to the slot:
 *
 * - `$task` - @see \TYPO3\CMS\Scheduler\Task\AbstractTask
 *   The executed task instance containing useful information.
 *
 * - `$exception` - @see \Throwable
 *   The exception that was thrown during the execution.
 */
class Scheduler extends \TYPO3\CMS\Scheduler\Scheduler
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    public function __construct()
    {
        parent::__construct();

        $this->dispatcher = GeneralUtility::makeInstance(EventDispatcher::class);
    }

    /**
     * See class description for more information.
     *
     * @param AbstractTask $task
     * @return bool
     *
     * @throws Throwable
     */
    public function executeTask(AbstractTask $task): bool
    {
        try {
            $result = parent::executeTask($task);
            $this->dispatcher->dispatch(new SchedulerTaskExecutedEvent($task, $result));
            return $result;
        } catch (Throwable $exception) {
            $this->dispatcher->dispatch(new SchedulerTaskExecutionFailedEvent($task, $exception));
            throw $exception;
        }
    }
}
