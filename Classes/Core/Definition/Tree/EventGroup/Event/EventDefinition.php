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

namespace CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use CuyZ\Notiz\Core\Definition\Tree\Definition;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Configuration\EventConfiguration;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\Connection;
use CuyZ\Notiz\Core\Definition\Tree\EventGroup\EventGroup;
use CuyZ\Notiz\Core\Notification\Notification;
use CuyZ\Notiz\Core\Property\Factory\PropertyDefinition;
use CuyZ\Notiz\Core\Property\Factory\PropertyFactory;
use CuyZ\Notiz\Service\LocalizationService;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessor;
use Romm\ConfigurationObject\Service\Items\DataPreProcessor\DataPreProcessorInterface;
use Romm\ConfigurationObject\Service\Items\Parents\ParentsTrait;

class EventDefinition extends AbstractDefinitionComponent implements DataPreProcessorInterface
{
    use ParentsTrait;

    /**
     * @var string
     *
     * @validate NotEmpty
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     *
     * @validate Romm.ConfigurationObject:ClassImplements(interface=CuyZ\Notiz\Core\Event\Event)
     */
    protected $className;

    /**
     * @var \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Configuration\EventConfiguration
     */
    protected $configuration;

    /**
     * @var \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\Connection
     *
     * @validate NotEmpty
     *
     * @mixedTypesResolver \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\ConnectionResolver
     */
    protected $connection;

    /**
     * @param string $identifier
     * @param string $className
     */
    public function __construct(string $identifier, string $className)
    {
        $this->identifier = $identifier;
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns a full version of the identifier, containing both the event group
     * identifier and the event identifier, separated by a dot.
     *
     * @return string
     */
    public function getFullIdentifier(): string
    {
        return $this->getGroup()->getIdentifier() . '.' . $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return LocalizationService::localize($this->label);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return LocalizationService::localize($this->description);
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return EventConfiguration
     */
    public function getConfiguration(): EventConfiguration
    {
        return $this->configuration;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @return EventGroup
     */
    public function getGroup(): EventGroup
    {
        /** @var EventGroup $eventGroup */
        $eventGroup = $this->getFirstParent(EventGroup::class);

        return $eventGroup;
    }

    /**
     * @param string $propertyClassName
     * @param Notification $notification
     * @return PropertyDefinition
     */
    public function getPropertyDefinition(string $propertyClassName, Notification $notification): PropertyDefinition
    {
        return PropertyFactory::get()->getPropertyDefinition($propertyClassName, $this, $notification);
    }

    /**
     * Counts the number of notifications that are using this event.
     *
     * @return int
     */
    public function getNotificationNumber(): int
    {
        $counter = 0;

        /** @var Definition $definition */
        $definition = $this->getFirstParent(Definition::class);

        foreach ($definition->getListableNotifications() as $notification) {
            $counter += $notification->getProcessor()->countNotificationsFromEventDefinition($this);
        }

        return $counter;
    }

    /**
     * @param DataPreProcessor $processor
     */
    public static function dataPreProcessor(DataPreProcessor $processor)
    {
        $data = $processor->getData();

        // Configuration must always be set.
        if (!is_array($data['configuration'])) {
            $data['configuration'] = [];
        }

        $processor->setData($data);
    }
}
