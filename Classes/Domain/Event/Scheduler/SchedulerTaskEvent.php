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

namespace CuyZ\Notiz\Domain\Event\Scheduler;

use CuyZ\Notiz\Core\Event\AbstractEvent;
use CuyZ\Notiz\Core\Event\Support\HasNotificationData;
use CuyZ\Notiz\Core\Event\Support\ProvidesExampleProperties;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

abstract class SchedulerTaskEvent extends AbstractEvent implements ProvidesExampleProperties
{
    /**
     * @marker
     *
     * @var int
     */
    protected $uid;

    /**
     * @marker
     *
     * @var string
     */
    protected $title;

    /**
     * @marker
     *
     * @var string
     */
    protected $description;

    /**
     * @marker
     * @label Event/Scheduler/SchedulerTask:marker.data
     *
     * @var array
     */
    protected $data;

    /**
     * @param AbstractTask $task
     */
    protected function checkTaskFilter(AbstractTask $task)
    {
        if ($this->configuration['doFilterTasks']) {
            $allowedTasks = GeneralUtility::trimExplode(',', $this->configuration['filteredTasks']);

            if (!in_array($task->getTaskUid(), $allowedTasks)) {
                $this->cancelDispatch();
            }
        }
    }

    /**
     * @param AbstractTask $task
     */
    protected function fillTaskData(AbstractTask $task)
    {
        $this->uid = $task->getTaskUid();
        $this->title = $task->getTaskTitle();
        $this->description = $task->getDescription();

        if ($task instanceof HasNotificationData) {
            $this->data = $task->getNotificationData();
        }
    }

    /**
     * @return array
     */
    public function getExampleProperties()
    {
        return [
            'uid' => '42',
            'title' => 'My Scheduler Task',
            'description' => 'Some random description that gives details about my scheduler task.',
            'data' => ['foo' => 'bar'],
        ];
    }
}
