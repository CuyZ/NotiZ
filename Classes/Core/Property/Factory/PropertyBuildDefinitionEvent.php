<?php


namespace CuyZ\Notiz\Core\Property\Factory;


use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Notification\Notification;

class PropertyBuildDefinitionEvent
{

    protected PropertyDefinition $propertyDefinition;
    protected EventDefinition $eventDefinition;
    protected Notification $notification;

    public function __construct(PropertyDefinition $propertyDefinition, EventDefinition $eventDefinition, Notification $notification)
    {
        $this->propertyDefinition = $propertyDefinition;
        $this->eventDefinition = $eventDefinition;
        $this->notification = $notification;
    }

    /**
     * @return PropertyDefinition
     */
    public function getPropertyDefinition(): PropertyDefinition
    {
        return $this->propertyDefinition;
    }

    /**
     * @return EventDefinition
     */
    public function getEventDefinition(): EventDefinition
    {
        return $this->eventDefinition;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

}
