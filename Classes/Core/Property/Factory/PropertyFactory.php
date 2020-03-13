<?php
declare(strict_types=1);

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
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Factory for getting both properties definitions and values, that are defined
 * by events and used by notifications.
 *
 * Global properties manipulation
 * ------------------------------
 *
 * If you need to globally do things with properties (for instance markers), you
 * can use the signals below.
 *
 * In the example below, we add a new global marker `currentDate` that will be
 * accessible for every notification.
 *
 * > my_extension/ext_localconf.php
 * ```
 * $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
 *     \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
 * );
 *
 *  // We add a new entry to the definition of the markers: `currentDate` that will
 *  // be later filled with the date of the day.
 *  //
 *  // This marker will be accessible to every notification, regardless of the event
 *  // and other selected configuration.
 * $dispatcher->connect(
 *     \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::class,
 *     \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::SIGNAL_PROPERTY_BUILD_DEFINITION,
 *     function (
 *         \CuyZ\Notiz\Core\Property\Factory\PropertyDefinition $propertyDefinition,
 *         \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition $eventDefinition,
 *         \CuyZ\Notiz\Core\Notification\Notification $notification
 *     ) {
 *         if ($propertyDefinition->getPropertyType() === \CuyZ\Notiz\Domain\Property\Marker::class) {
 *             $propertyDefinition->addEntry('currentDate')
 *                 ->setLabel('Formatted date of the day');
 *         }
 *     }
 * );
 *
 * // Manually filling the marker `currentDate` with the date of the day.
 * $dispatcher->connect(
 *     \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::class,
 *     \CuyZ\Notiz\Core\Property\Factory\PropertyFactory::SIGNAL_PROPERTY_FILLING,
 *     function (
 *         \CuyZ\Notiz\Core\Property\Factory\PropertyContainer $propertyContainer,
 *         \CuyZ\Notiz\Core\Event\Event $event
 *     ) {
 *         if ($propertyContainer->getPropertyType() === \CuyZ\Notiz\Domain\Property\Marker::class) {
 *             $propertyContainer->getEntry('currentDate')
 *                 ->setValue(date('d/m/Y'));
 *         }
 *     }
 * );
 * ```
 */
class PropertyFactory implements SingletonInterface
{
    const SIGNAL_PROPERTY_BUILD_DEFINITION = 'propertyBuildDefinition';

    const SIGNAL_PROPERTY_FILLING = 'propertyFilling';

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
     * @var Dispatcher
     */
    protected $slotDispatcher;

    /**
     * @param ObjectManager $objectManager
     * @param Container $objectContainer
     * @param Dispatcher $slotDispatcher
     */
    public function __construct(ObjectManager $objectManager, Container $objectContainer, Dispatcher $slotDispatcher)
    {
        $this->objectManager = $objectManager;
        $this->objectContainer = $objectContainer;
        $this->slotDispatcher = $slotDispatcher;
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
    public function getPropertyDefinition(string $propertyClassName, EventDefinition $eventDefinition, Notification $notification): PropertyDefinition
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
    public function getPropertyContainer(string $propertyClassName, Event $event): PropertyContainer
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
    public function getProperties(string $propertyClassName, Event $event): array
    {
        return $this->getPropertyContainer($propertyClassName, $event)->getEntries();
    }

    /**
     * @param string $propertyClassName
     * @param EventDefinition $eventDefinition
     * @param Notification $notification
     * @return PropertyDefinition
     */
    protected function buildPropertyDefinition(string $propertyClassName, EventDefinition $eventDefinition, Notification $notification): PropertyDefinition
    {
        /** @var PropertyDefinition $propertyDefinition */
        $propertyDefinition = $this->objectManager->get(PropertyDefinition::class, $eventDefinition->getClassName(), $propertyClassName);

        if ($this->eventHasProperties($eventDefinition)) {
            /** @var HasProperties $eventClassName */
            $eventClassName = $eventDefinition->getClassName();

            $propertyBuilder = $eventClassName::getPropertyBuilder();

            $propertyBuilder->build($propertyDefinition, $notification);
        }

        $this->dispatchPropertyBuildDefinitionSignal($propertyDefinition, $eventDefinition, $notification);

        return $propertyDefinition;
    }

    /**
     * @param string $propertyClassName
     * @param Event|HasProperties $event
     * @return PropertyContainer
     */
    protected function buildPropertyContainer(string $propertyClassName, Event $event): PropertyContainer
    {
        $propertyDefinition = $this->getPropertyDefinition($propertyClassName, $event->getDefinition(), $event->getNotification());

        /** @var PropertyContainer $propertyContainer */
        $propertyContainer = GeneralUtility::makeInstance(PropertyContainer::class, $propertyDefinition);

        if ($this->eventHasProperties($event->getDefinition())) {
            $event->fillPropertyEntries($propertyContainer);
        }

        $this->dispatchPropertyFillingSignal($propertyContainer, $event);

        $propertyContainer->freeze();

        return $propertyContainer;
    }

    /**
     * This signal is sent after the property definition was built. It can be
     * used to alter the definition depending on your needs.
     *
     * @param PropertyDefinition $propertyDefinition
     * @param EventDefinition $eventDefinition
     * @param Notification $notification
     */
    protected function dispatchPropertyBuildDefinitionSignal(
        PropertyDefinition $propertyDefinition,
        EventDefinition $eventDefinition,
        Notification $notification
    ) {
        $this->slotDispatcher->dispatch(
            self::class,
            self::SIGNAL_PROPERTY_BUILD_DEFINITION,
            [
                $propertyDefinition,
                $eventDefinition,
                $notification,
            ]
        );
    }

    /**
     * This signal is sent just after properties have been filled with their own
     * values. It can be used to manipulate the values of properties before they
     * are freezed.
     *
     * @param PropertyContainer $propertyContainer
     * @param Event $event
     */
    protected function dispatchPropertyFillingSignal(PropertyContainer $propertyContainer, Event $event)
    {
        $this->slotDispatcher->dispatch(
            self::class,
            self::SIGNAL_PROPERTY_FILLING,
            [
                $propertyContainer,
                $event,
            ]
        );
    }

    /**
     * @param EventDefinition $eventDefinition
     * @return bool
     */
    protected function eventHasProperties(EventDefinition $eventDefinition): bool
    {
        return in_array(HasProperties::class, class_implements($eventDefinition->getClassName()));
    }
}
