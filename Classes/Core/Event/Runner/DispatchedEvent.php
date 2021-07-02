<?php


namespace CuyZ\Notiz\Core\Event\Runner;


use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Notification\Notification;

class DispatchedEvent
{

    protected Event $event;
    protected Notification $notification;

    public function __construct(Event $event, Notification $notification)
    {
        $this->event = $event;
        $this->notification = $notification;
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
