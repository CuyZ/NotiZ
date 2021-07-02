<?php


namespace CuyZ\Notiz\Service\Scheduler;


class SchedulerTaskExecutedEvent
{

    protected \TYPO3\CMS\Scheduler\Task\AbstractTask $task;
    protected bool $result;

    public function __construct(\TYPO3\CMS\Scheduler\Task\AbstractTask $task, bool $result)
    {
        $this->task = $task;
        $this->result = $result;
    }

    /**
     * @return \TYPO3\CMS\Scheduler\Task\AbstractTask
     */
    public function getTask(): \TYPO3\CMS\Scheduler\Task\AbstractTask
    {
        return $this->task;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

}
