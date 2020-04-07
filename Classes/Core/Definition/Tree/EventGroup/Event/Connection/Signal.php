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

namespace CuyZ\Notiz\Core\Definition\Tree\EventGroup\Event\Connection;

use CuyZ\Notiz\Core\Definition\Tree\AbstractDefinitionComponent;
use CuyZ\Notiz\Core\Event\Runner\EventRunner;
use CuyZ\Notiz\Service\Container;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

class Signal extends AbstractDefinitionComponent implements Connection
{
    /**
     * @var string
     *
     * @validate NotEmpty
     */
    protected $className;

    /**
     * @var string
     *
     * @validate NotEmpty
     */
    protected $name;

    /**
     * @param string $className
     * @param string $name
     */
    public function __construct(string $className, string $name)
    {
        $this->className = $className;
        $this->name = $name;
    }

    /**
     * Registers the signal in TYPO3 signal slot dispatcher.
     *
     * @param EventRunner $eventRunner
     */
    public function register(EventRunner $eventRunner)
    {
        /** @var Dispatcher $signalSlotDispatcher */
        $signalSlotDispatcher = Container::get(Dispatcher::class);

        $signalSlotDispatcher->connect(
            $this->className,
            $this->name,
            ...$eventRunner->getCallable()
        );
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
