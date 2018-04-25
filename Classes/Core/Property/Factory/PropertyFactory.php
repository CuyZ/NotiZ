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

namespace CuyZ\Notiz\Core\Property\Factory;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Event\Event;
use CuyZ\Notiz\Core\Event\Support\HasProperties;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\PropertyEntry;
use CuyZ\Notiz\Service\Traits\ExtendedSelfInstantiateTrait;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Container\Container;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Factory for getting both properties definitions and values, that are defined
 * by events and used by notifications.
 */
class PropertyFactory implements SingletonInterface
{
    use ExtendedSelfInstantiateTrait;

    /**
     * @var PropertyDefinition[]
     */
    protected $propertyDefinition = [];

    /**
     * @var PropertyContainer[]
     */
    protected $properties = [];

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var Container
     */
    protected $objectContainer;

    /**
     * @param ObjectManager $objectManager
     * @param Container $objectContainer
     */
    public function __construct(ObjectManager $objectManager, Container $objectContainer)
    {
        $this->objectManager = $objectManager;
        $this->objectContainer = $objectContainer;
    }

    /**
     * Return property definition from given event definition and notification.
     *
     * The definition is built only once for the given parameters, memoization
     * is used to serve the same definition later in a same run time.
     *
     * Entries have not been processed by any event instance yet. This means all
     * their data can not be accessed yet (mainly their values, but also
     * arbitrary data the property can have).
     *
     * @param string $propertyClassName
     * @param EventDefinition $eventDefinition
     * @param Notification $notification
     * @return PropertyDefinition
     */
    public function getPropertyDefinition($propertyClassName, EventDefinition $eventDefinition, Notification $notification)
    {
        $propertyClassName = $this->objectContainer->getImplementationClassName($propertyClassName);

        $identifier = $eventDefinition->getClassName() . '::' . $propertyClassName;

        if (false === isset($this->propertyDefinition[$identifier])) {
            $this->propertyDefinition[$identifier] = $this->buildPropertyDefinition($propertyClassName, $eventDefinition, $notification);
        }

        return $this->propertyDefinition[$identifier];
    }

    /**
     * Returns a container of property entries that have been processed by the
     * given event. This means all their data can be accessed properly.
     *
     * Note that each property type for each event is processed only once,
     * memoization is used to serve the same properties later in a same run
     * time.
     *
     * @param string $propertyClassName
     * @param Event $event
     * @return PropertyContainer
     */
    public function getPropertyContainer($propertyClassName, Event $event)
    {
        $propertyClassName = $this->objectContainer->getImplementationClassName($propertyClassName);

        $hash = spl_object_hash($event) . '::' . $propertyClassName;

        if (false === isset($this->properties[$hash])) {
            $this->properties[$hash] = $this->buildPropertyContainer($propertyClassName, $event);
        }

        return $this->properties[$hash];
    }


    /**
     * @param string $propertyClassName
     * @param Event $event
     * @return PropertyEntry[]
     */
    public function getProperties($propertyClassName, Event $event)
    {
        return $this->getPropertyContainer($propertyClassName, $event)->getEntries();
    }

    /**
     * @param string $propertyClassName
     * @param EventDefinition $eventDefinition
     * @param Notification $notification
     * @return PropertyDefinition
     */
    protected function buildPropertyDefinition($propertyClassName, EventDefinition $eventDefinition, Notification $notification)
    {
        /** @var PropertyDefinition $propertyDefinition */
        $propertyDefinition = $this->objectManager->get(PropertyDefinition::class, $eventDefinition->getClassName(), $propertyClassName);

        if ($this->eventHasProperties($eventDefinition)) {
            /** @var HasProperties $eventClassName */
            $eventClassName = $eventDefinition->getClassName();

            $propertyBuilder = $eventClassName::getPropertyBuilder();

            $propertyBuilder->build($propertyDefinition, $notification);
        }

        return $propertyDefinition;
    }

    /**
     * @param string $propertyClassName
     * @param Event|HasProperties $event
     * @return PropertyContainer
     */
    protected function buildPropertyContainer($propertyClassName, Event $event)
    {
        $propertyDefinition = $this->getPropertyDefinition($propertyClassName, $event->getDefinition(), $event->getNotification());

        /** @var PropertyContainer $propertyContainer */
        $propertyContainer = GeneralUtility::makeInstance(PropertyContainer::class, $propertyDefinition);

        if ($this->eventHasProperties($event->getDefinition())) {
            $event->fillPropertyEntries($propertyContainer);

            $propertyContainer->freeze();
        }

        return $propertyContainer;
    }

    /**
     * @param EventDefinition $eventDefinition
     * @return bool
     */
    protected function eventHasProperties(EventDefinition $eventDefinition)
    {
        return in_array(HasProperties::class, class_implements($eventDefinition->getClassName()));
    }
}
