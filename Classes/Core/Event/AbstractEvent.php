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

namespace CuyZ\Notiz\Core\Event;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Event\Exception\CancelEventDispatch;
use CuyZ\Notiz\Core\Event\Support\HasProperties;
use CuyZ\Notiz\Core\Exception\InvalidClassException;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Builder\PropertyBuilder;
use CuyZ\Notiz\Core\Property\Factory\PropertyContainer;
use CuyZ\Notiz\Core\Property\Factory\PropertyFactory;
use CuyZ\Notiz\Domain\Property\Builder\TagsPropertyBuilder;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Default event implementation provided by this extension, you can use it for
 * your own events.
 *
 * It does implement all methods needed by the interface, so you wont have to do
 * the work yourself, unless you want to override something.
 *
 * You may still implement your own method named `run()` where you can process
 * the logic of the event (usually used to fill the properties of the class).
 *
 * Tag property service
 * --------------------
 *
 * By default, the property definitions are handled by the tag property service,
 * that will analyze your event class attributes and their annotations to
 * automatically fill the definitions.
 *
 * @see \CuyZ\Notiz\Core\Property\Service\TagsPropertyService
 *
 * The only thing you need to do is add the correct annotations on the class
 * attributes you want to use, and fill them with the correct values during the
 * dispatch process.
 *
 * Example:
 *
 * ```
 * /**
 *  * @var string
 *  *
 *  * @marker
 *  * /
 * protected $userName;
 *
 * public function run(UserObject $userObject)
 * {
 *     $this->userName = $userObject->getName();
 * }
 * ```
 *
 * Cancel dispatch
 * ---------------
 *
 * In the implementation of the method `run()` you can call the method
 * `cancelDispatch()` whenever you need to. This will cancel the dispatch of the
 * event and prevent any notification bound to this event from being fired.
 */
abstract class AbstractEvent implements Event, HasProperties
{
    const BUILDER_SUFFIX = 'PropertyBuilder';

    /**
     * @var EventDefinition
     */
    protected $eventDefinition;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var PropertyFactory
     */
    protected $propertyFactory;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * WARNING
     * -------
     *
     * If you need to override the constructor, do not forget to call:
     * `parent::__construct`
     *
     * @param EventDefinition $eventDefinition
     * @param Notification $notification
     * @param PropertyFactory $propertyFactory
     * @param ObjectManager $objectManager
     */
    public function __construct(EventDefinition $eventDefinition, Notification $notification, PropertyFactory $propertyFactory, ObjectManager $objectManager)
    {
        $this->eventDefinition = $eventDefinition;
        $this->notification = $notification;
        $this->configuration = $notification->getEventConfiguration();
        $this->propertyFactory = $propertyFactory;
        $this->objectManager = $objectManager;
    }

    /**
     * This method can be called from the method `run()` to cancel the dispatch
     * of the event.
     *
     * You may call this under certain conditions of your own if they need the
     * event not to be dispatched, preventing the notifications bound to this
     * event to be fired.
     *
     * @throws CancelEventDispatch
     */
    protected function cancelDispatch()
    {
        throw new CancelEventDispatch;
    }

    /**
     * By default, the following builder will be used for your event:
     * @see \CuyZ\Notiz\Domain\Property\Builder\TagsPropertyBuilder
     *
     * To use a custom builder, you need to create a class with the same name as
     * your event at which you append `PropertyBuilder`. The method `build` of
     * your builder will then be automatically called when needed.
     *
     * Example:
     *
     * `MyVendor\MyExtension\Domain\Event\MyEvent` -> Event
     * `MyVendor\MyExtension\Domain\Event\MyEventPropertyBuilder` -> Builder
     *
     * @return PropertyBuilder
     *
     * @throws InvalidClassException
     */
    public static function getPropertyBuilder(): PropertyBuilder
    {
        $builderClassName = static::class . static::BUILDER_SUFFIX;

        if (!class_exists($builderClassName)) {
            $builderClassName = TagsPropertyBuilder::class;
        } elseif (!in_array(PropertyBuilder::class, class_implements($builderClassName))) {
            throw InvalidClassException::eventPropertyBuilderMissingInterface($builderClassName);
        }

        /** @var PropertyBuilder $builder */
        $builder = Container::get($builderClassName);

        return $builder;
    }

    /**
     * Fills the property container with the values from the class attributes.
     *
     * @param PropertyContainer $container
     */
    public function fillPropertyEntries(PropertyContainer $container)
    {
        foreach ($container->getEntries() as $property) {
            $name = $property->getName();

            if (property_exists($this, $name)) {
                $property->setValue($this->$name);
            }
        }
    }

    /**
     * @return EventDefinition
     */
    public function getDefinition(): EventDefinition
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
