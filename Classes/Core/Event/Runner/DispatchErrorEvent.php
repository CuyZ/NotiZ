<?php


namespace CuyZ\Notiz\Core\Event\Runner;


use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Notification\Notification;
use Throwable;

class DispatchErrorEvent
{

    protected Throwable $exception;
    protected Event $event;
    protected Notification $notification;

    public function __construct(Throwable $exception, Event $event, Notification $notification)
    {
        $this->exception = $exception;
        $this->event = $event;
        $this->notification = $notification;
    }

    /**
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

}
