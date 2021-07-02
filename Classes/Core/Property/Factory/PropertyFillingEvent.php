<?php


namespace CuyZ\Notiz\Core\Property\Factory;


use CuyZ\Notiz\Core\Event\Event;

class PropertyFillingEvent
{

    protected PropertyContainer $propertyContainer;
    protected Event $event;

    public function __construct(PropertyContainer $propertyContainer, Event $event)
    {
        $this->propertyContainer = $propertyContainer;
        $this->event = $event;
    }

    /**
     * @return PropertyContainer
     */
    public function getPropertyContainer(): PropertyContainer
    {
        return $this->propertyContainer;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }


}
