<?php
declare(strict_types=1);

/*
 * Copyright (C)
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

namespace CuyZ\Notiz\Core\Event\Runner;

use CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\EventDefinition;
use CuyZ\Notiz\Core\Event\NotizEvent;
use CuyZ\Notiz\Core\Exception\EntryNotFoundException;
use CuyZ\Notiz\Service\Traits\SelfInstantiateTrait;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Contains all the event runners.
 *
 * This class is mostly needed because of the way event hooks can be registered:
 *
 * @see \CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection\Hook::preventEvalNeverIdealStuff
 */
class EventRunnerContainer implements SingletonInterface
{
    use SelfInstantiateTrait {
        get as getInstance;
    }

    /**
     * @var EventDefinition[]
     */
    protected $eventDefinitions;

    /**
     * @var EventRunner
     */
    protected $eventRunner;

    public function __construct(EventRunner $eventRunner)
    {
        $this->eventRunner = $eventRunner;
    }

    /**
     * @param EventDefinition $eventDefinition
     * @return EventDefinition
     */
    public function add(EventDefinition $eventDefinition): EventDefinition
    {
        $identifier = $eventDefinition->getFullIdentifier();

        if (false === $this->has($identifier)) {
            $this->eventDefinitions[$identifier] = $eventDefinition;
        }

        return $this->eventDefinitions[$identifier];
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function has(string $identifier): bool
    {
        return isset($this->eventDefinitions[$identifier]);
    }

    /**
     * @param string $identifier
     * @return EventDefinition
     *
     * @throws EntryNotFoundException
     */
    public function get(string $identifier): EventDefinition
    {
        if (false === $this->has($identifier)) {
            throw EntryNotFoundException::eventRunnerEntryNotFound($identifier);
        }

        return $this->eventDefinitions[$identifier];
    }

    public function __invoke(NotizEvent $notizEvent)
    {
        $identifier = $notizEvent->getIdentifier();
        $args = $notizEvent->getArgs();

        if ($this->has($identifier)) {
            $eventDefinition = $this->get($identifier);
            $this->eventRunner->process($eventDefinition, ...$args);
        }
    }

}
