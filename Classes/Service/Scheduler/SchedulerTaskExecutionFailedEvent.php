<?php


namespace CuyZ\Notiz\Service\Scheduler;


use Throwable;

class SchedulerTaskExecutionFailedEvent
{
    protected \TYPO3\CMS\Scheduler\Task\AbstractTask $task;
    protected Throwable $exception;

    public function __construct(\TYPO3\CMS\Scheduler\Task\AbstractTask $task, Throwable $exception)
    {
        $this->task = $task;
        $this->exception = $exception;
    }

    /**
     * @return \TYPO3\CMS\Scheduler\Task\AbstractTask
     */
    public function getTask(): \TYPO3\CMS\Scheduler\Task\AbstractTask
    {
        return $this->task;
    }

    /**
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }

}
